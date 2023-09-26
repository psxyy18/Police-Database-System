
 

  <?php
  date_default_timezone_set('Europe/London');
  // Start a new session
  session_start();

  // Check if the user is logged in
  if (isset($_SESSION['username'])) {
    // User is logged in, store the username in a variable
    $user = $_SESSION['username'];
  } else {
    // User is not logged in, redirect to the login page
 header('Location: login.php');
    exit;
  }
// Connect to the database
require("db.inc.php");

      $db = mysqli_connect($servername, $username, $password, $dbname);   

// Check if the form has been submitted
if (isset($_POST['people_name']) && isset($_POST['people_address']) && isset($_POST['people_licence'])) {
// Form has been submitted, insert the record into the database
$people_name = $db->real_escape_string($_POST['people_name']);
$people_address = $db->real_escape_string($_POST['people_address']);
$people_licence = $db->real_escape_string($_POST['people_licence']);
$result = $db->query("INSERT INTO People (People_name, People_address, People_licence) VALUES ('$people_name', '$people_address', '$people_licence')");

// Check if the insertion was successful
if ($result) {
  // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'insertion into table People';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
// Insertion was successful, redirect back to the search page with a success message
header('Location: search.php?message=Record+added+successfully');
exit;
} else {
// Insertion was not successful, display an error message
echo "<p>Error adding record: ".$db->error."</p>";
}
}

// Close the database connection
$db->close();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Person</title>
  <link rel="stylesheet" href="add_person.css">
</head>
<body>
  <h1>Add Person</h1>

  <form action="add_person.php" method="post">
    <label for="people_name">Person's name:</label>
    <input type="text" name="people_name" id="people_name">
    <br>
    <label for="people_address">Person's address:</label>
    <input type="text" name="people_address" id="people_address">
    <br>
    <label for="people_licence">Person's licence plate:</label>
    <input type="text" name="people_licence" id="people_licence">
    <br>
    <input type="submit" value="Add">
  </form>
  <a href="admin.php">Back to Admin Page</a>
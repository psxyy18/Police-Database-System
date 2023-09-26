<!DOCTYPE html>
<html>
<head>
  <title>Search and Edit Person</title>
  <link rel="stylesheet" href="retrieve_incident.css">

</head>
<body>
  <h1>Person Search</h1>

  <form action="search.php" method="post">
    <label for="search_term">Enter a search term:</label>
    <input type="text" name="search_term" id="search_term">
    <br>
    <label for="search_by">Search by:</label>
    <select name="search_by" id="search_by">
      <option value="People_ID">Person's ID</option>
      <option value="People_name">Person's name</option>
      <option value="People_address">Person's address</option>
      <option value="People_licence">Person's licence plate</option>
    </select>
    <br>
    <input type="submit" value="Search">
  </form>
  <a href="admin.php">Back to Admin Page</a>

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
if (isset($_POST['search_term']) && isset($_POST['search_by'])) {
  // Form has been submitted, search the database
  $search_term = $_POST['search_term'];
  $search_by = $_POST['search_by'];
  $result = $db->query("SELECT * FROM People WHERE $search_by LIKE '%$search_term%'");
  // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'access to table People';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
} else {
  // Form has not been submitted, retrieve all records from the database
  $result = $db->query("SELECT * FROM People");
}
// Check if any records were retrieved
if ($result->num_rows > 0) {
  // Records were retrieved, display them in a table
  ?>
  <table>
    <tr>
      <th>Person's ID</th>
      <th>Person's name</th>
      <th>Person's address</th>
      <th>Person's Licence Plate</th>

    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td><?php echo $row['People_ID']; ?></td>
        <td><?php echo $row['People_name']; ?></td>
        <td><?php echo $row['People_address']; ?></td>
        <td><?php echo $row['People_licence']; ?></td>
        <td>
          <form action="edit_person.php" method="post">
            <input type="hidden" name="people_id" value="<?php echo $row['People_ID']; ?>">
            <input type="submit" value="Edit">
          </form>
        </td>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
} else {
  // No records were retrieved, display a message
  ?>
  <p>No records found.</p>
  <?php
}
// Check if a message was passed in the query string
if (isset($_GET['message'])) {
  // Message was passed in the query string, display it
  $message = urldecode($_GET['message']);
  echo "<p>$message</p>";
  }
  
  // Close the database connection
  $db->close();



?>
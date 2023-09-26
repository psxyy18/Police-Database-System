<?php
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

// Check for connection error
if ($db->connect_error) {
  die('Connection error: ' . $db->connect_error);
}


// Check if the form has been submitted
if (isset($_POST['people_id'])) {
  // Form has been submitted, retrieve the record to be edited
  $people_id = $_POST['people_id'];
  $result = $db->query("SELECT * FROM People WHERE People_ID='$people_id'");
  $row = $result->fetch_assoc();
} else {
  // Form has not been submitted, redirect to the retrieve_incident.php page
  header('Location: search.php');
  exit;
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Person's information</title>
  <link rel="stylesheet" href="edit_person.css">
</head>
<body>
  <h1>Edit Person's information</h1>
  <form action="update_person.php" method="post">
<label for="people_name">Person's Name:</label>
<input type="text" name="people_name" value="<?php echo $row['People_name']; ?>"><br>
<label for="people_address">Person's Address:</label>
<input type="text" name="people_address" value="<?php echo $row['People_address']; ?>"><br>
<label for="people_licence">Person's Licence Plate:</label>
<input type="text" name="people_licence" value="<?php echo $row['People_licence']; ?>"><br>
<input type="hidden" name="people_id" value="<?php echo $row['People_ID']; ?>">
<input type="submit" value="Update">


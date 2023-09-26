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
$people_id = $_POST['people_id'];


// Check for connection error
if ($db->connect_error) {
  die('Connection error: ' . $db->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['people_name']) && isset($_POST['people_address']) && isset($_POST['people_licence'])){
// Update the record in the People table
$people_name = $_POST['people_name'];
$people_address = $_POST['people_address'];
$people_licence = $_POST['people_licence'];
$db->query("UPDATE People SET People_name='$people_name', People_address='$people_address', People_licence='$people_licence' WHERE People_ID='$people_id'");

// Add a record to the audit trail for the updated report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'update record in table People';
$time = date('Y-m-d H:i:s');
$record_id = $incident_id; // Get the ID of the updated report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");

// Redirect to the retrieve_incident.php page
header('Location: search.php');
exit;
} else {
  // Form has not been submitted, redirect to the edit_incident.php page
  header('Location: edit_person.php');
  exit;
}

// Close the database connection
$db->close();
?>


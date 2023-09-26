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

// Check for connection error
if ($db->connect_error) {
  die('Connection error: ' . $db->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['incident_report']) && isset($_POST['incident_date']) && isset($_POST['vehicle_type']) && isset($_POST['vehicle_colour']) && isset($_POST['vehicle_licence']) && isset($_POST['people_name']) && isset($_POST['people_address']) && isset($_POST['people_licence']) && isset($_POST['offence_description'])){
// Update the record in the Incident_report table
$incident_id = $_POST['incident_id'];
$incident_report = $_POST['incident_report'];
$incident_date = $_POST['incident_date'];
$vehicle_type = $_POST['vehicle_type'];
$vehicle_colour = $_POST['vehicle_colour'];
$vehicle_licence = $_POST['vehicle_licence'];
$people_name = $_POST['people_name'];
$people_address = $_POST['people_address'];
$people_licence = $_POST['people_licence'];
$offence_description = $_POST['offence_description'];
  $result = $db->query("Select Offence_ID from Offence where Offence_description = '$offence_description'");
  if ($result === false) {
    // Query failed, display an error message and exit
    echo 'Error: ' . $db->error;
    exit;
  }
  if ($result->num_rows > 0) {
    // Query returned at least one row, fetch the first row
    $row1 = $result->fetch_assoc();
    $db->query("UPDATE Incident Left join Vehicle on Incident.Vehicle_ID = Vehicle.Vehicle_ID left join People on Incident.People_ID = People.People_ID left join Offence on Incident.Offence_ID = Offence.Offence_ID SET Vehicle_type = '$vehicle_type',Vehicle_colour = '$vehicle_colour',Vehicle_licence = '$vehicle_licence',People_name = '$people_name',People_address = '$people_address',People_licence = '$people_licence',Incident_Report='$incident_report', Incident_Date='$incident_date', Incident.Offence_ID='$row1[Offence_ID]' WHERE Incident_ID='$incident_id'");
  }
else {
  // Query returned no rows, display an error message and exit
  echo 'Error: No rows returned by the query';
  exit;
}
// Add a record to the audit trail for the updated report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'update record in table Incident';
$time = date('Y-m-d H:i:s');
$record_id = $incident_id; // Get the ID of the updated report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");

// Redirect to the retrieve_incident.php page
header('Location: retrieve_incident1.php');
exit;
} else {
  // Form has not been submitted, redirect to the edit_incident.php page
  header('Location: edit_incident.php');
  exit;
}

// Close the database connection
$db->close();
?>


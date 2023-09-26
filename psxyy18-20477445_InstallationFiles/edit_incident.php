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
if (isset($_POST['incident_id'])) {
  // Form has been submitted, retrieve the record to be edited
  $incident_id = $_POST['incident_id'];
  $result = $db->query("SELECT * FROM Incident Left join Vehicle on Incident.Vehicle_ID = Vehicle.Vehicle_ID left join People on Incident.People_ID = People.People_ID left join Offence on Incident.Offence_ID = Offence.Offence_ID WHERE Incident_ID='$incident_id'");
  $row = $result->fetch_assoc();
} else {
  // Form has not been submitted, redirect to the retrieve_incident.php page
  header('Location: retrieve_incident1.php');
  exit;
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Incident Report</title>
</head>
<body>
  <h1>Edit Incident Report</h1>
  <form action="update_incident.php" method="post">
    <label for="incident_report">Incident Report:</label>
    <input type="text" name="incident_report" value="<?php echo $row['Incident_Report']; ?>"><br>
    <label for="incident_date">Incident Date:</label>
    <input type="text" name="incident_date" value="<?php echo $row['Incident_Date']; ?>"><br>
    <label for="vehicle_type">Vehicle Type:</label>
    <input type="text" name="vehicle_type" value="<?php echo $row['Vehicle_type']; ?>"><br>
    <label for="vehicle_colour">Vehicle Colour:</label>
    <input type="text" name="vehicle_colour" value="<?php echo $row['Vehicle_colour']; ?>"><br>
    <label for="vehicle_licence">Vehicle Licence Plate:</label>
<input type="text" name="vehicle_licence" value="<?php echo $row['Vehicle_licence']; ?>"><br>
<label for="people_name">Person's Name:</label>
<input type="text" name="people_name" value="<?php echo $row['People_name']; ?>"><br>
<label for="people_address">Person's Address:</label>
<input type="text" name="people_address" value="<?php echo $row['People_address']; ?>"><br>
<label for="people_licence">Person's Licence Plate:</label>
<input type="text" name="people_licence" value="<?php echo $row['People_licence']; ?>"><br>
<input type="hidden" name="incident_id" value="<?php echo $row['Incident_ID']; ?>">
<label for="offence_description">Offence Description:</label>
  <select name="offence_description" id="offence_description">
  <?php
  // Retrieve the values for the dropdown menu
  $result = $db->query("SELECT Offence_description FROM Offence");
  while ($row = $result->fetch_assoc()) {
  echo  '<option value="' . $row['Offence_description'] . '">' . $row['Offence_description'] . '</option>';
}
?>
<input type="hidden" name="offence_id" value="<?php echo $row['Offence_ID']; ?>">
<input type="submit" value="Update">


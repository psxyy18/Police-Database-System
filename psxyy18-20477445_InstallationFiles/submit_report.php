
<?php
date_default_timezone_set('Europe/London');
error_reporting(E_ALL);
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


if (isset($_POST['incident_report']) && isset($_POST['incident_date']) && isset($_POST['vehicle_type']) && isset($_POST['vehicle_colour']) && isset($_POST['vehicle_licence']) && isset($_POST['people_name']) && isset($_POST['people_address']) && isset($_POST['people_licence']) && isset($_POST['offence_description'])) {
  // form has been submitted, process the data

// Connect to the database
require("db.inc.php");

$db = mysqli_connect($servername, $username, $password, $dbname);   

  // Check for connection error
  if ($db->connect_error) {
    die('Connection error: ' . $db->connect_error);
  }

  // Check if the person is already in the system
  $people_name = $_POST['people_name'];
  $result = $db->query("SELECT * FROM People WHERE People_name='$people_name'");


  if ($result->num_rows == 0) {
    // Add a new entry for the person
    $people_address = $_POST['people_address'];
    $people_licence = $_POST['people_licence'];
    $db->query("INSERT INTO People (People_name, People_address, People_licence) VALUES ('$people_name', '$people_address', '$people_licence')");
  // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'insertion into table People';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
}


  // Check if the vehicle is already in the system
  $vehicle_licence = $_POST['vehicle_licence'];
  $result = $db->query("SELECT * FROM Vehicle WHERE Vehicle_licence='$vehicle_licence'");


  if ($result->num_rows == 0) {
    // Add a new entry for the vehicle
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_colour = $_POST['vehicle_colour'];
    $db->query("INSERT INTO Vehicle (Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES ('$vehicle_type', '$vehicle_colour', '$vehicle_licence')");
  // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'insertion into table vehicle';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
}

  // Get the People_ID and Vehicle_ID for the report
  $result = $db->query("SELECT People_ID FROM People WHERE People_name='$people_name'");
  $people_id = $result->fetch_assoc()['People_ID'];

  $result = $db->query("SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_licence='$vehicle_licence'");
  $vehicle_id = $result->fetch_assoc()['Vehicle_ID'];

  // Get the Offence_ID for the chosen Offence_description
  $offence_description = $_POST['offence_description'];
  $result = $db->query("SELECT Offence_ID FROM Offence WHERE Offence_description='$offence_description'");
  $offence_id = $result->fetch_assoc()['Offence_ID'];

  // Add the report to the Report table
  $incident_report = $_POST['incident_report'];
  $incident_date = $_POST['incident_date'];
  $db->query("INSERT INTO Incident (Incident_Report, Incident_Date, People_ID, Vehicle_ID, Offence_ID) VALUES ('$incident_report', '$incident_date', '$people_id', '$vehicle_id', '$offence_id')");



  // Add a record to the audit trail for the inserted report
  $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
  $action = 'insertion into table incident';
  $time = date('Y-m-d H:i:s');
  $record_id = $db->insert_id; // Get the ID of the inserted report
  $db->query("INSERT INTO audit_trail ( Action, Time, User) VALUES ('$action', '$time', '$user')");
  echo 'Report filed successfully.<br>';
  echo "<a href='admin.php'>Go to dashboard page</a> | <a href='submit_report.php'>Go back to add another report</a>";
}else{
  ?>
  <form action="submit_report.php" method="post">
  <label for="incident_report">Incident Report:</label><br>
  <textarea id="incident_report" name="incident_report" rows="5" cols="40"></textarea><br>
  <label for="incident_date">Incident Date:</label><br>
  <input type="date" id="incident_date" name="incident_date"><br>
  <label for="vehicle_type">Vehicle Type:</label><br>
  <input type="text" id="vehicle_type" name="vehicle_type"><br>
  <label for="vehicle_colour">Vehicle Colour:</label><br>
  <input type="text" id="vehicle_colour" name="vehicle_colour"><br>
  <label for="vehicle_licence">Vehicle Licence:</label><br>
  <input type="text" id="vehicle_licence" name="vehicle_licence"><br>
  <label for="people_name">Person's Name:</label><br>
  <input type="text" id="people_name" name="people_name"><br>
  <label for="people_address">Person's Address:</label><br>
  <input type="text" id="people_address" name="people_address"><br>
  <label for="people_licence">Person's Licence:</label><br>
  <input type="text" id="people_licence" name="people_licence"><br><br>
  <label for="offence_description">Offence Description:</label><br>
  <select name="offence_description" id="offence_description">
    <?php
     require("db.inc.php");

     $conn = mysqli_connect($servername, $username, $password, $dbname);   
    // Select the Offence_description column from the Offence table
    $sql = "SELECT DISTINCT Offence_description FROM Offence";
    $result = mysqli_query($conn, $sql);
    
    // Loop through the results and create an option element for each row
    while ($row = mysqli_fetch_assoc($result)) {
      $offence_description = $row['Offence_description'];
      echo "<option value='$offence_description'>$offence_description:</option>";
    }
    ?>
  </select><br>
  <input type="submit" value="Submit">
</form> 
<a href="admin.php">Back to Admin Page</a>
<?php
}

?>
<head>
  <link rel="stylesheet" href="submit_report.css">
</head>

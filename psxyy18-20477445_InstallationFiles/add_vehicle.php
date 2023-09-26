<?php
date_default_timezone_set('Europe/London');
  // Start the session
  session_start();
  
  // Connect to the database
  require("db.inc.php");

      $db = mysqli_connect($servername, $username, $password, $dbname);   
  
  // Check if the connection was successful
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }
  
  // Check if the form has been submitted
  if(isset($_POST['submit'])) {
    // Retrieve the form data
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_colour = $_POST['vehicle_colour'];
    $vehicle_licence = $_POST['vehicle_licence'];
    $people_name = $_POST['people_name'];
    $people_address = $_POST['people_address'];
    $people_licence = $_POST['people_licence'];
    
    // Check if the owner is already in the database
    $result = $db->query("SELECT People_ID FROM People WHERE People_licence = '$people_licence'");
    if($result->num_rows > 0) {
      // Retrieve the owner's ID
      $row = $result->fetch_assoc();
      $people_id = $row['People_ID'];
    } else {
      // Insert the new owner into the "People" table
      $db->query("INSERT INTO People (People_name, People_address, People_licence) VALUES ('$people_name', '$people_address', '$people_licence')");
      // Retrieve the new owner's ID
      $people_id = $db->insert_id;
    echo $people_id;

    // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'insertion into People table';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
    }
    
    // Insert the new vehicle into the "Vehicle" table
$db->query("INSERT INTO Vehicle ( Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES ('$vehicle_type', '$vehicle_colour', '$vehicle_licence')");

// Retrieve the new vehicle's ID
$vehicle_id = $db->insert_id;

// Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'insertion into vehicle table';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");


// Insert a new record into the "Ownership" table

    $result = $db->query("INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES ('$people_id', '$vehicle_id')");

    // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'insertion into ownership table';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");


if($result === false) {
  // An error occurred, display an error message
  echo "Error: " . $db->error;
}

    
    // Redirect to the search page
    header('Location: admin.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="add.css">
</head>
<body>
  <h1>Add a new vehicle</h1>
  <form method="post">
    <label for="vehicle_type">Vehicle type:</label><br>
    <input type="text" id="vehicle_type" name="vehicle_type"><br>
    <label for="vehicle_colour">Vehicle colour:</label><br>
    <input type="text" id="vehicle_colour" name="vehicle_colour"><br>
    <label for="vehicle_licence">Vehicle registration number:</label><br>
    <input type="text" id="vehicle_licence" name="vehicle_licence"><br>
    <label for="people_name">Owner's name:</label><br>
    <input type="text" id="people_name" name="people_name"><br>
    <label for="people_address">Owner's address:</label><br>
    <input type="text" id="people_address" name="people_address"><br>
    <label for="people_licence">Owner's driving license number:</label><br>
    <input type="text" id="people_licence" name="people_licence"><br><br>
    <input type="submit" value="Submit" name="submit">
  </form> 
</body>
</html>
<a href="admin.php">Back to Admin Page</a>

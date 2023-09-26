<?php
date_default_timezone_set('Europe/London');
// start a new session
session_start();

if (isset($_POST['amount']) && isset($_POST['points']) && isset($_POST['incident_id'])) {
  // form has been submitted, process the data

  // connect to the database
  require("db.inc.php");

      $db = mysqli_connect($servername, $username, $password, $dbname);   

  $amount = $_POST['amount'];
  $points = $_POST['points'];
  $incident_id = $_POST['incident_id'];

  $sql = "INSERT INTO Fines (Fine_Amount, Fine_Points, Incident_ID) VALUES ('$amount', '$points', '$incident_id')";
  $result = $db->query($sql);

  if ($result) {
    // fine added successfully
    echo "Fine added successfully!<br>";
    ?><a href="admin.php">Back to dashboard Page</a><?php

    // Add a record to the audit trail for the inserted report
    $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
    $action = 'insertion to table fine';
    $time = date('Y-m-d H:i:s');
    $record_id = $db->insert_id; // Get the ID of the inserted report
    $db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
    // handle error
  }else{ echo "Error adding fine: " . $db->error;}}
   
  
else {
  // form has not been submitted, display the form
  ?>
    <a href="admin.php">Back to dashboard Page</a>
  <form action="add_fine.php" method="post">
    <label for="amount">Amount:</label><br>
    <input type="text" id="amount" name="amount"><br>
    <label for="points">Points:</label><br>
    <input type="text" id="points" name="points"><br>
    <label for="incident_id">Incident ID:</label><br>
    <input type="text" id="incident_id" name="incident_id"><br><br>
    <input type="submit" value="Add Fine">
  </form> 
  <?php
}
?>
<head>
  <link rel="stylesheet" href="add_fine.css">
</head>

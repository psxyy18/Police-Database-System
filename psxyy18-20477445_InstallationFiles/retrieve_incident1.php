<!DOCTYPE html>
<html>
<head>
  <title>Retrieve Incident Report</title>
  <link rel="stylesheet" href="retrieve_incident.css">

</head>
<body>
  <h1>Retrieve Incident Report</h1>
  <form action="retrieve_incident1.php" method="post">
    <label for="search_term">Enter a search term:</label>
    <input type="text" name="search_term" id="search_term">
    <br>
    <label for="search_by">Search by:</label>
    <select name="search_by" id="search_by">
      <option value="Incident_ID">Incident ID</option>
      <option value="Incident_Report">Incident Report</option>
      <option value="Incident_Date">Incident Date</option>
      <option value="Vehicle_type">Vehicle Type</option>
      <option value="Vehicle_colour">Vehicle Colour</option>
      <option value="Vehicle_licence">Vehicle Licence Plate</option>
      <option value="People_name">Person's Name</option>
      <option value="People_address">Person's Address</option>
      <option value="People_licence">Person's Licence Plate</option>
      <option value="Offence_description">Offence Description</option>
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
  $result = $db->query("SELECT * FROM Incident Left join Vehicle on Incident.Vehicle_ID = Vehicle.Vehicle_ID left join People on Incident.People_ID = People.People_ID left join Offence on Incident.Offence_ID = Offence.Offence_ID WHERE $search_by LIKE '%$search_term%'");
} else {
  // Form has not been submitted, retrieve all records from the database
  $result = $db->query("SELECT * FROM Incident Left join Vehicle on Incident.Vehicle_ID = Vehicle.Vehicle_ID left join People on Incident.People_ID = People.People_ID left join Offence on Incident.Offence_ID = Offence.Offence_ID");
}
// Check if any records were retrieved
if ($result->num_rows > 0) {
  // Add a record to the audit trail for the inserted report
$user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
$action = 'access to table Incident';
$time = date('Y-m-d H:i:s');
$record_id = $db->insert_id; // Get the ID of the inserted report
$db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
  // Records were retrieved, display them in a table
  ?>
  <table>
    <tr>
      <th>Incident ID</th>
      <th>Incident Report</th>
      <th>Incident Date</th>
      <th>Vehicle Type</th>
      <th>Vehicle Colour</th>
      <th>Vehicle Licence Plate</th>
      <th>Person's Name</th>
      <th>Person's Address</th>
      <th>Person's Licence Plate</th>
      <th>Offence Description</th>
      <th>Actions</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td><?php echo $row['Incident_ID']; ?></td>
        <td><?php echo $row['Incident_Report']; ?></td>
        <td><?php echo $row['Incident_Date']; ?></td>
        <td><?php echo $row['Vehicle_type']; ?></td>
        <td><?php echo $row['Vehicle_colour']; ?></td>
        <td><?php echo $row['Vehicle_licence']; ?></td>
        <td><?php echo $row['People_name']; ?></td>
        <td><?php echo $row['People_address']; ?></td>
        <td><?php echo $row['People_licence']; ?></td>
        <td><?php echo $row['Offence_description']; ?></td>
        <td>
          <form action="edit_incident.php" method="post">
            <input type="hidden" name="incident_id" value="<?php echo $row['Incident_ID']; ?>">
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

// Close the database connection
$db->close();

?>

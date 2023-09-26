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
  
  // Check if the search query is set in the URL
  if(isset($_GET['query'])) {
    // Retrieve the search query from the URL
    $query = $_GET['query'];
    
    // Convert the search query and the data in the database to lowercase
    $query = strtolower($query);
    
    // Search the "Vehicle" table for a vehicle with a registration number that matches the search query
    $result = $db->query("SELECT v.Vehicle_ID, v.Vehicle_type, v.Vehicle_colour, v.Vehicle_licence, p.People_name, p.People_licence FROM Vehicle v LEFT JOIN Ownership o ON v.Vehicle_ID = o.Vehicle_ID LEFT JOIN People p ON o.People_ID = p.People_ID WHERE LOWER(v.Vehicle_licence) LIKE '%$query%'");

  // Check if any records were found
    if($result->num_rows > 0) {
      // Print the records
      while($row = $result->fetch_assoc()) {
        echo "<div class='record'>";
        echo "<p class='vehicle-id'>Vehicle ID: " . $row['Vehicle_ID'] . "</p>";
        echo "<p class='vehicle-type'>Vehicle type: " . $row['Vehicle_type'] . "</p>";
        echo "<p class='vehicle-color'>Vehicle color: " . $row['Vehicle_colour'] . "</p>";
        echo "<p class='vehicle-licence'>Vehicle registration number: " . $row['Vehicle_licence'] . "</p>";
        echo "<p class='owner-name'>Owner's name: " . $row['People_name'] . "</p>";
        echo "<p class='owner-licence'>Owner's driving license number: " . $row['People_licence'] . "</p>";
        echo "</div>";

        // Add a record to the audit trail for the inserted report
        $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
        $action = 'access to table Vehicle,People,Ownership';
        $time = date('Y-m-d H:i:s');
        $record_id = $db->insert_id; // Get the ID of the inserted report
        $db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
      }
    } else {
      // Print a message if no records were found
      echo "<p>No records found.</p>";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="search_vehicle.css">
</head>
</html>

<!-- Search form -->
<form method="get">
  <label for="query">Search:</label>
  <input type="text" id="query" name="query" placeholder="Enter a vehicle license number">
  <button type="submit">Search</button>
</form>
<a href="admin.php">Back to Admin Page</a>
<!-- Search results -->
<div id="search-results">
  <?php
    // Print the search results
    if(isset($_GET['query'])) {
      // Check if any records were found
      if($result->num_rows > 0) {
        // Print the records
        while($row = $result->fetch_assoc()) {
          echo "<div class='record'>";
          echo "<p class='vehicle-id'>Vehicle ID: " . $row['Vehicle_ID'] . "</p>";
          echo "<p class='vehicle-type'>Vehicle type: " . $row['Vehicle_type'] . "</p>";
          echo "<p class='vehicle-color'>Vehicle color: " . $row['Vehicle_colour'] . "</p>";
          echo "<p class='vehicle-licence'>Vehicle registration number: " . $row['Vehicle_licence'] . "</p>";
          echo "<p class='owner-name'>Owner's name: " . $row['People_name'] . "</p>";
          echo "<p class='owner-licence'>Owner's driving license number: " . $row['People_licence'] . "</p>";
          echo "</div>";
        }
        } else {
        // Print a message if no records were found
        echo "<p>No records found.</p>";
        }
        }
        ?>
        
        </div>
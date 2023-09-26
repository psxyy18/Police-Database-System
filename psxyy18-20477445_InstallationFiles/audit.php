<?php
date_default_timezone_set('Europe/London');
session_start();
  // Connect to the database
  require("db.inc.php");

      $conn = mysqli_connect($servername, $username, $password, $dbname);   
  
  // Check if a view type has been selected
  if (isset($_POST['view'])) {
    // Check which view type was selected
    if ($_POST['view'] == 'user') {
      // View type is per-user, check if a user has been selected
      if (isset($_POST['user'])) {
        // Get the selected user
        $user = $_POST['user'];
        
        // Retrieve the audit logs for the selected user
        $sql = "SELECT Time, Action, Record_ID FROM audit_trail WHERE User='$user'";
        $result = $conn->query($sql);
        
        // Check if any records were returned
        if ($result->num_rows > 0) {
          // Display the audit logs in an HTML table
          echo "<table><tr><th>Time</th><th>Action</th><th>Record ID</th></tr>";
          while($row = $result->fetch_assoc()) {
              echo "<tr><td>" . $row["Time"]. "</td><td>" . $row["Action"]. "</td><td>" . $row["Record_ID"]. "</td></tr>";
          }
          echo "</table><br>";
          echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";

          // Add a record to the audit trail for the inserted report
          $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
          $action = 'access to audit trail';
          $time = date('Y-m-d H:i:s');
          $record_id = $conn->insert_id; // Get the ID of the inserted report
          $conn->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
      } else {
        // No records were returned, display a message
        echo "No audit logs found for the selected user.<br>";
        echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";
      }
        } else{
          // No user has been selected, display a form to select a user
          ?>
          <form action="audit.php" method="post">
            <input type="hidden" name="view" value="user">
            <label for="user">Select a user:</label><br>
            <select id="user" name="user">
              <?php
              echo "<br>";
              echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";
              // Retrieve the list of users from the database
              $sql = "SELECT Username FROM users";
              $result = $conn->query($sql);
              // Loop through the list of users and display them as options in the select element
              while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['Username'] . "'>" . $row['Username'] . "</option><br>";
                echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";

              }
              ?>
            </select>
            <br>
            <input type="submit" value="View Audit Logs">
          </form>
          <?php
        }
      } elseif ($_POST['view'] == 'record') {
        // View type is per-record, check if a record ID has been provided
        if (isset($_POST['record_id'])) {
          // Get the provided record ID
          $record_id = $_POST['record_id'];
          
          // Retrieve the audit logs for the specified record ID
          $sql = "SELECT Time, Action, User FROM audit_trail WHERE Record_ID='$record_id'";
          $result = $conn->query($sql);
          
          // Check if any records were returned
          if ($result->num_rows > 0) {
            // Display the audit logs in an HTML table
            echo "<table><tr><th>Time</th><th>Action</th><th>User</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["Time"]. "</td><td>" . $row["Action"]. "</td><td>" . $row["User"]. "</td></tr>";
                }
                echo "</table><br>";
                echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";
                } else {
                // No records were returned, display a message
                echo "No audit logs found for the specified record ID.<br>";
                echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";

                // Add a record to the audit trail for the inserted report
                $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
                $action = 'access to audit trail';
                $time = date('Y-m-d H:i:s');
                $record_id = $db->insert_id; // Get the ID of the inserted report
                $conn->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
                }
                } else {
                // No record ID has been provided, display a form to enter a record ID
                ?>
                <form action="audit.php" method="post">
                <input type="hidden" name="view" value="record">
                <label for="record_id">Enter a record ID:</label><br>
                <input type="text" id="record_id" name="record_id"><br>
                <input type="submit" value="View Audit Logs">
                </form>
                <?php
                echo "<br>";
                echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";
                }
                }
                } else {
                // No view type has been selected, display a form to select a view type
                ?>
                <form action="audit.php" method="post">
                <label for="view">Select a view type:</label><br>
                <select id="view" name="view">
                <option value="user">Per-User</option>
                <option value="record">Per-Record</option>
                </select>
                <br>
                <input type="submit" value="View Audit Logs">
                </form>
                <?php
                echo "<br>";
                echo "<a href='admin.php'>Go to dashboard page</a> | <a href='audit.php'>Go back to audit trial page</a>";
                }
                ?>
                <head>
  <link rel="stylesheet" href="audit.css">
</head>

  
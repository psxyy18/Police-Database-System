<?php
  session_start(); // Start the session
  date_default_timezone_set('Europe/London');
  // connect to the database
  require("db.inc.php");

      $conn = mysqli_connect($servername, $username, $password, $dbname);   
  
  if (!empty($_POST)) {
    // retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password']; // Remove the call to password_hash
  
    // Check if the provided username already exists in the table
    $sql = "SELECT * FROM users WHERE Username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // The username already exists, display an error message
      echo "Error: The provided username is already in use. Please choose a different username.<br>";
      // Display a link to the login page and addofficer.php page
      echo "<a href='admin.php'>Go to dashboard page</a> | <a href='addofficer.php'>Go back to add officer page</a>";
    } else {
      // The username is available, insert the new record into the database
      $sql = "INSERT INTO users (Username,Password,type) VALUES ('$username', '$password','user')";
      $result = $conn->query($sql);
  
      // Check if the query was successful
      if ($result) {
        // Get the ID of the inserted record
        $record_id = $conn->insert_id;
  
        // Add a record to the audit trail for the inserted report
        $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
        $action = 'add a new officer account';
        $time = date('Y-m-d H:i:s');
        $conn->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");
  
        echo "New officer account created successfully! <br>";
        // Display a link to the login page and addofficer.php page
        echo "<a href='admin.php'>Go to dashboard page</a> | <a href='addofficer.php'>Go back to add officer page</a>";
      } else {
        // Display the error message returned by the query, along with links to the login page and addofficer.php page
        echo "Error adding user: " . $conn->error . " <br>";
        echo "<a href='admin.php'>Go to dashboard page</a> | <a href='addofficer.php'>Go back to add officer page</a>";
      }
    }
  } else {
    // display the form
    ?>
    <form action="addofficer.php" method="post">
      <label for="username">Username:</label><br>
      <input type="text" id="username" name="username"><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password"><br><br>
      <input type="submit" value="Create Account">
    </form>
    <br>
    <!-- Display a link to the login page -->
    <a href='login.php'>Go to login page</a>
    <?php
  }
  ?>
<head>
  <link rel="stylesheet" href="add_officer.css">
</head>


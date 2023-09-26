<!DOCTYPE html>
<html>
<head>
  <title>admin</title>
</head>
<body>
  <?php
    session_start();
  
    // Check if the user is logged in, if not redirect to the login page
    if(!isset($_SESSION['username'])) {
      header("Location: login.php");
    }
  
    // Check if the user is an administrator
    if($_SESSION['user_type'] == 'admin') {
      // Show additional content for administrators
      echo "<div class='message'>Welcome to the dashboard, administrator!</div>";
    } elseif($_SESSION['user_type'] == 'user') {
      // Show normal user content
      echo "<div class='message'>You don't have access to this page!</div>";
    header("Location: dashboard.php");
    }
  
    // Check if the user has requested to log out
    if(isset($_GET['logout'])) {
      // Unset all of the session variables
      $_SESSION = array();
      // Destroy the session
      session_destroy();
      // Redirect the user to the login page
      header("Location: login.php");
    }
  
    // Check if the user has requested to reset their password
    if(isset($_GET['reset_password'])) {
      // Redirect the user to the password reset page
      header("Location: reset_password.php");
    }
  ?>
  
  <!-- Add HTML for log out and password reset links -->
  <a href="logout.php">Log out</a> | <a href="reset_password.php">Reset password</a> | <a href="search.php">Search/Edit person information</a> | <a href="add_person.php">Add person</a> | <a href="search_vehicle.php">Search for vehicle</a> | <a href="add_vehicle.php">Add new vehicle</a> | <a href="submit_report.php">Submit report</a> | <a href="retrieve_incident1.php">Retrieve/Edit report</a> | <a href="addofficer.php">Add new officer account</a> | <a href="add_fine.php">Add fines</a> | <a href="audit.php">Audit trail</a>
</body>
</html>
<head>
  <link rel="stylesheet" href="admin.css">
</head>


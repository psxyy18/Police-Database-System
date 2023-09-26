<?php
  session_start();
  date_default_timezone_set('Europe/London');
  
  // Check if the user is already logged in, if so redirect to the dashboard
  if(isset($_SESSION['username'])) {
    header("Location: dashboard.php");
  }
  
  // Initialize the $user_type variable to an empty string
  $user_type = "";
  
  // Check if the form has been submitted
  if(isset($_POST['submit'])) {
    // Connect to the database
    require("db.inc.php");

      $db = mysqli_connect($servername, $username, $password, $dbname);   
    
    // Get the form data
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    // Check if the username and password are correct
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) == 1) {
      // Get the user type
      $user = mysqli_fetch_array($result);
      $user_type = $user['type'];
      // Set the session variables and redirect to the dashboard
      $_SESSION['username'] = $username;
      $_SESSION['user_type'] = $user_type;
      if($user_type == 'admin'){
        $_SESSION['logged_in'] = true;
        $_SESSION['is_admin'] = true;
        header('Location: admin.php');
      } elseif($user_type == 'user') {
        $_SESSION['logged_in'] = true;
        $_SESSION['is_admin'] = false;
        header("Location: dashboard.php");
      } else {
        // Display an error message
        $error = "Invalid user type";
      }
      
      // Add a record to the audit trail for the inserted report
      $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
      $action = 'login';
      $time = date('Y-m-d H:i:s');
      $record_id = $db->insert_id; // Get the ID of the inserted report
      $db->query("INSERT INTO audit_trail ( Action, Time, User) VALUES ('$action', '$time', '$user')");
    } else {
      // Display an error message
      $error = "Invalid username or password";
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
		<link rel="stylesheet" href="login.css">
  </head>
  <body>
    <?php if(isset($error)) { echo$error; } ?>
<form method="post" action="login.php">
<label for="username">Username:</label>
<input type="text" name="username" id="username">
<label for="password">Password:</label>
<input type="password" name="password" id="password">
<input type="submit" name="submit" value="Login">
</form>

  </body>
</html>

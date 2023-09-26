<?php
  date_default_timezone_set('Europe/London');
  // Start the session
  session_start();

  // Check if the user is logged in
  if(!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
  }

  // Connect to the database
  require("db.inc.php");

      $db = mysqli_connect($servername, $username, $password, $dbname);   

  // Check if the form has been submitted
  if(isset($_POST['submit'])) {
    // Get the form data
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Update the password in the database
    $query = "UPDATE users SET password='$password' WHERE username='$username'";
    mysqli_query($db, $query);

    // Add a record to the audit trail for the password reset
    $user = $_SESSION['username']; // Replace with the actual username of the user who performed the action
    $action = 'reset_password';
    $time = date('Y-m-d H:i:s');
    $db->query("INSERT INTO audit_trail (Action, Time, User) VALUES ('$action', '$time', '$user')");

    // Display a success message
    $success = "Password reset successful";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Reset Password</title>
  </head>
  <body>
    <?php if(isset($success)) { echo "<p class='success'>$success</p>"; } ?>
<form method="post" action="reset_password.php">
  <label for="username">Username:</label>
  <input type="text" name="username" id="username" value="<?php echo $_SESSION['username']; ?>" readonly>
  <label for="password">New Password:</label>
  <input type="password" name="password" id="password">
  <input type="submit" name="submit" value="Reset Password">
</form>

<?php if(isset($success)) { echo "<p class='success'>$success</p>"; } ?>

<p>To reset your password, enter your new password in the form above and click the "Reset Password" button.</p>

<p>Your password should be at least 8 characters long and should contain a combination of letters and numbers for added security.</p>

<p>If you have any trouble resetting your password, please contact your administrator for assistance.</p>

<p><a href="dashboard.php">Return to the dashboard</a></p>


<style>
  .success {
    color: green;
    font-weight: bold;
  }
</style>
<head>
  <link rel="stylesheet" href="reset_password.css">
</head>

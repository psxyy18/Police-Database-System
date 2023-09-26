<?php
  session_start();
  $_SESSION = array();
 
  // Destroy the session.
  session_destroy();
  #unset($_SESSION['user_type']);
  header('Location: login.php');
?>


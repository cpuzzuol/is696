<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h3>Thank you for signing up for an account!</h3>
<p>Now it's time to <a href="customerLogin.php">login</a> with your new credentials!</p>
<?php include 'footer.php' ?>
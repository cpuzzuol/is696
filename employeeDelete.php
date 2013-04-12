<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
if (1==1) {
  $insertSQL = sprintf("DELETE FROM Employee WHERE Username = '{$_REQUEST['Username']}';");
  $query = mysql_query($insertSQL);
  session_destroy();
  header(sprintf("Location: employeelogin.php"));
} else {
	include 'header.php';
	include 'sidebar.php';
  echo "<p>Your item could not be deleted! Sorry.</p>" . "<a href=\"employeeaccount.php\">Back to my account page.</a>";	
  include 'footer.php';
}
?>
<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
if (1==1) {
  $insertSQL = sprintf("DELETE FROM Service WHERE SerivceID = '{$_REQUEST['ServiceID']}';");
  $query = mysql_query($insertSQL);
  header(sprintf("Location: reservationsList.php"));
} else {
	include 'header.php';
	include 'sidebar.php';
  echo "<p>Your item could not be deleted! Sorry.</p>" . "<a href=\"reservationsList.php\">Back to reservations page.</a>";	
  include 'footer.php';
}
?>
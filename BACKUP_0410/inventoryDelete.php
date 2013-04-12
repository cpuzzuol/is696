<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
if (1==1) {
  $insertSQL = sprintf("DELETE FROM Part WHERE PartID = '{$_REQUEST['PartID']}';");
  $query = mysql_query($insertSQL);
  header(sprintf("Location: inventoryMain.php"));
} else {
	include 'header.php';
	include 'sidebar.php';
  echo "<p>Your item could not be deleted! Sorry.</p>" . "<a href=\"myaccount.php\">Back to account page.</a>";	
  include 'footer.php';
}
?>
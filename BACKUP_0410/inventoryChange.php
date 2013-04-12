<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 

if (isset($_POST['part-submit'])) {
  $insertSQL = sprintf("UPDATE Part SET Price='{$_POST['part-price']}', Quantity='{$_POST['part-quantity']}' WHERE PartID='{$_POST['part-id-hide']}';");
  $query = mysql_query($insertSQL);
  header(sprintf("Location: inventoryMain.php")); 
} else {
	include 'header.php';
	include 'sidebar.php';
  echo "<p>You do not have permssion to access this part of the site!</p>" . "<a href=\"index.php\">Back to Homepage</a>";	
  include 'footer.php';
}
?>
<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php mysql_select_db($database_godaddy, $godaddy);
if(isset($_POST['new-part-submit'])){
	$id = $_POST['new-part-id'];
	$name = $_POST['new-part-name'];
	$price = $_POST['new-part-price'];
	$brand = $_POST['new-part-brand'];
	$quantity = $_POST['new-part-quantity'];
	$query_part = ("INSERT INTO Part (PartID, PartName, Price, partBrand, Quantity) VALUES ('{$id}','{$name}','{$price}','{$brand}','{$quantity}');");
	$part_search = mysql_query($query_part, $godaddy) or die(mysql_error());
	header("Location: inventoryMain.php");
}
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>Add Inventory</h4>
<form method="post" id="show-inventory-item" action="<?php $_SERVER['PHP_SELF']; ?>">
<table width="605" border="1" align="center" cellpadding="3">
  <tr>
    <td><span class="detail">Part ID</span></td>
    <td><input type="text" id="new-part-id" name="new-part-id" placeholder="ex: EJ3948X#B" required></td>
  </tr>
  <tr>
    <td><span class="detail">Part Name</span></td>
    <td><input type="text" id="new-part-name" name="new-part-name" placeholder="ex: Oil Filter" required></td>
  </tr>
  <tr>
    <td><span class="detail">Price</span></td>
    <td><input type="text" id="new-part-price" name="new-part-price" placeholder="ex: 44.99" required></td>
  </tr>
  <tr>
    <td><span class="detail">Brand</span></td>
    <td><input type="text" id="new-part-brand" name="new-part-brand" placeholder="ex: Moog" required></td>
  </tr>
  <tr>
    <td><span class="detail">Quantity</span></td>
    <td><input type="number" id="new-part-quantity" name="new-part-quantity" placeholder="ex: 15" required></td>
  </tr>
</table>
<br>
<input type="submit" id="new-part-submit" name="new-part-submit" value="Add Item">
</form>
<p>&nbsp;</p>
<?php include 'footer.php'; ?>
<?php
mysql_free_result($part_search);
?>
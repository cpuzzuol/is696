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

<?php $invID = $_POST['inventorySearch'];?>
<?php mysql_select_db($database_godaddy, $godaddy);
/*USE THE $_REQUEST global variable to get the PartID from the URL*/
$query_part = ("SELECT * FROM Part WHERE PartID = '{$_REQUEST['PartID']}';");
$part_search = mysql_query($query_part, $godaddy) or die(mysql_error());
$row_part = mysql_fetch_assoc($part_search);
$totalRows_part = mysql_num_rows($part_search);?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>Service Request Detail</h4>
<?php if($row_part['PartID']):?>
<p>Product details for Item #<strong><?php echo $row_part['PartID']; ?></strong></p>
<p>You can update pricing and quantity information below.</p>
<form method="post" id="show-inventory-item" action="inventoryChange.php">
<table width="605" border="1" align="center" cellpadding="3">
  <tr>
    <td><span class="detail">Part ID</span></td>
    <td><input type="text" id="part-id" name="part-id" value="<?php echo $row_part['PartID']; ?>" disabled></td>
  </tr>
  <tr>
    <td><span class="detail">Part Name</span></td>
    <td><input type="text" id="part-name" name="part-name" value="<?php echo $row_part['PartName']; ?>" disabled></td>
  </tr>
  <tr>
    <td><span class="detail">Price</span></td>
    <td><input type="text" id="part-price" name="part-price" value="<?php echo $row_part['Price']; ?>"></td>
  </tr>
  <tr>
    <td><span class="detail">Brand</span></td>
    <td><input type="text" id="part-brand" name="part-brand" value="<?php echo $row_part['partBrand']; ?>" disabled></td>
  </tr>
  <tr>
    <td><span class="detail">Quantity</span></td>
    <td><input type="text" id="part-quantity" name="part-quantity" value="<?php echo $row_part['Quantity']; ?>"></td>
  </tr>
</table>
<br>
<input type="hidden" id="part-id-hide" name="part-id-hide" value="<?php echo $row_part['PartID']; ?>">
<input type="submit" id="part-submit" name="part-submit" value="Make Changes">
<input type="button" class="red-button" id="part-delete" name="part-delete" value="DELETE PART" onClick="reallyDelete();">
</form>
<p>&nbsp;</p>
<?php else: ?>
<p>EY! FUGET ABOUT IT! THAT PART DON'T EVEN EXIST HEE!</p>
<p><a href="inventoryMain.php">Try again</a></p>
<?php endif; ?>
<?php include 'footer.php'; ?>
<?php
mysql_free_result($part_search);
?>
<script>
	function reallyDelete(){
		var conf = confirm("Are you sure you want to delete this item?");
		if(conf){
			window.location = "inventoryDelete.php?PartID=<?php echo $row_part['PartID']; ?>"	
		}
	}
</script>
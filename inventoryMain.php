<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "employeelogin.php";
if (!(isset($_SESSION['MM_UserGroup']))){
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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
mysql_select_db($database_godaddy, $godaddy);
$query_rs_part = ("SELECT * FROM Part ORDER BY PartID ASC;");
$rs_part = mysql_query($query_rs_part, $godaddy) or die(mysql_error());
$totalRows_rs_part = mysql_num_rows($rs_part);
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>Inventory System</h4>
<p style="color:#0088CC">Click on a part's ID to view it, edit it, or delete it.</p>
<table id="inventoryTable" name="inventoryTable" border="1" cellpadding="1" cellspacing="1">
<tbody>
<?php
while($row_rs_part = mysql_fetch_assoc($rs_part)){
	echo "<tr>";
		/*Passing the PardID in through the URL eliminates the need for a form...you can use it with the $_REQUEST global on the inventoryDetail page */
		echo "<td><a href=\"inventoryDetail.php?PartID=" . $row_rs_part['PartID'] . "\">" . $row_rs_part['PartID'] . "</a></td>";
		echo "<td>{$row_rs_part['PartName']}</td>";
		echo "<td>{$row_rs_part['Price']}</td>";
		echo "<td>{$row_rs_part['partBrand']}</td>";
		echo "<td>{$row_rs_part['Quantity']}</td>";
	echo "</tr>";	
}
?>
</tbody>
<thead>
	<tr>
    	<td>Part ID</td>
        <td>Part Name</td>
        <td>Price</td>
        <td>Brand</td>
        <td>Quantity</td>
    </tr>
</thead>
</table>
<br>
<form action="inventoryAdd.php" method="post">
	<input type="submit" class="green-button" name="add-submit" value="Add New Item">
</form>
<?php include 'footer.php'; ?>
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
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
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
$query_rs_service =("SELECT * FROM Service ORDER  BY SerivceID ASC;");
$rs_service = mysql_query($query_rs_service, $godaddy) or die(mysql_error());
$row_rs_service = mysql_fetch_assoc($rs_service);
$totalRows_rs_service = mysql_num_rows($rs_service);
?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<form name="employeeStartForm" method="post" action="empstartTosvcdet.php">
  <span id="sprytextfield1">
  <h4>
    <input placeholder="Enter a Service ID Number" type="number" name="SerivceID" id="SerivceID">
    <br>
    <span class="textfieldRequiredMsg">Service ID Number required</span></h4>
  </span>
  <p>
    <input name="" type="submit">
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
      </script>  
  </p>
  <p>&nbsp;</p>
</form>
<form method="get">
<table id="ServiceTable" name="ServiceTable" border="1" cellpadding="1" cellspacing="1">
<tbody>
<?php
while($row_rs_service = mysql_fetch_assoc($rs_service)){
	echo "<tr>";
		echo "<td><a href=\"servicedetail.php?SerivceID=" . $row_rs_service['SerivceID'] . "&username=" . $row_rs_service['username'] . "\">" . $row_rs_service['SerivceID'] . "</a></td>";
		echo "<td>{$row_rs_service['username']}</td>";
		echo "<td>{$row_rs_service['DateRequest']}</td>";
	echo "</tr>";	
}
?>
</tbody>
<thead>
	<tr>
    	<td>Service ID</td>
        <td>Customer Username</td>
        <td>Date Requested</td>
      </tr>
</thead>
</table>
</form>
<?php include 'footer.php' ?>
<?php
mysql_free_result($rs_service);
?>

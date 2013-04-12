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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form9")) {
 $insertSQL = sprintf("INSERT INTO ServiceNotes (ServiceID, notes) VALUES (%s, %s)",
                       GetSQLValueString($_REQUEST['SerivceID'], "int"),
                       GetSQLValueString($_POST['servicenotes'], "text"));

  mysql_select_db($database_godaddy, $godaddy);
  $Result1 = mysql_query($insertSQL, $godaddy) or die(mysql_error());
}

mysql_select_db($database_godaddy, $godaddy);
$query_rs_servicenotes = ("SELECT * FROM ServiceNotes WHERE ServiceID = '{$_REQUEST['SerivceID']}';");
$rs_servicenotes = mysql_query($query_rs_servicenotes, $godaddy) or die(mysql_error());
/*$row_rs_servicenotes = mysql_fetch_assoc($rs_servicenotes);*/ 
$totalRows_rs_servicenotes = mysql_num_rows($rs_servicenotes);

?>
<?php mysql_select_db($database_godaddy, $godaddy);
/*Query for Service Information*/
$query_rs_vehicle = sprintf("SELECT SerivceID, username, ServiceReq, vehicleYear, vehicleMake, vehicleModel FROM Service WHERE SerivceID = '{$_REQUEST['SerivceID']}';");
$rs_vehicle = mysql_query($query_rs_vehicle, $godaddy) or die(mysql_error());
$row_rs_vehicle = mysql_fetch_assoc($rs_vehicle);
$totalRows_rs_vehicle = mysql_num_rows($rs_vehicle);
$_SESSION['svc_SerivceID'] = $row_rs_vehicle['SerivceID'];
$_SESSION['svc_username'] = $row_rs_vehicle['username'];
$_SESSION['svc_ServiceReq'] = $row_rs_vehicle['ServiceReq'];
$_SESSION['svc_vehicleYear'] = $row_rs_vehicle['vehicleYear'];
$_SESSION['svc_vehicleMake'] = $row_rs_vehicle['vehicleMake'];
$_SESSION['svc_vehicleModel'] = $row_rs_vehicle['vehicleModel'];
/*Query for Customer Information*/
$insertsql = sprintf("SELECT FirstName, LastName, Street, City, State, Zip, EmailAddress, Phone FROM Customer WHERE Username = '{$_REQUEST['username']}';");
$query = mysql_query($insertsql);
$row = mysql_num_rows($query);
$assoc = mysql_fetch_assoc($query);
$_SESSION['cust_FirstName'] = $assoc['FirstName'];
$_SESSION['cust_LastName'] = $assoc['LastName'];
$_SESSION['cust_Street'] = $assoc['Street'];
$_SESSION['cust_City'] = $assoc['City'];
$_SESSION['cust_State'] = $assoc['State'];
$_SESSION['cust_Zip'] = $assoc['Zip'];
$_SESSION['cust_Email'] = $assoc['EmailAddress'];
$_SESSION['cust_Phone'] = $assoc['Phone'];
?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<h4>Service ID Request Detail</h4>
<?php if($row_rs_vehicle['SerivceID']):?>
<table width="605" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td width="94"><span class="detail">Service</span> <span class="detail">ID</span></td>
    <td width="165">
      <?php echo $row_rs_vehicle['SerivceID']; ?>
      <input type="hidden" name="hiddenID" value="<?php echo $row_rs_vehicle['SerivceID']; ?>">
	</td>
    <td width="67" class="detail" colspan="2">Customer Username</td>
    <td width="251">
      <?php echo $row_rs_vehicle['username']; ?>
    </td>
  </tr>
  <tr>
    <td><span class="detail">Customer Issue </span></td>
    <td colspan="4"><?php echo $row_rs_vehicle['ServiceReq']; ?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Name </span></td>
    <td colspan="4"><?php echo $assoc['FirstName'] . " " . $assoc['LastName']; ?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Vehicle</span></td>
    <td colspan="4"><?php echo $row_rs_vehicle['vehicleYear'] . " " . $row_rs_vehicle['vehicleMake']  
	. " " . $row_rs_vehicle['vehicleModel']; ?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Address </span></td>
    <td colspan="4"><?php echo $assoc['Street'] . "<br>" . $assoc['City'] . ", ". $assoc['State'] . " " . $assoc['Zip'];?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Contact Info </span></td>
    <td colspan="4"><strong>Phone:</strong> <?php echo $assoc['Phone'];?> <br> <strong>Email:</strong> <?php echo "<a href=\"mailto:{$assoc['EmailAddress']}\">". $assoc['EmailAddress'] . "</a>";?></td>
  </tr>

 
<?php endif; ?>
</table>
     <table id="servicenotes-main" width="605" border="0" align="center" cellpadding="3" cellspacing="0">

    <form name="form1" method="post" action="">
        <tbody>
          <?php
while($row_rs_servicenotes = mysql_fetch_assoc($rs_servicenotes)){
	echo "<tr>";
		echo "<td>{$row_rs_servicenotes['notes']}</td>";
		echo "<td>{$row_rs_servicenotes['time']}</td>";
	echo "</tr>";	
}
?>
    </form>
    
    <thead>
      <tr>
        <td>Notes</td>
        <td>Date & Time</td>
        
      </tr>
</thead>
   
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</ul>

<p align="right"><a href="myaccount.php">Back to account details</a></p>

<p>&nbsp;</p>
</tbody>
</table>
<?php include 'footer.php'; ?>
<?php
mysql_free_result($rs_servicenotes);
?>
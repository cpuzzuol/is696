<?php require_once('Connections/godaddy.php'); ?>
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
<?php
/* Only let EMPLOYEES see the add and remove parts feature */
if(isset($_SESSION['MM_UserGroup'])): 
/*Query for Service Part Information*/
$part_insertsql = sprintf("SELECT PartName FROM Part");
$part_serviceparts = mysql_query($part_insertsql, $godaddy) or die(mysql_error());
$totalRows_part_serviceparts = mysql_num_rows($part_serviceparts);
?>
  <tr>
    <td class="detail">Parts</td>
    <td height="119" colspan="2">
    <form name="addForm">
      <p>
         <select size="<?php echo $totalRows_part_serviceparts; ?>" name="parts-list" id="parts-list" multiple> 
		  <?php 
			 while ($row_part_serviceparts = mysql_fetch_assoc($part_serviceparts)){
				echo "<option value=\"{$row_part_serviceparts['PartName']}\">{$row_part_serviceparts['PartName']}</option>"; 
			 }
		  ?>
         </select>
      </p>
    </form>
    </td>
    <td>
    <form id="arrows">
    	<input type="button" id="add" name="add" value=">" onClick="addPart()"><br>
        <input type="button" id="add" name="add" value="<" onclick="removePart()">
    </form>
    </td>
    <td><form id="removeForm">
      <p>Parts Ordered</p>
      <p>
         <select size="<?php echo $totalRows_part_serviceparts; ?>" name="used-list" id="used-list"> 
		  
         </select>
      </p>
        </form>

    <p>&nbsp;</p>
    </td>
  </tr>
  <tr valign="baseline">
    <td class="detail">
      	<p>Labor Hours</p>
    </td>
    <td colspan="2">
    	<form id="labor-hours">
        	<input type="number" id="labor" name="labor" placeholder="ex: 3">
        </form>
    </td>
  </tr>
<?php endif; ?>
</table>
    <div><form id="print-buttons" action="<?php $_SERVER['PHP_SELF']; ?>">
      <input type="button" id="toInvoice" value="Print Invoice" onClick="getMyParts()">
    </form></div>
    <div><form action="reservationsList.php">
      <input name="return" type="submit" id="return" value="Return to Service Requests">
    </form></div>
    <div><form>
            <input type="button" class="red-button" id="user-delete" name="user-delete" value="DELETE REQUEST" onClick="reallyDelete();">
        </form></div>

  <table id="servicenotes-main" width="605" border="0" align="center" cellpadding="3" cellspacing="0">
    <?php
/* Only let EMPLOYEES see the add and remove parts feature */
if(isset($_SESSION['MM_UserGroup'])): 
/*Query for Service Part Information*/
$part_insertsql = sprintf("SELECT PartName FROM Part");
$part_serviceparts = mysql_query($part_insertsql, $godaddy) or die(mysql_error());
$totalRows_part_serviceparts = mysql_num_rows($part_serviceparts);
?>
    <tr>
      <td width="94"  class="detail">Service Notes</td>
      <td height="119" colspan="2"><form method="POST" action="<?php echo $editFormAction; ?>" name="form9" id="form9">
        <p><span id="sprytextarea1">
          <textarea name="servicenotes" rows="10" id="servicenotes"></textarea>
          <span class="textareaRequiredMsg">required</span></span></p>
        <p>
          <input name="savenotes" type="submit" value="Save Notes">
          <input type="hidden" name="MM_insert" value="form9">
        </p>
      </form></td>
      <td width="268" colspan="2"><form name="form1" method="post" action="">
        <table id="servicenotes" name="servicenotes" border="1" cellpadding="1" cellspacing="1">
        <tbody>
          <?php
while($row_rs_servicenotes = mysql_fetch_assoc($rs_servicenotes)){
	echo "<tr>";
		echo "<td>{$row_rs_servicenotes['notes']}</td>";
		echo "<td>{$row_rs_servicenotes['time']}</td>";
	echo "</tr>";	
}
?>
        </form></td>
    </tr>
    <thead>
      <tr>
        <td>Notes</td>
        <td>Date & Time</td>
        
      </tr>
</thead>
    <?php endif; ?>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</ul>
<?php else: ?>
<p><font color="#FF0000">That Service ID does not exist</font></p>
<p><a href="reservationsList.php">Try again</a></p>
<?php endif; 
if(isset($_SESSION['MM_UserGroup'])):
?>
<?php else: ?>
<p align="right"><a href="myaccount.php">Back to account details</a></p>
<p>
  <?php endif; ?>
</p>
<p>&nbsp;</p>
</tbody>
</table>
<?php include 'footer.php'; ?>
<?php
mysql_free_result($rs_servicenotes);
?>
<script>
/*Add a part to the "Parts ordered list"*/
	function addPart(){
		var list = document.getElementById("parts-list");
		var listItem = list.options[list.selectedIndex].value;
		/*Only execute if an item is selected...prevent possible errors*/
		if(listItem){
			var addToList = document.getElementById("used-list");
			var newItem = document.createElement("option");
			var newItemText = document.createTextNode(listItem);
			newItem.appendChild(newItemText);
			addToList.appendChild(newItem);
			
			/*print invoice form*/
			var printForm = document.getElementById("print-buttons");
			var submitBtn = document.getElementById("toInvoice");
			var parent = submitBtn.parentNode;
			var newInput = document.createElement("input");
			newInput.type = "hidden";
			newInput.value = listItem;
			/*insert the new node BEFORE the submit button*/
			parent.insertBefore(newInput, submitBtn);
			/*
			printForm.appendChild(newInput);*/	
		}
	}
/*Remove a part from the table of Hidden Fields...passed a parameter which is the value of the part you want to remove*/
	function removeFromTable(itemToRemove){
		/*get the form where the parts are sent*/
			var form = document.getElementById("print-buttons");
			/*for each of the form's items...*/
			for(var i=0; i < form.length; i++){
				/*if the current(i) form's element is a <input type="text" value="the part you want"> ...*/	
				if((form.elements[i].type == "hidden") && (form.elements[i].value == itemToRemove)){
					/*remove this element from the form!*/
					form.removeChild(form.elements[i]);	
					break; //this statement MUST be here or else it will delete multiple items with the same value
				}
			}
	}
   /*Remove a part from "Ordered Parts" form call the removeFromTable() function to also remove it from the table of hidden fields*/
	function removePart(){
		var usedList = document.getElementById("used-list");
		var usedListItem = usedList.options[usedList.selectedIndex];
		var usedListItemValue = usedList.options[usedList.selectedIndex].value;
		/*Only execute if an item is selected...prevent possible errors*/
		if(usedListItem){
			/*remove item from the list*/
			usedList.removeChild(usedListItem);	
			/*call the function that has the item removed from the table of hidden fields!*/
			removeFromTable(usedListItemValue);	
		}
	}
	
	/*Sends the URL with the appended parameters based upon which parts the user has selected*/
	function getMyParts(){
		var theList = document.getElementById("print-buttons");
		var url = "printdetail.php?"; //Our base url
		/*for each hidden field in the form 
		(we know it will be length-1 because only hidden fields are going in here besides the submit button at the end...hence the -1)*/
		for(var i=0; i < theList.length -1; i++){	
			/*if it's the first element, can simply append the key with the value...otherwise we need the & to connect parameters*/
			if(i==0){
				url += "PartName" + i + "=" + theList.elements[i].value;	
			} else {
				url += "&PartName" + i + "=" + theList.elements[i].value;	
			}
		}
		/*Adds the labor cost to the URL*/
		var theLabor = document.getElementById("labor").value;
		url += "&Labor=" + theLabor;
		window.open(url,'mywindow','width=700,height=700,scrollbars=1');
	}
	
	/*Ask the user if they really want to delete the service request*/
	function reallyDelete(){
		var conf = confirm("Are you sure you want to delete your account item? Doing so will delete your user information for good!");
		if(conf){
			window.location = "serviceDelete.php?ServiceID=<?php echo $row_rs_vehicle['SerivceID']; ?>"	
		}
	}
</script>
<script>var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");</script>
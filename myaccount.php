<?php require_once('Connections/godaddy.php'); ?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>My Account Page</h4>
<?php
mysql_select_db("IS696");
/*Query for Customer information*/
$sql = sprintf("SELECT FirstName, LastName, Street, City, State, Zip, Username, EmailAddress, Phone FROM Customer WHERE Username = '{$_SESSION['MM_Username']}';");
$retrieve = mysql_query($sql);
if (!$retrieve) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
}
while ($row = mysql_fetch_assoc($retrieve)):
    $user_fname = $row['FirstName'];
    $user_last = $row['LastName'];
    $user_street = $row['Street'];
	$user_city = $row['City'];
    $user_state = $row['State'];
    $user_zip = $row['Zip'];
    $user_username = $row['Username'];
	$user_email = $row['EmailAddress'];
    $user_phone = $row['Phone'];

mysql_select_db($database_godaddy, $godaddy);
$query_rs_state = "SELECT DISTINCT (state_name) FROM tbl_state ORDER BY `state_name` ASC";
$rs_state = mysql_query($query_rs_state, $godaddy) or die(mysql_error());
$row_rs_state = mysql_fetch_assoc($rs_state);
$totalRows_rs_state = mysql_num_rows($rs_state);
?>
<p><strong>Simply change the fields below to update your account information. Click "Submit Changes" to save your updates.</strong></p>
<p>Note: User names cannot be changed once they are created.</p>
<form action="processAccountChanges.php" method="post" name="account-form" id="account-form">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">First Name</td>
      <td><span id="sprytextfield1">
            <input type="text" name="user-fname" id="user-fname" value="<?php echo $user_fname;?>" />
          <span class="textfieldRequiredMsg">A value is required.</span></span><br></td>
   	</tr>
  	<tr valign="baseline">
      <td nowrap align="right">Last Name: </td>
      <td><span id="sprytextfield2">
            <input type="text" name="user-last" id="user-last" value="<?php echo $user_last;?>" />
  		  <span class="textfieldRequiredMsg">A value is required.</span></span><br></td>
   	</tr>
  	<tr valign="baseline">
      <td nowrap align="right">Address: </td>
      <td><span id="sprytextfield3">
            <input type="text" name="user-street" id="user-street" value="<?php echo $user_street;?>" />
          <span class="textfieldRequiredMsg">A value is required.</span></span><br></td>
    </tr>
  	<tr valign="baseline">
      <td nowrap align="right">City: </td>
      <td><span id="sprytextfield4">
            <input type="text" name="user-city" id="user-city" value="<?php echo $user_city;?>" />
          <span class="textfieldRequiredMsg">A value is required.</span></span><br></td>
    </tr>
  	<tr valign="baseline">
      <td nowrap align="right">State: </td>
      <td><span id="sprytextfield5">
            <select name="user-state" id="user-state" value="<?php echo $user_state;?>" />
            <option selected><?php echo $user_state;?></option>
          <?php
do {  
?>
    <option value="<?php echo $row_rs_state['state_name']?>"><?php echo $row_rs_state['state_name']?></option>
    <?php
} while ($row_rs_state = mysql_fetch_assoc($rs_state));
  $rows = mysql_num_rows($rs_state);
  if($rows > 0) {
      mysql_data_seek($rs_state, 0);
	  $row_rs_state = mysql_fetch_assoc($rs_state);
  }
?>
  </select></td>
    </tr>
  	<tr valign="baseline">
      <td nowrap align="right">Zip: </td>
      <td><span id="sprytextfield6">
            <input type="text" name="user-zip" id="user-zip" value="<?php echo $user_zip;?>" />
          <span class="textfieldRequiredMsg">A value is required.</span></span><br></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone Number: </td>
      <td><span id="sprytextfield9">
            <input type="text" name="user-phone" id="user-phone" value="<?php echo $user_phone;?>" />
          <span class="textfieldRequiredMsg">A valid phone number is required.</span><span class="textfieldInvalidFormatMsg">Phone number required.</span></span><br></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email: </td>
      <td><span id="sprytextfield8">
            <input type="text" name="user-email" id="user-email" value="<?php echo $user_email;?>" />
          <span class="textfieldRequiredMsg">An email address is required.</span><span class="textfieldInvalidFormatMsg">Email address required!</span></span><br></td>
 	</tr>   
    <tr valign="baseline">
      <td nowrap align="right">Username: </td>
      <td><span id="sprytextfield7">
            <input type="text" name="user-username" id="user-username" value="<?php echo $user_username;?>" disabled/>
            <input type="hidden" name="user-username-hidden" id="user-username-hidden" value="<?php echo $user_username;?>"/>
          <span class="textfieldRequiredMsg">A value is required.</span></span><br></td>
    </tr>      
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="change-values" id="change-values" type="submit" value="Submit Changes" />
      		<input type="button" class="red-button" id="user-delete" name="user-delete" value="DELETE ACCOUNT" onClick="reallyDelete();">
      </td>
    </tr>
    </table>
</form>
<h5>My Service Requests</h5>
<?php 
endwhile;
/*Query for Service Information*/
$query_rs_vehicle = sprintf("SELECT * FROM Service WHERE username = '{$_SESSION['MM_Username']}';");
$rs_vehicle = mysql_query($query_rs_vehicle, $godaddy) or die(mysql_error());
if (!$rs_vehicle) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
}
while ($row2 = mysql_fetch_assoc($rs_vehicle)):
    $serviceID = $row2['SerivceID'];
    $service_user = $row2['LastName'];
    $service_req = $row2['ServiceReq'];
	$service_vehicleYear = $row2['vehicleYear'];
    $service_make = $row2['vehicleMake'];
    $service_model = $row2['vehicleModel'];
	$service_date = $row2['DateRequest'];
	
?>
<form action="" method="get">
<table id="ServiceTable" name="ServiceTable" border="1" cellpadding="1" cellspacing="1">
<tbody>
<?php
	echo "<tr>";
		echo "<td><a href=\"customerservicedetail.php?SerivceID=" . $serviceID . "&username=" . $user_username . "\">" . $serviceID . "</a></td>";
		echo "<td>{$user_username}</td>";
		echo "<td>{$service_date}</td>";
	echo "</tr>";	
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
<?php 
endwhile; 
mysql_free_result($retrieve);
mysql_free_result($rs_vehicle);
?>
<p>Click here to <a href="changePassword.php">change your password</a></p>
<p>Click here to <a href="logout.php">logout</a></p>
<?php include 'footer.php' ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "zip_code", {useCharacterMasking:true});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "email");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "phone_number", {useCharacterMasking:true});

/*Ask the user if they really want to delete the service request*/
function reallyDelete(){
	var conf = confirm("Are you sure you want to delete your account item? Doing so will delete your user information for good!");
	if(conf){
		window.location = "customerDelete.php?Username=<?php echo $user_username; ?>"	
	}
}

</script>
<?php require_once('Connections/godaddy.php'); ?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>My Account Page</h4>
<?php
mysql_select_db("IS696");

$sql = sprintf("SELECT FirstName, LastName, Username FROM Employee WHERE Username = '{$_SESSION['MM_Username']}';");

$retrieve = mysql_query($sql);

if (!$retrieve) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
}

while ($row = mysql_fetch_assoc($retrieve)):
    $employee_fname = $row['FirstName'];
    $employee_last = $row['LastName'];
    $employee_username = $row['Username'];
?>
<p><strong>Simply change the fields below to update your account information. Click "Make Changes" to save your updates.</strong></p>
<p>Note: User names cannot be changed once they are created.</p>
<form action="processEmployeeAccountChanges.php" method="post" name="account-form" id="account-form">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">First Name</td>
      <td><span id="sprytextfield1">
            <input type="text" name="employee-fname" id="employee-fname" value="<?php echo $employee_fname;?>" />
          <span class="textfieldRequiredMsg">required</span></span><br></td>
   	</tr>
  	<tr valign="baseline">
      <td nowrap align="right">Last Name: </td>
      <td><span id="sprytextfield2">
            <input type="text" name="employee-last" id="employee-last" value="<?php echo $employee_last;?>" />
  		  <span class="textfieldRequiredMsg">required</span></span><br></td>
   	</tr>
  	<tr valign="baseline">
      <td nowrap align="right">Username: </td>
      <td><span id="sprytextfield7">
            <input type="text" name="employee-username" id="employee-username" value="<?php echo $employee_username;?>" disabled/>
            <input type="hidden" name="employee-username-hidden" id="employee-username-hidden" value="<?php echo $employee_username;?>" />
          <span class="textfieldRequiredMsg">required</span></span><br></td>
    </tr>       
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input name="change-values" id="change-values" type="submit" value="Make Changes" />
      <?php if($_SESSION['MM_Username'] !== "admin"): ?>
        <input type="button" class="red-button" id="employee-delete" name="employee-delete" value="DELETE ACCOUNT" onClick="reallyDelete();">
      <?php endif; ?>
      </td>
    </tr>
    </table>
</form>
<p>Click here to <a href="employeeChangePassword.php">change your password</a></p>
<p>Click here to <a href="logout.php">logout</a></p>
<?php 
endwhile;
mysql_free_result($retrieve);
?>
<?php include 'footer.php' ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");

function reallyDelete(){
	var conf = confirm("Are you sure you want to delete your account item? Doing so will delete your user information for good!");
	if(conf){
		window.location = "employeeDelete.php?Username=<?php echo $employee_username; ?>"	
	}
}

</script>
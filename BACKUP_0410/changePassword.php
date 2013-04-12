<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
/*The script is a self submitting single page form that
requires the user to know their current password, and correctly enter a new
password, then emails the user for notification. This does require  a working
mail server.*/


//Establish output variable - For displaying Error Messages
$msg = "";

//Check to see if the form has been submitted
if (mysql_real_escape_string($_POST['change-pass'])):

    //Establish Post form variables
    $username = mysql_real_escape_string($_POST['username']);
    $oldpassword = mysql_real_escape_string($_POST['old-password']);
    $newpassword = mysql_real_escape_string($_POST['new-password']);
    $confnewpassword = mysql_real_escape_string($_POST['confirm-new-password']);

    // Query the database - To find which user we're working with
	mysql_select_db('IS696');
    $sql = "SELECT * FROM Customer WHERE Username = '$username' ";
    $query = mysql_query($sql);
    $numrows = mysql_num_rows($query);

    //Gather database information
    while ($rows = mysql_fetch_array($query)):

        $dbusername = $rows['Username'];
        $dbpassword = $rows['password'];
        $dbfirstname = $rows ['FirstName'];
        $dblastname = $rows ['LastName'];

    endwhile;

    if ($numrows == 0):

        $msg = "This username does not exist";
		echo $msg;
    elseif ($oldpassword != $dbpassword):

        $msg = "The CURRENT password you entered is incorrect.";
		echo $msg;
    elseif ($newpassword != $confnewpassword):

        $msg = "Your new passwords do not match";
		echo $msg;
    elseif ($newpassword == $password):

        $msg = "Your new password cannot match your old password";
		echo $msg;
    else:
        $msg = "Your Password has been changed.";
		echo $msg;
        mysql_query("UPDATE Customer SET password = '$newpassword', passwordValidate = '$confnewpassword' WHERE Username = '$username'");

        /*$to = $email;

        $subject = "YOUR PASSWORD HAS BEEN CHANGED";

        $message = "<p>Hello $dbfirstname $dblastname. You've received this E-Mail
        because you have requested a PASSWORD CHANGE. If you did not submit a password
        change request, and believe this account modification to be fraudulant, please
        click <a href=\"#\">HERE.</a>";

        $from = "my@emailaddress.com";

        $headers = "From: $from";

        //Mails the username and unencrypted password to the user
        mail($to,$subject,$message,$headers);*/
	endif;
endif;
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <p>Change Password</p>
     Username:
  <p><span id="sprytextfield1">

    <input type="text" name="username" id="username">
  <span class="textfieldRequiredMsg">username required</span></span> </p>
  Old Password:     
  <p><span id="sprytextfield2">
     			
      <input type="password" name="old-password" id="old-password">
  <span class="textfieldRequiredMsg">old password required</span></span> </p>

  New Password:     
  <p><span id="sprytextfield3">
     			
      <input type="password" name="new-password" id="new-password">
  <span class="textfieldRequiredMsg">new password required</span></span> </p>
  Confirm New Password:     
  <p><span id="sprytextfield4">
     			
      <input type="password" name="confirm-new-password" id="confirm-new-password">
  <span class="textfieldRequiredMsg">new password required</span></span> </p>
  <p>
    <input type="submit" name="change-pass" id="change-pass" value="Change Password">
  </p>
</form>
<?php include 'footer.php' ?>
<script type="text/javascript">
/*var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");*/
</script>

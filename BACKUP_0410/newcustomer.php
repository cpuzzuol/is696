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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	/*check to see if username already exists, if so go back and tell the user to use a different name*/
  mysql_select_db("IS696");
  $dupe = sprintf("SELECT Username FROM Customer WHERE Username='{$_POST['Username']}';");
  $query_dupe = mysql_query($dupe) or die('Cannot Execute:'. mysql_error());;
  $num_rows = mysql_num_rows($query_dupe);
  /*if there is a matching row with a username, tell them to enter a new one*/
    if ($num_rows) {
    	$user_dup = "<p style=\"color:red\">This user name already on our database! Please try again with a new user name.</p>";
		$pick_another_name = true;
    } 
	/*if there are no pre-existing accuonts with the same user, execute the query normally*/
	else {
		  $insertSQL = sprintf("INSERT INTO Customer (FirstName, LastName, Street, City, State, Zip, Phone, Username, EmailAddress, password, passwordValidate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($_POST['FirstName'], "text"),
							   GetSQLValueString($_POST['LastName'], "text"),
							   GetSQLValueString($_POST['Street'], "text"),
							   GetSQLValueString($_POST['City'], "text"),
							   GetSQLValueString($_POST['state'], "text"),
							   GetSQLValueString($_POST['zip'], "int"),
							   GetSQLValueString($_POST['Phone'], "text"),
							   GetSQLValueString($_POST['Username'], "text"),
							   GetSQLValueString($_POST['EmailAddress'], "text"),
							   GetSQLValueString($_POST['password'], "text"),
							   GetSQLValueString($_POST['passwordValidate'], "text"));
		  mysql_select_db($database_godaddy, $godaddy);
		  $Result1 = mysql_query($insertSQL, $godaddy) or die(mysql_error());
		  $insertGoTo = "newaccountconfirm.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  header(sprintf("Location: %s", $insertGoTo));
	}
}

mysql_select_db($database_godaddy, $godaddy);
$query_rs_state = "SELECT DISTINCT (state_name) FROM tbl_state ORDER BY `state_name` ASC";
$rs_state = mysql_query($query_rs_state, $godaddy) or die(mysql_error());
$row_rs_state = mysql_fetch_assoc($rs_state);
$totalRows_rs_state = mysql_num_rows($rs_state);
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h3>Welcome to Puzzuoli's Mr. Muffler</h3>
<h4><font color="blue">Complete the form to create a new account</font></h4>
<?php if($pick_another_name){ echo $user_dup; }?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">

   
      
    <div><span id="sprytextfield1">
        <input placeholder="First Name" type="text" name="FirstName" value="" size="32">
      </span><span class="required"></span></div>
    
      
    <div> <span id="sprytextfield2">
        <input placeholder="Last Name" type="text" name="LastName" value="" size="32">
      </span><span class="required"></span></div>

    <div><input placeholder="Street" type="text" name="Street" value="" size="32"></div>
 
     
    <div><input placeholder="City" type="text" name="City" value="" size="32"></div>
    
    <div><select name="state" id="state">
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
  </select></div>
   
    <div><span id="sprytextfield5">
        <input placeholder="Zip Code" type="text" name="zip" id="zip" size="32">
            <span class="textfieldInvalidFormatMsg">format</span></span><span class="required"></span></div>
  
    <div><span id="sprytextfield4">
      <input placeholder="Phone Number" type="text" name="Phone" value="" size="32">
      <span class="textfieldInvalidFormatMsg">Invalid phone number.</span></span><span class="required"></span></div>
  
      
    <div><span id="sprytextfield6">
        <input placeholder="Username" type="text" name="Username" value="" size="32">
     </span><span class="required"></span></div>
     
    <div><span id="sprytextfield3">
      <input placeholder="Email Address" type="text" name="EmailAddress" value="" size="32">
      <br>
      <span class="textfieldInvalidFormatMsg">invalid email.</span></span><span class="required"></span></div>
    
    <div><span id="sprypassword1">
      <input placeholder="Password" type="password" name="password" id="password">
      <span class="passwordMinCharsMsg">8 characters min.</span><span class="passwordMaxCharsMsg">20 characters max.</span><span class="passwordInvalidStrengthMsg">weak password</span></span></div>
 
    <div><span id="spryconfirm1">
        <input placeholder="Verify Password" type="password" name="passwordValidate" value=""> 
     <span class="confirmInvalidMsg">The values don't match.</span></span><span class="required"></span></div>     
      <div><input type="submit" value="Submit">
      <input name="Reset" type="reset" value="Reset"></div>
  
  <p>
    <input type="hidden" name="MM_insert" value="form1">
  </p>
  <p>  passwords must be at least 8 characters and not more than 20. must contain at least 1 letter, 1 number and 1 speacial character (ex. @, #, $, %, &amp;)</p>
</form>
<p>&nbsp;</p>
<?php include 'footer.php' ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {useCharacterMasking:true});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {useCharacterMasking:true});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:8, maxChars:20, minAlphaChars:1, minNumbers:1, minSpecialChars:1});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "sprypassword1");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield5", "zip_code", {useCharacterMasking:true});
</script>

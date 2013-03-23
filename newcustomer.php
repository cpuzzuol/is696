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
  $insertSQL = sprintf("INSERT INTO Customer (FirstName, LastName, Street, City, `State`, Zip, Phone, Username, EmailAddress, password, passwordValidate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Street'], "text"),
                       GetSQLValueString($_POST['City'], "text"),
                       GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['Zip'], "int"),
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
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h3>Welcome to Puzzuol's Mr. Muffler</h3>
<h4>Complete the form to create a new account</h4>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">First Name</td>
      <td><span id="sprytextfield1">
        <input type="text" name="FirstName" value="" size="32">
      <span class="textfieldRequiredMsg">required</span></span><span class="required">*</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Last Name</td>
      <td><span id="sprytextfield2">
        <input type="text" name="LastName" value="" size="32">
      <span class="textfieldRequiredMsg">required</span></span><span class="required">*</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Street</td>
      <td><input type="text" name="Street" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">City</td>
      <td><input type="text" name="City" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">State:</td>
      <td>
      <datalist id="states">
      	<select name="State"> 
<option value="" selected="selected">Select a State</option> 
<option value="AL">Alabama</option> 
<option value="AK">Alaska</option> 
<option value="AZ">Arizona</option> 
<option value="AR">Arkansas</option> 
<option value="CA">California</option> 
<option value="CO">Colorado</option> 
<option value="CT">Connecticut</option> 
<option value="DE">Delaware</option> 
<option value="DC">District Of Columbia</option> 
<option value="FL">Florida</option> 
<option value="GA">Georgia</option> 
<option value="HI">Hawaii</option> 
<option value="ID">Idaho</option> 
<option value="IL">Illinois</option> 
<option value="IN">Indiana</option> 
<option value="IA">Iowa</option> 
<option value="KS">Kansas</option> 
<option value="KY">Kentucky</option> 
<option value="LA">Louisiana</option> 
<option value="ME">Maine</option> 
<option value="MD">Maryland</option> 
<option value="MA">Massachusetts</option> 
<option value="MI">Michigan</option> 
<option value="MN">Minnesota</option> 
<option value="MS">Mississippi</option> 
<option value="MO">Missouri</option> 
<option value="MT">Montana</option> 
<option value="NE">Nebraska</option> 
<option value="NV">Nevada</option> 
<option value="NH">New Hampshire</option> 
<option value="NJ">New Jersey</option> 
<option value="NM">New Mexico</option> 
<option value="NY">New York</option> 
<option value="NC">North Carolina</option> 
<option value="ND">North Dakota</option> 
<option value="OH">Ohio</option> 
<option value="OK">Oklahoma</option> 
<option value="OR">Oregon</option> 
<option value="PA">Pennsylvania</option> 
<option value="RI">Rhode Island</option> 
<option value="SC">South Carolina</option> 
<option value="SD">South Dakota</option> 
<option value="TN">Tennessee</option> 
<option value="TX">Texas</option> 
<option value="UT">Utah</option> 
<option value="VT">Vermont</option> 
<option value="VA">Virginia</option> 
<option value="WA">Washington</option> 
<option value="WV">West Virginia</option> 
<option value="WI">Wisconsin</option> 
<option value="WY">Wyoming</option>
</select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Zip</td>
      <td><span id="sprytextfield5">
      <input type="text" name="Zip" value="" size="32">
      <span class="textfieldRequiredMsg">required</span><span class="textfieldInvalidFormatMsg">Invalid zip</span></span><span class="required">*</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Phone</td>
      <td><span id="sprytextfield4">
      <input type="text" name="Phone" value="" size="32">
      <span class="textfieldRequiredMsg">required</span><span class="textfieldInvalidFormatMsg">Invalid phone number.</span></span><span class="required">*</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Username</td>
      <td><span id="sprytextfield6">
        <input type="text" name="Username" value="" size="32">
        <span class="textfieldRequiredMsg">required</span></span><span class="required">*</span>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email</td>
      <td><span id="sprytextfield3">
      <input type="text" name="EmailAddress" value="" size="32">
      <span class="textfieldRequiredMsg">required</span><span class="textfieldInvalidFormatMsg">invalid email.</span></span><span class="required">*</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Password</td>
      <td><span id="sprypassword1">
      <input type="password" name="password" id="password">
      <span class="passwordRequiredMsg">required</span><span class="passwordMinCharsMsg">8 characters min.</span><span class="passwordMaxCharsMsg">20 characters max.</span><span class="passwordInvalidStrengthMsg">weak password.</span></span><span class="required">*</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Verify Password</td>
      <td><span id="spryconfirm1">
        <input type="password" name="passwordValidate" value="">
      <span class="confirmRequiredMsg">required</span><span class="confirmInvalidMsg">The values don't match.</span></span><span class="required">*</span></td>
    </tr>
   
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      
      <td><input type="submit" value="Submit"></td>
    </tr>
    
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1">	
   <span class="required">*required field</span></p>
  <p class="passwordrequirements"> passwords must be at least 8 characters and not more than 20. must contain at least 1 letter, 1 number and 1 speacial character (ex. @, #, $, %, &amp;)</p>
</form>
<p>&nbsp;</p>
<?php include 'footer.php' ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {useCharacterMasking:true, validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {useCharacterMasking:true});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["change"], minChars:8, maxChars:20, minAlphaChars:1, minNumbers:1, minSpecialChars:1});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "sprypassword1", {validateOn:["change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "zip_code", {useCharacterMasking:true});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
</script>

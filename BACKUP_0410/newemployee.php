<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "employee";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  /*check to see if username already exists, if so go back and tell the user to use a different name*/
  mysql_select_db("IS696");
  $dupe = sprintf("SELECT Username FROM Employee WHERE Username='{$_POST['Username']}';");
  $query_dupe = mysql_query($dupe) or die('Cannot Execute:'. mysql_error());;
  $num_rows = mysql_num_rows($query_dupe);
  /*if there is a matching row with a username, tell them to enter a new one*/
    if ($num_rows) {
    	$user_dup = "<p style=\"color:red\">This user name already on our database! Please try again with a new user name.</p>";
		$pick_another_name = true;
    } 
	/*if there are no pre-existing accuonts with the same user, execute the query normally*/
	else {
  		$insertSQL = sprintf("INSERT INTO Employee (FirstName, LastName, Username, Password, PasswordValidate) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['verifypassword'], "text"));

		  mysql_select_db($database_godaddy, $godaddy);
		  $Result1 = mysql_query($insertSQL, $godaddy) or die(mysql_error());
			$pick_another_name = false;
		  $insertGoTo = "employeestart.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  header(sprintf("Location: %s", $insertGoTo));
	}
}
?><head>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
</head>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>
  <div align="center">Complete the form below to create a new employee account</div></h4>
  <?php if($pick_another_name){ echo $user_dup; }?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
      <span id="sprytextfield1">
        <input placeholder="First Name" type="text" name="FirstName" value="" size="32">
    </span>
      <span id="sprytextfield2">
        <input placeholder="Last Name" type="text" name="LastName" value="" size="32">
      </span>
      <span id="sprytextfield3">
        <input placeholder="Username" type="text" name="Username" value="" size="32">
      </span>
	<span id="sprypassword1">
      <input placeholder="Password" type="password" name="Password" value="" size="32" id="Password">
    <span class="passwordMinCharsMsg">8 characters </span></span>
  <span id="spryconfirm1">
        <input placeholder="Verify Password" type="password" name="verifypassword" value="" size="32" id="verifypassword">
        <br>
  <span class="confirmInvalidMsg">passwords don't match.</span></span>
      <p>
        <input type="submit" value="Create Account">
        <input name="Reset" type="reset" value="Reset">
        <input type="hidden" name="MM_insert" value="form1">
        </form>
      </p>
      <p>&nbsp; </p>
      <p>  <font size="-1">passwords must be at least 8 characters and not more than 20. must contain at least 1 letter, 1 number and 1 speacial character (ex. @, #, $, %, &amp;)</p></font>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:8});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "Password");
</script>
<?php include 'footer.php' ?>
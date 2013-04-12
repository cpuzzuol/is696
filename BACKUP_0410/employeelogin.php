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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "employeestart.php";
  $MM_redirectLoginFailed = "employeelogin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_godaddy, $godaddy);
  
  $LoginRS__query=sprintf("SELECT Username, Password FROM Employee WHERE Username=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $godaddy) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     /*THIS VARIABLE SHOULD ONLY BE SET FOR EMPLOYEES!!*/
	 $loginStrGroup = "employee";
     $rightCredentials = true;
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    
	/*THIS VARIABLE SHOULD ONLY BE SET FOR EMPLOYEES!!*/
	$_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	$rightCredentials = false;
	$wrongcreds = "<font color=#FF0000 ><em>incorrect username or password</em></font>";
  }
  
}
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<p><h4>Puzzuoli's Mr. Muffler Service Management</h4> </p>
<?php if(!$rightCredentials){echo $wrongcreds;}?>
<form action="<?php echo $loginFormAction; ?>" method="POST">
  <span id="sprytextfield1">
  <input type="text" name="username" id="username" placeholder="employee username">
  <span class="textfieldRequiredMsg">enter your username</span></span>
  <p><span id="sprytextfield2">
    <input type="password" name="password" id="password" placeholder="password">
    <span class="textfieldRequiredMsg">enter your password</span></span>
    </p>
  <p>
    <input type="submit" name="Login" id="Login" value="Submit">
  </p>
</form>
<?php include 'footer.php' ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
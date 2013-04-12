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
  $loginUsername= $_POST['username'];
  $password= $_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "customerstart.php";
  $MM_redirectLoginFailed = "customerLogin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_godaddy, $godaddy);
  
  $LoginRS__query=sprintf("SELECT Username, password FROM Customer WHERE Username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $godaddy) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    $rightCredentials = true;
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    unset($_SESSION['MM_UserGroup']);      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  } else {
    $rightCredentials = false;
	$wrongcreds = "<font color=#FF0000><em>incorrect username or password</em></font><br>";
  }
}
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>

<form action="<?php echo $loginFormAction; ?>" method="POST">
  <p>Login to get started</p>
     
     <?php if(!$rightCredentials){echo $wrongcreds;}?>
  <span id="sprytextfield1">

    <input placeholder="username" type="text" name="username" id="username">
  <span class="textfieldRequiredMsg">username required</span></span> 
    
  <p><span id="sprytextfield2">
 <input placeholder="password" type="password" name="password" id="password">
  <span class="textfieldRequiredMsg">password required</span></span> </p>
  <p>
    <input type="submit" name="login" id="login" value="Login">
  </p>
  <p>Not a member? Create a new <a href="newcustomer.php">account</a>.</p>
  <p>Click here to <a href="changePassword.php">Change Password</a></p>
</form>
<?php include 'footer.php' ?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>

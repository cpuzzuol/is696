<?php
//initialize the session
// ** Logout the current user. **
/*$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}*/
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>

<h3>Thank you</h3>
<h5>Your reservation request has been received. You will receive a call within 24 hours to confirm your appointment</a></h5>
<p>View and update <a href="<?php echo "myaccount.php" ?>">my account</a>.</p>
<?php include 'footer.php' ?>
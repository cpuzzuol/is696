<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
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
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
if(isset($_SESSION['MM_Username']) && !isset($_SESSION['MM_UserGroup'])){
	$linkage = "myaccount.php";
	$loggedin = "<strong><span style=\"color:yellow\">".$_SESSION['MM_Username']."</span></strong>";
} elseif(isset($_SESSION['MM_Username']) && isset($_SESSION['MM_UserGroup'])) {
	$linkage = "employeeaccount.php";
	$loggedin = "<strong><span style=\"color:yellow\">".$_SESSION['MM_Username']."</span></strong>";
} else {
	$linkage = "customerLogin.php";
	$loggedin = "<strong><span style=\"color:yellow\">login</span></strong>";
}
?>
<!doctype html>
<html>
<head>
        <meta charset="utf-8">
        <title>Puzzuoli's Mr. Muffler |  14441 W. Warren Ave. Dearborn, MI 48126 Tel: (313) 584-8770</title>
        <link rel="stylesheet" type="text/css" href="CSS/custom.css">

        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
              }
              .sidebar-nav {
                padding: 9px 0;
              }
        </style>
        <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
		<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
        <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
		<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
		<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>
		/*This script highlights the currently selected pages on the nav and sidebar menus*/
			$(document).ready(function () {        
				var url = window.location;
				// Will only work if string in href matches with location
				$('ul.nav a[href="'+ url +'"]').parent().addClass('active');
				
				// Will also work for relative and absolute hrefs
				$('ul.nav a').filter(function() {
					return this.href == url;
				}).parent().addClass('active');
				// Prevents "print invoice" buttom from submitting on servicedetail.php
				/*$('#toInvoice').click(function(e){
					// custom handling here
					e.preventDefault();
				});*/
			}); 
  		</script>
</head>
<body>
<div id="site-wrapper">
<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
 					
                  </a>
                    <a class="brand" href="index.php">Puzzuoli's Mr. Muffler</a>
                  <div class="nav-collapse in collapse" style="height: 100%;">
                        <p class="navbar-text pull-right"><a href="customerlogin.php"></a>
                        </p>
                     
                         <ul class="nav">
                            <li>
                                <a href="index.php">Home</a>
                            </li>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                            <?php if(!isset($_SESSION['MM_UserGroup'])): ?>
                            <li>
                              <a href="createreservation.php">Create a Service Request</a>
                            </li>
                            <?php else: ?>
                            <li>
                              <a href="employeestart.php">Employee Options</a>
                            </li>
                            <?php endif; ?>
                            <li>
                              <a href="<?php echo $linkage;?>"><?php echo $loggedin; ?></a>
                            </li>
                            <?php if(isset($_SESSION['MM_Username'])): ?>
                            <li>
                            <a href="<?php echo $logoutAction ?>">Log out</a>
                            </li>
                            <?php endif; ?>
                           </ul>
                  </div> 
                </div>
            </div>
        </div>
<p>&nbsp;</p>
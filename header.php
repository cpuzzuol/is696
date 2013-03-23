<?php
if (!isset($_SESSION)) {
  session_start();
} 
if(isset($_SESSION['MM_Username'])){
	$linkage = "myaccount.php";
	$loggedin = "<strong><span style=\"color:red\">".$_SESSION['MM_Username']."</span></strong>";
} else {
	$linkage = "customerLogin.php";
	$loggedin = "<strong><span style=\"color:red\">login</span></strong>";
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
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

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
                            <li class="active">
                                <a href="index.php">Home</a>
                            </li>
                            <li>
                                <a href="about.php">About</a>
                            </li>
                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                            <li>
                              <a href="createreservation.php">Make a Service Appointment</a>
                            </li>
                            <li>
                              <a href="employeelogin.php">Employees</a>
                            </li>
                            <li>
                              <a href="myaccount.php">My Account</a>
                            </li>
                            <li>
                              <a href="<?php echo $linkage;?>"><?php echo $loggedin; ?></a>
                            </li>
                           </ul>
                  </div>
                   
                </div>
            </div>
        </div>
<p>&nbsp;</p>

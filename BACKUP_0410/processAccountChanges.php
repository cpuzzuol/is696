<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
  mysql_select_db("IS696");
  $insertSQL = sprintf("UPDATE Customer SET FirstName='{$_POST['user-fname']}', LastName='{$_POST['user-last']}', Street='{$_POST['user-street']}', City='{$_POST['user-city']}',
  State='{$_POST['user-state']}', Zip='{$_POST['user-zip']}', Username='{$_POST['user-username-hidden']}', EmailAddress='{$_POST['user-email']}', Phone='{$_POST['user-phone']}' WHERE Username='{$_SESSION['MM_Username']}';");
  $query = mysql_query($insertSQL) or die(mysql_error());
  $_SESSION['MM_Username'] = $_POST['user-username-hidden'];
  header(sprintf("Location: myaccount.php"));
  
?>
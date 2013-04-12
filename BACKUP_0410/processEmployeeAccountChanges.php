<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
  mysql_select_db("IS696");
  $insertSQL = sprintf("UPDATE Employee SET FirstName='{$_POST['employee-fname']}', LastName='{$_POST['employee-last']}', Username='{$_POST['employee-username-hidden']}' WHERE Username='{$_SESSION['MM_Username']}';");
  $query = mysql_query($insertSQL);
  $_SESSION['MM_Username'] = $_POST['employee-username-hidden'];
  header(sprintf("Location: employeeaccount.php"));
  
?>
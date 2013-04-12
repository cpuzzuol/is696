<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "customerLogin.php";
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
  $insertSQL = sprintf("INSERT INTO Service (username, ServiceReq, DateRequest, vehicleYear, vehicleMake, vehicleModel) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['hiddenusername'], "text"),
                       GetSQLValueString($_POST['issue'], "text"),
                       GetSQLValueString($_POST['dateRequest'], "date"),
                       GetSQLValueString($_POST['year'], "int"),
                       GetSQLValueString($_POST['make'], "text"),
                       GetSQLValueString($_POST['model'], "text"));

  mysql_select_db($database_godaddy, $godaddy);
  $Result1 = mysql_query($insertSQL, $godaddy) or die(mysql_error());

  $insertGoTo = "reservationConfirm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_godaddy, $godaddy);
$query_rs_make = "SELECT DISTINCT (make) FROM VehicleModelYear ORDER BY `make` ASC";
$rs_make = mysql_query($query_rs_make, $godaddy) or die(mysql_error());
$row_rs_make = mysql_fetch_assoc($rs_make);
$totalRows_rs_make = mysql_num_rows($rs_make);

mysql_select_db($database_godaddy, $godaddy);
$query_rs_model = "SELECT DISTINCT (model) FROM VehicleModelYear ORDER BY `model` ASC";
$rs_model = mysql_query($query_rs_model, $godaddy) or die(mysql_error());
$row_rs_model = mysql_fetch_assoc($rs_model);
$totalRows_rs_model = mysql_num_rows($rs_model);

mysql_select_db($database_godaddy, $godaddy);
$query_rs_year = "SELECT DISTINCT `year` FROM VehicleModelYear ORDER BY `year` DESC";
$rs_year = mysql_query($query_rs_year, $godaddy) or die(mysql_error());
$row_rs_year = mysql_fetch_assoc($rs_year);
$totalRows_rs_year = mysql_num_rows($rs_year);
?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php'?>
<p>Creating a new auto service reservation is easy.</p>
<h4>Hi, <font color="blue"><?php echo $_SESSION['MM_Username']; ?>.</font> </h4>
<p style="font-style:italic"><a href="myaccount.php">Click here</a> to edit your account details.</p>
        <p><font size="+1">Step 1.</font> Choose a date.</p>
        <p><font size="+1">Step 2.</font> Describe the issue you're having and the service you'd like us to work on. Feel free to be as detailed as possible.</p>
        <p>After we receive your request one of our technicians will review the request and contact you to confirm your reservation</p>
<form name="form1" method="post" action="">

<link rel="stylesheet" type="text/css" href="datepickerjquery/css/ui-lightness/jquery-ui-1.10.1.custom.min.css"/>
<script src="datepickerjquery/js/jquery-1.9.1.js"></script>
<script src="datepickerjquery/js/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
<p><span id="sprytextfield1"><span id="sprytextfield2"><span id="sprytextfield3">
<input id="datepicker" type="text" placeholder="Choose a Date">
<span class="textfieldRequiredMsg">Select a date</span></span></p>
<input name="dateRequest" type="hidden" id="alt-datepicker">

<script type="text/javascript">

  $( "#datepicker" ).datepicker({
    altField  : '#alt-datepicker',
    altFormat : 'yy-mm-dd',
    format    : 'mm-dd-yy'
});
</script><span id="sprytextarea1">
<textarea name="issue" id="issue" cols="45" rows="5" placeholder="Describe the work you'd like to have done"></textarea>
<span id="countsprytextarea1">&nbsp;</span>&nbsp;<span class="textareaRequiredMsg">required.</span><span class="textareaMaxCharsMsg">Exceeded maximum number of characters.</span></span>
<p>Vehicle Year:

  <select name="year" id="year">
    <?php
do {  
?>
    <option value="<?php echo $row_rs_year['year']?>"><?php echo $row_rs_year['year']?></option>
    <?php
} while ($row_rs_year = mysql_fetch_assoc($rs_year));
  $rows = mysql_num_rows($rs_year);
  if($rows > 0) {
      mysql_data_seek($rs_year, 0);
	  $row_rs_year = mysql_fetch_assoc($rs_year);
  }
?>

  </select>
<p>Vehicle Make:
  <select name="make" id="make">
    <?php
do {  
?>
    <option value="<?php echo $row_rs_make['make']?>"><?php echo $row_rs_make['make']?></option>
    <?php
} while ($row_rs_make = mysql_fetch_assoc($rs_make));
  $rows = mysql_num_rows($rs_make);
  if($rows > 0) {
      mysql_data_seek($rs_make, 0);
	  $row_rs_make = mysql_fetch_assoc($rs_make);
  }
?>
  </select>
<p>Vehicle Model:
  <select name="model" id="model">
    <?php
do {  
?>
    <option value="<?php echo $row_rs_model['model']?>"><?php echo $row_rs_model['model']?></option>
    <?php
} while ($row_rs_model = mysql_fetch_assoc($rs_model));
  $rows = mysql_num_rows($rs_model);
  if($rows > 0) {
      mysql_data_seek($rs_model, 0);
	  $row_rs_model = mysql_fetch_assoc($rs_model);
  }
?>
  </select>
<p>
  <input type="submit" name="submit" id="submit" value="Submit">
  <input type="reset" name="reset" id="reset" value="Reset">
<p>
<p>
  <input name="hiddenusername" type="hidden" value="<?php echo $_SESSION['MM_Username']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
 
</form>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {maxChars:1000, counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none");
</script>
</body>
<?php include 'footer.php'?>
<?php
mysql_free_result($rs_year);

mysql_free_result($rs_make);

mysql_free_result($rs_model);
?>
</html>

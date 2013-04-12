<?php require_once('Connections/godaddy.php'); ?>
<?php

mysql_select_db($database_godaddy, $godaddy);
/*WE DON'T NEED THIS QUERY BECAUSE WE ALREADY KNOW WHICH SERVICE ID WE WANT WHEN WE ENTERED IT IN THE FORM!
$query_rs_service =("SELECT SerivceID FROM Service ORDER BY SerivceID ASC;"); */

/*Instead, we need to select the USERNAME in the Service table that owns the service request */
$query_rs_user = "SELECT username from Service WHERE SerivceID = {$_POST['SerivceID']};";
$rs_user = mysql_query($query_rs_user, $godaddy) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);

/*Pick out the username to use in the next query*/
$theUser = $row_rs_user['username'];

/*Next, we need to use the USERNAME to QUERY the CUSTOMER TABLE to match it up to the username in that table and RETRIEVE CUSTOMER INFO*/
$insertsql = sprintf("SELECT FirstName, LastName, Street, City, State, Zip, EmailAddress, Phone FROM Customer WHERE Username = '{$theUser}';");
$query = mysql_query($insertsql);
$row = mysql_num_rows($query);
$assoc = mysql_fetch_assoc($query);

/*Finally, redirect to the location where the url holds the matching SERVICE ID and USER...The form will populate via the script on servicedetail.php*/
header("Location: servicedetail.php?SerivceID={$_REQUEST['SerivceID']}&username={$theUser}");

?>
<?php require_once('Connections/godaddy.php'); ?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h4>My Account Page</h4>
<p>Click here to <a href="logout.php">logout</a></p>
<p>Click here to <a href="changePassword.php">change your password</a></p>
<?php
mysql_select_db("IS696");

$sql = sprintf("SELECT FirstName, LastName, Street, City, State, Zip, Username, EmailAddress, Phone FROM Customer WHERE Username = '{$_SESSION['MM_Username']}';");

$retrieve = mysql_query($sql);

if (!$retrieve) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
}

while ($row = mysql_fetch_assoc($retrieve)):
    $user_fname = $row['FirstName'];
    $user_last = $row['LastName'];
    $user_street = $row['Street'];
	$user_city = $row['City'];
    $user_state = $row['State'];
    $user_zip = $row['Zip'];
    $user_username = $row['Username'];
	$user_email = $row['EmailAddress'];
    $user_phone = $row['Phone'];
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="account-form">
<p>USER DATA GOES HERE!</p>
</form>
<?php 
endwhile;
mysql_free_result($retrieve);
?>
<?php include 'footer.php' ?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_godaddy = "IS696.db.10536098.hostedresource.com";
$database_godaddy = "IS696";
$username_godaddy = "IS696";
$password_godaddy = "Password1!";
$godaddy = mysql_pconnect($hostname_godaddy, $username_godaddy, $password_godaddy) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
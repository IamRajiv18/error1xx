<?php

# server name
$sName = 'localhost';
# user name
$uName = 'root';
# password
$pass = '';

# database name
$db_name = 'lhdb';

#creating database connection
$conn = mysqli_connect($sName, $uName, $pass, $db_name);
?>
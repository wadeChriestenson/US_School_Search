<?php
$dbServername = "localhost";
$dbUsername = "*****";
$dbPassword = "**********";
$dbName = "******";
global $conn;
//(host, username, password, database)
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
  die("Connection failed:" . mysqli_connect_error());
}


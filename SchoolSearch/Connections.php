<?php
$dbServername = "localhost";
$dbUsername = "Wade";
$dbPassword = "Chriestenson1";
$dbName = "schools";
global $conn;
//(host, username, password, database)
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
  die("Connection failed:" . mysqli_connect_error());
}


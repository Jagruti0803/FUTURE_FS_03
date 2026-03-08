<?php
$host = "localhost:3306";
$user = "root";
$pass = ""; // default XAMPP password is empty
$db   = "terranew";

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>

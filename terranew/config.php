<?php
// config.php
$con = mysqli_connect("localhost:3306", "root", "", "terranew");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

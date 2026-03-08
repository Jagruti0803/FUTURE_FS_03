<?php
session_start();
include '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Delete user from 'userss' table
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM userss WHERE id=$id");
}

// Redirect back to users page
header("Location: users.php");
exit;
?>

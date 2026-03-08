<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../config.php"; // adjust path if needed

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f1f1f1; margin:0; }
        .sidebar { position:fixed; left:0; top:0; height:100%; width:220px; background:#006400; color:#fff; padding-top:20px; }
        .sidebar a { display:block; padding:12px 20px; color:#fff; text-decoration:none; }
        .sidebar a:hover { background:#008000; }
        .content { margin-left:220px; padding:20px; }
    </style>
</head>
<body>
<div class="sidebar">
    <h3 class="text-center mb-4"><i class="fa-solid fa-recycle"></i> Admin</h3>
    <a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="customers.php"><i class="fa fa-users"></i> Customers</a>
    <a href="products.php"><i class="fa fa-box"></i> Products</a>
    <a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a>
    <a href="contact_messages.php"><i class="fa fa-envelope"></i> Messages</a>
    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
</div>
<div class="content">

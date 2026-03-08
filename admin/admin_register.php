<?php
session_start();
include "config.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO admins_new (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Admin Registered Successfully!'); window.location='admin_login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Register</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { font-family: Arial; background:#f4f4f9; display:flex; justify-content:center; align-items:center; height:100vh; }
.box { background:#fff; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:350px; }
.box h2 { text-align:center; margin-bottom:20px; }
input { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:5px; }
button { width:100%; padding:10px; background:#28a745; border:none; color:#fff; font-size:16px; border-radius:5px; cursor:pointer; }
button:hover { background:#218838; }
</style>
</head>
<body>
<div class="box">
<h2>Admin Register</h2>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Register</button>
</form>
<p style="text-align:center;margin-top:10px;">Already have account? <a href="admin_login.php">Login</a></p>
</div>
</body>
</html>

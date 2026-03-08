<?php
session_start();
include "config.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

// --- 1. Handle Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare the query
    $query = "SELECT * FROM admins_new WHERE username=? OR email=? LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username_or_email, $username_or_email);
    
    // Execute the query
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any result is returned
    if ($row = mysqli_fetch_assoc($result)) {
        // If password matches the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Admin not found! Please check the username or email.";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ----------------------------------------------------------------- */
/* Global and Base Styles - GREEN THEME */
/* ----------------------------------------------------------------- */
body {
    background: linear-gradient(135deg, #2e7d32, #66bb6a); 
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
    overflow: hidden; 
    position: relative; 
}

/* ----------------------------------------------------------------- */
/* Bag Icon Animation */
/* ----------------------------------------------------------------- */
#initial-bag-icon {
    position: absolute;
    font-size: 8rem; 
    color: #ffffff;
    opacity: 0; 
    z-index: 10;
    text-shadow: 0 4px 15px rgba(0,0,0,0.4); 
    pointer-events: none;  /* ✅ ignore clicks */

    animation: bagIntro 0.5s ease-out forwards, 
               bagOpenAndExit 0.8s ease-in-out 0.8s forwards;
    animation-fill-mode: forwards;
}

@keyframes bagIntro {
    from { transform: scale(0); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@keyframes bagOpenAndExit {
    0% { transform: scale(1) rotate(0deg); opacity: 1; }
    50% { transform: scale(1.2) rotate(10deg); opacity: 0.8; }
    100% { transform: scale(2) rotate(30deg); opacity: 0; visibility: hidden; }
}

/* ----------------------------------------------------------------- */
/* Login Box Styles with Form Reveal Animation */
/* ----------------------------------------------------------------- */
.box {
    background: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); 
    width: 100%;
    max-width: 380px;
    box-sizing: border-box;

    opacity: 0; 
    transform: scale(0.8);
    animation: formReveal 0.8s ease-out 1.6s forwards;
}

@keyframes formReveal {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}

.box h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #2e7d32;
    font-size: 26px;
    font-weight: 700;
}

/* ----------------------------------------------------- */
/* Form and Input Styles */
/* ----------------------------------------------------- */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 14px 15px;
    margin: 8px 0;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #2e7d32;
    box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15); 
    outline: none;
}

/* ----------------------------------------------------- */
/* Button Styles */
/* ----------------------------------------------------- */
button[type="submit"] {
    width: 100%;
    padding: 15px;
    margin-top: 15px;
    background-color: #2e7d32;
    border: none;
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.1s;
}

button[type="submit"]:hover {
    background-color: #1b5e20;
}

button[type="submit"]:active {
    transform: translateY(1px);
}

/* ----------------------------------------------------- */
/* Error Message Styles */
/* ----------------------------------------------------- */
.error {
    color: #c0392b; 
    background-color: #fcecec; 
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 20px;
    border: 1px solid #f09595;
    font-size: 14px;
}
</style>
</head>
<body>

<div id="initial-bag-icon">
    <i class="fas fa-user-shield"></i> 
</div>

<div class="box">
    <h2>Admin Login</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Secure Login</button>
    </form>
</div>
</body>
</html>

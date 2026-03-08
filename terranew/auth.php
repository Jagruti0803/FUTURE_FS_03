<?php
session_start();
include "config.php";

$errors = [];
$success = "";

// Helper: sanitize input
function clean($con, $v){
    return trim(mysqli_real_escape_string($con, $v));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ---------- REGISTER ----------
    if (isset($_POST['register'])) {
        $fullname = clean($con, $_POST['fullname'] ?? '');
        $email    = clean($con, $_POST['email'] ?? '');
        $phone    = clean($con, $_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $cpassword = $_POST['cpassword'] ?? '';

        if ($fullname === "" || $email === "" || $password === "" || $cpassword === "") {
            $errors[] = "Please fill all required fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        } elseif ($password !== $cpassword) {
            $errors[] = "Passwords do not match.";
        } else {
            // Check if email already exists
            $stmt = $con->prepare("SELECT id FROM customers WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = "Email already registered.";
            } else {
                // Hash password before storing
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $ins = $con->prepare("INSERT INTO customers (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
                $ins->bind_param("ssss", $fullname, $email, $phone, $hash);
                if ($ins->execute()) {
                    $success = "Registration successful! Please login below.";
                } else {
                    $errors[] = "Registration failed: " . $ins->error;
                }
                $ins->close();
            }
            $stmt->close();
        }
    }

    // ---------- LOGIN ----------
    if (isset($_POST['login'])) {
        $email = clean($con, $_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === "" || $password === "") {
            $errors[] = "Please enter email and password.";
        } else {
            $stmt = $con->prepare("SELECT id, fullname, password FROM customers WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $fullname, $hash);
                $stmt->fetch();
                if (password_verify($password, $hash)) {
                    // ✅ Login success
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $fullname; 
                    header("Location: index.php");
                    exit;
                } else {
                    $errors[] = "Invalid password!";
                }
            } else {
                $errors[] = "Email not found!";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Auth - TerraNew</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
/* ----------------------------------------------------------------- */
/* Global and Base Styles */
/* ----------------------------------------------------------------- */
body {
    background: linear-gradient(135deg, #2e7d32, #66bb6a);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
    overflow: hidden; 
    position: relative; /* For positioning the icon and form */
}

/* ----------------------------------------------------------------- */
/* Bag Icon and Animation (NEW) ✨ */
/* ----------------------------------------------------------------- */
#initial-bag-icon {
    position: absolute;
    font-size: 8rem; /* Large icon */
    color: #ffffff;
    opacity: 0; /* Start hidden */
    z-index: 10;
    text-shadow: 0 4px 15px rgba(0,0,0,0.3); /* Subtle shadow */

    /* Animation: scale in, then scale out and fade */
    animation: bagIntro 0.5s ease-out forwards, 
               bagOpenAndExit 0.8s ease-in-out 0.8s forwards; /* Starts after intro */
}

@keyframes bagIntro {
    from { transform: scale(0); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@keyframes bagOpenAndExit {
    0% { transform: scale(1) rotate(0deg); opacity: 1; }
    50% { transform: scale(1.2) rotate(10deg); opacity: 0.8; /* "Open" effect */ }
    100% { transform: scale(2) rotate(30deg); opacity: 0; /* Zoom out and disappear */ }
}

/* ----------------------------------------------------------------- */
/* Auth Card Styles with Form Reveal Animation */
/* ----------------------------------------------------------------- */
.auth-card {
    background: #fff;
    padding: 28px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0px 10px 30px rgba(0,0,0,0.3); 
    border-radius: 15px; 

    opacity: 0; /* Start hidden */
    transform: scale(0.8); /* Start slightly smaller */
    animation: formReveal 0.8s ease-out 1.6s forwards; /* Starts after bag animation */
}

@keyframes formReveal {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}


/* ----------------------------------------------------------------- */
/* Existing Form Styles (Bootstrap Overrides) */
/* ----------------------------------------------------------------- */
.auth-card h3 { font-weight: 700; color: #2e7d32; }
.form-control { border-radius: 10px; padding: 11px; transition: border-color 0.3s; }
.form-control:focus {
    border-color: #2e7d32;
    box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
}
.btn-success {
    background: #2e7d32; 
    border: none; 
    border-radius: 10px; 
    padding: 12px; 
    font-weight: 600;
    transition: background-color 0.3s, transform 0.1s;
}
.btn-success:hover {
    background-color: #1b5e20;
}
.btn-success:active {
    transform: scale(0.98);
}
.eye-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color:#555; }
.position-relative { position: relative; }
.nav-tabs .nav-link { 
    border: 1px solid transparent; 
    color: #2e7d32;
    transition: all 0.3s;
}
.nav-tabs .nav-link.active { 
    background-color: #2e7d32 !important; 
    color: #fff !important; 
    border-radius: 10px; 
    border-color: #2e7d32 !important;
}
</style>
</head>
<body>

<div id="initial-bag-icon">
    <i class="fas fa-briefcase"></i> </div>

<div class="auth-card">
    <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo empty($success) ? 'active' : ''; ?>" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo !empty($success) ? '' : ''; ?>" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">Register</button>
        </li>
    </ul>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $err) echo "<li>" . htmlspecialchars($err) . "</li>"; ?></ul></div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var loginTab = new bootstrap.Tab(document.getElementById('login-tab'));
                loginTab.show();
            });
        </script>
    <?php endif; ?>

    <div class="tab-content">
        <div class="tab-pane fade <?php echo empty($success) ? 'show active' : 'show active'; ?>" id="login" role="tabpanel">
            <h3 class="text-center mb-3">Login</h3>
            <form method="post" novalidate>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" name="password" id="login_password" class="form-control" placeholder="Password" required>
                    <i class="fa fa-eye eye-icon" onclick="togglePassword('login_password')"></i>
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="register" role="tabpanel">
            <h3 class="text-center mb-3">Register</h3>
            <form method="post" novalidate>
                <div class="mb-3">
                    <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Phone (optional)">
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" name="password" id="reg_password" class="form-control" placeholder="Password" required>
                    <i class="fa fa-eye eye-icon" onclick="togglePassword('reg_password')"></i>
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" name="cpassword" id="reg_cpassword" class="form-control" placeholder="Confirm Password" required>
                    <i class="fa fa-eye eye-icon" onclick="togglePassword('reg_cpassword')"></i>
                </div>
                <div class="d-grid">
                    <button type="submit" name="register" class="btn btn-success">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(id){
    const input = document.getElementById(id);
    const icon = input.nextElementSibling;
    input.type = (input.type === "password") ? "text" : "password";
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
</script>
</body>
</html>
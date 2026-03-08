<?php
session_start();
include 'config.php';

$errors = [];
$success = "";

// Handle Register
if (isset($_POST['register'])) {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    } else {
        // Check if email already exists
        $email_check = "SELECT * FROM userss WHERE email='$email'";
        $res = mysqli_query($con, $email_check);
        if (mysqli_num_rows($res) > 0) {
            $errors[] = "Email already exists";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO userss (firstname, lastname, email, password) 
                       VALUES ('$firstname','$lastname','$email','$hashedPassword')";
            if (mysqli_query($con, $insert)) {
                $success = "Registration successful! You can login now.";
            } else {
                $errors[] = "Database error: ".mysqli_error($con);
            }
        }
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM userss WHERE email='$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['firstname'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $errors[] = "Invalid password";
        }
    } else {
        $errors[] = "Invalid email";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Register</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f4f6;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .auth-container {
      display: flex;
      width: 900px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .auth-forms {
      flex: 1;
      padding: 40px;
    }

    .auth-forms h2 {
      margin-bottom: 10px;
      color: #111827;
    }

    .auth-forms p {
      margin-bottom: 20px;
      font-size: 14px;
      color: #6b7280;
    }

    .form-group {
      margin-bottom: 15px;
      position: relative;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      outline: none;
      font-size: 14px;
    }

    .form-group i {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #9ca3af;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background: #22c55e;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }

    .submit-btn:hover {
      background: #16a34a;
    }

    .form-check {
      margin-bottom: 15px;
    }

    .form-check-label {
      font-size: 14px;
      color: #374151;
    }

    .auth-security {
      flex: 0.5;
      background: #f9fafb;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      border-left: 1px solid #e5e7eb;
    }

    .auth-security h3 {
      color: #111827;
      margin-bottom: 10px;
    }

    .auth-security p {
      font-size: 14px;
      color: #6b7280;
    }

    .switch-link {
      margin-top: 15px;
      font-size: 14px;
      text-align: center;
    }

    .switch-link a {
      color: #22c55e;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="auth-container">

    <div class="auth-forms">

      <!-- Display Errors / Success -->
      <?php if(!empty($errors)): ?>
        <div style="color:red; margin-bottom:10px;">
          <?php foreach($errors as $err){ echo $err . "<br>"; } ?>
        </div>
      <?php endif; ?>

      <?php if(!empty($success)): ?>
        <div style="color:green; margin-bottom:10px;">
          <?= $success ?>
        </div>
      <?php endif; ?>

      <!-- Login Form -->
      <form id="loginForm" method="POST" style="display:block;">
        <h2>Welcome Back</h2>
        <p>Please login to continue</p>

        <div class="form-group">
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <input type="password" id="loginPass" name="password" placeholder="Enter your password" required>
          <i class="fa fa-eye" onclick="togglePassword('loginPass', this)"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <a href="#" style="color:#22c55e; font-size:14px;">Forgot password?</a>
        </div>

        <button type="submit" name="login" class="submit-btn">Login</button>

        <div class="switch-link">
          Don’t have an account? <a onclick="switchForm('register')">Register</a>
        </div>
      </form>

      <!-- Register Form -->
      <form id="registerForm" method="POST" style="display:none;">
        <h2>Create Account</h2>
        <p>Join us today</p>

        <div class="form-group" style="display:flex; gap:10px;">
          <input type="text" name="firstname" placeholder="First Name" required>
          <input type="text" name="lastname" placeholder="Last Name" required>
        </div>
        <div class="form-group">
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <input type="password" id="regPass" name="password" placeholder="Create password" required>
          <i class="fa fa-eye" onclick="togglePassword('regPass', this)"></i>
          <small style="font-size:12px; color:#666;">Password strength</small>
        </div>
        <div class="form-group">
          <input type="password" id="regCPass" name="confirm_password" placeholder="Confirm password" required>
          <i class="fa fa-eye" onclick="togglePassword('regCPass', this)"></i>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" class="form-check-input" id="terms" required>
          <label for="terms" class="form-check-label" style="font-size:14px;">
            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>
        </div>

        <button type="submit" name="register" class="submit-btn">Create Account</button>

        <div class="switch-link">
          Already have an account? <a onclick="switchForm('login')">Login</a>
        </div>
      </form>
    </div>

    <!-- Right Side: Enhanced Security -->
    <div class="auth-security">
      <i class="fa fa-lock fa-3x" style="color:#22c55e; margin-bottom:15px;"></i>
      <h3>Enhanced Security</h3>
      <p>✔ Advanced encryption protocols</p>
      <p>✔ Biometric authentication support</p>
      <p>✔ Two-factor authentication</p>
    </div>

  </div>

  <script>
    function togglePassword(id, el) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        el.classList.remove("fa-eye");
        el.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        el.classList.remove("fa-eye-slash");
        el.classList.add("fa-eye");
      }
    }

    function switchForm(type) {
      if (type === "register") {
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("registerForm").style.display = "block";
      } else {
        document.getElementById("loginForm").style.display = "block";
        document.getElementById("registerForm").style.display = "none";
      }
    }
  </script>

</body>
</html>

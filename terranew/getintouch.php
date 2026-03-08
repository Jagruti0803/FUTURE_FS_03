<?php
include "header.php";
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $sql = "INSERT INTO get_in_touch (name, email, message) 
            VALUES ('$name','$email','$message')";
    if (mysqli_query($con, $sql)) {
        $success = "✅ Thank you! We will contact you soon.";
    } else {
        $error = "❌ Something went wrong. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Get in Touch</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f4f8f9; }
    header { background: #28a745; color: white; padding: 15px; text-align: center; }
    .container {
      display: flex;
      max-width: 1000px;
      margin: 40px auto;
      gap: 30px;
      padding: 20px;
    }
    .contact-form, .contact-info {
      flex: 1;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .contact-form h2, .contact-info h2 { margin-bottom: 20px; color: #333; }
    .contact-form input, .contact-form textarea {
      width: 100%; padding: 12px; margin: 10px 0;
      border: 1px solid #ccc; border-radius: 5px;
    }
    .contact-form button {
      background: #28a745; color: white; border: none;
      padding: 12px 20px; cursor: pointer;
      border-radius: 5px; font-size: 16px;
    }
    .contact-form button:hover { background: #218838; }
    .info-item { margin-bottom: 15px; }
    .info-item strong { display: block; color: #28a745; }
    iframe { width: 100%; height: 200px; border-radius: 10px; margin-top: 15px; }
    .message { margin: 15px 0; padding: 12px; border-radius: 5px; }
    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }
    footer { text-align: center; padding: 20px; margin-top: 40px; background: #333; color: white; }
  </style>
</head>
<body>

<header>
  <h1>Get in Touch</h1>
</header>

<div class="container">

  <!-- Contact Form -->
  <div class="contact-form">
    <h2>Send Us a Message</h2>

    <?php if (!empty($success)) { echo "<div class='message success'>$success</div>"; } ?>
    <?php if (!empty($error)) { echo "<div class='message error'>$error</div>"; } ?>

    <form action="" method="post">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>

  <!-- Contact Info -->
  <div class="contact-info">
    <h2>Contact Information</h2>
    <div class="info-item">
      <strong>📍 Address:</strong>
      123 Green Street, New Delhi, India
    </div>
    <div class="info-item">
      <strong>📞 Phone:</strong>
      +91 98765 43210
    </div>
    <div class="info-item">
      <strong>✉️ Email:</strong>
      support@terranew.com
    </div>
    <div class="info-item">
      <strong>⏰ Office Hours:</strong>
      Mon - Sat: 9:00 AM - 6:00 PM
    </div>
  </div>

</div>

<footer>
  <p>&copy; <?php echo date("Y"); ?> TerraNew. All Rights Reserved.</p>
</footer>

</body>
</html>

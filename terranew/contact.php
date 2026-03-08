<?php 
include 'header.php';
include 'config.php'; // ✅ database connection
$success = $error = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname   = mysqli_real_escape_string($con, $_POST['first_name']);
    $lname   = mysqli_real_escape_string($con, $_POST['last_name']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, message) 
            VALUES ('$fname', '$lname', '$email', '$phone', '$message')";
    
    if (mysqli_query($con, $sql)) {
        $success = "✅ Your message has been sent successfully!";
    } else {
        $error = "❌ Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact - TerraNew</title>

  <!-- Local Bootstrap -->
  <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
  <!-- Local Font Awesome -->
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"/>
  <!-- Google Font -->
  <link rel="stylesheet" href="assets/fonts/poppins.css">
  

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0fdf4; /* light green bg */
      color: #064e3b;
    }

    /* Hero Section */
    .hero-section {
      background: linear-gradient(135deg, #15803d, #166534, #14532d); /* dark green */
      min-height: 480px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .hero-section h1 {
      font-weight: 700;
      font-size: 2.8rem;
    }

    .hero-section p {
      max-width: 600px;
      margin: 0 auto;
      opacity: 0.9;
    }

    .floating-shape {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      animation: float 8s ease-in-out infinite;
    }

    .shape-1 { width: 250px; height: 250px; top: -120px; right: -90px; }
    .shape-2 { width: 350px; height: 350px; bottom: -160px; left: -120px; animation-delay: 2s; }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-25px); }
    }

    /* Info Box */
    .info-box {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(12px);
      border-radius: 16px;
      padding: 25px;
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      margin-top: 30px;
    }

    .info-item {
      text-align: center;
      color: #fff;
    }

    .info-item i {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #bbf7d0; /* light green */
    }

    /* Contact Form */
    .contact-form {
      background: #ffffff;
      border-radius: 16px;
      padding: 35px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      transition: transform 0.3s ease;
    }

    .contact-form:hover {
      transform: translateY(-5px);
    }

    .form-control, select, textarea {
      border-radius: 10px;
      padding: 12px 15px;
    }

    .form-control:focus {
      border-color: #16a34a;
      box-shadow: 0 0 0 4px rgba(22,163,74,0.2);
    }

    .btn-submit {
      background: linear-gradient(135deg, #16a34a, #15803d);
      border: none;
      border-radius: 12px;
      padding: 12px;
      font-weight: 600;
      color: #fff;
      transition: all 0.3s ease;
    }

    .btn-submit:hover {
      background: linear-gradient(135deg, #15803d, #166534);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(22,163,74,0.3);
    }

    /* Side Cards */
    .contact-card {
      border-radius: 14px;
      padding: 25px;
      transition: all 0.3s ease;
      color: #ecfdf5;
    }

    .contact-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .contact-card h4 {
      font-weight: 600;
      color: #fff;
    }

    .list-unstyled li {
      margin-bottom: 10px;
      font-size: 0.95rem;
      color: #d1fae5;
    }

    .list-unstyled i {
      color: #bbf7d0;
    }

    /* Card Variants */
    .dark-green {
      background: linear-gradient(135deg, #166534, #15803d, #16a34a);
    }

    .dark-red {
      background: linear-gradient(135deg, #14532d, #064e3b, #052e16); /* dark green alt */
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>

    <div class="container">
      <div class="recycle-icon mb-4">
        <i class="fas fa-recycle fa-3x"></i>
      </div>
      <h1>Get In Touch With Us</h1>
      <p class="lead">Join us in our mission to create a cleaner, greener planet through innovative plastic recycling solutions.</p>

      <div class="info-box mt-5">
        <div class="info-item">
          <i class="fas fa-phone"></i>
          <h6>Call Us</h6>
          <p>+91 98765 43210</p>
        </div>
        <div class="info-item">
          <i class="fas fa-envelope"></i>
          <h6>Email Us</h6>
          <p>info@terranew.com</p>
        </div>
        <div class="info-item">
          <i class="fas fa-clock"></i>
          <h6>Business Hours</h6>
          <p>Mon-Fri: 9AM - 6PM</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Form Section -->
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Send Us a Message</h2>
        <p class="text-muted">We’re here to answer your questions about our recycling services.</p>

        <?php if($success): ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif($error): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
      </div>

      <div class="row g-5">
        <!-- Form -->
        <div class="col-lg-6">
          <div class="contact-form">
            <form method="POST">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">First Name</label>
                  <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Last Name</label>
                  <input type="text" name="last_name" class="form-control" required>
                </div>
              </div>
              <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mt-3">
                <label class="form-label">Phone</label>
                <input type="tel" name="phone" class="form-control" required>
              </div>
              <div class="mt-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="4" required></textarea>
              </div>
              <button type="submit" class="btn btn-submit w-100 mt-4">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
            </form>
          </div>
        </div>

        <!-- Side Info -->
        <div class="col-lg-6">
          <div class="contact-card dark-green mb-4">
            <h4>Why Choose TerraNew?</h4>
            <ul class="list-unstyled mt-3">
              <li><i class="fas fa-check-circle me-2"></i> 15+ years expertise</li>
              <li><i class="fas fa-check-circle me-2"></i> Modern recycling facilities</li>
              <li><i class="fas fa-check-circle me-2"></i> Eco-certified processes</li>
              <li><i class="fas fa-check-circle me-2"></i> Community-driven initiatives</li>
            </ul>
          </div>

          <div class="contact-card dark-red">
            <h4>Emergency Services</h4>
            <p class="mb-1">For urgent waste disposal:</p>
            <p class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> +91 91111 22222</p>
            <small>Available 24/7</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Local Bootstrap JS -->
  <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
  <?php include 'footer.php'; ?>
</body>
</html>

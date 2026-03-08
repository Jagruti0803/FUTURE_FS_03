<?php
// recycle.php - Plastic Submission Page
session_start();
include 'config.php'; 
include 'header.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to submit plastic.'); window.location.href='login.php';</script>";
    exit;
}

// Get logged-in user info
$user_id = (int)$_SESSION['user_id'];
$user_query = mysqli_query($con, "SELECT fullname, email, phone FROM customers WHERE id='$user_id'");
if (mysqli_num_rows($user_query) == 0) {
    echo "<script>alert('Invalid user. Please login again.'); window.location.href='login.php';</script>";
    exit;
}
$user = mysqli_fetch_assoc($user_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plastic_type = mysqli_real_escape_string($con, $_POST['plasticType']);
    $weight = (float)$_POST['quantity'];
    $condition = mysqli_real_escape_string($con, $_POST['condition']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $delivery = mysqli_real_escape_string($con, $_POST['delivery']);

    $rate = 10; 
    $amount = $weight * $rate;

    $sql = "INSERT INTO recycle_submissions 
        (customer_id, plastic_type, weight, amount, condition_status, description, delivery, status)
        VALUES ('$user_id', '$plastic_type', '$weight', '$amount', '$condition', '$description', '$delivery', 'pending')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Plastic submission recorded successfully!'); window.location.href='recycle.php';</script>";
    } else {
        echo "<script>alert('Database Error: ".mysqli_error($con)."');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recycle Plastic - TerraNew</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
/* ===== GLOBAL STYLES ===== */
body {
    font-family:'Poppins', sans-serif;
    background: linear-gradient(135deg, #e0f7e0, #b2dfb2);
    color: #2c3e50;
    padding-top: 100px; /* distance from navigation/header */
}
.section {
    background:white;
    padding:60px 40px;
    margin:40px auto;
    max-width:1200px;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}
.section:hover {
    transform: translateY(-5px);
    box-shadow:0 25px 50px rgba(0,0,0,0.15);
}
.section h2 {
    text-align:center;
    color:#27ae60;
    font-size:2.8rem;
    margin-bottom:40px;
    position:relative;
}
.section h2::after {
    content:'';
    width:100px;
    height:4px;
    background:#27ae60;
    display:block;
    margin:15px auto 0;
    border-radius:5px;
}

/* ===== PROCESS STEPS ===== */
.process-steps {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}
.step {
    background:#f9f9f9;
    padding:25px 20px;
    border-radius:15px;
    border-left:5px solid #2ecc71;
    text-align:center;
    transition: transform 0.3s, box-shadow 0.3s;
}
.step:hover {
    transform: translateY(-7px);
    box-shadow:0 20px 35px rgba(39,174,96,0.15);
    border-left-color:#27ae60;
}
.step-number {
    background:#2ecc71;
    color:white;
    width:50px;
    height:50px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 15px;
    font-size:1.3rem;
    font-weight:700;
    animation: float 3s ease-in-out infinite;
}
.step h3 {color:#27ae60; margin-bottom:10px; font-size:1.3rem;}
.step p {color:#555; font-size:0.95rem;}
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0px); }
}

/* ===== FORM STYLING ===== */
.form-grid {
    display:flex;
    justify-content:center;
    margin-top:40px;
}
.form-container {
    background:#f0fdf4;
    padding:35px;
    border-radius:15px;
    width:100%;
    max-width:600px;
    box-shadow:0 15px 25px rgba(0,0,0,0.08);
    transition: all 0.3s;
}
.form-container:hover {
    box-shadow:0 25px 50px rgba(0,0,0,0.12);
}
.form-group {margin-bottom:20px;}
.form-group label {
    font-weight:600;
    color:#2c3e50;
    margin-bottom:5px;
    display:block;
}
.form-group input, 
.form-group select, 
.form-group textarea {
    width:100%;
    padding:12px 15px;
    border:2px solid #c8e6c9;
    border-radius:10px;
    font-size:16px;
    transition: all 0.3s ease-in-out;
}
.form-group input:focus, 
.form-group select:focus, 
.form-group textarea:focus {
    border-color:#27ae60;
    box-shadow:0 0 10px rgba(39,174,96,0.25);
    outline:none;
}
.btn {
    background:#27ae60;
    color:white;
    padding:15px 25px;
    font-size:18px;
    font-weight:600;
    border-radius:10px;
    width:100%;
    cursor:pointer;
    position:relative;
    overflow:hidden;
    transition: all 0.3s;
}
.btn::after {
    content:"";
    position:absolute;
    left:50%;
    top:50%;
    transform:translate(-50%, -50%) scale(0);
    width:300%;
    height:300%;
    background: rgba(255,255,255,0.2);
    border-radius:50%;
    transition: transform 0.5s;
}
.btn:hover::after { transform:translate(-50%, -50%) scale(1); }
.btn:hover {background:#1e8449; transform:translateY(-3px);}

/* ===== REVEAL ANIMATIONS ===== */
.reveal {
    opacity:0;
    transform:translateY(30px);
    transition: all 0.8s ease-out;
}
.reveal.active {
    opacity:1;
    transform:translateY(0);
}
</style>
</head>
<body>

<!-- ===== PROCESS STEPS ===== -->
<section class="section" id="process">
<h2>How to Recycle Plastic: Step-by-Step</h2>
<div class="process-steps">
    <div class="step reveal">
        <div class="step-number">1</div>
        <h3>Collection & Sorting</h3>
        <p>Gather your plastic waste and sort it by type.</p>
    </div>
    <div class="step reveal">
        <div class="step-number">2</div>
        <h3>Identification</h3>
        <p>Check recycling symbols (1-7) to identify the type.</p>
    </div>
    <div class="step reveal">
        <div class="step-number">3</div>
        <h3>Preparation</h3>
        <p>Remove labels, caps, and non-plastic parts.</p>
    </div>
    <div class="step reveal">
        <div class="step-number">4</div>
        <h3>Delivery/Collection</h3>
        <p>Bring your sorted plastic to our collection center.</p>
    </div>
    <div class="step reveal">
        <div class="step-number">5</div>
        <h3>Processing</h3>
        <p>Our facility shreds, washes, and melts the plastic.</p>
    </div>
    <div class="step reveal">
        <div class="step-number">6</div>
        <h3>Rewards</h3>
        <p>Receive payment based on quantity and type.</p>
    </div>
</div>
</section>

<!-- ===== SELL PLASTIC FORM ===== -->
<section class="section" id="sell">
<h2>Sell Your Plastic Materials</h2>
<div class="form-grid">
<div class="form-container reveal">
<form id="plasticForm" method="POST">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="fullname" value="<?= htmlspecialchars($user['fullname']); ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>
    </div>
    <div class="form-group">
        <label for="plasticType">Plastic Type</label>
        <select id="plasticType" name="plasticType" required>
            <option value="">Select plastic type</option>
            <option value="HDPE">HDPE</option>
            <option value="PET">PET</option>
        </select>
    </div>
    <div class="form-group">
        <label for="quantity">Quantity (kg)</label>
        <input type="number" id="quantity" name="quantity" min="1" max="1000" placeholder="Enter quantity in kg" required>
    </div>
    <div class="form-group">
        <label for="condition">Condition</label>
        <select id="condition" name="condition" required>
            <option value="">Select condition</option>
            <option value="excellent">Excellent - Clean & Sorted</option>
            <option value="good">Good - Clean, Mixed Types</option>
            <option value="fair">Fair - Some Contamination</option>
            <option value="poor">Poor - Dirty/Mixed Materials</option>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Additional Details</label>
        <textarea id="description" name="description" rows="4"></textarea>
    </div>
    <div class="form-group">
        <label for="delivery">Delivery Method</label>
        <select id="delivery" name="delivery" required>
            <option value="">Select delivery method</option>
            <option value="dropoff">Drop-off at Center</option>
            <option value="pickup">Schedule Pickup (+₹10 fee)</option>
        </select>
    </div>
    <div class="form-group">
        <p><strong>Estimated Earning: ₹<span id="earning">0</span></strong></p>
    </div>
    <button type="submit" class="btn">Sell Plastic</button>
</form>
</div>
</div>
</section>

<!-- ===== JS ANIMATIONS & LIVE CALCULATOR ===== -->
<script>
const revealElements = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.isIntersecting) { 
            entry.target.classList.add('active'); 
            observer.unobserve(entry.target); 
        }
    });
}, {threshold:0.1});
revealElements.forEach(el => observer.observe(el));

const quantityInput = document.getElementById('quantity');
const earningDisplay = document.getElementById('earning');
quantityInput.addEventListener('input', () => {
    const rate = 10;
    const qty = parseFloat(quantityInput.value) || 0;
    earningDisplay.textContent = (qty * rate).toFixed(2);
});

const plasticType = document.getElementById('plasticType');
plasticType.addEventListener('change', () => {
    const form = document.querySelector('.form-container');
    if(plasticType.value === 'HDPE') form.style.borderColor = '#27ae60';
    else if(plasticType.value === 'PET') form.style.borderColor = '#2ecc71';
    else form.style.borderColor = '#c8e6c9';
});
</script>
<?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();
include 'config.php'; // database connection

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first to submit plastic.'); window.location='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id  = (int)$_SESSION['user_id'];
    $plastic_type = mysqli_real_escape_string($con, $_POST['plasticType'] ?? '');
    $weight       = (float)$_POST['quantity'] ?? 0;

    // Validate input
    if ($plastic_type == '' || $weight <= 0) {
        echo "<script>alert('Please select plastic type and enter valid quantity.'); window.history.back();</script>";
        exit;
    }

    // Calculate amount
    $priceMap = ['HDPE' => 10, 'PET' => 8, 'LDPE' => 6]; // add rates here
    $amount = ($priceMap[$plastic_type] ?? 0) * $weight;

    // Insert into recycle_submissions
    $sql = "INSERT INTO recycle_submissions (customer_id, plastic_type, weight, amount, status, created_at) 
            VALUES ('$customer_id', '$plastic_type', '$weight', '$amount', 'pending', NOW())";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Plastic submission successful!'); window.location='about.php';</script>";
    } else {
        echo "Database Error: " . mysqli_error($con);
    }
}
?>

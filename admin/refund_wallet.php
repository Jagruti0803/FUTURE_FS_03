<?php
include 'config.php'; // adjust path if inside admin folder
session_start();

// Check if logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['user_id'], $_POST['amount'])) {
        die("❌ Missing required fields.");
    }

    $user_id = intval($_POST['user_id']);
    $amount = floatval($_POST['amount']);

    if ($user_id <= 0 || $amount <= 0) {
        die("❌ Invalid user ID or amount.");
    }

    // Step 1: Refund amount to wallet
    $sql = "UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("❌ SQL Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("di", $amount, $user_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "✅ Refunded ₹" . number_format($amount, 2) . " to User ID #$user_id's wallet.";
    } else {
        echo "❌ Refund failed (User not found or DB error): " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

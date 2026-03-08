<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Ensure cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Fixed payment method
$payment_method = 'Cash on Delivery';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    // Calculate total price
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Insert into purchase_history
    $sql_order = "INSERT INTO purchase_history (customer_id, total_price, status, created_at)
                  VALUES ('$customer_id', '$total_price', 'Pending', NOW())";

    if (!mysqli_query($con, $sql_order)) {
        die("Error inserting order: " . mysqli_error($con));
    }

    $order_id = mysqli_insert_id($con);

    // Insert items into purchase_items
    foreach ($_SESSION['cart'] as $item) {
        $pid = intval($item['id']);
        $qty = intval($item['quantity']);
        $price = floatval($item['price']);
        $name = mysqli_real_escape_string($con, $item['name']);

        $sql_item = "INSERT INTO purchase_items (purchase_id, product_id, name, quantity, price)
                     VALUES ('$order_id', '$pid', '$name', '$qty', '$price')";

        if (!mysqli_query($con, $sql_item)) {
            die("Error inserting order item: " . mysqli_error($con));
        }
    }

    // Insert customer details
    $sql_details = "INSERT INTO purchase_details (purchase_id, fullname, email, phone, address, payment_method)
                    VALUES ('$order_id', '$fullname', '$email', '$phone', '$address', '$payment_method')";

    if (!mysqli_query($con, $sql_details)) {
        die("Error inserting order details: " . mysqli_error($con));
    }

    // Clear cart
    unset($_SESSION['cart']);

    // Optional: store last order info in session for quick access
    // After successful order insertion
// After inserting order and order items
$_SESSION['last_order_id'] = $order_id;
$_SESSION['last_order_email'] = $email;

// Redirect to pending order page
header("Location: pending_order.php");
exit();

}
?>

<?php
session_start();
include "config.php";

// ✅ Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $cart_id => $quantity) {
        $cart_id = intval($cart_id);
        $quantity = max(1, intval($quantity)); // avoid 0 or negative
        mysqli_query($con, "UPDATE cart SET quantity=$quantity WHERE id=$cart_id");
    }
}

header("Location: cart.php");
exit;
?>

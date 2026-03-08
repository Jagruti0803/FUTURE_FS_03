<?php
session_start();
include 'config.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product via AJAX
if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_id = intval($_POST['id']);
    
    $query = mysqli_query($con, "SELECT * FROM recycled_products WHERE id = $product_id LIMIT 1");
    if ($row = mysqli_fetch_assoc($query)) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Ensure only filename is stored
            $image = basename($row['image']);

            $_SESSION['cart'][$product_id] = [
                'id'       => $row['id'],
                'name'     => $row['name'],
                'price'    => $row['price'],
                'image'    => $image, // only filename stored
                'quantity' => 1
            ];
        }
    }

    // Return total cart quantity for AJAX
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    echo $count;
    exit;
}

// Increase quantity
if (isset($_GET['increase'])) {
    $id = intval($_GET['increase']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    }
    header("Location: cart.php");
    exit;
}

// Decrease quantity
if (isset($_GET['decrease'])) {
    $id = intval($_GET['decrease']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] -= 1;
        if ($_SESSION['cart'][$id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit;
}

// Remove product
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit;
}
?>

<?php
session_start();
include 'header.php';
include 'config.php';

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Calculate total and prepare products array
$products = $_SESSION['cart'];
$total = 0;
foreach ($products as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - TerraNew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom Styles for TerraNew Checkout */
        :root {
            --primary-color: #28a745; /* A fresh green for 'TerraNew' */
            --secondary-color: #6c757d;
            --light-bg: #f8f9fa;
            --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        }

        body {
            padding-top: 120px; /* adjust based on your navbar */
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 900px; /* Limit container width for better readability */
        }

        h2 {
            color: var(--primary-color);
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        h4 {
            color: var(--secondary-color);
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        /* Order Summary Table Styling */
        .table-bordered {
            border: 1px solid #dee2e6;
            box-shadow: var(--box-shadow);
            background-color: white;
        }

        .table-light th {
            background-color: var(--primary-color) !important;
            color: white;
            border-color: var(--primary-color);
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }
        
        /* Total Display */
        .checkout-total {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            padding: 10px 0;
            border-top: 2px solid #eee;
            margin-top: 15px;
        }

        /* Form Styling (card-like appearance) */
        .checkout-form-card {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            margin-bottom: 50px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }

        /* Place Order Button */
        .btn-success {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: background-color 0.2s, border-color 0.2s;
            width: 100%; /* Make button full width for prominence */
            margin-top: 20px;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            border-color: #1c7430;
        }

        /* Quantity Buttons in Summary */
        .d-inline-flex a.btn-secondary {
            background-color: #e9ecef;
            border-color: #e9ecef;
            color: var(--secondary-color);
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .d-inline-flex a.btn-secondary:hover {
            background-color: #ced4da;
            border-color: #ced4da;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><i class="fas fa-truck-moving me-2"></i>Checkout</h2>
    <p class="mb-4 text-muted">Review your order and enter your details to complete the purchase.</p>
    
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <h4>Order Summary</h4>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th class="text-end">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class="text-end">₹<?php echo number_format($item['price'], 2); ?></td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center">
                            <a href="cart_action.php?decrease=<?php echo $item['id']; ?>" class="btn btn-sm btn-secondary me-1">-</a>
                            <span style="min-width: 20px; text-align: center;"><?php echo $item['quantity']; ?></span>
                            <a href="cart_action.php?increase=<?php echo $item['id']; ?>" class="btn btn-sm btn-secondary ms-1">+</a>
                        </div>
                    </td>
                    <td class="text-end">₹<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    
        <div class="d-flex justify-content-end checkout-total">
            <span>Total:</span> <span class="ms-3">₹<?php echo number_format($total, 2); ?></span>
        </div>
    </div>
    
    <div class="checkout-form-card">
        <h4>Shipping & Payment Details</h4>
        <form action="place_order.php" method="post" class="mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="payment_method_display" class="form-label">Payment Method</label>
                    <input type="text" id="payment_method_display" class="form-control bg-light" value="Cash on Delivery (COD)" disabled>
                    <input type="hidden" name="payment_method" value="Cash on Delivery"> 
                </div>
            </div>
            <div class="mb-4">
                <label for="address" class="form-label">Shipping Address</label>
                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-success btn-lg">Complete Purchase (₹<?php echo number_format($total, 2); ?>)</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
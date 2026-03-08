<?php
session_start();
include 'header.php'; 
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - TerraNew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom Styles for TerraNew (Copied from checkout.php) */
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

        /* Grand Total Display */
        .cart-grand-total {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            padding: 15px 20px;
            border-top: 2px solid #eee;
            margin-top: 15px;
            background-color: white;
            border-radius: 0 0 8px 8px;
            box-shadow: var(--box-shadow);
        }

        /* Action Buttons */
        .btn-success {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            border-color: #1c7430;
        }
        
        /* Quantity Buttons */
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
            line-height: 1; /* Fix alignment for the symbols */
        }

        .d-inline-flex a.btn-secondary:hover {
            background-color: #ced4da;
            border-color: #ced4da;
        }

        /* Table Wrapper for Shadow */
        .table-wrapper {
            box-shadow: var(--box-shadow);
            border-radius: 8px;
            overflow: hidden; /* To keep the shadow clean */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Your Cart</h2>
    <p class="mb-4 text-muted">Review, update, or remove items before proceeding to checkout.</p>

    <?php if (!empty($_SESSION['cart'])): ?>
    <div class="table-wrapper">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 100px;">Image</th>
                    <th>Name</th>
                    <th class="text-end">Price</th>
                    <th class="text-center" style="width: 150px;">Quantity</th>
                    <th class="text-end">Subtotal</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grand_total = 0;
                foreach ($_SESSION['cart'] as $item_id => $item):
                    $total = $item['price'] * $item['quantity'];
                    $grand_total += $total;

                    // Correct image path
                    $imgPath = "images/" . $item['image'];
                    if (empty($item['image']) || !@file_exists($imgPath)) { // @ suppresses file_exists warning if open_basedir is set
                        $imgPath = "images/placeholder.png"; // fallback image (ensure this exists)
                    }
                ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($imgPath); ?>" width="80" class="img-fluid rounded" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class="text-end">₹<?php echo number_format($item['price'], 2); ?></td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center">
                            <a href="cart_action.php?decrease=<?php echo $item['id']; ?>&redirect=cart" class="btn btn-sm btn-secondary me-1">-</a>
                            <span style="min-width: 25px; text-align: center;"><?php echo $item['quantity']; ?></span>
                            <a href="cart_action.php?increase=<?php echo $item['id']; ?>&redirect=cart" class="btn btn-sm btn-secondary ms-1">+</a>
                        </div>
                    </td>
                    <td class="text-end">₹<?php echo number_format($total, 2); ?></td>
                    <td class="text-center">
                        <a href="cart_action.php?remove=<?php echo $item['id']; ?>&redirect=cart" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> <div class="d-flex justify-content-between align-items-center cart-grand-total">
        <div class="text-muted">Total Items: <?php echo count($_SESSION['cart']); ?></div>
        <div class="d-flex align-items-center">
            <span>Grand Total:</span> 
            <span class="ms-3">₹<?php echo number_format($grand_total, 2); ?></span>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="products.php" class="btn btn-outline-primary btn-lg"><i class="fas fa-undo me-2"></i>Continue Shopping</a>
        <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i></a>
    </div>

    <?php else: ?>
    <div class="alert alert-info py-4 text-center">
        <i class="fas fa-box-open fa-2x d-block mb-3"></i>
        Your shopping cart is currently empty.
    </div>
    <div class="text-center">
        <a href="products.php" class="btn btn-primary btn-lg"><i class="fas fa-store me-2"></i>Start Shopping</a>
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
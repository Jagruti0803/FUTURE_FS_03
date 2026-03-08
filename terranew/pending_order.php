<?php
session_start();
include 'config.php';
include 'header.php';

// Assuming 'header.php' contains the necessary HTML structure up to <body>
// If you want a visual header/navbar, make sure 'header.php' is included or add it manually.
// include 'header.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Database connection check (optional, but good practice if 'config.php' doesn't handle failures)
if (!isset($con)) {
    die("Database connection is not established. Check config.php.");
}

// Fetch last pending order
$stmt = $con->prepare("
    SELECT ph.*, pd.fullname, pd.email, pd.phone, pd.address, pd.payment_method
    FROM purchase_history ph
    JOIN purchase_details pd ON ph.id = pd.purchase_id
    WHERE ph.customer_id = ? AND ph.status = 'Pending'
    ORDER BY ph.created_at DESC
    LIMIT 1
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result_order = $stmt->get_result();
$order = $result_order->fetch_assoc();

// Fetch order items
$items = [];
if ($order) {
    $order_id = $order['id'];
    $stmt_items = $con->prepare("SELECT * FROM purchase_items WHERE purchase_id = ?");
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $result_items = $stmt_items->get_result();
    while($row = $result_items->fetch_assoc()){
        $items[] = $row;
    }
    // Set a flag to recalculate total from items, as the purchase_history total might not be included in the join
    $calculated_total = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pending Order - TerraNew</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* CSS Variables */
    :root {
        --primary-color: #28a745; /* Green */
        --warning-color: #ffc107; /* Bootstrap Warning */
        --light-bg: #f8f9fa;
        --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }

    body { 
        padding-top:120px; /* Adjusted for navbar */
        background-color: var(--light-bg); 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 900px;
    }

    h2 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 30px;
    }

    /* Order Details Box Styling */
    .order-details-card {
        background-color: #fff3cd; /* Light warning background */
        border-left: 5px solid var(--warning-color);
        padding: 25px;
        border-radius: 8px;
        box-shadow: var(--box-shadow);
        margin-bottom: 30px;
    }

    .order-details-card h4 {
        color: #856404; /* Darker yellow/brown text for contrast */
        margin-bottom: 15px;
        font-weight: 700;
    }

    .order-details-card p {
        margin-bottom: 5px;
        font-size: 0.95rem;
    }

    .order-details-card strong {
        font-weight: 600;
        color: #000;
    }

    /* Item Table Styling */
    h5 {
        color: #495057;
        margin-top: 25px;
        margin-bottom: 15px;
        border-bottom: 1px dashed #ced4da;
        padding-bottom: 5px;
    }

    .order-table thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border-color: var(--primary-color);
    }

    .order-table td { 
        vertical-align: middle; 
        background-color: white;
    }

    /* Total Display */
    .total-display {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--primary-color);
        text-align: right;
        padding: 10px 0;
        margin-top: 10px;
        border-top: 2px solid #eee;
    }

    /* No Orders Alert */
    .alert-success {
        border-left: 5px solid var(--primary-color);
        font-size: 1.1rem;
        padding: 20px;
    }
</style>
</head>
<body>
<div class="container">
<h2><i class="fas fa-history me-2"></i>Your Pending Order</h2>

<?php if($order): ?>
    <div class="order-details-card">
        <h4>Order #<?php echo htmlspecialchars($order['id']); ?> 
            <span class="badge bg-warning text-dark ms-2"><?php echo htmlspecialchars($order['status']); ?></span>
        </h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($order['created_at'])); ?></p>
                <p><strong>Payment Method:</strong> <span class="badge bg-secondary"><?php echo htmlspecialchars($order['payment_method']); ?></span></p>
                <p><strong>Shipping To:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            </div>
        </div>
    </div>

    <?php if(!empty($items)): ?>
        <h5>Purchased Items</h5>
        <div class="table-responsive">
            <table class="table table-bordered order-table">
                <thead class="table-light">
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $calculated_total=0; foreach($items as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $calculated_total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                            <td class="text-end">₹<?php echo number_format($item['price'],2); ?></td>
                            <td class="text-end">₹<?php echo number_format($subtotal,2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="total-display">
            Total: ₹<?php echo number_format($calculated_total,2); ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No items found for this order.</div>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i>You have no pending orders. All good! 🎉
    </div>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
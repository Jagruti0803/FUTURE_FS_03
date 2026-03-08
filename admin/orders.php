<?php
include "header.php";
include "config.php"; // database connection

// Require admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Approve / Reject / Mark Paid
if (isset($_GET['action']) && isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == "approve") {
        mysqli_query($con, "UPDATE orders_new SET status='Approved' WHERE id=$order_id");
    } elseif ($action == "reject") {
        mysqli_query($con, "UPDATE orders_new SET status='Rejected' WHERE id=$order_id");
    } elseif ($action == "paid") {
        mysqli_query($con, "UPDATE orders_new SET status='Paid' WHERE id=$order_id");
    }
    header("Location: orders.php");
    exit;
}

// Fetch all orders with product, customer & purchase details
$query = "SELECT o.*, 
                 p.name AS product_name, 
                 p.image, 
                 c.fullname AS customer_name,
                 pd.fullname AS purchaser_name,
                 pd.email AS purchaser_email,
                 pd.phone AS purchaser_phone,
                 pd.address AS purchaser_address,
                 pd.payment_method
           FROM orders_new o
           JOIN recycled_products p ON o.product_id = p.id
           JOIN customers c ON o.customer_id = c.id
           LEFT JOIN purchase_details pd ON o.id = pd.purchase_id
           ORDER BY o.created_at DESC";

$result = mysqli_query($con, $query);
if (!$result) {
    die("SQL Error: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Manage Orders</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
/* --- DASHBOARD STYLES (COPIED FROM dashboard.php) --- */
/* Define a green color palette for TerraNew */
:root {
    --tn-primary-green: #006400; /* Dark Green - Sidebar BG */
    --tn-light-green: #38a832; /* Medium Green - Hover/Accent */
    --tn-bg-color: #f7f9fc; /* Light background */
    --tn-card-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

body {
    background: var(--tn-bg-color);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* --- Sidebar Styling --- */
.sidebar { 
    position: fixed; 
    left: 0; 
    top: 0; 
    height: 100%; 
    width: 240px; /* Unified width */
    background: var(--tn-primary-green); 
    color: #fff; 
    padding-top: 20px; 
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.sidebar h3 {
    font-weight: 700;
    margin-bottom: 30px !important;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.sidebar a { 
    display: block; 
    padding: 12px 25px; 
    color: #fff; 
    text-decoration: none; 
    font-size: 1.05rem;
    transition: background 0.3s, padding-left 0.3s;
}

.sidebar a:hover { 
    background: var(--tn-light-green); 
    padding-left: 30px; 
}

.sidebar a i {
    margin-right: 10px;
    width: 20px;
}
/* Highlight active link */
.sidebar a[href="orders.php"] {
    background: var(--tn-light-green); 
}

/* --- Content Styling --- */
.content { 
    margin-left: 100px; /* Unified margin */
    padding: 30px; 
}

h2 {
    color: var(--tn-primary-green); /* Darker green for header */
    font-weight: 600;
    margin-bottom: 20px;
}

/* --- TABLE-SPECIFIC STYLES (Adjusted for placement) --- */

/* Card-Style Container for the Table */
.table-card-container {
    background: #fff; /* White background for the card */
    padding: 20px;
    border-radius: 12px;
    box-shadow: var(--tn-card-shadow); /* Use defined shadow variable */
    margin-bottom: 20px;
}

/* Table Responsive Wrapper */
.table-responsive {
    overflow-x: auto;
}

/* Table itself */
table {
    width: 100%;
    margin-bottom: 0; 
    min-width: 1400px; 
    font-size: 14px;
    border-radius: 10px;
    overflow: hidden; 
}

/* Table Header */
.table thead th {
    background: var(--tn-primary-green); /* Primary Dark Green Header */
    color: #fff;
    font-weight: 700;
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
    padding: 12px 8px; 
    border-bottom: none;
}

/* Table Body Cells */
td {
    text-align: center;
    vertical-align: middle;
    white-space: nowrap; 
    padding: 10px 8px;
}
.table-hover tbody tr:hover {
    background-color: #f5f5f5; /* Subtle hover effect */
}

/* Product Image */
td img {
    width: 50px; 
    height: 50px; 
    object-fit: cover; 
    border-radius: 4px;
    margin-right: 8px;
    border: 1px solid #eee;
}

/* Status Badges */
.badge {
    padding: 6px 10px; 
    border-radius: 50px; /* Pill shape */
    font-size: 12px;
    font-weight: 600;
    min-width: 80px;
    display: inline-block;
}

/* Specific Status Colors */
.status-Pending { 
    background: #fff3cd; 
    color: #856404; 
}
.status-Approved { 
    background: #d4edda; 
    color: #155724; 
}
.status-Rejected { 
    background: #f8d7da; 
    color: #721c24; 
}
.status-Paid { 
    background: #d1ecf1; 
    color: #0c5460; 
}

/* Action Buttons */
.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
    min-width: 80px;
}

/* Responsive adjustments */
@media(max-width: 768px) {
    .content {
        margin-left: 0; /* Remove margin on small screens if you hide or collapse the sidebar */
        padding: 15px;
    }
    table {
        font-size: 12px;
    }
    /* min-width on table handles horizontal scroll */
}
</style>
</head>
<body>

<div class="sidebar">
    <h3 class="text-center mb-4"><i class="fa-solid fa-recycle"></i> TerraNew</h3>
    <a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="customers.php"><i class="fa fa-users"></i> Customers</a>
    <a href="products.php"><i class="fa fa-box"></i> Products</a>
    <a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a>
    <a href="contact_messages.php"><i class="fa fa-envelope"></i> Messages</a>
    <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <h2 class="mb-4"><i class="fa fa-shopping-cart"></i> Manage Orders</h2>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="table-card-container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { 
                            $imgPath = $row['image'] ? "../images/".$row['image'] : "../images/placeholder.png";
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td class="text-start"><?php echo $row['customer_name']; ?></td>
                            <td class="text-start">
                                <img src="<?php echo $imgPath; ?>" alt="" width="40" height="40" style="border-radius:5px; margin-right:6px;">
                                <span style="vertical-align: middle;"><?php echo $row['product_name']; ?></span>
                            </td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                            <td><span class="badge status-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
                            <td>
                                <div class="d-grid gap-1">
                                    <?php if ($row['status'] == "Pending") { ?>
                                        <a href="orders.php?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Approve</a>
                                        <a href="orders.php?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                                    <?php } elseif ($row['status'] == "Approved") { ?>
                                        <a href="orders.php?action=paid&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Mark Paid</a>
                                    <?php } else { ?>
                                        <span class="text-muted btn-sm d-block">Completed</span>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">⚠ No orders found.</div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

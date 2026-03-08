<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Count helper
function get_count($con, $table, $where = "1") {
    $sql = "SELECT COUNT(*) AS count FROM $table WHERE $where";
    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("SQL Error in get_count(): " . mysqli_error($con) . " - Query: " . $sql);
    }

    $row = mysqli_fetch_assoc($res);
    return $row['count'] ?? 0;
}

function get_wallet_total($con) {
    $sql = "SELECT SUM(wallet) AS total FROM customers";
    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("SQL Error in get_wallet_total(): " . mysqli_error($con) . " - Query: " . $sql);
    }

    $row = mysqli_fetch_assoc($res);
    return $row['total'] ?? 0;
}

// Dashboard counts
$total_customers  = get_count($con, 'customers');
$total_products   = get_count($con, 'recycled_products');
$total_orders     = get_count($con, 'orders_new');
$total_wallet     = get_wallet_total($con);

// Orders status
$pending_orders   = get_count($con, 'orders_new', "status='pending'");
$completed_orders = get_count($con, 'orders_new', "status='completed'");
$cancelled_orders = get_count($con, 'orders_new', "status='cancelled'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - TerraNew</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { background:#f1f1f1; }
.sidebar { position: fixed; left:0; top:0; height:100%; width:220px; background:#006400; color:#fff; padding-top:20px; }
.sidebar a { display:block; padding:12px 20px; color:#fff; text-decoration:none; }
.sidebar a:hover { background:#008000; }
.content { margin-left:220px; padding:20px; }
.card { border-radius:10px; }
</style>
</head>
<body>
<div class="sidebar">
<h3 class="text-center mb-4"><i class="fa-solid fa-recycle"></i> Admin</h3>
<a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
<a href="customers.php"><i class="fa fa-users"></i> Customers</a>
<a href="products.php"><i class="fa fa-box"></i> Products</a>
<a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a>
<a href="contact_messages.php"><i class="fa fa-envelope"></i> Messages</a>
<a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
<a class="nav-link" href="orders.php"><i class="fas fa-shopping-cart"></i> Manage Orders
</a>
</li>

</div>

<div class="content">
<h2><i class="fa fa-home"></i> Dashboard</h2>
<hr>

<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="card text-white bg-success p-3"><div class="card-body"><h5 class="card-title"><i class="fa fa-users"></i> Customers</h5><p class="card-text fs-4"><?php echo $total_customers; ?></p></div></div></div>
  <div class="col-md-3"><div class="card text-white bg-primary p-3"><div class="card-body"><h5 class="card-title"><i class="fa fa-box"></i> Products</h5><p class="card-text fs-4"><?php echo $total_products; ?></p></div></div></div>
  <div class="col-md-3"><div class="card text-white bg-warning p-3"><div class="card-body"><h5 class="card-title"><i class="fa fa-shopping-cart"></i> Orders</h5><p class="card-text fs-4"><?php echo $total_orders; ?></p></div></div></div>
</div>


</script>
</body>
</html>

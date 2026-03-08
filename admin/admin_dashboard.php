<?php
session_start();
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        error_log("SQL Error in get_count(): " . mysqli_error($con) . " - Query: " . $sql);
        return 0;
    }

    $row = mysqli_fetch_assoc($res);
    return $row['count'] ?? 0;
}

// Mock data for Monthly Orders (Replace with actual database query later)
$monthly_orders_data = [
    'labels' => ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
    'data' => [45, 60, 52, 75, 68, 85] // Example order counts
];

// Dashboard counts
$total_customers  = get_count($con, 'customers');
$total_products   = get_count($con, 'recycled_products');
$total_orders     = get_count($con, 'orders_new');

// Recent Orders Query
$orders_sql = "SELECT o.id, o.created_at, c.fullname AS customer_name
               FROM orders_new o 
               JOIN customers c ON o.customer_id = c.id 
               ORDER BY o.created_at DESC LIMIT 5";
$orders = mysqli_query($con, $orders_sql);
// Check for query failure and capture error
if (!$orders) {
    $orders_error = "SQL Error (Recent Orders): " . mysqli_error($con) . " - Query: " . $orders_sql;
    error_log($orders_error);
}

// Recent Messages Query - UPDATED to use 'get_in_touch' table
$msgs_sql = "SELECT name, email, message, created_at FROM get_in_touch ORDER BY created_at DESC LIMIT 5";
$msgs = mysqli_query($con, $msgs_sql);
// Check for query failure and capture error
if (!$msgs) {
    $msgs_error = "SQL Error (Recent Messages - get_in_touch): " . mysqli_error($con) . " - Query: " . $msgs_sql;
    error_log($msgs_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - TerraNew</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<style>
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
    width: 240px; 
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

/* --- Content Styling --- */
.content { 
    margin-left: 240px; 
    padding: 30px; 
}

h2 {
    color: var(--tn-primary-green);
    font-weight: 600;
    margin-bottom: 20px;
}

/* --- Dashboard Cards --- */
.card { 
    border-radius: 10px; 
    border: none;
    box-shadow: var(--tn-card-shadow);
    transition: transform 0.3s;
    background-color: white; /* Ensure tables/charts have white background */
}

.card-stat { /* Style for the stat cards */
    min-height: 120px;
}

.card:hover {
    transform: translateY(-3px);
}

.card-body h5 {
    font-size: 1.1rem;
    opacity: 0.85;
}

.card-body .fs-4 {
    font-size: 2.2rem !important;
    font-weight: 700;
}

/* Table Card Styling */
.card-table h5 {
    color: var(--tn-primary-green);
    margin-bottom: 15px;
    font-weight: 600;
}

.table thead th {
    background-color: #e9ecef;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
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
<h2><i class="fa fa-tachometer-alt"></i> Dashboard Overview</h2>
<hr>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-success p-3 card-stat">
            <div class="card-body">
                <h5 class="card-title"><i class="fa fa-users"></i> Total Customers</h5>
                <p class="card-text fs-4"><?php echo $total_customers; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary p-3 card-stat">
            <div class="card-body">
                <h5 class="card-title"><i class="fa fa-box"></i> Total Products</h5>
                <p class="card-text fs-4"><?php echo $total_products; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning p-3 card-stat">
            <div class="card-body">
                <h5 class="card-title"><i class="fa fa-shopping-cart"></i> Total Orders</h5>
                <p class="card-text fs-4"><?php echo $total_orders; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card card-table p-3">
            <h5 class="mb-3"><i class="fa fa-chart-line"></i> Monthly Orders Trend</h5>
            <div class="chart-container" style="height:300px;">
                <canvas id="monthlyOrdersChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-table mb-4 p-3">
            <h5><i class="fa fa-shopping-cart"></i> Recent Orders</h5>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check for query error first
                    if (isset($orders_error)) {
                        echo "<tr><td colspan='3' class='text-center text-danger'>Query Failed: {$orders_error}</td></tr>";
                    } elseif ($orders && mysqli_num_rows($orders) > 0) {
                        while ($ord = mysqli_fetch_assoc($orders)) {
                            $date = date('M d, Y', strtotime($ord['created_at']));
                            echo "<tr>
                                    <td><span class='badge bg-secondary'>#{$ord['id']}</span></td>
                                    <td>" . htmlspecialchars($ord['customer_name']) . "</td>
                                    <td>{$date}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center text-muted'>No recent orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-table mb-4 p-3">
            <h5><i class="fa fa-envelope"></i> Recent Messages (Get in Touch)</h5>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Message Snippet</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check for query error first
                    if (isset($msgs_error)) {
                         echo "<tr><td colspan='3' class='text-center text-danger'>Query Failed: {$msgs_error}</td></tr>";
                    } elseif ($msgs && mysqli_num_rows($msgs) > 0) {
                        while ($msg = mysqli_fetch_assoc($msgs)) {
                            // Display the name and a snippet of the message
                            $msg_snippet = isset($msg['message']) && !empty($msg['message']) 
                                   ? (strlen($msg['message']) > 25 ? substr($msg['message'], 0, 25) . '...' : htmlspecialchars($msg['message']))
                                   : 'No message content'; // Using 'message' field from 'get_in_touch'
                            $date = date('M d, H:i', strtotime($msg['created_at']));
                            echo "<tr>
                                    <td>" . htmlspecialchars($msg['name']) . "</td>
                                    <td>{$msg_snippet}</td>
                                    <td>{$date}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center text-muted'>No recent messages found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // PHP variables are converted to JavaScript here
    const chartLabels = <?php echo json_encode($monthly_orders_data['labels']); ?>;
    const chartData = <?php echo json_encode($monthly_orders_data['data']); ?>;

    const ctx = document.getElementById('monthlyOrdersChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Orders',
                data: chartData,
                borderColor: '#006400', // Dark Green
                backgroundColor: 'rgba(0, 100, 0, 0.1)', // Light Green fill
                tension: 0.4, // Smooth curve
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Orders'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false,
                }
            }
        }
    });
});
</script>
</body>
</html>
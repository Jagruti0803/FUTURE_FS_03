<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$customers = mysqli_query($con, "SELECT * FROM customers ORDER BY id DESC");
// Check for query failure
if (!$customers) {
    die("Database query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customers - Admin | TerraNew</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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

/* --- Sidebar Styling (Copied from dashboard) --- */
.sidebar { 
    position: fixed; 
    left: 0; 
    top: 0; 
    height: 100%; 
    width: 240px; /* Adjusted width to match dashboard */
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
.sidebar a[href="customers.php"] {
    background: var(--tn-light-green); 
}

/* --- Content Styling --- */
.content { 
    margin-left: 240px; /* Adjusted margin to match dashboard width */
    padding: 30px; 
}

h2 {
    color: var(--tn-primary-green);
    font-weight: 600;
    margin-bottom: 20px;
}

/* --- Table Styling --- */
.table-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: var(--tn-card-shadow);
}

.table thead th { 
    background-color: var(--tn-primary-green); /* Dark Green Header */
    color: white; 
    font-size: 0.95rem;
    font-weight: 600;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #e9ecef;
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
<a href="messages.php"><i class="fa fa-envelope"></i> Messages</a>
<a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
<h2><i class="fa fa-users"></i> Customer Management</h2>

<div class="table-container">
    <table class="table table-striped table-hover mt-3">
    <thead>
    <tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php 
    if (mysqli_num_rows($customers) > 0) {
        while($row = mysqli_fetch_assoc($customers)) { 
            // Use badge for status to make it more visual
            $status_text = isset($row['status']) ? ucfirst($row['status']) : 'Active';
            $status_class = (isset($row['status']) && strtolower($row['status']) == 'inactive') ? 'bg-danger' : 'bg-success';
        ?>
        <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
        </tr>
        <?php 
        } 
    } else {
        echo '<tr><td colspan="5" class="text-center">No customers found.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
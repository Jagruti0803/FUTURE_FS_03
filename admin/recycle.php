<?php
session_start();
include '../config.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: auth.php");
    exit;
}

// Fetch recycle submissions with user names
$query = "SELECT recycle_products.*, users.name AS fullname 
          FROM recycle_products
          JOIN users ON recycle_products.user_id = users.id";

$recycles = mysqli_query($con, $query);

// Check for query errors
if (!$recycles) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Recycle Submissions - TerraNew</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f1fdf3; }
    .sidebar { height: 100vh; background: #006400; color: white; padding-top: 20px; position: fixed; width: 220px; }
    .sidebar a { color: white; display: block; padding: 12px 20px; text-decoration: none; }
    .sidebar a:hover { background: #008000; }
    .content { margin-left: 220px; padding: 20px; }
    .table th { background: #006400; color: white; }
  </style>
</head>
<body>

<div class="sidebar">
  <h3 class="text-center mb-4"><i class="fa-solid fa-recycle"></i> Admin</h3>
  <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a href="users.php"><i class="fa fa-users"></i> Users</a>
  <a href="products.php"><i class="fa fa-box"></i> Products</a>
  <a href="recycle.php"><i class="fa fa-leaf"></i> Recycle</a>
  <a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a>
  <a href="categories.php"><i class="fa fa-list"></i> Categories</a>
  <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
</div>

<div class="content">
  <h2><i class="fa fa-leaf"></i> Manage Recycle Submissions</h2>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Type</th>
        <th>Weight (kg)</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($recycles) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($recycles)): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
            <td><?php echo htmlspecialchars($row['plastic_type']); ?></td>
            <td><?php echo htmlspecialchars($row['weight_kg']); ?></td>
            <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="text-center">No recycle submissions found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>

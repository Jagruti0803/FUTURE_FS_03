<?php
session_start();
include '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all users from 'userss' table
$users_query = "SELECT *, CONCAT(firstname,' ',lastname) AS fullname FROM userss";
$users = mysqli_query($con, $users_query);

if (!$users) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - TerraNew</title>
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
  <h2><i class="fa fa-users"></i> Manage Users</h2>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($users) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($users)): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td>
              <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">
                <i class="fa fa-trash"></i> Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center">No users found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>

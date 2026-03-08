<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Add Category
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    mysqli_query($con, "INSERT INTO categories (name) VALUES ('$name')");
}

// Delete Category
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM categories WHERE id=$id");
}

$categories = mysqli_query($con, "SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Categories - TerraNew</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f1fdf3; }
    .sidebar {
      height: 100vh;
      background: #006400;
      color: white;
      padding-top: 20px;
      position: fixed;
      width: 220px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #008000;
    }
    .content {
      margin-left: 220px;
      padding: 20px;
    }
    .table th {
      background: #006400;
      color: white;
    }
    .btn-green { background: #006400; color: #fff; }
    .btn-green:hover { background: #008000; }
  </style>
</head>
<body>

<!-- Sidebar -->
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

<!-- Main Content -->
<div class="content">
  <h2><i class="fa fa-list"></i> Manage Categories</h2>

  <!-- Add Form -->
  <form method="POST" class="row g-3 mb-4">
    <div class="col-auto">
      <input type="text" name="name" class="form-control" placeholder="Category Name" required>
    </div>
    <div class="col-auto">
      <button type="submit" name="add" class="btn btn-green"><i class="fa fa-plus"></i> Add</button>
    </div>
  </form>

  <!-- Categories Table -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Category Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td>
          <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">
            <i class="fa fa-trash"></i> Delete
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>

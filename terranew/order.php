<?php
session_start();
include "config.php";

// ✅ Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$customer_id = $_SESSION['user_id'];

// Fetch all orders for this customer
$query = "SELECT o.*, p.name, p.image 
          FROM orders_new o 
          JOIN recycled_products p ON o.product_id = p.id 
          WHERE o.customer_id = $customer_id 
          ORDER BY o.created_at DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders - TerraNew</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f4fff4; }
    .order-card { background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); }
    .order-card img { width: 80px; height: 80px; object-fit: contain; border-radius: 8px; margin-right: 15px; }
    .status-badge { padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-success">My Orders</h2>

  <?php if (mysqli_num_rows($result) > 0) { ?>
    <?php while ($row = mysqli_fetch_assoc($result)) { 
      $imgPath = $row['image'] ? "images/".$row['image'] : "images/placeholder.png"; 
      $statusClass = "status-pending";
      if ($row['status'] == "Approved") $statusClass = "status-approved";
      if ($row['status'] == "Rejected") $statusClass = "status-rejected";
    ?>
      <div class="order-card d-flex align-items-center">
        <img src="<?php echo $imgPath; ?>" alt="<?php echo $row['name']; ?>">
        <div>
          <h5><?php echo $row['name']; ?></h5>
          <p class="mb-1">Quantity: <?php echo $row['quantity']; ?></p>
          <p class="mb-1">Total: ₹<?php echo $row['total_price']; ?></p>
          <p class="mb-1"><small>Ordered on: <?php echo $row['created_at']; ?></small></p>
          <span class="status-badge <?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
        </div>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="alert alert-warning">⚠ You haven’t placed any orders yet.</div>
    <a href="products.php" class="btn btn-success">Browse Products</a>
  <?php } ?>
</div>
</body>
</html>

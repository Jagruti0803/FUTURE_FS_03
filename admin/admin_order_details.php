<?php
session_start();
include 'config.php';
include 'header.php'; // Admin header

// Check if order ID is provided
if (!isset($_GET['id'])) {
    header("Location: admin_orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// Update status if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = mysqli_real_escape_string($con, $_POST['status']);
    mysqli_query($con, "UPDATE orders_new SET status='$new_status' WHERE id=$order_id");
    // Optional: refresh the page to reflect change
    header("Location: admin_order_details.php?id=$order_id");
    exit();
}

// Fetch order info
$order_query = mysqli_query($con, "SELECT o.*, u.fullname 
                                   FROM orders_new o
                                   JOIN users u ON o.customer_id = u.id
                                   WHERE o.id = $order_id");
$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    echo "<div class='alert alert-danger'>Order not found.</div>";
    exit();
}

// Fetch order items
$items_query = mysqli_query($con, "SELECT oi.*, rp.name 
                                   FROM order_items oi
                                   JOIN recycled_products rp ON oi.product_id = rp.id
                                   WHERE oi.order_id = $order_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Details - TerraNew Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>body{padding-top:120px;}</style>
</head>
<body>
<div class="container">
  <h2>Order Details</h2>

  <div class="mb-3">
    <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
    <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
    <p><strong>Created At:</strong> <?php echo $order['created_at']; ?></p>

    <form method="post" class="d-inline">
      <label><strong>Status:</strong></label>
      <select name="status" class="form-select d-inline w-auto">
        <option value="Pending" <?php if($order['status']=='Pending') echo 'selected'; ?>>Pending</option>
        <option value="Processing" <?php if($order['status']=='Processing') echo 'selected'; ?>>Processing</option>
        <option value="Completed" <?php if($order['status']=='Completed') echo 'selected'; ?>>Completed</option>
        <option value="Cancelled" <?php if($order['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
      </select>
      <button type="submit" class="btn btn-success btn-sm mt-1">Update Status</button>
    </form>
  </div>

  <h4>Items</h4>
  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $total = 0;
      while($item = mysqli_fetch_assoc($items_query)) { 
          $subtotal = $item['quantity'] * $item['price'];
          $total += $subtotal;
      ?>
      <tr>
        <td><?php echo htmlspecialchars($item['name']); ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td>₹<?php echo $item['price']; ?></td>
        <td>₹<?php echo $subtotal; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <h4>Total: ₹<?php echo $total; ?></h4>
  <a href="admin_orders.php" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
</body>
</html>

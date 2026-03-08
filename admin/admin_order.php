<?php
session_start();
include 'config.php';

// Require admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Approve / Reject
if (isset($_GET['action'], $_GET['id'])) {
    $order_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $con->prepare("UPDATE purchase_history SET status='Approved' WHERE id=?");
    } elseif ($action === 'reject') {
        $stmt = $con->prepare("UPDATE purchase_history SET status='Rejected' WHERE id=?");
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_order.php"); // reload page
        exit();
    }
}

// Fetch all orders
$sql = "SELECT ph.*, pd.fullname, pd.email, pd.phone, pd.address, pd.payment_method 
        FROM purchase_history ph
        JOIN purchase_details pd ON ph.id = pd.purchase_id
        ORDER BY ph.created_at DESC";

$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Orders - TerraNew</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{padding:50px;}</style>
</head>
<body>
<div class="container">
<h2>All Orders</h2>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td>
                <?php if($row['status'] === 'Pending'): ?>
                    <a href="?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                    <a href="?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                <?php else: ?>
                    <span class="text-muted">No action</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>
</html>

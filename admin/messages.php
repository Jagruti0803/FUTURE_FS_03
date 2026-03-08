<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$messages = mysqli_query($con,"SELECT * FROM messages ORDER BY id DESC");

// Delete message
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($con,"DELETE FROM messages WHERE id=$id");
    header("Location: messages.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Messages - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body { background:#f1f1f1; }
.sidebar { position:fixed; left:0; top:0; height:100%; width:220px; background:#006400; color:white; padding-top:20px; }
.sidebar a { display:block; padding:12px 20px; color:white; text-decoration:none; }
.sidebar a:hover { background:#008000; }
.content { margin-left:220px; padding:20px; }
.table th { background:#006400; color:white; }
</style>
</head>
<body>
<div class="sidebar">
<h3 class="text-center mb-4"><i class="fa-solid fa-recycle"></i> Admin</h3>
<a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
<a href="customers.php"><i class="fa fa-users"></i> Customers</a>
<a href="products.php"><i class="fa fa-box"></i> Products</a>
<a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a>
<a href="messages.php"><i class="fa fa-envelope"></i> Messages</a>
<a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
</div>

<div class="content">
<h2><i class="fa fa-envelope"></i> Messages</h2>
<table class="table table-bordered mt-3">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row = mysqli_fetch_assoc($messages)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['message']; ?></td>
<td>
<a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this message?')"><i class="fa fa-trash"></i> Delete</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>

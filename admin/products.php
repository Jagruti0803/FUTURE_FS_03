<?php
session_start();
include "../config.php"; // Adjusted path based on typical admin directory structure

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all PET and HDPE products
$products_query = mysqli_query($con, "SELECT * FROM recycled_products WHERE category IN ('PET','HDPE') ORDER BY id DESC");
if (!$products_query) {
    die("Database query failed: " . mysqli_error($con));
}

// --- PHP LOGIC (Add and Delete) ---

// Add Product Logic
if (isset($_POST['add'])) {
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $category = $_POST['category'];
    $grade    = $_POST['grade'];
    $price    = $_POST['price'];

    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $target_dir = "../images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image_name)) {
             error_log("Failed to move uploaded file.");
             $image_name = null;
        }
    }

    $insert_sql = "INSERT INTO recycled_products (name, category, grade, price, image) 
                   VALUES ('$name','$category','$grade','$price',".($image_name ? "'$image_name'" : "NULL").")";
    
    if (mysqli_query($con, $insert_sql)) {
        echo "<script>alert('Product added successfully!'); window.location='products.php';</script>"; 
    } else {
        echo "<script>alert('Error adding product: " . mysqli_error($con) . "');</script>";
    }
    exit;
}

// Delete Product Logic
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $res = mysqli_query($con, "SELECT image FROM recycled_products WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['image']) && file_exists("../images/".$row['image'])) {
            unlink("../images/".$row['image']);
        }
    }

    if (mysqli_query($con, "DELETE FROM recycled_products WHERE id=$id")) {
        echo "<script>alert('Product deleted successfully!'); window.location='products.php';</script>";
    } else {
         echo "<script>alert('Error deleting product: " . mysqli_error($con) . "');</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products - Admin | TerraNew</title>
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
/* Highlight active link */
.sidebar a[href="products.php"] {
    background: var(--tn-light-green); 
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

/* Card-style containers for form and table */
.card-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: var(--tn-card-shadow);
    margin-bottom: 20px;
}

/* Form specific styling */
.form-control, .btn {
    height: 40px;
}

/* Table styling */
.table thead th { 
    background-color: var(--tn-primary-green); 
    color: white; 
    font-size: 0.95rem;
    font-weight: 600;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #e9ecef;
}

.table img {
    border-radius: 5px;
    object-fit: cover;
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

<h2><i class="fa fa-box"></i> Manage Recycled Products</h2>
<hr>

<div class="card-container">
    <h5 class="mb-4 text-secondary">Add New Product</h5>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-2">
            <input type="text" name="name" class="form-control" placeholder="Product Name" required>
        </div>
        <div class="col-md-2">
            <select name="category" class="form-control" required>
                <option value="">Category</option>
                <option value="PET">PET</option>
                <option value="HDPE">HDPE</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="grade" class="form-control" required>
                <option value="Recycled">Recycled</option>
                <option value="Virgin">Virgin</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="price" class="form-control" placeholder="Price (₹)" required>
        </div>
        <div class="col-md-2">
            <input type="file" name="image" class="form-control">
        </div>
        <div class="col-md-2">
            <button type="submit" name="add" class="btn btn-success w-100"><i class="fa fa-plus"></i> Add Product</button>
        </div>
    </form>
</div>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Grade</th>
                <th>Price (₹)</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($products_query) > 0) {
                while ($row = mysqli_fetch_assoc($products_query)) { 
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><span class="badge bg-success"><?= $row['category'] ?></span></td>
                    <td><?= $row['grade'] ?></td>
                    <td>₹ <?= number_format($row['price'], 2) ?></td>
                    <td>
                        <?php 
                        if (!empty($row['image'])) {
                            $imgPath = "../images/" . $row['image'];
                            if (file_exists($imgPath)) {
                                echo "<img src='$imgPath' width='50' height='50' alt='".htmlspecialchars($row['name'])."'>";
                            } else {
                                echo "<img src='https://via.placeholder.com/50/CCCCCC/808080?text=N/A' width='50' height='50' alt='No Image'>";
                            }
                        } else {
                            echo "<img src='https://via.placeholder.com/50/CCCCCC/808080?text=N/A' width='50' height='50' alt='No Image'>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php 
                } 
            } else {
                echo '<tr><td colspan="7" class="text-center text-muted">No products found in PET or HDPE categories.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
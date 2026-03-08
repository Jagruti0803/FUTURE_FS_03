<?php
session_start();
include "../config.php";

// Require admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize variables
$edit_mode = false;
$product = [
    'id' => 0,
    'name' => '',
    'price' => '',
    'quantity' => '',
    'image' => ''
];
$error = '';
$success = '';

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    // Delete image file if exists
    $img_res = mysqli_query($con, "SELECT image FROM recycled_products WHERE id=$delete_id");
    if ($img_res && mysqli_num_rows($img_res) > 0) {
        $img_row = mysqli_fetch_assoc($img_res);
        $img_path = "../images/" . $img_row['image'];
        if ($img_row['image'] && file_exists($img_path)) {
            unlink($img_path);
        }
    }
    mysqli_query($con, "DELETE FROM recycled_products WHERE id=$delete_id");
    header("Location: manage_products.php");
    exit;
}

// Handle edit form load
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $res = mysqli_query($con, "SELECT * FROM recycled_products WHERE id=$edit_id");
    if ($res && mysqli_num_rows($res) > 0) {
        $product = mysqli_fetch_assoc($res);
        $edit_mode = true;
    } else {
        $error = "Product not found.";
    }
}

// Handle add/edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $name = trim(mysqli_real_escape_string($con, $_POST['name']));
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    // Validate required fields
    if ($name === '' || $price <= 0 || $quantity < 0) {
        $error = "Please fill in all required fields correctly.";
    } else {
        // Handle image upload if any
        $image_name = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $error = "Image upload error. Please try again.";
            } else {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowed_types)) {
                    $error = "Only JPG, PNG, GIF images are allowed.";
                } else {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $image_name = uniqid('prod_') . "." . $ext;
                    $target_path = "../images/" . $image_name;
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                        $error = "Failed to upload image.";
                    }
                }
            }
        }

        if (!$error) {
            if ($product_id > 0) {
                // Update existing product
                if ($image_name) {
                    // Delete old image
                    $old_img_res = mysqli_query($con, "SELECT image FROM recycled_products WHERE id=$product_id");
                    if ($old_img_res && mysqli_num_rows($old_img_res) > 0) {
                        $old_img_row = mysqli_fetch_assoc($old_img_res);
                        $old_img_path = "../images/" . $old_img_row['image'];
                        if ($old_img_row['image'] && file_exists($old_img_path)) {
                            unlink($old_img_path);
                        }
                    }
                    $update_query = "UPDATE recycled_products SET name='$name', price=$price, quantity=$quantity, image='$image_name' WHERE id=$product_id";
                } else {
                    $update_query = "UPDATE recycled_products SET name='$name', price=$price, quantity=$quantity WHERE id=$product_id";
                }
                mysqli_query($con, $update_query);
                $_SESSION['success'] = "Product updated successfully.";
            } else {
                // Insert new product
                $image_name = $image_name ?: ''; // blank if no image
                $insert_query = "INSERT INTO recycled_products (name, price, quantity, image) VALUES ('$name', $price, $quantity, '$image_name')";
                mysqli_query($con, $insert_query);
                $_SESSION['success'] = "Product added successfully.";
            }
            // Redirect to avoid form resubmission
            header("Location: manage_products.php");
            exit;
        }
    }
}

// Fetch all products
$query = "SELECT * FROM recycled_products ORDER BY id DESC";
$result = mysqli_query($con, $query);

// Retrieve success message from session if exists
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background: #f9fdf9; }
    table { background: #fff; border-radius: 10px; overflow: hidden; }
    th { background: #2e7d32; color: #fff; }
    td img { width: 60px; height: 60px; object-fit: contain; border-radius: 8px; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-success">Manage Products</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php endif; ?>

  <!-- Add/Edit Product Form -->
  <div class="card mb-4">
    <div class="card-header bg-success text-white">
      <?php echo $edit_mode ? "Edit Product" : "Add New Product"; ?>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
        <div class="mb-3">
          <label class="form-label">Product Name *</label>
          <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Price (₹) *</label>
          <input type="number" step="0.01" min="0" name="price" class="form-control" required value="<?php echo htmlspecialchars($product['price']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Quantity *</label>
          <input type="number" min="0" name="quantity" class="form-control" required value="<?php echo htmlspecialchars($product['quantity']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Image <?php if ($edit_mode && $product['image']) echo '(leave blank to keep current)'; ?></label>
          <input type="file" name="image" class="form-control" accept="image/*">
          <?php if ($edit_mode && $product['image']): ?>
            <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" style="max-width:100px; margin-top:10px;">
          <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success"><?php echo $edit_mode ? "Update Product" : "Add Product"; ?></button>
        <?php if ($edit_mode): ?>
          <a href="manage_products.php" class="btn btn-secondary ms-2">Cancel</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Products Table -->
  <?php if ($result && mysqli_num_rows($result) > 0) { ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { 
          $imgPath = $row['image'] ? "../images/" . $row['image'] : "../images/placeholder.png";
        ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><img src="<?php echo $imgPath; ?>" alt="Product Image"></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
              <a href="manage_products.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="manage_products.php?delete_id=<?php echo $row['id']; ?>" 
                 class="btn btn-sm btn-danger" 
                 onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  <?php } else { ?>
    <div class="alert alert-warning">No products found.</div>
  <?php } ?>
</div>
</body>
</html>

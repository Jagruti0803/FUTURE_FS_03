<?php
include 'header.php';
include 'config.php';

// Input values
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : '';
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';

// Filter logic
$filters = [];

if ($search) {
  $filters[] = "(p.pname LIKE '%$search%' OR c.category_name LIKE '%$search%')";
}
if ($category_id) {
  $filters[] = "c.category_id = $category_id";
}
if ($price_range) {
  list($min_price, $max_price) = explode('-', $price_range);
  $filters[] = "p.price BETWEEN $min_price AND $max_price";
}

$search_query = !empty($filters) ? "WHERE " . implode(" AND ", $filters) : '';

// SQL with JOIN on categories
$query = "
  SELECT p.*, c.category_name 
  FROM products p
  JOIN categories c ON p.category_id = c.category_id
  $search_query
";

$result = mysqli_query($con, $query);
if (!$result) {
  die("Query Failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Buyer - View Plastic Products</title>
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    /* All your styles remain unchanged (from your previous code) */
    /* ... (keep all your existing CSS from your current code) ... */
  </style>
</head>
<body>

<div class="header-bar">
  <h1 class="header-title">Recycled PET & HDPE Products</h1>
  <div class="icon-links">
    <a href="wishlist.php"><i class="bx bx-heart"></i> Wishlist</a>
    <a href="cart.php"><i class="bx bx-cart"></i> Cart</a>
  </div>
</div>

<!-- Sub Navigation Tabs -->
<div class="tab-nav">
  <a href="seller.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'seller.php' ? 'active' : ''; ?>">Sell Plastic</a>
  <a href="admin_product.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin_product.php' ? 'active' : ''; ?>">Purchase Products</a>
</div>

<!-- Filter and Search Bar -->
<div class="search-bar">
  <form method="GET" action="">
    <input type="text" name="search" placeholder="Search by name or category" value="<?php echo htmlspecialchars($search); ?>">

    <!-- Category Filter -->
    <select name="category">
      <option value="">All Categories</option>
      <?php
      $category_query = mysqli_query($con, "SELECT * FROM categories");
      while ($cat = mysqli_fetch_assoc($category_query)) {
        $selected = ($category_id == $cat['category_id']) ? 'selected' : '';
        echo "<option value='{$cat['category_id']}' $selected>{$cat['category_name']}</option>";
      }
      ?>
    </select>

    <!-- Price Filter -->
    <select name="price_range">
      <option value="">All Prices</option>
      <option value="0-500" <?php if ($price_range == '0-500') echo 'selected'; ?>>₹0 - ₹500</option>
      <option value="501-1000" <?php if ($price_range == '501-1000') echo 'selected'; ?>>₹501 - ₹1000</option>
      <option value="1001-5000" <?php if ($price_range == '1001-5000') echo 'selected'; ?>>₹1001 - ₹5000</option>
    </select>

    <input type="submit" value="Filter">
  </form>
</div>

<!-- Product Grid -->
<div class="product-grid">
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="card">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
        <div class="card-body">
          <div class="product-title">
            <?php echo htmlspecialchars($row['pname']); ?>
            <span class="rating">★ 4.5</span>
          </div>
          <div class="desc"><?php echo htmlspecialchars($row['description']); ?></div>
          <div class="price">₹<?php echo htmlspecialchars($row['price']); ?></div>
          <div class="btn-group">
            <a href="buy.php?id=<?php echo $row['id']; ?>" class="btn btn-buy">Buy</a>
            <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn btn-card" onclick="return confirm('Add this product to your cart?');">Add to cart</a>
            <a href="add_to_wishlist.php?id=<?php echo $row['id']; ?>" class="btn btn-list">Wishlist</a>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php else: ?>
    <div class="no-products">No products found.</div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();
include 'header.php';
include 'config.php'; // database connection

// Fetch all products
$products_query = mysqli_query($con, "SELECT * FROM recycled_products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products - TerraNew</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); min-height: 100vh; }
    .container { max-width: 1200px; margin:120px auto; padding:20px; }
    .filter-section { background: #f8f9fa; padding: 10px 15px; border-radius: 10px; margin-bottom: 30px; display: flex; align-items: center; justify-content: flex-start; gap: 10px; flex-wrap: wrap; }
    .filter-section h3 { margin: 0; color: #2e7d32; }
    .filter-section select { height: 40px; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .product-card { background: white; border: 1px solid #ddd; border-radius: 10px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: transform 0.3s; }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { max-width: 100%; height: 150px; object-fit: contain; margin-bottom: 10px; }
    .product-card h4 { color: #2e7d32; margin-bottom: 10px; }
    .product-card .price { font-weight: bold; color: #4caf50; margin-bottom: 5px; }
    .product-card .grade { font-size: 14px; color: #555; margin-bottom: 10px; }
  </style>
</head>
<body>
<div class="container">
  <!-- Filter Section -->
  <section class="filter-section">
    <h3>Filter:</h3>
    <select id="typeFilter" class="form-select" style="width:200px;">
      <option value="all">All Plastic Types</option>
      <option value="PET">PET</option>
      <option value="HDPE">HDPE</option>
    </select>

    <select id="gradeFilter" class="form-select" style="width:200px;">
      <option value="all">All Grades</option>
      <option value="Recycled">Recycled</option>
      <option value="Virgin">Virgin</option>
    </select>
  </section>

  <!-- Products Section -->
  <section id="products">
    <h2>Our Products</h2>
    <div class="product-grid">
      <?php while($row = mysqli_fetch_assoc($products_query)) { 
        $imgPath = $row['image'] ? "images/".$row['image'] : "images/placeholder.png"; 
      ?>
      <div class="product-card" 
           data-type="<?php echo htmlspecialchars($row['category']); ?>" 
           data-grade="<?php echo htmlspecialchars($row['grade']); ?>">
        <img src="<?php echo $imgPath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <h4><?php echo htmlspecialchars($row['name']); ?></h4>
        <p class="price">₹<?php echo $row['price']; ?></p>
        <p class="grade"><?php echo htmlspecialchars($row['grade']); ?> | <?php echo htmlspecialchars($row['category']); ?></p>
        <button class="btn btn-success add-to-cart-btn" data-id="<?php echo $row['id']; ?>">
          <i class="fa fa-cart-plus"></i> Add to Cart
        </button>
      </div>
      <?php } ?>
    </div>
  </section>
</div>

<script>
// Filter products automatically on dropdown change
function filterProducts() {
  const type = document.getElementById('typeFilter').value;
  const grade = document.getElementById('gradeFilter').value;

  document.querySelectorAll('.product-card').forEach(card => {
    const matchesType = (type === 'all' || card.dataset.type === type);
    const matchesGrade = (grade === 'all' || card.dataset.grade === grade);
    card.style.display = (matchesType && matchesGrade) ? 'block' : 'none';
  });
}

$(document).ready(function(){
    // Add to cart AJAX
    $('.add-to-cart-btn').click(function(e){
        e.preventDefault();

        var productId = $(this).data('id');

        $.ajax({
            url: 'cart_action.php',
            type: 'POST',
            data: { id: productId, action: 'add' },
            success: function(response){
                $('#cart-count').text(response);
            },
            error: function(){
                console.log('Error adding to cart');
            }
        });
    });

    // Run filter on dropdown change
    $('#typeFilter, #gradeFilter').on('change', filterProducts);

    // Show all products on initial load
    filterProducts();
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>

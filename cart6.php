<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the shop ID (e.g., passed as a query parameter or stored in the session)
if (isset($_GET['shop_id'])) {
    $shop_id = intval($_GET['shop_id']);
    $_SESSION['shop_id'] = $shop_id;
} elseif (isset($_SESSION['shop_id'])) {
    $shop_id = $_SESSION['shop_id'];
} else {
    die("Shop not specified.");
}

// Fetch the shop's name
$shop_query = "SELECT shop_name FROM shops WHERE id = ?";
$stmt = $conn->prepare($shop_query);
$stmt->bind_param("i", $shop_id);
$stmt->execute();
$shop_result = $stmt->get_result();
if ($shop_result->num_rows === 1) {
    $shop = $shop_result->fetch_assoc();
    $shop_name = $shop['shop_name'];
} else {
    die("Shop not found.");
}
$stmt->close();

// Fetch products for the current shop
$product_query = "SELECT * FROM products WHERE shop_id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("i", $shop_id);
$stmt->execute();
$products_result = $stmt->get_result();
?>

<?php
include("connection.php"); // Ensure this includes your database connection

$query = "ALTER TABLE products ADD shop_id INT NOT NULL";

// Make sure the query for altering the table is appropriate and executed as necessary
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title><?php echo htmlspecialchars($shop_name); ?> - Products</title>
    <style>
        /* Include your CSS styles here (omitted for brevity) */
    </style>
</head>
<body>
<header class="app-header">
    <div class="back-button">
        <a href="homepage.php" onclick="history.back()"><img src="IMG/chevron-left-regular-24.png" alt="Back"></a>
    </div>

    <div class="search-box">
    <h1><p>Your shop: <?php echo htmlspecialchars($shop_name); ?></p></h1>

  <input type="text" id="search" placeholder="Search products...">
    </div>

    <div class="header-icons">
        <a href="add_product.php"><button class="add-product-btn">+ Add Product</button></a>
        <a href="order_list.php"><button class="Order_list">Order List</button></a>
        <a href="#"><img src="IMG/bxs-cart (1).svg" alt="Cart"></a>
        <a href="#"><img src="IMG/dots-vertical-rounded-regular-24.png" alt="More"></a>
    </div>
</header>

<div class="product-grid">
    <?php while ($row = $products_result->fetch_assoc()): ?>
        <div class="product-item">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image">
            </div>
            <div class="product-info">
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="product-price">Price: $<?php echo number_format($row['price'], 2); ?></div>
            </div>
            <div class="product-seller">
                <a href="form5.php?product_id=<?php echo $row['id']; ?>&image=<?php echo urlencode($row['image_url']); ?>&name=<?php echo urlencode($row['name']); ?>&price=<?php echo urlencode($row['price']); ?>">
                    <button>Buy Now</button>
                </a>
                <button class="remove-btn" onclick="removeFromCart(<?php echo $row['id']; ?>)">Remove</button>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script>
    // Search functionality for filtering products
    document.getElementById("search").addEventListener("input", function() {
        let query = this.value.toLowerCase();
        let products = document.querySelectorAll(".product-item");
        products.forEach(function(product) {
            let title = product.querySelector("h2").textContent.toLowerCase();
            if (title.includes(query)) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });
    });

    function removeFromCart(productId) {
        console.log("Product removed from cart: " + productId);
    }
</script>

</body>
</html>

<?php
$stmt->close();
?>

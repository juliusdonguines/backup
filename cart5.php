<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; // Update with your MySQL root password
$dbname = 'shop'; // Correct database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check if the shop name exists in session
$shop_name = isset($_SESSION['shop_name']) ? $_SESSION['shop_name'] : 'Default Shop';

// Optionally, fetch from the database if not found in session
if (!isset($_SESSION['shop_name'])) {
    include("connection.php");
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    $query = "SELECT shop_name FROM shops WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($shop_name);
    $stmt->fetch();
    $_SESSION['shop_name'] = $shop_name; // Store in session for future use
    $stmt->close();
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fetching cart data for display
$cart = $_SESSION['cart'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title>Shopping Cart</title>
    <style>
        .product-seller button {
            background-color: #007bff; /* Blue background for Buy Now */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
        }

        .product-seller button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .product-seller button:active {
            background-color: #004085;
            transform: scale(1);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .product-item:hover {
            transform: translateY(-10px);
        }

        .product-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .product-info {
            padding: 15px;
        }

        .product-price {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .product-info h2 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }

        .product-info p {
            font-size: 14px;
            color: #666;
        }

        .product-grid .product-item a {
            text-decoration: none;
            color: inherit;
        }

        @media screen and (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        .search-box input {
            padding: 8px;
            width: 300px;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<header class="app-header">
    <div class="back-button">
        <a href="homepage.php" onclick="history.back()"><img src="euthaliaremove.png" alt="Back"></a>
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
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-item" id="product-<?php echo $row['id']; ?>"> <!-- Add unique ID -->
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2><?php echo htmlspecialchars($row['product_title']); ?></h2>
                    <p><?php echo htmlspecialchars($row['product_description']); ?></p>
                    <div class="product-price">Price: $<?php echo number_format($row['price'], 2); ?></div>
                </div>
                <div class="product-seller">
                    <button onclick="window.location.href='form5.php?name=<?php echo urlencode($row['product_title']); ?>&price=<?php echo urlencode($row['price']); ?>&image=<?php echo urlencode($row['product_image']); ?>'">Buy Now</button>
                    <!-- Use product ID for the Remove button -->
                    </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products available. Add some products first!</p>
    <?php endif; ?>
</div>

<script>
        // Send the POST request with the product_id
        xhr.send("product_id=" + productId);
</script>

</body>
</html>

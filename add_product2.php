<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; // Update with your MySQL root password
$dbname = 'shop'; // Correct database name here

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_product'])) {
    $productTitle = htmlspecialchars($_POST['product_title']);
    $productDescription = htmlspecialchars($_POST['product_description']);
    $price = floatval($_POST['price']);
    $productImage = '';

    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileTmpPath = $_FILES['product_image']['tmp_name'];
        $fileName = uniqid('img_', true) . '.' . pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $productImage = $uploadDir . $fileName;

        if (!move_uploaded_file($fileTmpPath, $productImage)) {
            echo "<p>Error uploading the image.</p>";
            exit;
        }
    }

    // Insert product into the database
    $stmt = $conn->prepare("INSERT INTO products (product_title, product_description, price, product_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssds', $productTitle, $productDescription, $price, $productImage);

    if ($stmt->execute()) {
        echo "<p>Product added successfully!</p>";
        // Redirect to cart page
        header("Location: cart6.php");
        exit();
    } else {
        echo "<p>Error adding product: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="add_product.css">
</head>
<body>

<header>
    <h1>Add Product</h1>
</header>

<!-- Product Add Form -->
<form action="add_product.php" method="POST" enctype="multipart/form-data">
    <label for="product-title">Product Title:</label>
    <input type="text" id="product-title" name="product_title" required>

    <label for="product-description">Product Description:</label>
    <textarea id="product-description" name="product_description" rows="4" required></textarea>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" min="0" step="0.01" required>

    <label for="product-image">Product Image (Upload):</label>
    <input type="file" id="product-image" name="product_image" accept="image/*" required>

    <button type="submit" name="submit_product">Submit</button>
</form>

</body>
</html>

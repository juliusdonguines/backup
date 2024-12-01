<?php
// Start the session
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title>E-commerce Store</title>
    <style>
     /* CSS for Buy Now Button */
     .product-seller button {
          background-color: #28a745; /* Green background */
          color: white; /* White text */
          padding: 10px 20px; /* Add padding for a comfortable size */
          border: none; /* Remove borders */
          border-radius: 5px; /* Rounded corners */
          font-size: 16px; /* Font size for readability */
          cursor: pointer; /* Pointer cursor on hover */
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
          transition: background-color 0.3s, transform 0.2s; /* Smooth hover effect */
      }

      .product-seller button:hover {
          background-color: #218838; /* Darker green on hover */
          transform: scale(1.05); /* Slightly enlarge the button */
      }

      .product-seller button:active {
          background-color: #1e7e34; /* Even darker green when clicked */
          transform: scale(1); /* Reset size */
      }

      /* Product Grid Styling */
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
      /* General Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
}

/* Header Styles */
.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f8c8d4; /* Light pink background */
  padding: 10px 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

/* Back Button */
.back-button a {
  display: flex;
  align-items: center;
  text-decoration: none;
}

.back-button img {
  width: 24px;
  height: 24px;
  transition: transform 0.3s ease;
}

.back-button img:hover {
  transform: scale(1.1);
}

/* Search Box */
.search-box {
  flex: 1;
  text-align: center;
}

.search-box h1 {
  font-size: 24px; /* Larger font size */
  color: #333;
  margin-bottom: 10px;
}

.search-box input {
  width: 50%; /* Smaller width */
  padding: 8px 12px;
  border: 2px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s;
}

.search-box input:focus {
  border-color: #4CAF50;
}

/* Header Icons Section */
.header-icons {
  display: flex;
  align-items: center;
}

.header-icons a {
  margin-left: 20px;
}

.header-icons img {
  width: 24px;
  height: 24px;
  transition: transform 0.3s ease;
}

.header-icons img:hover {
  transform: scale(1.1);
}

/* Add to Cart Button */
.addtocart {
  padding: 8px 15px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  text-decoration: none;
}

.addtocart:hover {
  background-color: #45a049;
}

    </style>
</head>
<body>
  <header class="app-header">
    <div class="back-button">
      <a href="homepage.php" onclick="history.back()"><img src="IMG/chevron-left-regular-24.png"></a>
    </div>

    <div class="search-box">
      <h1><p>Your shop: <?php echo htmlspecialchars($shop_name); ?></p></h1>
      <input type="text" placeholder="search">
    </div>

    <div class="header-icons">


    </div>
  </header>

  <div class="product-grid">
  <div class="product-item">
    <div class="product-image">
      <a href="#">
      <img src="giphy.gif" alt="Product Image">
      </a>
    </div>

    <div class="product-info">
      <h2>Product Name</h2>
      <p>Product description</p>

      <div class="product-price">
        <span>$ 500</span>
      </div>

      <div class="product-seller">
      </div>
    </div>
  </div>

  <div class="product-item">
    <div class="product-image">
      <a href="#">
      <img src="curvo.jpg" alt="Product Image">
      </a>
    </div>

    <div class="product-info">
      <h2>Product Name</h2>
      <p>Product description</p>

      <div class="product-price">
        <span>$ 900</span>
      </div> 
      
      <div class="product-seller">
      </div>
    </div>
  </div>

  <div class="product-item">
    <div class="product-image">
      <a href="#">
      <img src="IMG/pic4.jpg" alt="Product Image">
      </a>
    </div>

    <div class="product-info">
      <h2>Product Name</h2>
      <p>Product description</p>

      <div class="product-price">
        <span>$ 600</span>

      </div>
      
      <div class="product-seller">
      </div>
    </div>
  </div>

  <div class="product-item">
    <div class="product-image">
      <a href="#">
      <img src="IMG/pic2.jpg" alt="Product Image">
      </a>
    </div>

    <div class="product-info">
      <h2>Product Name</h2>
      <p>Product description</p>

      <div class="product-price">
        <span>$ 1200</span>

      </div> 
      
      <div class="product-seller">
      </div>
     </div>
  </div>

  <div class="product-item">
    <div class="product-image">
      <a href="#">
      <img src="IMG/pic3.jpg" alt="Product Image">
      </a>
    </div>

    <div class="product-info">
      <h2>Product Name</h2>
      <p>Product description</p>

      <div class="product-price">
        <span>$ 999.00</span>  
      </div>
      
      <div class="product-seller">
      </div>
    </div>
  </div>

  <div class="product-item">
    <div class="product-image">
      <a href="#">
      <img src="IMG/pic4.jpg" alt="Product Image">
      </a>
    </div>

    <div class="product-info">
      <h2>Product Name</h2>
      <p>Product description</p>

      <div class="product-price">
        <span>$ 680</span>
 
      </div> 
      
      <div class="product-seller">
      </div>
    </div>
  </div>
  </div>

  <div class="result">
    <p><a href="homepage.php"><button class="Back">Back</button></a></p>
  </div>
  <script>
    function buyNow(productName, productPrice) {
        // Save product details to localStorage
        const product = { name: productName, price: productPrice };
        localStorage.setItem('checkoutProduct', JSON.stringify(product));

        // Redirect to checkout form page
        window.location.href = 'form2.php';
    }
</script>


</body>
</html>
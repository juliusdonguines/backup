<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("connection.php"); // Include database connection

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all shops from the database
$query = "SELECT * FROM shops";
$result = $conn->query($query);

// Store all shops in an array
$shops = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $shops[] = $row; // Add each shop to the array
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="home.css">
</head>
<body>

<header>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            
            <li><a href="#reviews">Reviews</a></li>
            <li><a href="shopcart.php" class="shoppingcart">View Shopping Cart</a></li>
            <li><a href="account.php" class="accountsettings">Account Settings</a></li>
            <li><a href="home.php" class="logout">Logout</a></li>
            <li><a href="map.php" class="map">Map</a></li>
        </ul>
    </nav>
</header>

<!-- Hero Section -->
<section class="hero" id="home">
    <img src="flower.gif" alt="Animated background" class="backgroundgif">
    <h1>Welcome to Euthalia Fancies!</h1>
    <p>Make your experience special and memorable</p>

</section>

<!-- Services Section -->
    <!-- About Section -->
    <section class="about" id="about">
    <div class="container">
        <div class="about-text">
            <h2>About Us</h2>
            <p>Welcome to Euthalia Fancies We specialize in providing Best flowershop for every occasion, from weddings to everyday bouquets. Our team is passionate about bringing beauty and joy through the language of flowers. With years of experience in the floral industry, we ensure that each arrangement is carefully curated with love and attention to detail.</p>
            <p>Our mission is to create memorable experiences for our customers by offering Best floweshops that gives exceptional customer service. Whether you're celebrating a special event or just brightening someone's day, we’re here to help you express your emotions with flowers.</p>
        </div>
        <div class="about-image">
            <img src="euthaliaremove.png" alt="Flower Shop">
        </div>
    </div>
</section>


<div class="services-grid">
    <?php if (!empty($shops)): ?>
        <?php foreach ($shops as $index => $shop): ?>
            <div class="service-item">
                <img src="<?php echo htmlspecialchars($shop['profile_pic'] ?: 'IMG/default-shop.jpg'); ?>" 
                     alt="Shop Image" width="100" height="100">
                <h3>Shop <?php echo $index + 1; ?>: <?php echo htmlspecialchars($shop['shop_name']); ?></h3>
                <p>Email: <?php echo htmlspecialchars($shop['shop_email']); ?></p>
                <p>Address: <?php echo htmlspecialchars($shop['shop_address']); ?></p>
                <p>Phone: <?php echo htmlspecialchars($shop['shop_phone']); ?></p>
                <a href="<?php echo $index === 0 ? 'cart.php' : 'cart' . ($index + 1) . '.php'; ?>?shop_id=<?php echo $shop['id']; ?>">
                    View Shop
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No shops available at the moment. Please check back later!</p>
    <?php endif; ?>
</div>




        

    </div>

    <?php
if (isset($_POST['submit_review'])) {
    $review_text = $_POST['review_text'];
    $customer_name = $_POST['customer_name'];
    $event_type = $_POST['event_type'];
    $customer_photo = ''; // Default value for photo

    // Handle file upload for customer photo
    if (isset($_FILES['customer_photo']) && $_FILES['customer_photo']['error'] == 0) {
        $file_tmp = $_FILES['customer_photo']['tmp_name'];
        $file_name = $_FILES['customer_photo']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = "IMG/"; // Directory where images will be stored
            $customer_photo = uniqid() . "." . $file_ext;
            move_uploaded_file($file_tmp, $upload_dir . $customer_photo);
        }
    }

    // Insert the review into the database
    include('connection.php');
    $stmt = $conn->prepare("INSERT INTO reviews (review_text, customer_name, event_type, customer_photo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $review_text, $customer_name, $event_type, $customer_photo);
    
    if ($stmt->execute()) {
        echo "<p>Your review has been submitted successfully!</p>";
    } else {
        echo "<p>Error submitting your review. Please try again later.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>


<section class="reviews" id="reviews">
    <div class="container">
        <h2>What Our Customers Are Saying</h2>
        <p>Read some of the reviews from our happy customers who loved our floral services. We value customer satisfaction and strive to make every experience special.</p>

        <!-- Add Review Button -->
        <button class="add-review-btn" id="add-review-btn">Add Review</button>

        <!-- Add Review Form (Initially Hidden) -->
        <div id="add-review-form" class="add-review-form" style="display: none;">
            <form action="homepage.php" method="POST" enctype="multipart/form-data">
                <label for="review_text">Review:</label>
                <textarea name="review_text" id="review_text" required></textarea>

                <label for="customer_name">Your Name:</label>
                <input type="text" name="customer_name" id="customer_name" required>

                <label for="event_type">Rate:</label>
                <input type="text" name="event_type" id="event_type" required>

                <label for="customer_photo">Your Photo (optional):</label>
                <input type="file" name="customer_photo" id="customer_photo" accept="image/*">

                <button type="submit" name="submit_review">Submit Review</button>
            </form>
        </div>


        
        <div class="reviews-grid">
            <?php
            // Fetch reviews from the database
            include('connection.php');
            $sql = "SELECT * FROM reviews ORDER BY created_at DESC"; // Query to get reviews
            $result = $conn->query($sql);

            // Check if there are reviews
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="review-item">';
                    echo '    <div class="review-content">';
                    echo '        <p>"' . htmlspecialchars($row['review_text']) . '"</p>';
                    echo '    </div>';
                    echo '    <div class="reviewer">';
                    echo '        <img src="IMG/' . htmlspecialchars($row['customer_photo']) . '" alt="' . htmlspecialchars($row['customer_name']) . '">';
                    echo '        <div>';
                    echo '            <h4>' . htmlspecialchars($row['customer_name']) . '</h4>';
                    echo '            <p>' . htmlspecialchars($row['event_type']) . '</p>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No reviews available at the moment. Please check back later!</p>';
            }
            ?>
        </div>
    </div>
</section>

<script>
    // Show/Hide the review form when the "Add Review" button is clicked
    document.getElementById('add-review-btn').addEventListener('click', function() {
        var form = document.getElementById('add-review-form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
</script>


<?php
// Close the database connection
$conn->close();
?>


</body>
</html>

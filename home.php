<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();   
}
include ("connection.php");

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
    <!-- Navigation Bar --><!-- Navigation Bar with Settings Icon --><!-- Navigation Bar with Settings Icon -->
<header>
    <nav class="navbar">
        
    <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            
            <li><a href="#reviews">Reviews</a></li>
            <li><a href="login.php" class="login"><span class="text">Login</span></a></li>
            <li><a href="map1.php" class="map" onclick="map()"><span class="text">Maps</span></a></li>
        </ul>

        <!-- Search and Settings Icons -->
        <div class="nav-icons">
            <input type="text" id="search-bar" class="search-bar" placeholder="Search...">
            
            <!-- Settings Icon -->
            <div class="settings-icon" id="settings-icon">
                <img src="IMG/bxs-user (1).svg">
            </div>

            <!-- Settings Dropdown Menu (hidden by default) -->
            <div id="settings-menu" class="settings-menu">
                <h3>Settings</h3>
                <ul>
                  <a href="setting.html" class="account">
                 <span class="text">Account Settings</span>
                 </a>
                    
                </ul>
            </div>
        </div>
    </nav>
</header>



    <!-- Hero Section -->
    <section class="hero" id="home">
    <img src="flower.gif" alt="Animated background" class="backgroundgif">
    <h1>Welcome to Euthalia Fancies!</h1>
    <p>Make your experience special and memorable</p>

</section>
    
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

<!-- Services Section -->
        <div class="services-grid">
            <!-- Flower Shop 1 -->
            <div class="service-item">
                <img src="euthaliaremove.png" alt="Flower Shop 1">
                <h3>Flower Shop 1</h3>
                <p>Offering a variety of fresh flowers for all occasions. Specializing in wedding bouquets and corporate events.</p>
                <a href="store.php" >View Shop</a>
            </div>

            <!-- Flower Shop 2 -->
            <div class="service-item">
                <img src="threeblooms.jpg" alt="Flower Shop 2">
                <h3>Flower Shop 2</h3>
                <p>Beautiful flower arrangements for birthdays, anniversaries, and home decor. Delivery services available.</p>
                <a href="store2.php" >View Shop</a>
            </div>

            <!-- Flower Shop 3 -->
            <div class="service-item">
                <img src="welflowershop.jpg" alt="Flower Shop 3">
                <h3>Flower Shop 3</h3>
                <p>Expert florists providing custom arrangements and floral gifts. We focus on personalized service and quality.</p>
                <a href="store3.php" >View Shop</a>
            </div>

            <!-- Flower Shop 4 -->
            <div class="service-item">
                <img src="download.jpg" alt="Flower Shop 4">
                <h3>Flower Shop 4</h3>
                <p>Luxury floral services for events, weddings, and corporate functions. We offer bespoke designs to suit any occasion.</p>
                <a href="store4.php" >View Shop</a>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="reviews" id="reviews">
    <div class="container">
        <h2>What Our Customers Are Saying</h2>
        <p>Read some of the reviews from our happy customers who loved our floral services. We value customer satisfaction and strive to make every experience special.</p>

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
    <footer>
        <p>&copy; 2024 Euthalia Fancies. All Rights Reserved.</p>
    </footer>
    
    <script src="home.js"></script>
</body>
</html>
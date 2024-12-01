<?php
session_start();

// Check if order details are available
if (!isset($_SESSION['orderDetails'])) {
    echo "No order details found. Please complete the checkout process.";
    exit();
}

// Retrieve order details from session
$orderDetails = $_SESSION['orderDetails'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="order-details-container">
        <h1>Thank You for Your Order!</h1>
        
        <div class="order-details">
            <p><strong>Recipient Name:</strong> <?php echo htmlspecialchars($orderDetails['recipientName']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($orderDetails['address'] . ', ' . $orderDetails['barangay'] . ', ' . $orderDetails['city'] . ', ' . $orderDetails['province']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($orderDetails['phoneNumber']); ?></p>
            <p><strong>Instructions:</strong> <?php echo htmlspecialchars($orderDetails['instructions']); ?></p>
        </div>

        <h2>Order Summary</h2>

        <h2>Delivery Information</h2>
        <div class="delivery-info">
            <p><strong>Estimated Delivery Time:</strong> <?php echo htmlspecialchars($orderDetails['deliveryTime']); ?></p>
            <p><strong>Delivery Driver:</strong> <?php echo htmlspecialchars($orderDetails['driverName']); ?></p>
            <p><strong>Driver Contact:</strong> <?php echo htmlspecialchars($orderDetails['driverContact']); ?></p>
        </div>

        <!-- Cancel Order Button -->
        <div class="buttons">
            <a href="cart.php" class="button">Back to Cart</a>
            <button class="cancel-button" onclick="cancelOrder()">Cancel Order</button>
        </div>
    </div>

    <script>
        function cancelOrder() {
            // Clear the order details from the session
            <?php
            // Clear session data for the order
            unset($_SESSION['orderDetails']);
            ?>
            // Redirect to a cancellation confirmation page or back to the home page
            window.location.href = 'home.php';  // Change this to wherever you want to redirect
        }
    </script>
</body>
</html>

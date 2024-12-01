<?php
session_start(); // Start the session to access order details

// Check if order details exist in the session
if (!isset($_SESSION['orderDetails'])) {
    echo "No order details found. Please complete the checkout process.";
    exit();
}

// Retrieve order details from the session
$orderDetails = $_SESSION['orderDetails'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="order_list.css">
</head>
<body>
    <div class="order-container">
        <h1 class="order-title">Order Details</h1>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Recipient Name</th>
                    <th>Product Name</th>
                    <th>Shipping Address</th>
                    <th>Phone Number</th>
                    <th>Special Instructions</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($orderDetails['recipientName']); ?></td>
                    <td><?php echo htmlspecialchars($orderDetails['productName']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($orderDetails['address']) . ', ' . htmlspecialchars($orderDetails['barangay']) . ', ' . htmlspecialchars($orderDetails['city']) . ', ' . htmlspecialchars($orderDetails['province']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($orderDetails['phoneNumber']); ?></td>
                    <td><?php echo htmlspecialchars($orderDetails['instructions']); ?></td>
                    <td>P <?php echo number_format($orderDetails['totalPrice'], 2); ?></td>
                     <td><?php echo htmlspecialchars($orderDetails['orderDate'] ?? 'Today'); ?></td>
                </tr>
            </tbody>
        </table>
        <div class="button-container">
            <a href="cart.php"><button class="Back">Back</button></a>
        </div>
    </div>
</body>
</html>
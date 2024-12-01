<?php
session_start();
include('connection.php'); // Include database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST request
    $recipientName = $_POST['recipientName'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $phoneNumber = $_POST['phoneNumber'];
    $instructions = $_POST['instructions'];
    $productName = "Sample Product"; // Example, replace with actual data
    $subtotal = 150.00; // Replace with actual product price
    $shipping = 50.00;
    $totalPrice = $subtotal + $shipping;
    $deliveryTime = "30-45 minutes"; // Example, replace with dynamic data
    $driverName = "Brian"; // Example, replace with dynamic data
    $driverContact = "+1234567890"; // Example, replace with dynamic data

    // Prepare SQL query to insert data into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (recipientName, address, barangay, city, province, phoneNumber, instructions, productName, subtotal, shipping, totalPrice, deliveryTime, driverName, driverContact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssdddsds", $recipientName, $address, $barangay, $city, $province, $phoneNumber, $instructions, $productName, $subtotal, $shipping, $totalPrice, $deliveryTime, $driverName, $driverContact);

    // Execute the statement
    if ($stmt->execute()) {
        // Save order details to the session
        $_SESSION['orderDetails'] = [
            'recipientName' => $recipientName,
            'address' => $address,
            'barangay' => $barangay,
            'city' => $city,
            'province' => $province,
            'phoneNumber' => $phoneNumber,
            'instructions' => $instructions,
            'productName' => $productName,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'totalPrice' => $totalPrice,
            'deliveryTime' => $deliveryTime,
            'driverName' => $driverName,
            'driverContact' => $driverContact
        ];
        
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <link rel="stylesheet" href="form.css">
  <style>
    /* Reset some default styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .order-details-container {
        width: 80%;
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #4CAF50;
    }

    h2 {
        margin-top: 20px;
        color: #333;
    }

    .order-details,
    .order-summary,
    .delivery-info {
        margin-bottom: 20px;
    }

    .order-details p,
    .order-summary p,
    .delivery-info p {
        font-size: 16px;
        line-height: 1.6;
    }

    .order-summary p span,
    .delivery-info p span {
        font-weight: bold;
    }

    .buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .button {
        text-decoration: none;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #45a049;
    }

    .cancel-button {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #f44336;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .cancel-button:hover {
        background-color: #e53935;
    }
  </style>
</head>
<body>
    <div class="order-details-container">
        <h1>Thank You for Your Order!</h1>
        <h2>Prepare for exact Amount!</h2>
        
        <?php
        // Fetch order details from session
        if (isset($_SESSION['orderDetails'])) {
            $orderDetails = $_SESSION['orderDetails'];
        ?>

        <div class="order-details">
            <p><strong>Recipient Name:</strong> <?php echo htmlspecialchars($orderDetails['recipientName']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($orderDetails['address'] . ', ' . $orderDetails['barangay'] . ', ' . $orderDetails['city'] . ', ' . $orderDetails['province']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($orderDetails['phoneNumber']); ?></p>
            <p><strong>Instructions:</strong> <?php echo htmlspecialchars($orderDetails['instructions']); ?></p>
        </div>

        <h2>Delivery Information</h2>
        <div class="delivery-info">
            <p><strong>Estimated Delivery Time:</strong> <?php echo htmlspecialchars($orderDetails['deliveryTime']); ?></p>
            <p><strong>Delivery Driver:</strong> <?php echo htmlspecialchars($orderDetails['driverName']); ?></p>
            <p><strong>Driver Contact:</strong> <?php echo htmlspecialchars($orderDetails['driverContact']); ?></p>
        </div>

        <div class="buttons">
            <a href="homepage.php" class="button">Back to Homepage</a>
            <button class="cancel-button" onclick="window.history.back();">Cancel Order</button>
        </div>

        <?php
        } else {
            echo "<p>No order details found.</p>";
        }
        ?>
    </div>
</body>
</html>

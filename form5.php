<?php
// Check if the necessary query parameters are set
if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['image'])) {
    // Retrieve the product data from the query string
    $product_name = htmlspecialchars($_GET['name']);
    $product_price = $_GET['price'];
    $product_image = htmlspecialchars($_GET['image']);
} else {
    // Default values or error handling if the parameters are missing
    $product_name = 'Unknown Product';
    $product_price = 0.00;
    $product_image = 'default.jpg'; // Fallback image
}

// Define shipping fee
$shipping_fee = 50.00;
$total_price = $product_price + $shipping_fee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <link rel="stylesheet" href="form.css">
    <style>
        /* (Your existing CSS styles) */
    </style>
</head>
<body>

<div class="checkout-wrapper">
    <div class="checkout-form">
        <h2>CHECKOUT FORM</h2>

        <div class="order-summary">
            <!-- Display the product image, name, and price dynamically -->
            <img src="<?php echo $product_image; ?>" alt="Product Image" style="width: 300px; height: auto;" />
            <p><strong>Product:</strong> <?php echo $product_name; ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product_price, 2); ?></p>
            <p>Shipping: <span>$<?php echo number_format($shipping_fee, 2); ?></span></p>
            
            <!-- Total Price -->
            <p><strong>Total:</strong> <span>$<?php echo number_format($total_price, 2); ?></span></p>

            <form id="checkoutForm" action="notif.php" method="post" onsubmit="return handlePlaceOrder(event)">
                <label for="recipientName">Recipient Name</label>
                <input type="text" id="recipientName" name="recipientName" required placeholder="Enter recipient name">

                <label for="address">Address</label>
                <input type="text" id="address" name="address" required placeholder="Enter address">

                <label for="barangay">Barangay</label>
                <input type="text" id="barangay" name="barangay" required placeholder="Enter barangay">

                <div class="row">
                    <div>
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" required placeholder="Enter city">
                    </div>
                    <div>
                        <label for="province">Province</label>
                        <input type="text" id="province" name="province" required placeholder="Enter province">
                    </div>
                </div>

                <label for="phoneNumber">Phone Number</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="Enter phone number">

                <label for="instructions">Special Instructions</label>
                <input type="text" id="instructions" name="instructions" placeholder="Enter any special instructions">

                <!-- Cash on Delivery section -->
                <div class="cash-on-delivery">
                    <div class="icon"></div>
                    <span>Cash on Delivery</span>
                </div>

                <div class="terms">
                    <input type="checkbox" id="agree" onchange="togglePlaceOrderButton()">
                    <label for="agree">I agree to the terms and conditions.</label>
                </div>

                <!-- Buttons -->
                <div class="buttons">
                    <a href="cart5.php" class="button">Back</a>
                    <button type="submit" id="placeOrderButton" disabled>Place Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to toggle the "Place Order" button based on terms agreement
    function togglePlaceOrderButton() {
        const checkbox = document.getElementById('agree');
        const placeOrderButton = document.getElementById('placeOrderButton');
        placeOrderButton.disabled = !checkbox.checked;
    }

    // This is the function that is triggered on form submission
    function handlePlaceOrder(event) {
        // Prevent default form submission to process data first
        event.preventDefault(); // Prevent form submission initially

        // Additional data you want to store before submitting the form
        const deliveryTime = "30-45 minutes";
        const driverName = "Brian";
        const driverContact = "+1234567890";

        // Store this information in sessionStorage
        sessionStorage.setItem('deliveryTime', deliveryTime);
        sessionStorage.setItem('driverName', driverName);
        sessionStorage.setItem('driverContact', driverContact);

        // After storing the data, submit the form
        document.getElementById('checkoutForm').submit(); // Submit the form programmatically
    }
</script>

</body>
</html>

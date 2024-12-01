<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="checkout-wrapper">
        <div class="checkout-form">
            <h2>CHECKOUT FORM</h2>
            <div class="order-summary">
                <img src="https://via.placeholder.com/150" alt="Product Image">
                <div class="summary-details">
                    <p>Product Name</p>
                    <p>Subtotal: <span>P 150.00</span></p>
                    <p>Shipping: <span>P 50.00</span></p>
                    <p>Total: <span>P 200.00</span></p>
                </div>
            </div>

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
                    <a href="cart2.php" class="button">Back</a>
                    <button type="submit" id="placeOrderButton" disabled>Place Order</button>
                </div>
            </form>
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

        // You can also pre-populate the order summary using JavaScript if needed
        document.addEventListener('DOMContentLoaded', () => {
            const product = JSON.parse(localStorage.getItem('checkoutProduct')); // Assume you stored product data earlier

            if (product) {
                document.querySelector('.order-summary img').src = product.image;
                document.querySelector('.order-summary img').alt = product.name;
                document.querySelector('.order-summary p:first-child').textContent = product.name;
                document.querySelector('.order-summary p:nth-child(2) span').textContent = `P ${product.price.toFixed(2)}`;
                document.querySelector('.order-summary p:nth-child(4) span').textContent = `P ${(product.price + 50).toFixed(2)}`;
            }
        });
    </script>
</body>
</html>

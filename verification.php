<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Form</title>
    <link rel="stylesheet" href="verification.css">
</head>
<body>

    <!-- Verification Notification -->
    <div id="verification-notification" class="notification">
        <span>Check your email for verification</span>
        <button class="close-btn" onclick="closeNotification()">×</button>
    </div>

    <!-- Verification Form -->
    <div class="verification-container">
    <form id="shop-form" action="shop1.php" method="POST" enctype="multipart/form-data">
        <h2>Enter Verification Code</h2>
        <form id="verification-form" action="submit_verification.php" method="POST">
            <label for="verification-code">Verification Code:</label>
            <input type="text" id="verification-code" name="verification-code" placeholder="Enter the code" required>
            
            <button type="shop1.php" class="submit-btn">Submit</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>

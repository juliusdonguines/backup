<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="signup-container">
        <div class="logo">
            <img src="IMG/Flower shop logo.png" alt="Logo">
        </div>
        <form class="signup-form" action="create_account.php" method="POST" onsubmit="return validatePasswords(event)">
            <input type="text" name="lastname" placeholder="Lastname" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="firstname" placeholder="Firstname" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="middlename" placeholder="Middlename" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="date" name="birthday" required>
            <input type="password" id="confirm-password" placeholder="Re-enter password" required>
            <p class="verification-text">Please check your email for a verification code</p>
            <div class="verification-section">
                <input type="text" name="verification_code" placeholder="Code" required>
                <button type="button" class="resend-btn">Send code</button>
            </div>
            <button type="button" class="resend-btn">Resend code</button>
            <p id="password-error" class="error-message"></p>
            <button type="submit" class="signup-btn">SIGN UP</button>
        </form>
        <div class="button-container">
            <a href="login.php"><button class="Back">Back to LogIn</button></a>
        </div>
    </div>
    
  <script src="register.js"></script>
</body>
</html>

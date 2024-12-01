


<?php
// Start session
session_start();

// Include the database connection
include('connection.php'); // Ensure this file sets up the $conn variable
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username and password are not empty
    if (!empty($username) && !empty($password)) {
        // Prepare and execute query
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;

                // Redirect to homepage
                header("Location: homepage.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    } else {
        $error = "Please fill in both fields.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="main-container">
        <div class="login-form-wrapper">
            <h1>Login</h1>

            <!-- Login Form -->
            <form action="login.php" method="POST" class="login-form">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="login-btn">Login</button>
            </form>

            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
            
        </div>
    </div>
</body>
</html>




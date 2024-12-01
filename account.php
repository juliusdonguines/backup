<?php
// Start session
session_start();

// Database connection
include("connection.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, firstname, lastname, middlename, birthday, password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

$stmt->close();

// Handle form submission to update user details or change password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update general user details
    if (isset($_POST['update_info'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $middlename = trim($_POST['middlename']);
        $birthday = $_POST['birthday'];

        // Prepare the update query
        $update_sql = "UPDATE users SET username = ?, email = ?, firstname = ?, lastname = ?, middlename = ?, birthday = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssssi", $username, $email, $firstname, $lastname, $middlename, $birthday, $user_id);

        if ($update_stmt->execute()) {
            $success_message = "Your information has been updated successfully!";
        } else {
            $error_message = "There was an error updating your information.";
        }

        $update_stmt->close();
    }

    // Change password
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Verify current password
        if (password_verify($current_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Prepare the update password query
                $update_password_sql = "UPDATE users SET password = ? WHERE id = ?";
                $update_password_stmt = $conn->prepare($update_password_sql);
                $update_password_stmt->bind_param("si", $hashed_new_password, $user_id);

                if ($update_password_stmt->execute()) {
                    $password_success_message = "Your password has been updated successfully!";
                } else {
                    $password_error_message = "There was an error updating your password.";
                }

                $update_password_stmt->close();
            } else {
                $password_error_message = "The new password and confirmation password do not match.";
            }
        } else {
            $password_error_message = "The current password is incorrect.";
        }
    }
}

$conn->close();
?>
<style>
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f8fa;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* Container to Center Content */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

.box {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    text-align: center;
}

/* Headings */
h1 {
    font-size: 26px;
    color: #4a90e2;
    margin-bottom: 20px;
}

h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 10px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-size: 14px;
    font-weight: bold;
    text-align: left;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"] {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
    transition: 0.2s;
}

input:focus {
    border-color: #4a90e2;
    outline: none;
}

/* Button Styles */
button {
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.2s;
}

button[type="submit"],
button[type="button"] {
    background-color: #4a90e2;
    color: white;
    font-weight: bold;
}

button[type="submit"]:hover,
button[type="button"]:hover {
    background-color: #357ab7;
}

/* Add margin around the Login as seller button */
button[type="button"] {
    margin-top: 20px; /* Adds space above the button */
    margin-bottom: 20px; /* Adds space below the button */
    padding: 12px 20px; /* Adjust padding if necessary */
}


/* Links */
a {
    color: #4a90e2;
    font-size: 14px;
    text-decoration: none;
}

a:hover {
    color: #357ab7;
}

/* Message Styles */
.message {
    margin: 10px 0;
    font-size: 14px;
    font-weight: bold;
}

.message.success {
    color: green;
}

.message.error {
    color: red;
}

/* Back to Homepage */
.back-to-homepage {
    margin-top: 20px;
}
/* Logo Section */
.logo {
    padding-left: 200px; /* Adds space to the left, adjust the value as needed */
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>

<div class="container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="euthaliaremove.png" alt="Logo" class="logo-img">
        </div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
</head>
<body>
    <div class="container">
        <div class="box">
            <!-- Login as Seller Button -->
           

            <!-- User Information Update Form -->
            <h3>Update Your Information</h3>
            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="account.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>

                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

                <label for="middlename">Middle Name:</label>
                <input type="text" name="middlename" id="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>">

                <label for="birthday">Birthday:</label>
                <input type="date" name="birthday" id="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required>

                <button type="submit" name="update_info">Update Information</button>
            </form>

            <!-- Password Change Form -->
            <h3>Change Your Password</h3>
            <?php if (isset($password_success_message)): ?>
                <p style="color: green;"><?php echo $password_success_message; ?></p>
            <?php elseif (isset($password_error_message)): ?>
                <p style="color: red;"><?php echo $password_error_message; ?></p>
            <?php endif; ?>

            <form action="account.php" method="POST">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit" name="change_password">Change Password</button>
            </form>
                
            <a href="terms_condition.php">
                <button type="button">Login in as seller</button>
            </a>

            <div class="back-to-homepage">
                <a href="homepage.php">Back to Homepage</a>
            </div>
        </div>
    </div>
</body>
</html>

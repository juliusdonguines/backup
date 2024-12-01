<?php
// Start the session
session_start();

include('connection.php'); // Include your database connection file


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = sanitizeInput($_POST['lastname']);
    $username = sanitizeInput($_POST['username']);
    $firstname = sanitizeInput($_POST['firstname']);
    $email = sanitizeInput($_POST['email']);
    $middlename = sanitizeInput($_POST['middlename']);
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];
    $verification_code = sanitizeInput($_POST['verification_code']);

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user data into the database
    $sql = "INSERT INTO users (lastname, username, firstname, email, middlename, password, birthday, verification_code)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $lastname, $username, $firstname, $email, $middlename, $hashedPassword, $birthday, $verification_code);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

<?php
// Start the session
session_start();

include("connection.php");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables to prevent undefined index warnings
$shop_name = $shop_email = $shop_address = $shop_phone = $profile_pic = "";

// If the form is submitted, handle the shop creation and file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use isset() to check if the keys are set before accessing
    $shop_name = isset($_POST['shop_name']) ? trim($_POST['shop_name']) : '';
    $shop_email = isset($_POST['shop_email']) ? trim($_POST['shop_email']) : '';
    $shop_address = isset($_POST['shop_address']) ? trim($_POST['shop_address']) : '';
    $shop_phone = isset($_POST['shop_phone']) ? trim($_POST['shop_phone']) : '';
    $user_id = $_SESSION['user_id'];  // Assuming user ID is stored in session

    // Handle Profile Picture Upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        // Get the file details
        $file_tmp = $_FILES['profile_pic']['tmp_name'];
        $file_name = $_FILES['profile_pic']['name'];
        $file_size = $_FILES['profile_pic']['size'];
        $file_type = $_FILES['profile_pic']['type'];

        // Get the file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Allowed file types (e.g., jpg, jpeg, png, gif)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file type is allowed
        if (in_array($file_ext, $allowed_ext)) {
            // Check if the file is too large (limit size to 2MB)
            if ($file_size <= 2 * 1024 * 1024) {
                // Define the upload directory and file path
                $upload_dir = "uploads/";
                $file_path = $upload_dir . uniqid() . "." . $file_ext;

                // Move the file to the server
                if (move_uploaded_file($file_tmp, $file_path)) {
                    // Save the image path in the database
                    $profile_pic = $file_path;
                } else {
                    $error_message = "There was an error uploading the file.";
                }
            } else {
                $error_message = "The file is too large. Please upload a file smaller than 2MB.";
            }
        } else {
            $error_message = "Only image files (JPG, JPEG, PNG, GIF) are allowed.";
        }
    }

    // Validate email format
    if (!filter_var($shop_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Insert shop details into the shops table
        $stmt = $conn->prepare("INSERT INTO shops (user_id, shop_name, shop_email, shop_address, shop_phone, profile_pic) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $shop_name, $shop_email, $shop_address, $shop_phone, $profile_pic);

        if ($stmt->execute()) {
            $_SESSION['shop_name'] = $shop_name; // Save the shop name in session
            $success_message = "Welcome to " . htmlspecialchars($shop_name) . "!";
            
            // Redirect the user to homepage.php with a success notification
            echo "<script>
                alert('Shop Created Successfully!');
                window.location.href = 'homepage.php';
            </script>";
            exit();
        } else {
            $error_message = "There was an error creating your shop. Please try again.";
        }

        $stmt->close();
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
    background-color: #f9f9f9;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
}

/* Container for the form */
.container {
    background-color: #fff;
    width: 100%;
    max-width: 600px;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    color: #5d5dff;
    font-size: 24px;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    text-align: left;
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 5px;
}

input, textarea, button {
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 100%;
}

textarea {
    resize: none;
    height: 100px;
}

input[type="file"] {
    padding: 6px;
}

/* Button styling */
button {
    background-color: #5d5dff;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #4c4ce7;
}

/* Success/Error Messages */
.message {
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
}

.success {
    color: #28a745;
}

.error {
    color: #dc3545;
}

/* Link Back to Homepage */
a {
    color: #5d5dff;
    font-size: 14px;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    .container {
        padding: 20px;
    }
    h1 {
        font-size: 20px;
    }
}
/* Logo Section */
.logo {
    padding-left: 50px; /* Adds space to the left, adjust the value as needed */
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>

<div class="logo">
            <img src="euthaliaremove.png" alt="Logo" class="logo-img">
        </div>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Shop</title>
</head>
<body>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="seller.php" method="POST" enctype="multipart/form-data">
        <label for="shop_name">Shop Name:</label>
        <input type="text" name="shop_name" id="shop_name" value="<?php echo htmlspecialchars($shop_name); ?>" required>

        <label for="shop_email">Shop Email:</label>
        <input type="email" name="shop_email" id="shop_email" value="<?php echo htmlspecialchars($shop_email); ?>" required>

        <label for="shop_address">Shop Address:</label>
        <textarea name="shop_address" id="shop_address" required><?php echo htmlspecialchars($shop_address); ?></textarea>

        <label for="shop_phone">Shop Phone Number:</label>
        <input type="text" name="shop_phone" id="shop_phone" value="<?php echo htmlspecialchars($shop_phone); ?>" required>

        <!-- Profile Picture Upload -->
        <label for="profile_pic">Profile Picture (Shop Icon):</label>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>

        <label for="profile_pic">Identity Proof (Upload):</label>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>

        <label for="profile_pic">Business License/Permit (Upload):</label>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>

        <label for="profile_pic">Sales Tax Registration (Upload):</label>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>

        <label for="profile_pic">Valid I.D (Upload):</label>
        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" required>

        <button type="submit">Create Shop</button>

        <p><a href="homepage.php">Back to Homepage</a></p>
    </form>
</body>
</html>

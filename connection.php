<?php
// Database credentials
$servername = "localhost";    // Usually "localhost" if running locally
$username = "root";
$password = "";
$dbname = "shop";

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "";
?>

<?php
// Start session for login system
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration
$host = "localhost";
$username = "root";      // XAMPP default username
$password = "";          // XAMPP default password (empty)
$database = "todo_db";

// Create Connection
$conn = new mysqli($host, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>

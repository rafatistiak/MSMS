<?php
session_start();
require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // In a real app, use password_verify() here

    // Query to check if the user exists
    $sql = "SELECT id, username FROM Admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_username'] = $row['username'];
        
        // Redirect to the medicine inventory
        header("Location: medicine_view.php");
        exit();
    } else {
        // Login failed, send back to login page with an error
        header("Location: login.php?error=1");
        exit();
    }

    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
?>
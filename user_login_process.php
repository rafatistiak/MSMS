<?php
session_start();
require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the user exists
    $sql = "SELECT id, name FROM Users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Set customer session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        
        // Redirect to cart (or homepage)
        header("Location: cart.php");
        exit();
    } else {
        header("Location: user_login.php?error=1");
        exit();
    }

    $conn->close();
} else {
    header("Location: user_login.php");
    exit();
}
?>
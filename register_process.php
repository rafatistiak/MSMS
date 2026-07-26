<?php
require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    
    // In a real production environment, ALWAYS hash passwords using password_hash()
    // We are using plain text here for simplified prototyping
    $password = $conn->real_escape_string($_POST['password']); 

    // Check if the email already exists
    $check_email = "SELECT id FROM Users WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "<h3>Error: An account with this email already exists.</h3>";
        echo "<a href='register.php'>Try again</a>";
    } else {
        // Insert new user
        $sql = "INSERT INTO Users (name, email, phone, address, password) 
                VALUES ('$name', '$email', '$phone', '$address', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<h3>Registration successful!</h3>";
            echo "<a href='user_login.php'>Click here to Login</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
    $conn->close();
} else {
    header("Location: register.php");
    exit();
}
?>
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO Categories (name, description) VALUES ('$name', '$description')";

    if ($conn->query($sql) === TRUE) {
        header("Location: category_view.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
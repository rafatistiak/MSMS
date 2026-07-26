<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST['name']);
    $generic_name = $conn->real_escape_string($_POST['generic_name']);
    $manufacturer = $conn->real_escape_string($_POST['manufacturer']);
    $price = $conn->real_escape_string($_POST['price']);
    $requires_prescription = $conn->real_escape_string($_POST['requires_prescription']);
    
    // Handle the category (If left empty, insert as NULL in SQL)
    $category_id = !empty($_POST['category_id']) ? "'" . $conn->real_escape_string($_POST['category_id']) . "'" : "NULL";

    $sql = "INSERT INTO Medicines (name, generic_name, manufacturer, price, requires_prescription, category_id) 
            VALUES ('$name', '$generic_name', '$manufacturer', '$price', '$requires_prescription', $category_id)";

    if ($conn->query($sql) === TRUE) {
        header("Location: medicine_view.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: medicine_add.php");
    exit();
}
?>
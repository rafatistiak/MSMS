<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $generic_name = $conn->real_escape_string($_POST['generic_name']);
    $manufacturer = $conn->real_escape_string($_POST['manufacturer']);
    $price = $conn->real_escape_string($_POST['price']);
    $requires_prescription = $conn->real_escape_string($_POST['requires_prescription']);
    
    // Handle the category (If left empty, insert as NULL in SQL)
    $category_id = !empty($_POST['category_id']) ? "'" . $conn->real_escape_string($_POST['category_id']) . "'" : "NULL";

    $sql = "UPDATE Medicines SET 
            name = '$name', 
            generic_name = '$generic_name', 
            manufacturer = '$manufacturer', 
            price = '$price', 
            requires_prescription = '$requires_prescription',
            category_id = $category_id
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: medicine_view.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: medicine_view.php");
    exit();
}
?>
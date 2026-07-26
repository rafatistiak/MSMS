<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    // Optional: You could update Medicines to set category_id to NULL before deleting the category
    $conn->query("UPDATE Medicines SET category_id = NULL WHERE category_id = '$id'");
    
    $sql = "DELETE FROM Categories WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: category_view.php");
        exit();
    }
}
?>
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $new_status = $conn->real_escape_string($_POST['new_status']);

    $sql = "UPDATE Orders SET order_status = '$new_status' WHERE id = '$order_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the orders page
        header("Location: order_view.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: order_view.php");
    exit();
}
?>
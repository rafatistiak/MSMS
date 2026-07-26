<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require_once 'includes/connection.php';

// Check if an ID was passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = $conn->real_escape_string($_GET['id']);

    // SQL query to delete the record
    $sql = "DELETE FROM Medicines WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the view page after successful deletion
        header("Location: medicine_view.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: medicine_view.php");
    exit();
}
?>
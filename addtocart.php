<?php
session_start();
require_once 'includes/connection.php';

// Check if an ID was sent from the homepage
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = $conn->real_escape_string($_GET['id']);

    // If the cart doesn't exist in the session yet, create it as an empty array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Fetch the specific medicine's details from the database
    $sql = "SELECT id, name, price, requires_prescription FROM Medicines WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $medicine = $result->fetch_assoc();
        
        // Check if the item is already in the cart to avoid duplicates
        $item_exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                // If it exists, just increase the quantity
                $item['quantity'] += 1;
                $item_exists = true;
                break;
            }
        }

        // If it's a new item, set quantity to 1 and push it into the session array
        if (!$item_exists) {
            $medicine['quantity'] = 1;
            $_SESSION['cart'][] = $medicine;
        }
    }
}

// Send the user to the Cart page to see their items
header("Location: cart.php");
exit();
?>
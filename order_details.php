<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: order_view.php");
    exit();
}

$order_id = $conn->real_escape_string($_GET['id']);

// Fetch order items joined with the medicine details
$sql_items = "SELECT Order_Items.quantity, Order_Items.price, Medicines.name, Medicines.generic_name 
              FROM Order_Items 
              JOIN Medicines ON Order_Items.medicine_id = Medicines.id 
              WHERE Order_Items.order_id = '$order_id'";
              
$result_items = $conn->query($sql_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Order #<?php echo $order_id; ?> Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px; }
        .btn-back { background-color: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; text-align: right; background-color: #e9ecef;}
    </style>
</head>
<body>

    <div class="container">
        <div class="header-bar">
            <h2>Items for Order #<?php echo htmlspecialchars($order_id); ?></h2>
            <a href="order_view.php" class="btn-back">← Back to Orders</a>
        </div>

        <table>
            <tr>
                <th>Medicine Name</th>
                <th>Generic Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php
            $grand_total = 0;
            if ($result_items->num_rows > 0) {
                while($item = $result_items->fetch_assoc()) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $grand_total += $subtotal;
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($item['generic_name']) . "</td>";
                    echo "<td>৳ " . number_format($item['price'], 2) . "</td>";
                    echo "<td>" . $item['quantity'] . "</td>";
                    echo "<td>৳ " . number_format($subtotal, 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No items found for this order.</td></tr>";
            }
            ?>
            
            <tr>
                <td colspan="4" class="total-row">Grand Total:</td>
                <td class="total-row">৳ <?php echo number_format($grand_total, 2); ?></td>
            </tr>
        </table>
    </div>

</body>
</html>
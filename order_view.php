<?php
// START SECURITY CHECK
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
// END SECURITY CHECK

require_once 'includes/connection.php';

// SQL query to fetch orders along with customer details, ordering by newest first
$sql = "SELECT Orders.id, Orders.total_amount, Orders.order_status, Orders.order_date, Orders.prescription_path, 
               Users.name, Users.phone, Users.address 
        FROM Orders 
        JOIN Users ON Orders.user_id = Users.id 
        ORDER BY Orders.id DESC";
        
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Manage Orders</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; background: #333; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 20px; }
        .header-bar a { color: white; text-decoration: none; margin-left: 15px; padding: 5px 10px; background: rgba(255,255,255,0.2); border-radius: 3px; }
        .header-bar a:hover { background: rgba(255,255,255,0.4); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-form { display: flex; align-items: center; gap: 5px; }
        .status-select { padding: 5px; border-radius: 3px; }
        .btn-update { background-color: #28a745; color: white; border: none; padding: 6px 10px; border-radius: 3px; cursor: pointer; }
        .btn-update:hover { background-color: #218838; }
        .btn-view-rx { background-color: #17a2b8; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; }
        .btn-view-items { background-color: #007bff; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 14px; }
        .btn-view-items:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="header-bar">
        <h3>MSMS Admin Panel - Order Management</h3>
        <div>
            <a href="medicine_view.php">Medicine Inventory</a>
            <a href="logout.php" style="background: #dc3545;">Logout</a>
        </div>
    </div>

    <h2>Customer Orders</h2>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Customer Name</th>
            <th>Contact & Address</th>
            <th>Total Amount</th>
            <th>Prescription</th>
            <th>Status</th>
            <th>Update Status</th>
            <th>Actions</th> <!-- NEW HEADER ADDED HERE -->
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>#" . $row["id"] . "</td>";
                echo "<td>" . date('d M Y, h:i A', strtotime($row["order_date"])) . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["phone"]) . "<br><small>" . htmlspecialchars($row["address"]) . "</small></td>";
                echo "<td>৳ " . number_format($row["total_amount"], 2) . "</td>";
                
                // Display prescription link if it exists
                echo "<td>";
                if ($row["prescription_path"]) {
                    echo "<a href='" . htmlspecialchars($row["prescription_path"]) . "' target='_blank' class='btn-view-rx'>View Rx</a>";
                } else {
                    echo "N/A";
                }
                echo "</td>";

                // Highlight the status text based on its value
                $status_color = ($row["order_status"] == 'Pending') ? 'orange' : (($row["order_status"] == 'Approved') ? 'green' : 'red');
                echo "<td style='color: {$status_color}; font-weight: bold;'>" . $row["order_status"] . "</td>";

                // Form to update the order status
                echo "<td>
                        <form class='status-form' action='process_order_status.php' method='POST'>
                            <input type='hidden' name='order_id' value='" . $row["id"] . "'>
                            <select name='new_status' class='status-select'>
                                <option value='Pending' " . ($row["order_status"] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                <option value='Approved' " . ($row["order_status"] == 'Approved' ? 'selected' : '') . ">Approved</option>
                                <option value='Shipped' " . ($row["order_status"] == 'Shipped' ? 'selected' : '') . ">Shipped</option>
                                <option value='Cancelled' " . ($row["order_status"] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                            </select>
                            <button type='submit' class='btn-update'>Update</button>
                        </form>
                      </td>";
                      
                // NEW ACTION BUTTON ADDED HERE
                echo "<td>
                        <a href='order_details.php?id=" . $row["id"] . "' class='btn-view-items'>View Items</a>
                      </td>";
                      
                echo "</tr>";
            }
        } else {
            // Colspan increased to 9 to match the new column
            echo "<tr><td colspan='9'>No orders have been placed yet.</td></tr>"; 
        }
        $conn->close();
        ?>
    </table>

</body>
</html>
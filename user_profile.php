<?php
session_start();

// 1. Force the user to log in if they haven't already
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

require_once 'includes/connection.php';

$user_id = $conn->real_escape_string($_SESSION['user_id']);

// Fetch user details
$sql_user = "SELECT name, email, phone, address FROM Users WHERE id = '$user_id'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

// Fetch order history for this specific user
$sql_orders = "SELECT id, total_amount, order_status, order_date FROM Orders WHERE user_id = '$user_id' ORDER BY id DESC";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - My Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; }
        header { background-color: #28a745; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 15px; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .profile-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px; border-top: 4px solid #007bff; }
        .profile-card h3 { margin-top: 0; color: #333; }
        .info-group { margin-bottom: 10px; }
        .info-group strong { display: inline-block; width: 120px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-logout { background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 15px; }
        .btn-logout:hover { background-color: #c82333; }
    </style>
</head>
<body>

    <header>
        <h2>⚕️ MSMS Pharmacy</h2>
        <div>
            <a href="index.php">Continue Shopping</a>
            <a href="cart.php">My Cart</a>
        </div>
    </header>

    <div class="container">
        
        <!-- User Details Section -->
        <div class="profile-card">
            <h3>Account Details</h3>
            <div class="info-group"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></div>
            <div class="info-group"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
            <div class="info-group"><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></div>
            <div class="info-group"><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></div>
            
            <a href="user_logout.php" class="btn-logout">Logout</a>
        </div>

        <!-- Order History Section -->
        <h3>My Order History</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Date Placed</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>

            <?php
            if ($result_orders->num_rows > 0) {
                while($order = $result_orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>#" . $order["id"] . "</td>";
                    echo "<td>" . date('d M Y, h:i A', strtotime($order["order_date"])) . "</td>";
                    echo "<td>৳ " . number_format($order["total_amount"], 2) . "</td>";
                    
                    // Color code the status for the customer
                    $status_color = ($order["order_status"] == 'Pending') ? 'orange' : (($order["order_status"] == 'Approved' || $order["order_status"] == 'Shipped') ? 'green' : 'red');
                    
                    echo "<td style='color: {$status_color}; font-weight: bold;'>" . $order["order_status"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>You haven't placed any orders yet.</td></tr>";
            }
            $conn->close();
            ?>
        </table>

    </div>

</body>
</html>
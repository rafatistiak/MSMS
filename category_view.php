<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

$sql = "SELECT id, name, description FROM Categories ORDER BY name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Categories</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; background: #333; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 20px; }
        .header-bar a { color: white; text-decoration: none; margin-left: 15px; padding: 5px 10px; background: rgba(255,255,255,0.2); border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-add { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 10px; }
        .btn-delete { background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <div class="header-bar">
        <h3>MSMS Admin Panel - Categories</h3>
        <div>
            <a href="medicine_view.php">Medicine Inventory</a>
            <a href="order_view.php">Orders</a>
            <a href="logout.php" style="background: #dc3545;">Logout</a>
        </div>
    </div>

    <h2>Manage Medicine Categories</h2>
    <a href="category_add.php" class="btn-add">+ Add New Category</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td><strong>" . htmlspecialchars($row["name"]) . "</strong></td>";
                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                echo "<td>
                        <a href='process_category_del.php?id=" . $row["id"] . "' class='btn-delete' onclick=\"return confirm('Delete this category?');\">Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No categories created yet.</td></tr>";
        }
        $conn->close();
        ?>
    </table>

</body>
</html>
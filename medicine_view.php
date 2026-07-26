<?php
// START SECURITY CHECK
session_start();
if (!isset($_SESSION['admin_id'])) {
    // If they aren't logged in, redirect to login page
    header("Location: login.php");
    exit();
}
// END SECURITY CHECK

// Include the database connection
require_once 'includes/connection.php';

// SQL query to fetch medicines, ordering by newest first
$sql = "SELECT id, name, generic_name, manufacturer, price, requires_prescription FROM Medicines ORDER BY id DESC LIMIT 50";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Medicine List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; background: #333; color: white; padding: 10px 20px; border-radius: 5px; margin-bottom: 20px; }
        .header-bar a { color: white; text-decoration: none; background: #dc3545; padding: 5px 15px; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-add { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 10px; }
        .btn-edit { background-color: #ffc107; color: black; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-delete { background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <div class="header-bar">
        <h3>MSMS Admin Panel - Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h3>
        <a href="logout.php">Logout</a>
    </div>

    <h2>Medicine Inventory</h2>
    
    <a href="medicine_add.php" class="btn-add">+ Add New Medicine</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Generic Name</th>
            <th>Manufacturer</th>
            <th>Price (Tk)</th>
            <th>Prescription Required</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["generic_name"]) . "</td>
                        <td>" . htmlspecialchars($row["manufacturer"]) . "</td>
                        <td>" . $row["price"] . "</td>
                        <td>" . $row["requires_prescription"] . "</td>
                        <td>
                            <a href='medicine_edit.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a> 
                            <a href='process_medicine_del.php?id=" . $row["id"] . "' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this medicine?');\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No medicines found in the database.</td></tr>";
        }
        $conn->close();
        ?>
    </table>

</body>
</html>
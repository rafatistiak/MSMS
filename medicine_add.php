<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

// Fetch categories for the dropdown menu
$cat_sql = "SELECT id, name FROM Categories ORDER BY name ASC";
$categories = $conn->query($cat_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Add Medicine</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

    <h2>Add New Medicine</h2>
    
    <div class="form-container">
        <form action="process_medicine_add.php" method="POST">
            
            <div class="form-group">
                <label for="name">Medicine Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="generic_name">Generic Name:</label>
                <input type="text" id="generic_name" name="generic_name" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id">
                    <option value="">-- No Category --</option>
                    <?php
                    if ($categories->num_rows > 0) {
                        while($cat = $categories->fetch_assoc()) {
                            echo "<option value='" . $cat['id'] . "'>" . htmlspecialchars($cat['name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="manufacturer">Manufacturer:</label>
                <input type="text" id="manufacturer" name="manufacturer" required>
            </div>

            <div class="form-group">
                <label for="price">Price (Tk):</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="requires_prescription">Requires Prescription?</label>
                <select id="requires_prescription" name="requires_prescription">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>

            <button type="submit">Save Medicine</button>
        </form>
    </div>
    
    <br>
    <a href="medicine_view.php">Back to Medicine List</a>

</body>
</html>
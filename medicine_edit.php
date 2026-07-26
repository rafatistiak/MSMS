<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/connection.php';

// Check if an ID was passed
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: medicine_view.php");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// Fetch the current data for this medicine
$sql = "SELECT * FROM Medicines WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Medicine not found!";
    exit();
}

$medicine = $result->fetch_assoc();

// Fetch all categories for the dropdown menu
$cat_sql = "SELECT id, name FROM Categories ORDER BY name ASC";
$categories = $conn->query($cat_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Edit Medicine</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #ffc107; color: black; border: none; cursor: pointer; font-weight: bold;}
        button:hover { background-color: #e0a800; }
    </style>
</head>
<body>

    <h2>Edit Medicine</h2>
    
    <div class="form-container">
        <form action="process_medicine_edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">
            
            <div class="form-group">
                <label for="name">Medicine Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($medicine['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="generic_name">Generic Name:</label>
                <input type="text" id="generic_name" name="generic_name" value="<?php echo htmlspecialchars($medicine['generic_name']); ?>" required>
            </div>

            <!-- NEW CATEGORY DROPDOWN -->
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id">
                    <option value="">-- No Category --</option>
                    <?php
                    if ($categories->num_rows > 0) {
                        while($cat = $categories->fetch_assoc()) {
                            // Check if this category matches the medicine's current category
                            $selected = ($medicine['category_id'] == $cat['id']) ? "selected" : "";
                            echo "<option value='" . $cat['id'] . "' $selected>" . htmlspecialchars($cat['name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="manufacturer">Manufacturer:</label>
                <input type="text" id="manufacturer" name="manufacturer" value="<?php echo htmlspecialchars($medicine['manufacturer']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price (Tk):</label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo $medicine['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="requires_prescription">Requires Prescription?</label>
                <select id="requires_prescription" name="requires_prescription">
                    <option value="No" <?php if($medicine['requires_prescription'] == 'No') echo 'selected'; ?>>No</option>
                    <option value="Yes" <?php if($medicine['requires_prescription'] == 'Yes') echo 'selected'; ?>>Yes</option>
                </select>
            </div>

            <button type="submit">Update Medicine</button>
        </form>
    </div>
    
    <br>
    <a href="medicine_view.php">Cancel and go back</a>

</body>
</html>
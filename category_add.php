<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Add Category</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Add New Category</h2>
    <div class="form-container">
        <form action="process_category_add.php" method="POST">
            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description (Optional):</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit">Save Category</button>
        </form>
    </div>
    <br>
    <a href="category_view.php">Back to Categories</a>
</body>
</html>
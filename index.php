<?php
session_start();
// Include the database connection
require_once 'includes/connection.php';

// Check if the user searched for something
$search_query = "";
$sql = "SELECT id, name, generic_name, manufacturer, price, requires_prescription FROM Medicines ORDER BY name ASC LIMIT 20";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    // Search by medicine name or generic name
    $sql = "SELECT id, name, generic_name, manufacturer, price, requires_prescription 
            FROM Medicines 
            WHERE name LIKE '%$search_query%' OR generic_name LIKE '%$search_query%' 
            ORDER BY name ASC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Online Medicine Store</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
        header { background-color: #28a745; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 15px; }
        .container { max-width: 1000px; margin: 20px auto; padding: 0 20px; }
        .search-bar { margin-bottom: 20px; display: flex; }
        .search-bar input { flex: 1; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px 0 0 4px; }
        .search-bar button { padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 0 4px 4px 0; cursor: pointer; }
        .medicine-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .medicine-card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-top: 4px solid #28a745; }
        .medicine-name { font-size: 18px; font-weight: bold; color: #333; margin-bottom: 5px; }
        .medicine-generic { font-size: 13px; color: #666; margin-bottom: 10px; height: 30px; overflow: hidden; }
        .medicine-price { font-size: 16px; font-weight: bold; color: #e83e8c; margin-bottom: 10px; }
        .rx-badge { display: inline-block; background: #dc3545; color: white; font-size: 11px; padding: 2px 6px; border-radius: 3px; margin-bottom: 10px; }
        .btn-cart { display: block; text-align: center; background-color: #ffc107; color: #333; padding: 8px; text-decoration: none; font-weight: bold; border-radius: 4px; }
        .btn-cart:hover { background-color: #e0a800; }
    </style>
</head>
<body>

    <header>
        <h2>⚕️ MSMS Pharmacy</h2>
        <div>
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <!-- If the user is logged in, show Profile link -->
                <a href="user_profile.php" style="background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 4px;">My Profile</a>
            <?php else: ?>
                <!-- If the user is a guest, show Login link -->
                <a href="user_login.php" style="background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 4px;">Login / Register</a>
            <?php endif; ?>
            
            <!-- Link to the admin panel -->
            <a href="login.php" style="background: #333; padding: 5px 10px; border-radius: 4px; margin-left: 20px; font-size: 12px;">Admin Panel</a>
        </div>
    </header>

    <div class="container">
        
        <!-- Search Form -->
        <form class="search-bar" action="index.php" method="GET">
            <input type="text" name="search" placeholder="Search for medicines by name or generic formula..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($search_query)): ?>
            <h3>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h3>
        <?php else: ?>
            <h3>Available Medicines</h3>
        <?php endif; ?>

        <!-- Medicine Grid -->
        <div class="medicine-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='medicine-card'>";
                    echo "<div class='medicine-name'>" . htmlspecialchars($row["name"]) . "</div>";
                    echo "<div class='medicine-generic'>" . htmlspecialchars($row["generic_name"]) . "</div>";
                    
                    if ($row["requires_prescription"] == 'Yes') {
                        echo "<span class='rx-badge'>Rx Required</span>";
                    } else {
                        echo "<span style='display:inline-block; height: 15px; margin-bottom: 10px;'></span>"; // Spacer
                    }

                    echo "<div class='medicine-price'>৳ " . $row["price"] . "</div>";
                    
                    // Button that sends the ID to the cart processing script
                    echo "<a href='addtocart.php?id=" . $row["id"] . "' class='btn-cart'>Add to Cart</a>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>No medicines found matching your criteria.</p>";
            }
            $conn->close();
            ?>
        </div>

    </div>

</body>
</html>
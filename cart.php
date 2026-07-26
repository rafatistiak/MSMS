<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
        header { background-color: #fd0505; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 15px; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border-bottom: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; font-size: 18px; text-align: right; }
        .btn-checkout { display: block; width: 100%; text-align: center; background-color: #007bff; color: white; padding: 12px; text-decoration: none; font-weight: bold; border-radius: 4px; margin-top: 20px; font-size: 18px; }
        .btn-checkout:hover { background-color: #0056b3; }
        .btn-clear { background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 20px; }
        .rx-warning { background-color: #fff3cd; color: #856404; padding: 10px; border-left: 5px solid #ffeeba; margin-bottom: 20px; }
    </style>
</head>
<body>

    <header>
        <h2>⚕️ MSMS Pharmacy</h2>
        <div>
            <a href="index.php">Continue Shopping</a>
        </div>
    </header>

    <div class="container">
        <h2>Your Shopping Cart</h2>

        <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            
            $total_price = 0;
            $needs_prescription = false;

            echo "<table>";
            echo "<tr><th>Medicine</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";

            foreach ($_SESSION['cart'] as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total_price += $subtotal;

                // Check if any item in the cart requires a prescription
                if ($item['requires_prescription'] == 'Yes') {
                    $needs_prescription = true;
                }

                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['name']) . " " . ($item['requires_prescription'] == 'Yes' ? '<span style="color:red; font-size:12px;">(Rx)</span>' : '') . "</td>";
                echo "<td>৳ " . number_format($item['price'], 2) . "</td>";
                echo "<td>" . $item['quantity'] . "</td>";
                echo "<td>৳ " . number_format($subtotal, 2) . "</td>";
                echo "</tr>";
            }

            echo "<tr><td colspan='3' class='total-row'>Grand Total:</td><td class='total-row'>৳ " . number_format($total_price, 2) . "</td></tr>";
            echo "</table>";

            // Show a warning if prescription upload will be needed
            if ($needs_prescription) {
                echo "<div class='rx-warning'><strong>Note:</strong> Your cart contains prescription-only medications. You will be required to upload a valid doctor's prescription during checkout.</div>";
            }

            echo "<a href='checkout.php' class='btn-checkout'>Proceed to Checkout</a>";
            echo "<a href='cart_clear.php' class='btn-clear'>Empty Cart</a>";

        } else {
            echo "<p>Your cart is currently empty.</p>";
            echo "<a href='index.php' style='color: #007bff; text-decoration: none;'>Browse medicines</a>";
        }
        ?>
    </div>

</body>
</html>
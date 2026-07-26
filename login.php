<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f4; }
        .login-box { background: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error { color: red; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2 style="text-align: center;">Admin Login</h2>
        
        <?php
        // Display error message if login fails
        if (isset($_GET['error'])) {
            echo "<div class='error'>Invalid username or password!</div>";
        }
        ?>

        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
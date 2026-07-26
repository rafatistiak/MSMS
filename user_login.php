<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Customer Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 350px; border-top: 4px solid #007bff; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background-color: #0056b3; }
        .error { color: red; margin-bottom: 15px; text-align: center; font-size: 14px; }
        .register-link { text-align: center; margin-top: 15px; font-size: 14px; }
        .register-link a { color: #28a745; text-decoration: none; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Customer Login</h2>
        
        <?php
        if (isset($_GET['error'])) {
            echo "<div class='error'>Invalid email or password!</div>";
        }
        ?>

        <form action="user_login_process.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Sign up here</a>
        </div>
    </div>

</body>
</html>
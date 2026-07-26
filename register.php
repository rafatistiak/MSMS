<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MSMS - Customer Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 400px; border-top: 4px solid #28a745; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input[type="text"], input[type="email"], input[type="password"], textarea { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background-color: #218838; }
        .login-link { text-align: center; margin-top: 15px; font-size: 14px; }
        .login-link a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

    <div class="register-box">
        <h2>Create an Account</h2>
        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="address">Delivery Address:</label>
                <textarea id="address" name="address" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Sign Up</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="user_login.php">Login here</a>
        </div>
    </div>

</body>
</html>
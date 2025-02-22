<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

// Check for signup success message
$signup_success = isset($_GET['signup']) && $_GET['signup'] === 'success';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Commerce App</title>
    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
}

header {
    width: 100%;
    text-align: center;
    padding: 20px 0;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2.5em;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

header a {
    color: #fff;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 600;
    transition: color 0.3s ease;
}

header a:hover {
    color: #4a90e2;
}

form {
    background-color: rgba(255, 255, 255, 0.1);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 300px;
    margin: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    text-align: center;
}

form h2 {
    margin-bottom: 25px;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
}

input[type="email"],
input[type="password"] {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
    box-sizing: border-box;
}

input[type="email"]:focus,
input[type="password"]:focus {
    outline: none;
    border-color: #4a90e2;
}

button[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4a90e2;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #357abd;
}

::placeholder {
    color: rgba(255, 255, 255, 0.7);
}
</style>
   

<script>
    // Display alert if login was successful
    <?php if ($signup_success): ?>
    window.onload = function() {
        alert("Signup successful!");
        // Remove the query parameter from the URL
        history.replaceState(null, '', window.location.pathname);
    };
    <?php endif; ?>
</script>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Login</h2>
        <form method="POST" action="authenticate.php">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="signup.php">Signup here</a>
        </div>
    </div>
</body>
</html>
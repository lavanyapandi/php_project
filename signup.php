<?php
include_once('config.php');
$user_fun = new Userfunction();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        
        $name = $user_fun->htmlvalidation($_POST['name']);
        $email = $user_fun->htmlvalidation($_POST['email']);
        $password = $user_fun->htmlvalidation($_POST['password']);
        
        if (!empty($name) && !empty($email) && !empty($password)) {
            
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $field_val = [
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
            ];
            
            $insert = $user_fun->insert("login_users", $field_val);
            
            if ($insert) {
                // Redirect to login page with success message
                header("Location: login.php?signup=success");
                exit();
            } else {
                $json['status'] = 102;
                $json['msg'] = "Error inserting data";
            }
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - E-Commerce App</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .container h2 {
            margin-bottom: 30px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 2em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #eee;
            font-weight: 600;
        }

        .input-group input {
            width: calc(100% - 22px);
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #4a90e2;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1em;
            font-weight: 600;
        }

        button[type="submit"]:hover {
            background-color: #357abd;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-link {
            margin-top: 20px;
            font-size: 0.9em;
            color: #ccc;
        }

        .login-link a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

    </style>

</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form method="POST">
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your name" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="signup">Signup</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection and Userfunction class
include_once('config.php');
$user_fun = new Userfunction();

// Fetch product counts
$productCounts = $user_fun->getProductCounts();
$CartCounts = $user_fun->getCartCounts();

// Check for login success message
$login_success = isset($_GET['login']) && $_GET['login'] === 'success';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Commerce App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .dashboard-header h1 {
            font-size: 36px;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .dashboard-header p {
            font-size: 18px;
            color: #666;
            font-weight: 400;
        }
        .dashboard-card {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border-radius: 15px;
            padding: 30px;
            margin: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #fff;
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        .dashboard-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .dashboard-card p {
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 20px;
        }
        .btn-custom {
            background: #fff;
            color: #2575fc;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .btn-custom:hover {
            background: #2575fc;
            color: #fff;
        }
        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2575fc;
            font-size: 18px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .logout-link:hover {
            color: #6a11cb;
        }
        .text-center {
            text-align: center;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
    </style>
    <script>
    // Display alert if login was successful
    <?php if ($login_success): ?>
    window.onload = function() {
        alert("Login successful!");
        // Remove the query parameter from the URL
        history.replaceState(null, '', window.location.pathname);
    };
    <?php endif; ?>
</script>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo $_SESSION['user']['email']; ?>!</h1>
            <p>Manage your products and carts efficiently</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Total Products</h3>
                    <p><?php echo $productCounts['total']; ?></p>
                    <a href="index.php" class="btn btn-custom">View Products</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Total Carts</h3>
                    <p><?php echo $CartCounts['totalcart']; ?></p>
                    <a href="cart.php" class="btn btn-custom">View Carts</a>
                </div>
            </div>
        </div>
      
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-custom">Add Product</a>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
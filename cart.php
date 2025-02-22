<?php
include_once('config.php');
$user_fun = new Userfunction();
$counter = 1;

if (isset($_POST['keyword']) && !empty(trim($_POST['keyword']))) {
    $keyword = $user_fun->htmlvalidation($_POST['keyword']);
    $match_field['productname'] = $keyword;
    $match_field['description'] = $keyword;
    $select = $user_fun->search("cart", $match_field, "OR");
} else {
    $select = $user_fun->selectCartWithDetails(); // Use the new function
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart List</title>
    <a href="dashboard.php" class="btn btn-lg btn-primary" style="position: relative;left: 865px;top:42px;">Go To Dashboard</a>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            margin: 50px auto;
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background: #343a40;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="table-container">
        <h2 class="text-center mb-4">Cart List</h2>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php if($select) { foreach($select as $se_data) { ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($se_data['username']); ?></td>
                    <td><?php echo htmlspecialchars($se_data['productname']); ?></td>
                    <td><?php echo htmlspecialchars($se_data['quantity']); ?></td>
                </tr>
                <?php }} else { ?>
                <tr>
                    <td colspan="4"><h4 class="text-danger">No Result Found</h4></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

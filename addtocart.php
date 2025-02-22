<?php
include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_id']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $user_id = $user_fun->htmlvalidation($_POST['user_id']);
        $product_id = $user_fun->htmlvalidation($_POST['product_id']);
        $quantity = $user_fun->htmlvalidation($_POST['quantity']);

        if ((!preg_match('/^[ ]*$/', $user_id)) && (!preg_match('/^[ ]*$/', $product_id)) && (!preg_match('/^[ ]*$/', $quantity))) {
            $insert = $user_fun->addToCart($user_id, $product_id, $quantity);

            if ($insert) {
                $json['status'] = 101;
                $json['msg'] = "Product Successfully Added to Cart";
            } else {
                $json['status'] = 102;
                $json['msg'] = "Product Not Added to Cart";
            }
        } else {
            if (preg_match('/^[ ]*$/', $user_id)) {
                $json['status'] = 103;
                $json['msg'] = "Please Enter User ID";
            }
            if (preg_match('/^[ ]*$/', $product_id)) {
                $json['status'] = 104;
                $json['msg'] = "Please Enter Product ID";
            }
            if (preg_match('/^[ ]*$/', $quantity)) {
                $json['status'] = 105;
                $json['msg'] = "Please Enter Quantity";
            }
        }
    } else {
        $json['status'] = 108;
        $json['msg'] = "Invalid Values Passed";
    }
} else {
    $json['status'] = 109;
    $json['msg'] = "Invalid Method Found";
}

echo json_encode($json);
?>
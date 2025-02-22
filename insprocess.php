<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['productname']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['quantity'])){

		$productname = $user_fun->htmlvalidation($_POST['productname']);
		$description = $user_fun->htmlvalidation($_POST['description']);
		$price = $user_fun->htmlvalidation($_POST['price']);
		$quantity = $user_fun->htmlvalidation($_POST['quantity']);

		if((!preg_match('/^[ ]*$/', $productname)) && (!preg_match('/^[ ]*$/', $description)) && (!preg_match('/^[ ]*$/', $price)) && (!preg_match('/^[ ]*$/', $quantity))){

			$field_val['productname'] = $productname;
			$field_val['description'] = $description;
			$field_val['price'] = $price;
			$field_val['quantity'] = $quantity;

			$insert = $user_fun->insert("products", $field_val);

			if($insert){
				$json['status'] = 101;
				$json['msg'] = "Data Successfully Inserted";
			}
			else{
				$json['status'] = 102;
				$json['msg'] = "Data Not Inserted";
			}

		}
		else{

			if(preg_match('/^[ ]*$/', $productname)){

				$json['status'] = 103;
				$json['msg'] = "Please Enter productname";

			}
			if(preg_match('/^[ ]*$/', $description)){

				$json['status'] = 104;
				$json['msg'] = "Please Enter Description";

			}
			if(preg_match('/^[ ]*$/', $price)){

				$json['status'] = 105;
				$json['msg'] = "Please Enter Price";

			}
			if(preg_match('/^[ ]*$/', $quantity)){

				$json['status'] = 106;
				$json['msg'] = "Please Enter Quantity";

			}
					}

	}
	else{

		$json['status'] = 108;
		$json['msg'] = "Invalid Values Passed";

	}

}
else{

	$json['status'] = 109;
	$json['msg'] = "Invalid Method Found";

}


echo json_encode($json);

?>
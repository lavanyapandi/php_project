<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['productname']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['quantity'])  && isset($_POST['dataval'])){

		$productname = $user_fun->htmlvalidation($_POST['productname']);
		$description = $user_fun->htmlvalidation($_POST['description']);
		$price = $user_fun->htmlvalidation($_POST['price']);
		$quantity = $user_fun->htmlvalidation($_POST['quantity']);
		$update_id = $user_fun->htmlvalidation($_POST['dataval']);

		if((!preg_match('/^[ ]*$/', $productname)) && (!preg_match('/^[ ]*$/', $description)) && (!preg_match('/^[ ]*$/', $price))  && ($quantity != NULL)){

			$condition['p_id'] = $update_id;

			$field_val['productname'] = $productname;
			$field_val['description'] = $description;
			$field_val['price'] = $price;
			$field_val['quantity'] = $quantity;	

			$update = $user_fun->update("products", $field_val, $condition);

			if($update){
				$json['status'] = 101;
				$json['msg'] = "Data Successfully Updated";
			}
			else{
				$json['status'] = 102;
				$json['msg'] = "Data Not Updated";
			}

		}
		else{

			if(preg_match('/^[ ]*$/', $productname)){

				$json['status'] = 103;
				$json['msg'] = "Please Enter productname";

			}
			if(preg_match('/^[ ]*$/', $description)){

				$json['status'] = 104;
				$json['msg'] = "Please Enter description";

			}
			if(preg_match('/^[ ]*$/', $price)){

				$json['status'] = 105;
				$json['msg'] = "Please Select price";

			}
			if(preg_match('/^[ ]*$/', $quantity)){

				$json['status'] = 106;
				$json['msg'] = "Please Enter quantity";

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
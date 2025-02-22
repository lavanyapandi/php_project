<?php

include_once('config.php');
$user_fun = new Userfunction();

$json = array();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isset($_GET['checkid']) && $_GET['checkid'] > 0){

		$update_ch_id = $user_fun->htmlvalidation($_GET['checkid']);

		$condition0['p_id'] = $update_ch_id;
		$select_pre = $user_fun->select_assoc("products", $condition0);

		if($select_pre){

			$json['status'] = 0;
			$json['productname'] = $select_pre['productname'];
			$json['description'] = $select_pre['description'];
			$json['price'] = $select_pre['price'];
			$json['quantity'] = $select_pre['quantity'];
			$json['msg'] = "Success";

		}
		else{

			$json['status'] = 1;
			$json['productname'] = "NULL";
			$json['description'] = "NULL";
			$json['price'] = "NULL";
			$json['quantity'] = "NULL";
			$json['msg'] = "Fail";

		}

	}
	else{
			$json['status'] = 2;
			$json['productname'] = "NULL";
			$json['description'] = "NULL";
			$json['price'] = "NULL";
			$json['quantity'] = "NULL";
			$json['msg'] = "Invalid Values Passed";
	}
}
else{
			$json['status'] = 3;
			$json['productname'] = "NULL";
			$json['description'] = "NULL";
			$json['price'] = "NULL";
			$json['quantity'] = "NULL";
			$json['msg'] = "Invalid Method Found";
}


echo json_encode($json);

?>
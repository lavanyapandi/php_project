<?php 

class Userfunction{

	private $DBHOST='localhost';
	private $DBUSER='root';
	private $DBPASS='';
	private $DBNAME='ajax';
	public $con;

	public function __construct(){
		$this->con = mysqli_connect($this->DBHOST, $this->DBUSER, $this->DBPASS, $this->DBNAME);
		if(!$this->con){
			return false;
		}
	}

	public function htmlvalidation($form_data){
		$form_data = trim( stripslashes( htmlspecialchars( $form_data ) ) );
		$form_data = mysqli_real_escape_string($this->con, trim(strip_tags($form_data)));
		return $form_data;
	}

	public function insert($tblname, $filed_data){

		$query_data = "";

		foreach ($filed_data as $q_key => $q_value) {
			$query_data = $query_data."$q_key='$q_value',";
		}
		$query_data = rtrim($query_data,",");

		$query = "INSERT INTO `$tblname` SET $query_data";
		$insert_fire = mysqli_query($this->con, $query);
		if($insert_fire){
			return $insert_fire;
		}
		else{
			return false;
		}

	}

	public function addToCart($user_id, $product_id, $quantity) {
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
		$insert_cart = mysqli_query($this->con, $sql);
		if($insert_cart){
			return $insert_cart;
		}
		else{
			return false;
		}    }

	

	public function select_assoc($tblname, $condition, $op='AND'){

		$field_op = "";
		foreach ($condition as $q_key => $q_value) {
			$field_op = $field_op."$q_key='$q_value' $op ";
		}
		$field_op = rtrim($field_op,"$op ");

		$select_assoc = "SELECT * FROM $tblname WHERE $field_op";
		$select_assoc_query = mysqli_query($this->con, $select_assoc);
		if(mysqli_num_rows($select_assoc_query) > 0){
			if(mysqli_num_rows($select_assoc_query) == 1)
			{
				$select_assoc_fire = mysqli_fetch_assoc($select_assoc_query);
				if($select_assoc_fire){
					return $select_assoc_fire;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{	
			return false;
		}

	}

	public function select($tblname){

		$select = "SELECT * FROM $tblname";
		$select_fire = mysqli_query($this->con, $select);
		if(mysqli_num_rows($select_fire) > 0){
			$select_fetch = mysqli_fetch_all($select_fire, MYSQLI_ASSOC);
			if($select_fetch){
				return $select_fetch;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}


	public function selectCartWithDetails() {
		$query = "SELECT 
					cart.id, 
					login_users.name AS username, 
					products.productname, 
					cart.quantity 
				  FROM cart
				  JOIN login_users ON cart.user_id = login_users.id
				  JOIN products ON cart.product_id = products.p_id";
	
		$result = mysqli_query($this->con, $query);
		
		if ($result && mysqli_num_rows($result) > 0) {
			return mysqli_fetch_all($result, MYSQLI_ASSOC);
		} else {
			return false;
		}
	}
	

	public function update($tblname, $field_data, $condition, $op='AND'){

		$field_row = "";
		foreach ($field_data as $q_key => $q_value) {
			$field_row = $field_row."$q_key='$q_value',";
		}
		$field_row = rtrim($field_row,",");

		$field_op = "";

		foreach ($condition as $q_key => $q_value) {
			$field_op = $field_op."$q_key='$q_value' $op ";
		}
		$field_op = rtrim($field_op,"$op ");

		$update = "UPDATE $tblname SET $field_row WHERE $field_op";
		$update_fire = mysqli_query($this->con, $update);
		if($update_fire){
			return $update_fire;
		}
		else{
			return false;
		}

	}	

	public function delete($tblname, $condition, $op='AND'){

		$delete_data = "";

		foreach ($condition as $q_key => $q_value) {
			$delete_data = $delete_data."$q_key='$q_value' $op ";
		}

		$delete_data = rtrim($delete_data,"$op ");		
		$delete = "DELETE FROM $tblname WHERE $delete_data";
		$delete_fire = mysqli_query($this->con, $delete);
		if($delete_fire){
			return $delete_fire;
		}
		else{
			return false;
		}

	}

	public function search($tblname,$search_val,$op="AND"){

		$search = "";
		foreach($search_val as $s_key => $s_value){
			$search = $search."$s_key LIKE '%$s_value%' $op ";
		}
		$search = rtrim($search, "$op ");

		$search = "SELECT * FROM $tblname WHERE $search";
		$search_query = mysqli_query($this->con, $search);
		if(mysqli_num_rows($search_query) > 0){
			$serch_fetch = mysqli_fetch_all($search_query, MYSQLI_ASSOC);
			return $serch_fetch;
		}
		else{
			return false;
		}

	}	
	public function getUserByEmail($email) {
		// Prepare the SQL statement
		$stmt = $this->con->prepare("SELECT id, email, password FROM login_users WHERE email = ?");
		if ($stmt) {
			// Bind the email parameter
			$stmt->bind_param("s", $email);
			
			// Execute the query
			$stmt->execute();
			
			// Get the result
			$result = $stmt->get_result();
			
			// Fetch the user data
			if ($result->num_rows > 0) {
				return $result->fetch_assoc();
			} else {
				return false;
			}
			
			// Close the statement
			$stmt->close();
		} else {
			return false;
		}
	}
	public function getProductCounts() {
		$counts = [];
	
		// Total Products
		$sql = "SELECT COUNT(*) as total FROM products";
		$result = mysqli_query($this->con, $sql);
		if ($result) {
			$row = mysqli_fetch_assoc($result);
			$counts['total'] = $row['total'];
		} else {
			$counts['total'] = 0; // Default value if query fails
		}
	
		
		return $counts;
	}
	public function getCartCounts() {
		$counts = [];
	
		// Count total cart items where product_id exists in the products table
		$sql1 = "SELECT COUNT(*) as totalcart 
				 FROM cart 
				 WHERE product_id IN (SELECT p_id FROM products)";
		
		$result1 = mysqli_query($this->con, $sql1);
		
		if ($result1) {
			$row = mysqli_fetch_assoc($result1);
			$counts['totalcart'] = $row['totalcart'];
		} else {
			$counts['totalcart'] = 0; // Default value if query fails
		}
	
		return $counts;
	}
	
}

?>

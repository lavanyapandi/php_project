<?php

include_once('config.php');
$user_fun = new Userfunction();
$counter = 1;

if(isset($_POST['keyword']) && !empty(trim($_POST['keyword']))){

	$keyword = $user_fun->htmlvalidation($_POST['keyword']);

	$match_field['productname'] = $keyword;
	$match_field['description'] = $keyword;
	$select = $user_fun->search("products", $match_field, "OR");

}
else{

	$select = $user_fun->select("products");

}


?>

				<table class="table" style="vertical-align: middle; text-align: center;">
				  <thead class="thead-dark">
					<tr>
					  	<th scope="col">#</th>
					  	<th scope="col">Products Name</th>
					  	<th scope="col">Description</th>
						<th scope="col">Price</th>
					  	<th scope="col">Quantity</th>
						<th scope="col">Action</th>
					</tr>
				  </thead>
				  <tbody>
				  	<?php if($select){ foreach($select as $se_data){ ?>
					<tr>
					  <th scope="row"><?php echo $counter; $counter++; ?></th>
					  	<td><?php echo $se_data['productname']; ?></td>
					  	<td><?php echo $se_data['description']; ?></td>
					  	<td><?php echo $se_data['price']; ?></td>
						<td><?php echo $se_data['quantity']; ?></td>
						
						<td>
						<button class='btn btn-primary addtocart' data-productid="<?php echo $se_data['p_id']; ?>">Add to Cart</button>
							<button type="button" class="btn btn-danger editdata" data-dataid="<?php echo $se_data['p_id']; ?>" data-toggle="modal" data-target="#updateModalCenter">Update</button>
							<button type="button" class="btn btn-danger deletedata" data-dataid="<?php echo $se_data['p_id']; ?>" data-toggle="modal" data-target="#deleteModalCenter">Delete</button>
						</td>
					</tr>
					<?php }}else{ echo "<tr><td colspan='7'><h2>No Result Found</h2></td></tr>"; } ?>
				  </tbody>
				</table>	
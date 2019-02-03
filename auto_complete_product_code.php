<?php 
	include("config.php");

	$searchTerm = $_GET['term'];
	$select =mysqli_query($conn,"SELECT * FROM products WHERE product_type LIKE '%".$searchTerm."%' ");
	$data = array();
	while ($row=mysqli_fetch_assoc($select)) {
		$item = array('id' => $row['id'], 'value' => $row['product_type'], 'price' => $row['product_price'], 'name' => $row['product_name'], 'remark' => $row['remark']);
		array_push($data, $item);
	}
	echo json_encode($data);
?>
<?php 
	include("config.php");

	$searchTerm = $_GET['term'];
	$select =mysqli_query($conn,"SELECT * FROM products WHERE product_name LIKE '%".$searchTerm."%' ");
	$data = array();
	while ($row=mysqli_fetch_assoc($select)) {
		$item = array('id' => $row['id'], 'value' => $row['product_name'], 'price' => $row['product_price'], 'code' => $row['product_type'], 'remark' => $row['remark']);
		array_push($data, $item);
	}
	echo json_encode($data);
?>
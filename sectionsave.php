<?php
include("config.php");
$id=$_POST['order_id'];
$section_type = $_POST['section'];
$table_type = $_POST['table_booking'];
echo "UPDATE `order_list` SET `section_type` = '$section_type',table_type='$table_type' WHERE `id` = '$id'";

$ttw = mysqli_query($conn,"UPDATE `order_list` SET `section_type` = '$section_type',table_type='$table_type' WHERE `id` = '$id'");
header('Location: orderlist.php');
?>

<?php 
session_start();
include("config.php");
$Merchantid = $_SESSION['login'];

	 $sql = "select * from order_list where status = 0 and merchant_id='$Merchantid' limit 0,50";   
	$rel = mysqli_query($conn, $sql);


		while($data = mysqli_fetch_assoc($rel))
		{   
		   
		    echo ' <input type="button" style="margin: 10px; background-color:#296ca0;" class="btn btn-info" name="invo" value="'.$data["invoice_no"].'">';
		    
		}


?>
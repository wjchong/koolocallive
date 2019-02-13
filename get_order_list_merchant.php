<?php 
	
	include("config.php");
	
    // $merchant_id = $_POST['merchant'];
	$merchant_id = 634;
	$total_rows = mysqli_query($conn, "SELECT order_list.*, users.mobile_number FROM order_list inner join users on order_list.user_id = users.id WHERE merchant_id ='".$merchant_id."' ORDER BY `created_on` DESC");

	$dt = new DateTime();

    $today =  $dt->format('Y-m-d');

	$result = array();

	$current_time = date('Y-m-d H:i:s');
	while ($row=mysqli_fetch_assoc($total_rows)){

        $product_ids = explode(",",$row['product_id']);

        $quantity_ids = explode(",",$row['quantity']);

        $amount_val = explode(",",$row['amount']);

        $product_code = explode(",",$row['product_code']);

        $amount_data = array_combine($product_ids, $amount_val);

        $total_data = array_combine($quantity_ids, $amount_val);



        $created =$row['created_on'];

        $remark_ids = explode("|",$row['remark']);

        $new_time = explode(" ",$created);

        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$row['product_id']."'"));



        $user_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$row['user_id']."'"));



        $id_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$row['id']."'"));



        $merchant_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$row['merchant_id']."'"));

        $date=date_create($created);


        if($row['status'] == 1) $callss = "gr";

        else if($row['status'] == 2) $callss = "or";

        else $callss = " ";

        $todayorder = $today == $new_time[0] ? "red" : "";

      	$dteDiff  = date_diff($date, date_create($current_time));
      	$diff_day = $dteDiff->d;
      	if($diff_day != '0') $diff_day .= ' days ';
      	else $diff_day = '';
      	$diff_hour = $dteDiff->h;
      	if(intval($diff_hour) < 10) $diff_hour = '0'.$diff_hour.':'; else $diff_hour = $diff_hour.':';
      	$diff_minute = $dteDiff->i;
      	if($diff_minute < 10) $diff_minute = '0'.$diff_minute.':'; else $diff_minute = $diff_minute.':';
      	$diff_second = $dteDiff->s;
      	if($diff_second < 10) $diff_second = '0'.$diff_second;
      	$diff_time = $diff_day.'<br>'.$diff_hour.$diff_minute.$diff_second;


        $i1 =1;

        if($row['status'] == 0) $sta = "Pending";

        else if($row['status'] == 1) $sta = "Done";

        else $sta = "Accepted";

        $quantities = "";
        foreach ($quantity_ids as $key){

        	$quantities .= $key . '<br>';
        }

        $product_name = "";
        foreach ($product_ids as $key ){

            if(is_numeric($key))

            {

                $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$key."'"));


                $product_name .= $product['product_name'].'<br>';

            }

            else

            {
            	$product_name .= $key .'<br>';

            }

        }

        $remarks = "";
        foreach ($remark_ids as $val) {
        	$remarks .= $val.'<br>';
		}

		$product_key = "";
        foreach ($product_code as $key) {
        	$product_key .= $key."<br>";
        }

        $amount_value = "";
        foreach ($amount_val as $key => $value){

        	$amount_value .= @number_format($value, 2).'<br>';

        }

        $q_id = 0;

        $quantity_val = '';
        foreach ($amount_val as $key => $value){

            $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$key."'"));

            if($value == '0') { ?>

            <?php  }

            if( $quantity_ids[$key] && $value ) {

                $quantity_val .= @number_format($quantity_ids[$key] * $value, 2).'<br>';

            } else {

               	$quantity_val .= '<p class="pop_upss" data-id=' . $row['id'] . '  style="margin-bottom: 0px;display:block;" data-prodid="' . $key . '""><i class="fa fa-pencil-square-o" aria-hidden="true"></i>0</p>';

            }

            $q_id++;

        }

        $total = 0;

        $total_val = "";

        foreach ($amount_val as $key => $value){

            if( $quantity_ids[$key] && $value ) {

                $total =  $total + ($quantity_ids[$key] *$value );

            } 

        }

        $total_val .= @number_format($total, 2);

        $lock_mobile = "";
    	if($user_name['number_lock'] == 0){
    		$lock_mobile = $user_name['mobile_number'];
		} else {
			$lock_mobile = "";
		}
		$account_type = "";
		if($sta == "Done"){
			$account_type = $user_name['account_type'];
		}else {
			$account_type = "";
		}
        $item = array(	"id" => $row['id'], "invoice_no" => $row['invoice_no'], 
        				'callss' => $callss, "todayorder" => $todayorder, 
        				'merchant_name' => $merchant_name['name'], 'user_mobile_number' => $user_name['mobile_number'], 'merchant_mobile_number' => $merchant_name['mobile_number'], 'merchant_google_map' => $merchant_name['google_map'], 'date' => date_format($date,"m/d/Y"), 'new_time' => $new_time[1], 'status' => $row['status'], 'diff_time' => $diff_time, 'user_name' => $user_name['name'], 'sta' => $sta, 'section_type'=>$row['section_type'],'table_type' => $row['table_type'], 'product_name' => $product_name, 'remark' => $remarks, 'product_code' => $product_key, 'amount_val' => $amount_value, 'quantity_val' => $quantity_val, 'total_val' => $total_val, 'wallet' => $row['wallet'], 'location' => $row['location'], 'lock_mobile' => $lock_mobile, 'user_id' => $row['user_id'], 'quantities' => $quantities, 'account_type' => $account_type);
        
		array_push($result, $item);
    }
    echo json_encode($result);

?>
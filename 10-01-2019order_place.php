<?php
include("config.php");
$profile_data = isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'")) : '';

if(isset($_POST['submit']))
{

 	$m_id=$_POST['m_id'];
 	$sql = "SELECT MAX(invoice_no) invoice_no
            FROM order_list
            WHERE merchant_id = '$m_id'";
	$invoice_no = mysqli_fetch_assoc(mysqli_query($conn, $sql))['invoice_no'];
	if($invoice_no == NULL) $invoice_no = 1;
	else $invoice_no += 1;

    if( !isset( $m_id ) || $m_id == '' || $m_id == 0 ) {
        echo('Something went wrong.');
    }
	$stl_key = isset($_POST['stl_key']) ? $_POST['stl_key'] : '';
	$u_id = $_SESSION['login'];
	$date = date('Y-m-d H:i:s');
	$location =$_POST['location'];
	$table_type =$_POST['table_type'];
	$p_code = implode(',', $_POST['p_code']);
	$pro_id = implode(',', $_POST['p_id']);
	$qty_list = implode(',', $_POST['qty']);
	$p_price = implode(',', $_POST['p_price']);
	$option = implode('|', $_POST['option']);
	$product_name =isset($_POST['product_name']) ? $_POST['product_name'] : '';
	$product_code =isset($_POST['product_code']) ? $_POST['product_code'] : '';
	
	$flag = 0;
	 if(!empty($_SESSION['login'])){
	     $merchant = mysqli_fetch_assoc(mysqli_query($conn, "SELECT account_type, k_lock FROM users WHERE id='".$m_id."'"));
	     $merchant_kType = $merchant['account_type'];
	     $k_lock = $merchant['k_lock'];
	     $user_kType = mysqli_fetch_assoc(mysqli_query($conn, "SELECT account_type FROM users WHERE id='".$u_id."'"))['account_type'];
		 $discount ="";
		 if(($merchant_kType != "") && ($user_kType != "") && ($merchant_kType != $user_kType) && (strlen($merchant_kType) != strlen($user_kType))){
		    $discount = "2%";
		 } else if(($merchant_kType != "") && ($user_kType != "") && ($merchant_kType == $user_kType) && (strlen($merchant_kType) == 2)){
		     $discount = "2%";
		 } else if(($merchant_kType != "") && ($user_kType != "") && ($merchant_kType == $user_kType) && (strlen($merchant_kType) == 7)){
		     $discount = "4%";
		 }
        if(($k_lock == '1') && ($discount != '')){
            $test_method = mysqli_query($conn, "INSERT INTO order_list SET product_id='$pro_id',user_id='$u_id',merchant_id='$m_id',quantity='$qty_list',product_code='$p_code',amount='$p_price',remark='$option',location='".$location."',table_type='".$table_type."',created_on='$date', invoice_no='$invoice_no'");
	        $order_id = mysqli_insert_id($conn);
        
            mysqli_query($conn, "INSERT INTO k1k2_history SET user_id='$u_id', merchant_id='$m_id', k_user='$user_kType', k_merchant='$merchant_kType', order_id='$order_id', discount='$discount'");
        
            $flag = 1;
        }
        if($k_lock == '0'){
            $test_method = mysqli_query($conn, "INSERT INTO order_list SET product_id='$pro_id',user_id='$u_id',merchant_id='$m_id',quantity='$qty_list',product_code='$p_code',amount='$p_price',remark='$option',location='".$location."',table_type='".$table_type."',created_on='$date', invoice_no='$invoice_no'");
	        $order_id = mysqli_insert_id($conn);
        
            if($discount != ""){
	            mysqli_query($conn, "INSERT INTO k1k2_history SET user_id='$u_id', merchant_id='$m_id', k_user='$user_kType', k_merchant='$merchant_kType', order_id='$order_id', discount='$discount'");
	        }
	        $flag = 1;
        }
	 } else {
	     $flag = 1;
	 	if($stl_key == $_SESSION['stl_key']) {
    		$test_method = mysqli_query($conn, "INSERT INTO order_list SET product_id='$pro_id',user_id='$u_id',merchant_id='$m_id',quantity='$qty_list',product_code='$p_code',amount='$p_price',remark='$option',location='".$location."',table_type='".$table_type."',created_on='$date', invoice_no='$invoice_no'");
    		$_SESSION['stl_key'] = "empty";
        }
     }

	$order_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `order_list` WHERE id = (SELECT MAX(id) FROM `order_list`)"));

// print_R($order_total);
// die;  
	$tttt_qt= $order_total['quantity'] ;
	$tt_amt= $order_total['amount'];

	$quantity = explode(",",$order_total['quantity']);
	$amount = explode(",",$order_total['amount']);
	$c = array_combine($quantity, $amount);
	$total = 0;
	foreach ($c as $key => $val){
	    $total = $total + ($key * $val);
	}
	if($flag == 0){
	    header("location:merchant_find.php");
	}
}

if(isset($_POST['update_cash'])){
    $money=$_POST['money'];
    $upt_tt = mysqli_query($conn,"UPDATE `order_list` SET `wallet`='$money'");
}

?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
<style>
.text_payment{
    width: 50%!important;
    text-align: center;
    margin: 0 auto;
}
.pay_wallet{
    font-size: 14px;
    text-align: center;
}
.order_whole {
    text-align: center;
    border: 1px solid;
    width: 50%;
    margin: 0 auto;
    padding: 15px;
}
.wallet_hr{
    width: 510px;
    margin-left: -15px;
    border-top: 1px solid black;
}

 @media (min-width: 360px) and (max-width:650px) {
.order_whole {
    text-align: center;
    border: 1px solid;
    width: 100%;
    margin: 0 12px;
    padding: 14px;
}
.wallet_hr {
    width: 325px;
}
}
 @media (min-width: 700px) and (max-width:800px) {

.wallet_hr {
    width: 335px;
   }
}
 @media (min-width: 650px) and (max-width:700px) {

.wallet_hr {
    width: 307px;    
}
}
 @media (min-width: 430px) and (max-width:400px) {

.wallet_hr {
    width: 360px!important;
}
}

</style>
<?php
  if(isset($_GET['user_id']))
  {
	  $user_id=$_GET['user_id'];
	  $member = "";
	  if(isset($_GET['member'])){
	      $member = $_GET['member'];
	  }
	  $profile_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$user_id."'"));
	  $name=$profile_data['name'];
	  $email=$profile_data['email'];
	  $mobile_number=$profile_data['mobile_number'];
	  $unique="guest".$mobile_number;
	?>
	<link rel="manifest" href="manifest.json">
<script type="text/javascript">
(function(i,s,o,g,r,a,m,n){
i['moengage_object']=r;t={}; q = function(f){return function(){(i['moengage_q']=i['moengage_q']||[]).push({f:f,a:arguments});};};
f = ['track_event','add_user_attribute','add_first_name','add_last_name','add_email','add_mobile',
'add_user_name','add_gender','add_birthday','destroy_session','add_unique_user_id','moe_events','call_web_push','track','location_type_attribute'];
for(k in f){t[f[k]]=q(f[k]);}
a=s.createElement(o);m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m);
i['moe']=i['moe'] || function(){n=arguments[0];return t;}; a.onload=function(){if(n){i[r] = moe(n);}};
})(window,document,'script','https://cdn.moengage.com/webpush/moe_webSdk.min.latest.js','Moengage');

Moengage = moe({
app_id:"YJQ9WUT6IU77C9FVFWJWUILT",
debug_logs: 0
});
<?php if($moengage_unique_id==''){

   mysqli_query($conn, "UPDATE users SET moengage_unique_id='".$unique."' WHERE id='".$user_id."'");
	 ?>
Moengage.add_user_attribute("koo_id", "<?php echo $user_id; ?>");
Moengage.add_first_name("<?php echo $name; ?>");
Moengage.add_email("<?php echo $email; ?>");
Moengage.add_mobile("<?php echo $mobile_number; ?>");
Moengage.add_user_name("<?php echo $name; ?>");
Moengage.add_unique_user_id("<?php echo $unique; ?>"); // UNIQUE_ID is used to uniquely identify a user.
<?php } ?>
</script>   
<?php 	
  }	  
?>
    <?php include("includes1/head.php"); ?>
</head>
<body class="header-light sidebar-dark sidebar-expand pace-done">
<div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <?php include("includes1/navbar.php"); ?>
        <!-- /.navbar -->
        <div class="content-wrapper">
            <!-- SIDEBAR -->
            <?php include("includes1/sidebar.php"); ?>
            <!-- /.site-sidebar -->


           <main class="main-wrapper clearfix" style="min-height: 522px;">
                <div class="row" id="main-content" style="padding-top:25px">
					<div class="well" style="width:100%">

						<div class="order_whole">
						<h4><?php echo $language["your_order_has_been_sent"];?></h4>
						<h5>
						    <?php if(isset($total)) {echo sprintf($language["following_mode_of_payments"],'');} ?>
							<!--Please pay RM <?php  echo $total; ?> by selecting the following mode of payments-->
						</h5>
            			<form  id="data" method="post" accept-charset="UTF-8" action="payment.php">   
                        <?php
                        if(!empty($profile_data['user_roles'])){?>

    						<select class="form-control text_payment required" name="wallet">
        						<option class="text_csah" value='cash_<?php echo $order_total['id'];?>'><?php echo $language["cash"] ;?></option>
        						<option value='MYR'><?php echo $language["wallet"];?></option>
        					</select>
					    <?php } else {?>
    						<select class="form-control text_payment required" name="wallet">
    						    <option class="text_csah" value='cash_<?php echo $order_total['id'];?>'>Cash</option>
    						</select>
						<?php } ?>
						   <input type="hidden" id="id" name="m_id" value="<?php echo $m_id;?>">
						   <input type="hidden" id="amount" name="amount" value="<?php echo $total;?>">
						    <input type="hidden" id="member" name="member" value="<?php echo $member;?>">
					       <input type="hidden" id="o_id" name="o_id" value="<?php echo $order_total['id'];?>">
						    <?php if(isset($_GET['user_id'])){  ?>
						    <input type="hidden" id="guest_id" name="guest_id" value="<?php echo $_GET['user_id'];?>">
						    <input type="hidden" id="guest_order_id" name="guest_order_id" value="<?php echo $_GET['order_id'];?>">
						   <?php } ?>
						   <button class="btn btn-block btn-primary"> Confirm </button>
					  </form>
					<hr class="wallet_hr">
					<!--div class="wallet_price">
					<h4 class="pay_wallet">Pay through wallet and stand a chance to win a trip Bali and money more benefit.</h4>

					</div!-->

						</div>

<div>

			</main>
        </div>
        <!-- /.widget-body badge -->
    </div>
    <!-- /.widget-bg -->

    <!-- /.content-wrapper -->
    <?php include("includes1/footer.php"); ?>
</body>
<script>
	$("select.text_payment").change(function() {
		//~ alert($(this).val());
  var action = $(this).val() == "MYR" ? "wallet_pay.php" : "payment.php";
  $("#data").attr("action", action);
});

</script>

</html>

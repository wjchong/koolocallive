<?php
include("config.php");

function checkSession(){
	$conn = $GLOBALS['conn'];
	$session = $_COOKIE['session_id'];
	$rw = mysqli_fetch_row(mysqli_query($conn, "SELECT id FROM users WHERE session = '$session'"));
	if($rw > 0){
		return true;
	}else{
		return false;
	}
}

if(!isset($_SESSION['login']) || empty($_SESSION['login']))
{
	header("location:logout.php");
}else{
	if(!checkSession()){
		header("location:logout.php");
	}
}


//if($st_phone)

function getURL(){
	global $site_url;
	$a = explode("_", $_COOKIE['session_id']);
	$conn = $GLOBALS['conn'];
	$id = $a[0];
	$ref_token = mysqli_fetch_assoc(mysqli_query($conn, "SELECT token FROM users WHERE id = '$id'"));
	$url = $site_url . "/login.php?tk=" . $ref_token['token'];
	return $url;
}

	// ------------
	// Debug purposes

// var_dump($_COOKIE);
// var_dump($_SESSION);

	// ------------
$token = getURL(); // This is the URL that the user has to save to access the account, everytime the user logs off the account the token is removed, but if the user did not log off and the session expired when he access with this URL it will automatically create new session for the user for ther period of one month. (You can change it on the cookie time)

// echo "<h2>Save " . "<a href=\"" . $token . "\">this URL </a>" . "as shortcut to acces directly to your account.</h2>";

$balance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT balance_usd,balance_inr,balance_myr FROM users WHERE id='".$_SESSION['login']."'"));
// var_dump($_SESSION['login']);
?>

<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
    <?php include("includes1/head.php"); ?>
	<style>
	/*.sidebar-toggle .ripple{     padding: 0 100px; }*/
	.well
	{
		min-height: 20px;
		padding: 19px;
		margin-bottom: 20px;
		background-color: #fff;
		border: 1px solid #e3e3e3;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
	}

	.wallet_h{
	        font-size: 30px;
    color: #213669;

	}
	</style>
	<?php
$profile_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'"));
if($_SESSION['login'])
{
  $user_id=$_SESSION['login'];
	$name=$profile_data['name'];
	$email=$profile_data['email'];

  	$mobile_number=$profile_data['mobile_number'];

	$moengage_unique_id=$profile_data['moengage_unique_id'];
	if($moengage_unique_id=='')
	{
		function generateRandomString($length = 4) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	 $unique_id=generateRandomString();
	
   $unique=$user_id.$mobile_number;     
	}


?>
<?php if($moengage_unique_id=='')
	{ include('mpush.php'); ?>   
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
app_id:"HAZX1A6SDRWD6Z1XHO8WO3B7",
debug_logs: 0
});
<?php if($moengage_unique_id==''){

   mysqli_query($conn, "UPDATE users SET moengage_unique_id='".$unique."' WHERE id='".$_SESSION['login']."'");
	 ?>
Moengage.add_user_attribute("koo_id", "<?php echo $user_id; ?>");
<?php if($name){  ?> Moengage.add_first_name("<?php echo $name; ?>"); <?php } ?>
<?php if($name){  ?> Moengage.add_user_name("<?php echo $name; ?>"); <?php } ?>
<?php if($email){  ?> Moengage.add_email("<?php echo $email; ?>"); <?php } ?>
<?php if($mobile_number){  ?> Moengage.add_user_name("<?php echo $mobile_number; ?>"); <?php } ?>
Moengage.add_unique_user_id("<?php echo $unique; ?>"); // UNIQUE_ID is used to uniquely identify a user.   
<?php } ?>
</script>
<?php

	}
 //die;
 }
 
?>
	<!-- Manifest -->
	<link rel="manifest" href="manifest.json">
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
                <div class="container-fluid" id="main-content" style="padding-top:25px">
					<h2 class="text-center wallet_h"><?php echo $language['wallet_balance'];?></h2>
					<div class="row">
						<div class="col-md-4 well text-center"><h3 style="color:#51d2b7;">MYR</h3> <h4><?php echo $balance['balance_myr']; ?></h4></div>
						<div class="col-md-4 well text-center"><h3 style="color:#51d2b7;">Community Fund(CF)</h3> <h4><?php echo $balance['balance_usd']; ?></h4></div>
						<div class="col-md-4 well text-center"><h3 style="color:#51d2b7;">Koo Coin</h3> <h4><?php echo $balance['balance_inr']; ?></h4></div>
					</div>
					<h2 class="wallet_h text-center">Notifications</h2>
					<div class="row">
						<table class="table table-striped">
							<tr>
								<th>Type</th>
								<th>Notification</th>
								<th>Arrived on</th>
							</tr>
							<?php
							$notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id='".$_SESSION['login']."' AND readStatus='0' ORDER BY id DESC LIMIT 10");
							while($notification = mysqli_fetch_assoc($notifications))
							{
							?>
							<tr>
								<td><?php echo $notification['type']; ?></td>
								<td><?php echo $notification['notification']; ?></td>
								<td><?php echo date("d-m-Y H:i A",$notification['created_on']); ?></td>
							</tr>
							<?php
							}

							mysqli_query($conn, "UPDATE notifications SET readStatus='1' WHERE user_id='".$_SESSION['login']."'");
							?>
						</table>
						<?php
						if(mysqli_num_rows($notifications) == 0)
						{
						    echo "<div style='text-align:center;    color: red;
    font-size: 17px;'>No More New Notifications</div>";
						}
						?>
					</div>
				</div>
			</main>
        </div>
        <!-- /.widget-body badge -->
    </div>
    <!-- /.widget-bg -->

    <!-- /.content-wrapper -->
	<?php include("includes1/footer.php"); ?>
</body>
	<!-- <script>
		
		// It has been commented because it does not exist such file service-worker.js and it throws an error on console

	  if ('serviceWorker' in navigator) {
	    navigator.serviceWorker.register('/service-worker.js')
	      .then(function(reg){
	        console.log("Service Worker loaded correctly");
	      }).catch(function(err) {
	        console.log("Service Worker error: ", err)
	      });
	  }
	</script> -->

</html>

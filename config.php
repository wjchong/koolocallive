<?php

 date_default_timezone_set("Asia/Kuala_Lumpur");

if(!isset($_SESSION))
{
 session_start();
}

error_reporting(0);
$conn = mysqli_connect("localhost", "root", "", "koofamil_b277");
// $conn = mysqli_connect("localhost", "root", "", "koofamil_demo");
// $conn = mysqli_connect("localhost", "koofamil_B277", "rSFihHas];1P", "koofamil_B277");
//$conn = mysqli_connect("localhost", "root","","koofamil_b277");
// $conn = mysqli_connect("stallioni.net", "dotnetst_B277", "Sy?}z)-o;TB6", "dotnetst_B277");

if(!$conn)
{
	echo "database error"; die;
}
// ZhengGe's code for wechat session

if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
	if (isset($_COOKIE['my_cookie_id']) && $_COOKIE['my_cookie_id'] != '') {
		$my_cookie_id = $_COOKIE['my_cookie_id'];
		$sql = "SELECT user_id, salt, cookie_id FROM pcookies WHERE cookie_id = '$my_cookie_id'";
		$result = $conn->query($sql);

		$savedCookie = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		if ($savedCookie > 0) {
			$old_cookie_id = hash_hmac('sha512',$_COOKIE['my_token'],$savedCookie['salt']);
			if ($savedCookie['cookie_id'] == $old_cookie_id) {
				$salt=md5(mt_rand());
	    		$my_cookie_id = hash_hmac('sha512', $_COOKIE['my_token'], $salt);
	    		$_SESSION['login'] = $savedCookie['user_id'];
	    		$token_sql = "UPDATE pcookies SET cookie_id = '$my_cookie_id', salt = '$salt'";
	    		$conn->query($token_sql);
	    		$_COOKIE['my_cookie_id'] = $my_cookie_id;
	    		setcookie("session_id", $_COOKIE['my_token'], time() + 3600 * 24 * 30 * 12 * 10,"/");
			} else {
			    setcookie("my_cookie_id", '', 1, "/");
				setcookie("my_token", '', 1, "/");
				unset($_COOKIE['my_cookie_id']);
				unset($_COOKIE['my_token']);
				$remove_sql = "DELETE FROM pcookies WHERE cookie_id = '$my_cookie_id'";
	    		$conn->query($remove_sql);
			}
		}
	}	
}
$paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr'; 

//$site_url = "http://koofamilies.local";  // local


//$site_url = "http://koofamilies.local";  // local

$site_url = "http://localhost/koo23";   // Prod


//$paypalId='stallioni.vvijay@gmail.com';
//$paypal_cancel_url = "http://kooexchange.com/demo/wallet.php?status=cancel";
//$paypal_success_url = "http://kooexchange.com/demo/success.php"
 $paypalId='ankit.karan99-myrB@gmail.com';

 $paypal_cancel_url = $site_url . "/wallet.php?status=cancel";
 $paypal_success_url = $site_url . "/success.php";
if(!function_exists('redirectToUrl')) {
	function redirectToUrl($url) {
		echo '<script language="javascript">window.location.href ="'.$url.'"</script>';
		exit;
	}
}
?>

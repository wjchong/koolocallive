<?php

 date_default_timezone_set("Asia/Kuala_Lumpur");

if(!isset($_SESSION))
{
 session_start();
}

error_reporting(0);
$conn = mysqli_connect("localhost", "root", "", "koofamil_b277");
//$conn = mysqli_connect("localhost", "root","","koofamil_b277");
// $conn = mysqli_connect("stallioni.net", "dotnetst_B277", "Sy?}z)-o;TB6", "dotnetst_B277");

if(!$conn)
{
	echo "database error"; die;
}

$paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr'; 

//$site_url = "http://koofamilies.local";  // local


//$site_url = "http://koofamilies.local";  // local

$site_url = "http://localhost/koolive";   // Prod


//$paypalId='stallioni.vvijay@gmail.com';
//$paypal_cancel_url = "http://kooexchange.com/demo/wallet.php?status=cancel";
//$paypal_success_url = "http://kooexchange.com/demo/success.php"
 $paypalId='ankit.karan99-myrB@gmail.com';

 $paypal_cancel_url = $site_url . "/wallet.php?status=cancel";
 $paypal_success_url = $site_url . "/success.php";

?>
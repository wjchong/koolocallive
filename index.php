<?php
include("config.php");
?>
<?php
function sanitize_output($buffer)
{
    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
        );
    $replace = array(
        '>',
        '<',
        '\\1'
        );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}
ob_start("sanitize_output");
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!--Meta-->	
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="theme-color" content="#4A90E2" />
	<meta name="description" content="Enjoy low fees when you send money to your friend or family. Transfer money directly to a bank account the choice is yours.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="robots" content="index, follow"/>
	<!--Favicon-->
	<link rel="icon" href="favicon.ico">

    <meta name="robots" content="index,follow"/>
	 <link rel="canonical" href="https://www.koofamilies.com/"/>
	<!-- Title-->
	<title>Transfer Money | Send and Earn Money Online | Koo Families</title>
		<!--Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Dosis:400,500,600,700%7COpen+Sans:400,600,700" rel="stylesheet">
  
	<!--Icon fonts-->
	<link rel="stylesheet" href="<?php echo $site_url; ?>/assets/vendor/strokegap/style.css">
	<link rel="stylesheet" href="<?php echo $site_url; ?>/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $site_url; ?>/assets/vendor/linearicons/style.css">
   <link rel="stylesheet" href="<?php echo $site_url; ?>/assets/css/bundle.css">
  <link rel="stylesheet" href="<?php echo $site_url; ?>/assets/css/style.css">
	<!-- Manifest -->
	<link rel="manifest" href="manifest.json">
  
  
  <style>
    
  .border {
    border: 1px solid #e9ecef00!important;}
.logo{
    color: #fff;
    font-size: 37px;
}
.u-mt-90 {
    margin-top: 10rem !important;
}
 .step-number {
    left: 20px;
    width: 50px;
    height: 50px;
    padding-top: 2px;
    font-size: 32px;
    font-weight: 200;
    text-align: center;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 50%;
}
.label{
    color: #fff;
    font-size: 23px;
}
.label_p{
    color: #fff;
    font-size: 23px;
} 

.select{
    border: 1px solid #e9eff5;
    padding: 9px 30px;
    border-radius: 4px;
    width: 100%;
    margin-bottom: 10px;
}
.display-4{
    font-size: 2rem;
}

<!-- Edited by Sumit  -->
@media (min-width:200px) and (max-width:767px){
.nav-link {
    display: block;
    padding: 0px;
}
.nav .dropdown-toggle {
    font-size: 13px !important;
}
.nav .dropdown-toggle img {
    width: 25px !important;

}
}
<!-- Edited by Sumit  -->
 </style>

</head>

 <body id="top">
 
 
<!--[if lt IE 8]>
<p>You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->



 <header class="header header-shrink header-inverse fixed-top">
  <div class="container">
		<nav class="navbar navbar-expand-lg px-md-0">
			<a class="navbar-brand" href="index.php">
				<span class="logo-default">
					<h3 class="logo">KooFamilies</h3>
				</span>
				<span class="logo-inverse">
					<h3>KooFamilies</h3> 
				</span>
			</a>
            <!--<div class="navbar-toggler" data-toggle="collapse" data-target="#navbarLanguage" style="font-size: 1rem; padding: .25rem 0.05rem;">
				<span>Language</span>
			</div>-->
			<?php if(!isset($_SESSION['login'])){	?>
			        <a class="nav-link" href="login.php">Login</a>
			<?php } else {?>
			        <a class="nav-link" href="dashboard.php">Dashboard</a>
			<?php }?>
		
			</div>
            
			<div class="collapse navbar-collapse" id="navbarLanguage">
			    <ul class="navbar-nav ml-auto">
			        <li class="nav-item active">
			            <a href="?language=english" class="nav-link">English</a>
			        </li>
			        <li class="nav-item dropdown">
			            <a href="?language=chinese" class="nav-link">Chinese</a>
			        </li>
			        <li class="nav-item dropdown">
			            <a href="?language=malaysian" class="nav-link">Malay</a>
			        </li>
			    </ul>
			</div>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
				
					<?php
					if(!isset($_SESSION['login']))
					{
					?>
					<li class="nav-item active">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					<?php
					}
					else
					{
					?>
					<li class="nav-item dropdown">
						<a class="nav-link" href="dashboard.php">Dashboard
						</a>
					</li>
					<?php
					}
					?>
				
				</ul>
			</div>

		</nav>
  </div> <!-- END container-->
</header> <!-- END header -->

<section class="u-py-100 u-h-100vh u-flex-center" style="  background-image: -webkit-linear-gradient(90deg, #113a82 0%, #157af9 100%);
    background-image: -o-linear-gradient(90deg, #113a82 0%, #157af9 100%);
    background-image: linear-gradient(0deg, #113a82 0%, #157af9 100%);
    background-image: url(img/circles.png), -webkit-linear-gradient(90deg, #113a82 0%, #157af9 100%);
    background-image: url(img/circles.png), -o-linear-gradient(90deg, #113a82 0%, #157af9 100%);
    background-image: url(img/circles.png), linear-gradient(0deg, #113a82 0%, #157af9 100%);
    -webkit-background-size: cover;
    background-size: cover;">
  <div class="container">
   
    <div class="row">
      <div class="col-8" style="margin-top:10px;">
        <h2 class="display-4 u-fw-600 text-white u-mb-40">
                Everyday, we create one more hour in your life through food ordering platform.
        </h2>
        <h1 class="display-4 u-fw-600 text-white u-mb-40">
         Safe, Easy, Immediate Payment and Earn Income Everyday
        </h1>
        <p class="u-fs-22 text-white u-lh-1_8 u-mb-40">
		Give us a united safe and convenient society.
        </p>
		<a href="login.php" style="background-color:#0659A2;color:#FFFFFF" class="btn btn btn-rounded btn-primary m-2 px-md-5 py-3">
        	 GET START 
        </a>
      </div> 
		 <div class="col-4 text-center"><img src="<?php echo $site_url; ?>/img/mobile.png"class="img-responsive" alt=""></div>

     
        <!-- END col-lg-6-->
    </div> <!-- END row-->
    
    
  </div> <!-- END container-->
</section> <!-- END intro-hero-->
<section>
	<div class="container">
		<h2 class="h1 text-center">
		Three steps to pay / transfer money / earn income 
		</h2>
		<div class="row align-items-center">			
			<div class="col-lg-6">
			<div class="media mt-4">
				<span class="step-number text-primary u-fs-28 mr-3 mt-2">1</span>
					<div class="media-body">
						<h4 class="h4">
							<a href="login.php">Sign Up</a>
						</h4>
						<p>
							Sign up for a free Koopay. Free wallet on web, iOS or Android and through easy verification process.
						</p>
					</div>
				</div>
			<div class="media mt-4">
				<span class="step-number text-primary u-fs-28 mr-3 mt-2">2</span>
					<div class="media-body">
						<h4 class="h4">
						<a href="login.php">Deposit money</a>
						</h4>
						<p>
							Select your preferred deposit method like bank and deposit money into your own wallet. 
						</p>
					</div>
				</div>
				<div class="media mt-4">
				<span class="step-number text-primary u-fs-28 mr-3 mt-2">3</span>
					<div class="media-body">
						<h4 class="h4">
						<a href="login.php">Make payment / transfer / withdraw money (Free of charge)</a>
						</h4>
						<p>
							You can easily make payment or transfer money through 100% secure method of authorisation code or finger print. 
						</p>
					</div>
				</div>
				<div class="media mt-4">
				<span class="step-number text-primary u-fs-28 mr-3 mt-2">4</span>
					<div class="media-body">
						<h4 class="h4">
						<a href="login.php">Earn Income</a>
						</h4>
						<p>
							You can start to earn money by advertising on your social networks. And you can use the money to pay for your bills.
						</p>
					</div>
				</div>
				<div class="media mt-4">
				<span class="step-number text-primary u-fs-28 mr-3 mt-2">5</span>
					<div class="media-body">
						<h4 class="h4">
						<a href="login.php">Donation </a>
						</h4>
						<p>
							If you like our idea and would like to donate to our team to improve the society. Or you can  
	Join our Crowdfunding: 

						</p>
					</div>
				</div>
			</div> <!-- END col-lg-6 -->
			<div class="col-lg-5 ml-auto text-center">
				<img class="wow fadeInRight w-100 rounded" src="<?php echo $site_url; ?>/img/mobile1.png" alt="">
			</div> <!-- END col-lg-6 pl-lg-5 -->
		</div> <!-- END row-->
	</div> <!-- END container-->
</section>

		<div class="scroll-top bg-white box-shadow-v1">
			<i class="fa fa-angle-up" aria-hidden="true"></i>
		</div> 

		<script src="<?php echo $site_url; ?>/assets/js/bundle.js" defer type="text/javascript"></script>
		<script src="<?php echo $site_url; ?>/assets/js/fury.js" defer type="text/javascript"></script>
		
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript' async='async' defer='defer'>
(function(){ var widget_id = 'QCJcJ4Qb9Q';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = 'https://code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
	
  </body>	
  <script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/pwa-sw.js').catch(function(err) {
        console.log("Service Worker error: ", err)
      });
  }
</script>
</html>

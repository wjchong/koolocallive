<?php
if(isset($_GET['language'])){
	$_SESSION["langfile"] = $_GET['language'];
} 
if (empty($_SESSION["langfile"])) { $_SESSION["langfile"] = "english"; }
    require_once ("languages/".$_SESSION["langfile"].".php");
/*else {
    $st_phone = substr($_SESSION['mobile'], 0, 2);
    if($st_phone == "60"){
        $_SESSION["langfile"] = "malaysian";
    } else if($st_phone == "86"){
         $_SESSION["langfile"] = "chinese";
    } else {
        $_SESSION["langfile"] = "english";
    }
    require_once ("languages/".$_SESSION["langfile"].".php");
}*/


$profile_data = isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'")) : '';
?>
<nav class="navbar">
    <!--<audio id="myAudio" style="display:none;">
      <source src="/notification.mp3" type="audio/mpeg">
    </audio>-->
    <input type="hidden" class="user_id" value="<?php echo $_SESSION['login'];?>" >
<!-- Logo Area -->
<div class="navbar-header">
<a href="index.php" class="navbar-brand">
    <p class="logo-expand">Koo Families</p>
    <p class="logo-collapse">Koo</p>
<!-- <p>OSCAR</p> -->
</a>
</div>
<!-- /.navbar-header -->
<!-- Left Menu & Sidebar Toggle -->
<ul class="nav navbar-nav">
<li class="sidebar-toggle"><a href="javascript:void(0)" class="ripple"><i class="fa fa-bars" aria-hidden="true"></i></a>
</li>
</ul>
<!-- /.navbar-left -->
<div class="spacer"></div>

<!-- User Image with Dropdown -->
<ul class="nav navbar-nav">
	<!--new-->
	<?php  if( isset($profile_data['user_roles']) && $profile_data['user_roles'] !=  '') { ?>
<li class="home_screen">	 
    	<div class="home_screen">
            <input type="hidden" class="sender_id" value="<?php echo $_SESSION['login'];?>">
    		<a href="https://koofamilies.com" class="fa-stack fa-1x unread" style="cursor:pointer; margin-top: 30px; margin-right:5px;">
				<i class="fa fa-home" aria-hidden="true"></i>
    		</a>
    
    	</div>
    </li>
    <?php } else { ?>
		<li class="home_screen">	 
    	<div class="home_screen">
    
    		<a href="https://koofamilies.com/login.php" class="fa-stack fa-1x unread" style="cursor:pointer; margin-top: 30px; margin-right:5px;">
				<i class="fa fa-sign-in"></i>
    		</a>
    
    	</div>
    </li>
    <?php } ?>
    <!--end new--->
    <li class="dropdown">	
    	<div class="stacked-icons">
    		<a class="fa-stack fa-1x unread" style="cursor:pointer; margin-top: 30px; margin-right:5px;">
    			<i class="fa fa-comment fa-stack-2x"></i>
    			<strong class="fa-stack-1x fa-stack-text fa-inverse unread_num" style="color: red;"></strong>
    		</a>
    
    	</div>
    </li>
<li class="dropdown">
  <a href="#" class="dropdown-toggle" style="cursor:pointer; font-size: 18px; padding:0" data-toggle="dropdown" >Language</a>
  
  <ul class="dropdown-menu" style="padding:10px 15px;">
	<a href="?language=english" style="display:block; color:#000; font-size: 18px; margin-bottom: 10px;">English</a>
	<a href="?language=chinese" style="display:block; color:#000; font-size: 18px; margin-bottom: 10px;">Chinese</a>
	<a href="?language=malaysian" style="display:block; color:#000; font-size: 18px; margin-bottom: 10px;">Malay</a>
  </ul>
</li>
<li class="dropdown">
  <a class="dropdown-toggle" style="cursor:pointer" data-toggle="dropdown"><img src="images/wallet.png" style="width:40px"></a>
  <?php
  $balance = isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT balance_usd,balance_inr,balance_myr FROM users WHERE id='".$_SESSION['login']."'")) : '';
  ?>
  <ul class="dropdown-menu" style="padding:10px 10px;">
	<table class="table table-striped">
	    <tr><th>MYR</th><td><?php if( isset($balance['balance_myr']) ) { echo $balance['balance_myr'];} ?></td></tr>
		<tr><th>CF</th><td><?php if( isset($balance['balance_usd']) ) {echo $balance['balance_usd'];} ?></td></tr>
		<tr><th>Koo Coin</th><td><?php if(isset($balance['balance_inr'])){echo $balance['balance_inr'];} ?></td></tr>
	</table>
  </ul>
</li>
<li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle ripple" data-toggle="dropdown">
<span class="thumb-sm"><img src="./Dashboard_files/user-image.png" class="rounded-circle" alt="" style="width: 40px;"> </span></a>
<div class="dropdown-menu dropdown-left dropdown-card-dark text-inverse" style="padding:8px">
	<!-- logout menu -->
	<a href="logout.php">Logout</a>
	<!-- // logout menu -->
</div>
</li>
</ul>
<!-- /.navbar-right -->
</nav>
<style>

i.fa.fa-home {
    font-size: 30px;
    margin-left: -15px;
    color:#09caab;
}
i.fa.fa-sign-in {
    font-size: 26px;
    margin-left: -10px;;
    color:#09caab;
    margin-top: 5px;
}
@media only screen and (max-width: 400px) and (min-width: 300px)  {
li.home_screen {
    margin-right: -15px;
}
i.fa.fa-bars {
    font-size: 19px;
}
}

</style>

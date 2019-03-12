<style>
.media-body .user-type{
    color:#fff;
}
 a:not([href]):not([tabindex]):hover {
    color: #fff;
    text-decoration: none;
}
.sidebar-dark .side-menu li a {
    color: #ffffff;
    font-size: 17px;
}
.color-color-scheme, .text-color-scheme {
    color: #ffffff !important;
}
.sidebar-dark .side-menu :not([class*="color-"]) > .list-icon, .sidebar-dark .side-menu .menu-item-has-children > a::before {
    color: #ffffff;
}
</style>

<?php 

$profile_data = isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'")) : '';

$user = isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT count('id') as xyz FROM products WHERE user_id ='".$_SESSION['login']."'and status=0")) : '';
//$user = count('id') ;
//print_r($user);

$product_type = isset($_SESSION['login']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM merchant_subscription WHERE user_id='".$_SESSION['login']."'")) : '';
?>

<style>
.side-menu .menu-item-has-children > a::before {
    font-family: FontAwesome;
    content: "\f0d7";
    position: absolute;
    right: 0.83333em;
    top: 0;
    font-size: 1.2em;
    color: #ccc;
}
.investor_relation i{
    color: yellow;
    font-size: 10px;
    position: absolute;
    top: 12px;
}

</style>

<aside class="site-sidebar scrollbar-enabled clearfix ps " data-ps-id="d59dfc42-2cc7-c0b1-cf68-87ad01c4613d">
<!-- User Details -->
<div class="side-user">
<a class="col-sm-12 media clearfix">
<div class="media-body hide-menu"> 
<?php if(isset($_SESSION['login'])) {?>
	<h4 class="media-heading mr-b-5 text-uppercase"><?php echo $profile_data['name']; ?></h4><span class="user-type fs-12"><?php echo $profile_data['email']; ?></span>
	<h4 class="media-heading mr-b-5 text-uppercase">Referral Id :</h4><span class="user-type fs-12"><?php echo $profile_data['referral_id']; ?></span>
<?php }?>
</div>
</a>
<div class="clearfix"></div>
</div>
<!-- /.side-user -->
<!-- Sidebar Menu -->
<nav class="sidebar-nav">
<?php
if(false){  //@isset($_SESSION['IsVIP']
    
    $mar_id = $_SESSION['merchant_id'] ;
    $merchant_detail = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$mar_id."'"));
?>
    <div class="box-left" style="width:100%">
		<div class="pro-pic"><a href="#"> <img src="<?php echo $merchant_detail['image'] ?>"> </a> </div>
		<div class="pic-text"><?php echo $merchant_detail['name'] ?> <br> <span> <?php echo $merchant_detail['referral_id'] ?></span> </div> 
		
		<div class="text-menu"> 
			<ul>
				<li> <a href="dashboard.php"> <?php echo $language["dashboard"] ?> <span> <img src="new/images/dashboard.png">  </span> </a> </li> 
				<li> <a href="merchant_find.php"><?php echo $language["find_merchant"];?> <span> <img src="new/images/home.png">  </span> </a></li> 
				<li> <a href="contact.php"><?php echo $language['contact'];?> <span> <img src="new/images/mail-side.png">  </span>  </a></li>
				<li>  <a href="https://www.koofamilies.com/chat.php" target="_new"><?php echo $language["my_community"];?> <span> <img src="new/images/people.png">  </span> </a> </li> 
				<li> <a href="logout.php"><?php echo $language['log_out'];?><span> <img src="new/images/signout.png">  </span>  </a></li>
			</ul> 
		</div> 
	</div>
<?php 
}else{
  ?>  
<ul class="nav in side-menu">
		<li><a href="dashboard.php"><span class="hide-menu"><?php echo $language["dashboard"] ?></span></a>
		        <?php 
        if( isset($profile_data['user_roles']) && $profile_data['user_roles'] !=  '') { ?>
		<!--<li class="menu-item-has-children">
			<a href="javascript:void(0);" class="ripple"><span class="color-color-scheme"><span class="hide-menu"><?php echo $language['wallet'];?></span></span></a>
			<ul class="list-unstyled sub-menu collapse" aria-expanded="true">
				<li><a href="wallet.php">Recharge</a></li>
				<li><a href="wallet_history.php">History</a></li>
			</ul>
        </li>
     
		<li class="menu-item-has-children">
			<a href="javascript:void(0);" class="ripple"><span class="color-color-scheme"><span class="hide-menu"><?php echo $language['transfer'];?></span></span></a>
			<ul class="list-unstyled sub-menu collapse" aria-expanded="true">
				<li><a href="receive.php">Receive</a></li>
				<li><a href="send.php">Send</a></li>
				<li><a href="transaction_history.php">History</a></li>
			</ul>
        </li>-->
        <?php } ?>
			<?php 
			if(isset($profile_data['user_roles']) && $profile_data['user_roles'] ==  '2') { ?>
			<li class="menu-item-has-children">
			<a href="merchant_product.php"><span class="hide-menu"><?php echo $language['merchant'];?></span></a>
			<ul class="list-unstyled sub-menu collapse" aria-expanded="true">
			<li><a href="orderview.php">Order list</a></li> 
			<li><a href="report.php">Report</a></li> 
			<?php 

			$check = $user['xyz'];

			$value = $product_type['type'] != "" ? 10000 + 10 : '10';

			if($check  <  $value) 
			{ ?>

			<li><a href="merchant_product.php">Add Product</a></li>

			<?php 
			}

            else

             {
	
             }

        ?>   
				 
				<li><a href="view_product.php">View Product</a></li>
				
				  <?php 
        if(isset($profile_data['user_roles']) && $profile_data['user_roles'] ==  '2') { 
			if(!empty($product_type['type']))
			{?>
		
        <li class="menu-item-has-children">
			<a href="javascript:void(0);" class="ripple"><span class="color-color-scheme"><span class="hide-menu">Category</span></span></a>
			<ul class="list-unstyled sub-menu collapse" aria-expanded="true">
				<li><a href="add_category.php">Add Category</a></li>
				<li><a href="add_mater_category.php">Add Master</a></li>
				<li><a href="view_category.php">View Category</a></li>
			</ul>
        </li>
        <?php } 
        }?>
				 <li><a href="sub.php"><span class="hide-menu">Subscription</span></a></li>
				 <li><a href="about_us.php"><span class="hide-menu">About Us</span></a></li>
<!--
				 <li><a href="rating.php"><span class="hide-menu">Rating</span></a></li>
-->
			</ul>
        </li>
        
        

        <?php } ?>
        
       <!--chat/chat.php?sender=<?php echo $_SESSION['login'];?>!-->
        
        <li><a href="https://www.koofamilies.com/chat.php" target="_new"><span class="hide-menu"><?php echo $language["my_community"];?></span></a></li>
         
	   <?php 
        if(isset($profile_data['user_roles']) && $profile_data['user_roles'] !=  '2') { ?>
     
<!--
       <li><a href="merchant_list.php"><span class="hide-menu">Merchant list</span></a></li>
-->
       
       <li class="menu-item-has-children">
			<a href="javascript:void(0);" class="ripple"><span class="color-color-scheme"><span class="hide-menu"><?php echo $language['merchant'];?></span></span></a>
			<ul class="list-unstyled sub-menu collapse" aria-expanded="true">
				<li><a href="merchant_find.php"><?php echo $language["find_merchant"];?></a></li>
				<?php if( isset($profile_data['user_roles']) && $profile_data['user_roles'] !=  '') { ?>
				<li><a href="orderlist.php"><?php echo $language['list_order_payment'];?></a></li>
				<?php } else { ?>
				<li><a href="order_guest.php"><?php echo $language['list_order_payment'];?></a></li> <?php }?>
			</ul>
        </li>
       
       
       
       <?php }  if( isset($profile_data['user_roles']) && $profile_data['user_roles'] !=  '') {?> 
		<!--<li class="menu-item-has-children">
			<a href="javascript:void(0);" class="ripple"><span class="color-color-scheme"><span class="hide-menu"><?php echo $language['withdrawal'];?></span></span></a>
			<ul class="list-unstyled sub-menu collapse" aria-expanded="true">
				<li><a href="request.php">Request</a></li>
				<li><a href="request_history.php">History</a></li>
			</ul>
        </li>-->
        <li><a href="referral_list.php"><span class="hide-menu"><?php echo $language['referral_list'];?></span></a> </li>
        <?php  }
        if(isset($profile_data['user_roles']) && $profile_data['user_roles'] !=  '') { ?>
		    <li><a href="kType.php"><span class="hide-menu">K Type</span></a></li>
			  
        <?php } ?>
        <?php if(isset($profile_data['user_roles']) && $profile_data['user_roles'] ==  '1') { ?>
		    <li><a href="profile.php"><span class="hide-menu"><?php echo $language['profile'];?></span></a></li>
        <?php } ?>
        <?php  if(isset($profile_data['user_roles']) && $profile_data['user_roles'] ==  '2') { ?>
		
		<li>
        	<a href="sections.php"><?php echo $language['sections'];?></a>
        </li>
		<li><a href="profile_merchant.php"><span class="hide-menu"><?php echo $language['profile'];?></span></a></li>
<?php } ?>
        <li><a href="investor_relations.php" class="investor_relation"><span class="hide-menu"><?php echo $language['investor_relations'];?></span><i class='fa fa-star' style="color:yellow;"></i></a></li>
		<li><a href="contact.php"><span class="hide-menu"><?php echo $language['contact'];?></span></a></li>
		<li><a href="logout.php"><span class="hide-menu"><?php echo $language['log_out'];?></span></a></li>
    </ul>
    <!-- /.side-menu -->
<?php    
}
?>	
	
</nav>
<!-- /.sidebar-nav -->
<div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;">
    <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
</div>
<div class="ps__scrollbar-y-rail" style="top: 0px; height: 523px; right: 0px;">
    <div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 271px;"></div></div></aside>

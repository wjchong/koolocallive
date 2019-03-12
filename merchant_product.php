<?php 
include("config.php");

if(!isset($_SESSION['login']))
{
	header("location:login.php");
}
$bank_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'"));
 $current_id = $bank_data['id'];

	$total_rows = mysqli_query($conn, "SELECT * FROM category WHERE user_id ='".$_SESSION['login']."' and status=0");


if(isset($_POST['submit']))
{
	
		//~ $currentDir = getcwd();
	    //~ $uploadDirectory = "koofamilies.com/images/product_images/";
		$productname = addslashes($_POST['productname']);
		$category = addslashes($_POST['category']);
		$product_type = addslashes($_POST['product_type']);
		$product_price = addslashes($_POST['product_price']);
		$remark = addslashes($_POST['product_remark']);
		$print_ip_address=$_POST['print_ip_address'];
		$image = $_FILES["image_pic"]["name"];	
		$code = $_FILES["code_pic"]["name"];
     
     if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["image_pic"]) && $_FILES["image_pic"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg","JPEG" => "image/JPEG", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image_pic"]["name"];
        $filetype = $_FILES["image_pic"]["type"];
        $filesize = $_FILES["image_pic"]["size"];
        
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        //~ $maxsize = 5 * 1024 * 1024;
        //~ if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $_FILES["image_pic"]["name"])){
                echo $_FILES["image_pic"]["name"] . " is already exists.";
            } else{
                move_uploaded_file($_FILES["image_pic"]["tmp_name"], "/home/koofamilies/public_html/images/product_images/" . $_FILES["image_pic"]["name"]);
               // echo "Your file was uploaded successfully.";
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    }
    if(isset($_FILES["code_pic"]) && $_FILES["code_pic"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg","JPEG" => "image/JPEG", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["code_pic"]["name"];
        $filetype = $_FILES["code_pic"]["type"];
        $filesize = $_FILES["code_pic"]["size"];
        
        
   
        
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        //~ $maxsize = 5 * 1024 * 1024;
        //~ if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $_FILES["code_pic"]["name"])){
                echo $_FILES["code_pic"]["name"] . " is already exists.";
            } else{
                move_uploaded_file($_FILES["code_pic"]["tmp_name"], "/home/koofamilies/public_html/images/product_images/" . $_FILES["code_pic"]["name"]);
               // echo "Your file was uploaded successfully.";
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } 
}
       
      $current_date= date("Y/m/d");  
	  
	mysqli_query($conn, "INSERT INTO products SET product_name='$productname',user_id='$current_id', category='$category', product_type='$product_type',product_price='$product_price', remark = '$remark', image='$image', code='$code',created_date='$current_date',print_ip_address='$print_ip_address'");

}
?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
    <?php include("includes1/head.php"); ?>
	<style>
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
	</style>
</head>

<body class="header-light sidebar-dark sidebar-expand pace-done">

    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

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
					<div class="container">
					<?php
						if(isset($error))
						{
							echo "<div class='alert alert-info'>".$error."</div>";
						}
					?>
					</div>
					<div class="container" >
					    <div class="row">
					        <div class="well col-md-10">
							<form method="post" method="post" enctype="multipart/form-data">
								<div class="panel price panel-red">
									<h2>Product Details</h2>
									<br><br>
									<div class="form-group">
										<label>Product Name</label>
										<input type="text" name="productname" maxlength="35" class="form-control" value="" required>
									</div>
								<?php	if(!empty($product_type['type']))
			{?>
									<div class="form-group">
										<label>Category</label>
<!--
										<input type="text" name="category"  value="" required>
-->
										
										<select  name="category" class="form-control">
									
											<?php 
										while ($row=mysqli_fetch_assoc($total_rows))
	{                                   $category = str_replace(' ', '-', $row["category_name"]);?>
								 <option value="<?php echo $category;?>"><?php echo $row["category_name"];?></option>
								 <br>
							<?php }
								?>
										</select>
									</div>
									<?php } ?>
									<div class="form-group">
										<label>Product Code</label>
										<input type="text" name="product_type" class="form-control" value="" >
									</div>
									<div class="form-group">
										<label>Print Ip address</label>
										<input type="text" name="print_ip_address" class="form-control" value="" >
									</div>

									<div class="form-group">
										<label>Remark</label>
										<input type="text" name="product_remark" class="form-control" value="" >
									</div>

									<div class="form-group">
										<label>Image</label><br>
										<input type="file" name="image_pic">
									</div>
									<div class="form-group">
										<label>Picture Code</label><br>
										<input type="file" name="code_pic">
									</div>
									<br>
									<input type="submit" class="btn btn-block btn-primary" name="submit" value="Submit">
								</div>
							</form>
						</div>
						
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

</html>
<style>
select {
    height: 30px;
}
</style>

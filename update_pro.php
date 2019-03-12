<?php
include("config.php");
//~ print_r($_POST); 
//~ print_r($_FILES); 

 $id=$_POST['id'];
 $productname=$_POST['productname'];
 $category=$_POST['category'];
 $product_type=$_POST['product_type'];
 $product_price=$_POST['product_price'];
 $print_ip_address=$_POST['print_ip_address'];
 $remark=$_POST['remark'];
 if($category)
 {
	$categories = mysqli_query($conn, "SELECT id FROM category WHERE category_name ='".$category."'");
	$categoryrow=mysqli_fetch_assoc($categories);
	$category_id=$categoryrow['id'];
 }
 	$image_pic =  $_FILES["image_pic"]["name"] != '' ? $_FILES["image_pic"]["name"] : $_POST['img']; 
    $image_code =  $_FILES["image_code"]["name"] != '' ? $_FILES["image_code"]["name"] : $_POST['img_code']; 
 
 //~ $image_pic=$_FILES["image_pic"]["name"]; 
  
//~ mysqli_query($conn,"UPDATE products SET product_name='$productname', category='$category', product_type='$product_type' image='$image_pic' WHERE id='$id'");
 
 $tt = mysqli_query($conn,"UPDATE `products` SET `product_name`='$productname', category='$category' , product_type='$product_type', product_price='$product_price',print_ip_address='$print_ip_address',remark = '$remark', image='$image_pic', code='$image_code',category_id='$category_id' WHERE `id`=$id");

//~ mysqli_query($conn,"UPDATE `products` SET `product_name`='ytyt',`category`='yty',`product_type`='tyt',`image`='yyytytyh.png' WHERE `id` = 4");
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

    if(isset($_FILES["image_code"]) && $_FILES["image_code"]["error"] == 0){
		
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg","JPEG" => "image/JPEG", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image_code"]["name"];
        $filetype = $_FILES["image_code"]["type"];
        $filesize = $_FILES["image_code"]["size"];
        

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        //~ $maxsize = 5 * 1024 * 1024;
        //~ if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("upload/" . $_FILES["image_code"]["name"])){
                echo $_FILES["image_code"]["name"] . " is already exists.";
            } else{
                move_uploaded_file($_FILES["image_code"]["tmp_name"], "/home/koofamilies/public_html/images/product_images/" . $_FILES["image_code"]["name"]);
               // echo "Your file was uploaded successfully.";
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } 

?>

<?php 
include("config.php");

$categories = mysqli_query($conn, "SELECT * FROM category WHERE user_id ='".$_SESSION['login']."' and status=0");

//~ $total_rows = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='".$_SESSION['login']."'"));
//$bank_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION['login']."'"));
// $current_id = $bank_data['id'];
	$total_rows = mysqli_query($conn, "SELECT * FROM products WHERE user_id ='".$_SESSION['login']."' and status=0");
 

?>

<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
<style>
.pagination {
  display: inline-block;
  padding-left: 0;
  margin: 20px 0;
  border-radius: 4px;
 }
 td.pop_up {
    cursor: pointer;
}
td.del {
    cursor: pointer;
}
 .pagination>li {
  display: inline;
 }
 .pagination>li:first-child>a, .pagination>li:first-child>span {
  margin-left: 0;
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
 }
 .pagination>li:last-child>a, .pagination>li:last-child>span {
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
 }
 .pagination>li>a, .pagination>li>span {
  position: relative;
  float: left;
  padding: 6px 12px;
  margin-left: -1px;
  line-height: 1.42857143;
  color: #337ab7;
  text-decoration: none;
  background-color: #fff;
  border: 1px solid #ddd;
 }
 .pagination a {
  text-decoration: none !important;
 }
 .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
  z-index: 3;
  color: #fff;
  cursor: default;
  background-color: #337ab7;
  border-color: #337ab7;
 }
 img.test_st {
    margin-right: 12px;
    margin-bottom: 12px;
}
</style>
 
    <?php include("includes1/head.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#searchbox1 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
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
                    <br /><br />
                    <input type="text" name="stext" value="" id="myInput" placeholder="Search category" class="form-control">
                    <br />
	<table class="table table-striped">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Category</th>
		    <th>Product Code</th>
		    <th>Product Price</th>
		    <th>Printer Ip Address</th>
	  	  <th>Remark</th>
        <th>Image</th>
        <th>Code</th>
        <th>Action</th>
      </tr>
    </thead>
	  <tbody id='searchbox1'>
	<?php
  
	while ($row=mysqli_fetch_assoc($total_rows)){
	?>
  
      <tr>
       <!-- <td class="name" data-id=<?php //echo $row['id']; ?> style="cursor:pointer;"><?php //echo $row['name'];  ?></td> -->

         <!--<td class='status' name='status' onchange="update_product('<?php //echo $row['id'];?>')"></td>-->
        <td><?php echo $row['product_name'];  ?></td>
		   <td><?php echo $row['category'];  ?></td>
		  <td><?php echo $row['product_type'];  ?></td>
		  <td><?php echo $row['product_price'];  ?></td>
		  <td><?php echo $row['print_ip_address'];  ?></td>
		  <td><?php //echo $row['remark'];  ?></td>
		  
      <?php
      if(!empty($row['image']))
      { ?>
              <td><img src="<?php echo $site_url; ?>/images/product_images/<?php echo $row['image'];  ?>" width="50" height="50" ></td>  

    <?php  } 
    else
    { ?>
       <td>       <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg" width="50" height="50" >
</td>

   <?php }
      ?>
      <?php
      if(!empty($row['image']))
      { ?>
              <td><img src="<?php echo $site_url; ?>/images/product_images/<?php echo $row['code'];  ?>" width="50" height="50" ></td>  

    <?php  } 
    else
    { ?>
       <td>       <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg" width="50" height="50" >
</td>

   <?php }
      ?>
      <td class="pop_up" data-id="<?php echo $row['id']; ?>">Edit</td>  
      <td class="sub_product" data-del="<?php echo $row['id']; ?>"><a href="<?php echo $site_url; ?>/sub_product.php?p_id=<?php echo $row['id']; ?>">Product Varieties</a></td>
      <td class="del" data-del="<?php echo $row['id']; ?>">Delete</td>
      </tr>
	  
      <?php
	}
	  ?>
	  
    </tbody>
  </table>
  
  <div style="margin:0px auto;">
 <ul class="pagination">
 <?php
 global $total_page_num ;
   for($i = 1; $i <= $total_page_num; $i++)
   {
    if($i == $page)
    {
     $active = "class='active'";
    }
    else
    {
     $active = "";
    }
    echo "<li $active><a href='?page=$i'>$i</a></li>";
   }
 ?>
 </ul>
</div>
<div>
	 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Product</h4>
        </div>
        <div class="modal-body" style="padding-bottom:0px;">
        
		 <div class="col-sm-10">
      <form id ="data">
      <div class="form-group">
      <label>Product Name</label>
		 	<input type="text" name="productname" id = "product_name" class="form-control" value="" required>
       <input type="hidden" id="id" name="id" value=""> 
      </div>
      <div class="form-group">
      <label>Category</label>
      <select  name="category" class="form-control" id="category">
		<?php while ($row=mysqli_fetch_assoc($categories)){   
		    $category = str_replace(' ', '-', $row["category_name"]);?>
		<option value="<?php echo $category;?>"><?php echo $row["category_name"];?></option>
		<br>
		<?php }?>
	   </select>
      </div>
      <div class="form-group">
      <label>Product Code</label>
    	<input type="text" name="product_type" id = "product_type" class="form-control" value="" required>
      </div>
	    <div class="form-group">
      <label>Print Ip Address</label>
    	<input type="text" name="print_ip_address" id = "print_ip_address" class="form-control">
      </div>
      <div class="form-group">
      <label>Product Price</label>  
    	<input type="text" name="product_price" id = "product_price" class="form-control" value="" required>
      </div>
      <div class="form-group">
      <label>Remark </label>
    	<input type="text" name="remark" id = "remark" class="form-control" value="">
      </div>
      
      <div class="form-group">
	    <label>Select Image</label><br>
	    <div id ="picture"></div>
	    <input type="file" class="save" name="image_pic"  onclick="save_pic()">
       <input type="hidden" id="img" name="img" value=""> 

		</div>
        <div class="form-group">
          <label>Select Code</label><br>
          <div id ="picture_code"></div>
          <input type="file" class="save" name="image_code"  onclick="save_pic()">
          <input type="hidden" id="img_code" name="img_code" value="">
      </div>
        </div>
		</div>
        <div class="modal-footer" style="padding-bottom:2px;">
			<button>Submit</button>
<!--
          <button type="submit" class="btn btn-default" data-dismiss="modal" id ="update" onclick="submitmodal()">submit</button>
-->
        </div>
      </form>
      </div>
  
 <div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="modalcontent">
       <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
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
	
	<script>
	$("form#data").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: 'update_pro.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            //~ alert(data)
             location.reload();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


  $(".pop_up").click(function(){
	  $("#myModal").modal("show");
	  var userid=$(this).data("id");
	   //target:'#picture';

	  $.ajax({
		  
		  url :'update_product.php',
		  type:'POST',
      dataType : 'json',
      data:{showid:userid},
		  success:function(response){
      console.log(response.id);
      //alert(response.id);
      $("#id").val(response.id);
      $("#product_name").val(response.product_name);
      $("#category").val(response.category);
      $("#product_type").val(response.product_type);
      $("#product_price").val(response.product_price);
      $("#print_ip_address").val(response.print_ip_address);
      $("#remark").val(response.remark);
      $("#img").val(response.image);
      $("#img_code").val(response.img_code);
      $("#picture").html("");
      $("#picture_code").html("");
       $("#picture").append('<img src="<?php echo $site_url; ?>/images/product_images/'+response.image+' " width="50" height="50"  class="test_st">');
       $("#picture_code").append('<img src="<?php echo $site_url; ?>/images/product_images/'+response.code+' " width="50" height="50"  class="test_st">');
      //$("#picture").val(response.image);
      console.log(response);
          
		  }		  
	  });
	 
  });

function submitmodal(){

$('#update').on('click', function() {
     form = jQuery("#form").serialize();

      var image =$(this).data("picture");
       //~ alert(image);
       //~ alert(form);
           $.ajax({
               url: 'update_pro.php',
               type: 'POST',
               data: form,
               data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)

        success: function(data) {
        console.log(data);
          }
           });
       });
}

  $('.del').click(function(){
    var id=$(this).data("del");
   $.ajax({
            url:'pro_delete.php',
           type:'POST',
            data:{userid:id},
            success: function(data) {
            location.reload();

         }
        
        });
    });
 
    $('.save').click(function(){
     var id = $(this).data("save_pic")
      
    });



	</script>
</body>

</html>

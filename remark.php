<?php 
include("config.php");

if(!isset($_SESSION['login']))
{
	header("location:login.php");
}

if(isset($_POST['update_ingredients'])){
	
	$words = $_POST['update_ingredients'];
	$id = $_SESSION['login'];
	if(!mysqli_query($conn,"UPDATE users SET preset_words='$words' WHERE id='$id'")){
		die(false);
	}
	die(true);
}

function loadIngredients($id){
	global $conn;
	
	$q = mysqli_query($conn,"SELECT preset_words FROM users WHERE id='$id'");
	if(!$q){die(false);}
	$data = mysqli_fetch_row($q);
	$ingredients = explode(",", $data[0]);
	foreach ($ingredients as $ingredient) {
		if(!empty($ingredient)){
			?>
			<div class="ingredient">
				<button type="button" class="btn btn-info remove-ingredient" aria-label="Close"><span aria-hidden="true">×</span></button>
				<span class="ingredient-name"><?php echo ucfirst(str_replace("_", " ", $ingredient)); ?></span>
				<input type="hidden" name="ingredient-name-input" value="<?php echo $ingredient; ?>"></div>
			<?php
		}
	}
	echo "<input type='hidden' name='ingredients' value='" . ((!empty($data[0])) ? $data[0] : '') . "'/>";
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
	.ingredient{
		border: 1px solid #03a9f3;
		color :#03a9f3;
		width: 95%;
		border-radius: 5px;
		padding: 3px;
		box-sizing: border-box;
		letter-spacing: 1px;
		margin: 8px 0;
		-webkit-touch-callout: none; 
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none; 
		-ms-user-select: none; 
		user-select: none;
	}
	.ingredient span:nth-child(even){
		padding-left: 10px;
		font-weight: bold;
	}
	#ingredients_container{
		display: grid;
		grid-template-columns: 1fr 1fr;
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
						
							<div class="form-group">
								<label>Ingredients</label><p style="color:#51d2b7;display:none;" class="tuto">Here you will see a preview of your keyword list.<br>You can introduce the keywords into the input down bellow, introduce one keyword by one or have them separated with commas.</p>
								<div id="ingredients_container">
									<?php loadIngredients($_SESSION['login']); ?>
								</div>
								<input type="text" name="new-ingredient" class="form-control" value="" style="margin:5px 0;" placeholder="Introduce the keywords. eg: More spice">
								<div id="add-ingredient" class="btn btn-outline-primary" >Add keyword</div>	<span class="tuto" style="color:#51d2b7;display:none;">To add the keyword into your temporal list click this button.</span>
							</div>
							<p style="color:#51d2b7;display:none;" class="tuto">
								Once you feel happy with your preview list, to update it to your actual list press the "Update remark list" button.
							</p>
							<button type="button" id="update-ingredients" class="btn btn-primary btn-lg btn-block">Update remark list</button>

						</div>
					</div>
					<div class="row">
				        <div class="well col-md-10">
				        	<label>Want to know how it works? <a href="#tutorial">Click here!</a></label>
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
<style type="text/css">
    .parent-category-menu {
        background-color: #fff;
        padding-top: 6px;
        padding-bottom: 6px;
        -webkit-box-shadow: 0px 3px 8px 0px rgba(82, 63, 105, 0.15);
        box-shadow: 0px 3px 8px 0px rgba(82, 63, 105, 0.15);
        position: relative;
    }
    .parent-category-menu a {
        padding: 8px 18px 8px 18px;
        display: inline-block;
        vertical-align: top;
        line-height: normal;
        font-size: 14px;
        color: #4a5368;
        font-weight: 600;
        background-color: transparent;
        border: 0px;
        box-shadow: none;
    }
    .merchant-layout-2 .sub_category_grid{
        background: #e9ebf1;
        margin-top: 0;
    }
    .merchant-layout-2 .sub_category_grid .category_filter{
        margin-right: 0px;
        width: 100%;
        border-bottom: 1px solid rgba(84, 92, 115, 0.14);
    }
    .merchant-layout-2 .sub_category_grid button{
        width: 100%;
        display: block;
        background-color: transparent;
        border: 0;
        color: #4a5368;
        border-radius: 0px;
        box-shadow: none;
        white-space: normal;
        text-align: left;
    }
    .merchant-layout-2 .text_add_cart{
        background-color: #50d2b7;
        width: 30px;
        height: 30px;
        font-size: 16px;
        border-radius: 100%;
        text-align: center;
        line-height: normal;
        padding: 6px 0 0 0;
        margin: 0;
        display: inline-block;
        vertical-align: top;
    }
    .merchant-layout-2 .common_quant{
        display: block;
        text-align: right;
    }
    .merchant-layout-2 .grid .grid-item{
        background-color: #ffffff;
        padding: 15px;
        -webkit-box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
        box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);
        margin-bottom: 15px;
    }
    @media (max-width: 767px) {
        .parent-category-menu a{
            padding: 8px 12px 8px 12px;
        }
        .main-wrapper {
            padding: 0 0 0 15px;
        }
        .merchant-layout-2 .sub_category_grid button {
            font-size: 12px;
        }
        .merchant-layout-2 .sub_category_grid .category_filter {
            padding: 6px 4px;
        }
        .merchant-layout-2 .grid .grid-item{
            padding: 8px;
        }
    }
    @media (max-width: 480px) and (min-width: 315px){
        .wrapper{
            width: 100%;
        }
    }
</style>
<?php
//$categories = mysqli_query($conn, "SELECT DISTINCT(products.category),created_date FROM products WHERE user_id ='".$id."' and status=0 ORDER BY created_date ASC");
$categories_q = mysqli_query($conn, "SELECT * FROM cat_mater WHERE UserID ='".$id."' and IsEnable=1 ");
if($product['pro_ct'] > 0) { ?>
    <div class="col-md-12 merchant-layout-2">
        <div class="filter-button-group parent-category-menu">
            <?php
            $index = 1;
            $category_a = mysqli_fetch_assoc($categories_q);
            $categories = explode(",",$category_a['CatName']);
            foreach ($categories as $category)
            {
                ?>
                <a href="#" class="master_category_filter" data-filter=".<?php echo str_replace(" ","-",$category);?>"><?php echo str_replace("-", " ", $category);?></a>
                <?php
                $index++;
            }
            $index = 1;
            ?>
        </div>
        <div class="row no-gutters">
            <div class="col-4 col-sm-3">
                <div class="sub_category_grid">
                    <?php
                    foreach ($categories as $category)
                    {
                        $sub_categories_q = mysqli_query($conn, "SELECT * FROM category WHERE user_id ='".$id."' and catparent='".$index."' and status=0 ");
                        while ($row = mysqli_fetch_assoc($sub_categories_q))
                        {
                            if($row['category_name'] == "") continue;
                            ?>
                            <div class="<?php echo str_replace(" ","-",$category);?> category_filter">
                                <button class="btn btn-primary" type="button" data-filter=".<?php echo str_replace(" ","-",$row['category_name']);?>"><?php echo str_replace("-", " ", $row['category_name']);?></button>
                            </div>
                        <?php }
                        $index++;
                    }
                    ?>

                    <?php
                    /*while ($row=mysqli_fetch_assoc($categories)){
                        if($row['category'] == "") continue;
                        if($index == 0) $category= $row['category'];
                        $index++;
                    ?>
                    <button class="btn btn-primary category_filter" type="button" data-filter=".<?php echo $row['category'];?>"><?php echo str_replace("-", " ", $row['category']);?></button>
                    <?php }
                    */
                    ?>
                </div>
            </div>
            <div class="col-8 col-sm-9 pl-2">
                <div class="grid">
                    <?php
                    while ($row=mysqli_fetch_assoc($total_rows)){
                        ?>
                        <?php   if(!empty($row['image'])) { ?>

                            <div class="element-item grid-item <?php echo $row['category'];?>" >
                                <form action="product_view.php" method="post" class= "set_calss" data-id = "<?php echo $row['id'] ?>" data-code = "<?php echo $row['product_type'] ?>"  data-pr = "<?php echo $row['product_price'] ?>">
                                    <div class="row no-gutters">
                                        <div class="col-5 col-sm-4">
                                            <div class="container_test"> <?php
                                                if(!empty($row['image']))
                                                { ?>

                                                    <img src="<?php echo $site_url; ?>/images/product_images/<?php echo $row['image'];  ?>" class="img-fluid" >
                                                    </a>


                                                <?php  }
                                                else
                                                { ?>
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg" width="100%" height="150px" class="make_bigger">
                                                <?php }
                                                ?></div>
                                        </div>
                                        <div class="col-7 col-sm-8 pl-2">
                                            <input type="hidden" id="id" name="m_id" value="<?php echo $id;?>">
                                            <input type="hidden" id="id" name="p_id" value="<?php echo $row['id'];?>">
                                            <p class="mBt10"><strong><?php echo $row['product_name']; ?></strong></p>
                                            <p class="mBt10"><?php echo 'Code: '.$row['product_type']; ?></p>
                                            <p class="mBt10"><?php echo $row['remark']; ?></p>
                                            <!--	<p><?php echo 'Category : '.str_replace("-", " ", $row['category']); ?></p>-->
                                            <p class="mBt10"><?php echo 'Price : Rm'.number_format($row['product_price'],2); ?></p>
                                            <div class="common_quant">
                                                <p class="text_add_cart"  data-id = "<?php echo $row['id'] ?>" data-code = "<?php echo $row['product_type'] ?>"  data-pr = "<?php echo $row['product_price'] ?>" data-name = "<?php echo $row['product_name'] ?>"><i class="fa fa-plus"></i></p>
                                                <p class="quantity">
                                                    <input type="hidden" value="1" class="quatity" name="quatity">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php  } } ?>
                </div>
            </div>
        </div>

    </div>

    <?php
}
?>
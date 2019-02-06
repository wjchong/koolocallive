<?php
//$categories = mysqli_query($conn, "SELECT DISTINCT(products.category),created_date FROM products WHERE user_id ='".$id."' and status=0 ORDER BY created_date ASC");
$categories_q = mysqli_query($conn, "SELECT * FROM cat_mater WHERE UserID ='".$id."' and IsEnable=1 ");
if($product['pro_ct'] > 0) { ?>
    <div class="col-md-12 filter-button-group">
        <?php
        $index = 1;
        $category_a = mysqli_fetch_assoc($categories_q);
        $categories = explode(",",$category_a['CatName']);
        foreach ($categories as $category)
        {
            ?>
            <button class="btn btn-primary master_category_filter" type="button" data-filter=".<?php echo str_replace(" ","-",$category);?>"><?php echo str_replace("-", " ", $category);?></button>
            <?php
            $index++;
        }
        $index = 1;
        ?>
    </div>
    <div class="col-md-12">
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


    <div class="grid row">


        <?php
        while ($row=mysqli_fetch_assoc($total_rows)){
            ?>
            <?php   if(!empty($row['image'])) { ?>

                <div class="well col-md-4 element-item <?php echo $row['category'];?>" >
                    <form action="product_view.php" method="post" class= "set_calss" data-id = "<?php echo $row['id'] ?>" data-code = "<?php echo $row['product_type'] ?>"  data-pr = "<?php echo $row['product_price'] ?>" style="background: #51d2b7;    padding: 12px;    border: 1px solid #e3e3e3;    border-radius: 4px;    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05); box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">
                        <div class="container_test"> <?php
                            if(!empty($row['image']))
                            { ?>

                                <img src="<?php echo $site_url; ?>/images/product_images/<?php echo $row['image'];  ?>" width="100%" height="150px" class="make_bigger">
                                </a>


                            <?php  }
                            else
                            { ?>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg" width="100%" height="150px" class="make_bigger">
                            <?php }
                            ?></div>
                        <input type="hidden" id="id" name="m_id" value="<?php echo $id;?>">
                        <input type="hidden" id="id" name="p_id" value="<?php echo $row['id'];?>">

                        <p class ="pro_name"><?php echo $row['product_name']; ?></p>
                        <p class="mBt10"><?php echo 'Code: '.$row['product_type']; ?></p>
                        <p class="mBt10"><?php echo $row['remark']; ?></p>
                        <!--	<p><?php echo 'Category : '.str_replace("-", " ", $row['category']); ?></p>-->
                        <p class="mBt10"></p><?php echo 'Price : Rm'.number_format($row['product_price'],2); ?></p>
                        <!--
                    <p ><?php //echo 'Remark : '.$row['remark']; ?></p>
                    -->
                        <!--
                        <p class="quantity">
                        <label>Quantity</label>
                        <input type="text" class="quatity" name="quatity">
                        </p>
                        -->
                        <div class="common_quant">
                            <p class="text_add_cart"  data-id = "<?php echo $row['id'] ?>" data-code = "<?php echo $row['product_type'] ?>"  data-pr = "<?php echo $row['product_price'] ?>" data-name = "<?php echo $row['product_name'] ?>">Add to Cart</p>
                            <p class="quantity">
                                <!--
                                <label>Quantity</label>
                                -->
                                <label>X</label>
                                <input type="number" value="1" class="quatity" name="quatity">
                            </p>
                        </div>

                    </form>
                </div>


            <?php  } } ?>
    </div>
    <?php
}
?>
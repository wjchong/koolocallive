<?php

session_start();
include("config.php");
if($_SESSION['login']=='')
{
    header('Location: '. $site_url .'/login.php');
    die;
}

$total_rows = mysqli_query($conn, "SELECT order_list.*, users.mobile_number FROM order_list inner join users on order_list.user_id = users.id WHERE merchant_id ='".$_SESSION['login']."' ORDER BY `created_on` DESC");

require_once ("languages/".$_SESSION["langfile"].".php");
?>
<!DOCTYPE html>
<html lang="en" style="" class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

<head>
    <style>
        .no-close .ui-dialog-titlebar-close {
            display: none;
        }
        .test_product{
            padding-right: 125px!important;
        }
        td.products_namess {
            text-transform: lowercase;
        }
        tr {
            border-bottom: 2px solid #efefef;
        }
        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        }
        td {
            border-right: 1px solid #efefef;
        }
        th {
            border-right: 1px solid #efefef;
        }
        tr.fdfd {
            border-bottom: 3px double #000;
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
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
        tr.red {
            color: red;
        }
        label.status {
            cursor: pointer;
        }
        td {
            border-right: 2px solid #efefef;
        }
        th {
            border-right: 2px solid #efefef;
        }
        .gr{
            color:green;
        }
        .or{
            color: orange !important;
        }
        .red.gr{
            color:green;
        }
        .product_name{
            width: 100%;
        }
        .total_order{
            font-weight:bold;
        }
        p.pop_upss {
            display: inline-block;
        }
        .location_head{
            width:200px;
        }
        .new_tablee {
            width: 200px!important;
            display: block;
            word-break: break-word;
        }
        td.test_productss {
            white-space: nowrap;
            /*width: 200px!important;*/
            display: block;
        }
        th.product_name.test_product {
            width: 200px!important;
        }

        @media only screen and (max-width: 600px) and (min-width: 300px){
            table.table.table-striped {
                white-space: unset!important;
            }


    </style>

    <?php include("includes1/head.php"); ?>
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
                <div class="well">
                    <div>
                        <h3><?php echo $language['order_list'];?></h3>
                        <span style="cursor: pointer; color: #ff0000; font-size: 40px;" id="scan_order"><?php echo $language['scan_order'];?></span>
                    </div>
                    <?php
                    $dt = new DateTime();
                    $today =  $dt->format('Y-m-d');
                    ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?php echo $language["items"];?></th>
                            <th><?php echo $language["date_of_order"];?></th>
                            <th>Username</th>
                            <th><?php echo $language["status"];?></th>
                            <th>Kitchen</th>
                            <th>Receipt</th>
                            <th><?php echo $language["chat"];?></th>
                            <th>Invoice</th>
                            <th><?php echo $language["table_number"];?></th>
                            <th><?php echo $language["product_code"];?></th>
                            <th class="product_name test_product"><?php echo $language["product_name"];?></th>
                            <th class="product_name test_product"><?php echo $language["remark"];?></th>
                            <th><?php echo $language["quantity"];?></th>
                            <th>Price</th>
                            <th><?php echo $language["amount"];?></th>
                            <th><?php echo $language["total"];?></th>
                            <th><?php echo $language["mode_of_payment"];?></th>
                            <th class="location_head"><?php echo $language["location"];?></th>
                            <th>Phone</th>
                            <th>Delivery <br> Service</th>
                            <th><?php echo $language["print"];?></th>
                            <th>K1/K2</th>
                        </tr>
                        </thead>
                        <?php
                        $i =1;

                        while ($row=mysqli_fetch_assoc($total_rows)){
                        $product_ids = explode(",",$row['product_id']);
                        $quantity_ids = explode(",",$row['quantity']);
                        $amount_val = explode(",",$row['amount']);
                        $product_code = explode(",",$row['product_code']);
                        $amount_data = array_combine($product_ids, $amount_val);
                        $total_data = array_combine($quantity_ids, $amount_val);

                        $created =$row['created_on'];
                        $remark_ids = explode("|",$row['remark']);
                        $new_time = explode(" ",$created);
                        //$c = array_combine($product_ids, $quantity_ids);
                        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$row['product_id']."'"));

                        $user_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$row['user_id']."'"));

                        $id_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$row['id']."'"));

                        $merchant_name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$row['merchant_id']."'"));
                        $date=date_create($created);
                        ?>
                        <tbody>
                        <?php
                        if($row['status'] == 1) $callss = "gr";
                        else if($row['status'] == 2) $callss = "or";
                        else $callss = " ";
                        $todayorder = $today == $new_time[0] ? "red" : "";

                        $i1 =1;  ?>
                        <tr class="<?php echo $todayorder; ?> fdfd <?php echo $callss; ?>" data-id="<?php echo $row['id']; ?>">
                            <input type="hidden" class="merchant_<?php echo $row['id'];?>" value="<?php echo $merchant_name['name'];?>">
                            <input type="hidden" class="userphone_<?php echo $row['id'];?>" value="<?php echo $user_name['mobile_number'];?>" >
                            <input type="hidden" class="merchantphone_<?php echo $row['id'];?>" value="<?php echo $merchant_name['mobile_number'];?>" >
                            <input type="hidden" class="merchantaddress_<?php echo $row['id'];?>" value="<?php echo $merchant_name['google_map'];?>" >
                            <td><?php echo  $i ?></td>
                            <td><?php echo date_format($date,"m/d/Y");  ?>
                                <?php echo '<br>'; echo $new_time[1] ?>
                            </td>
                            <td class="username_<?php echo $row['id'];?>"><?php echo $user_name['name']; ?></td>
                            <td>
                                <?php
                                if($row['status'] == 0) $sta = "Pending";
                                else if($row['status'] == 1) $sta = "Done";
                                else $sta = "Accepted";
                                ?>
                                <label class= "status" status="<?php echo $row['status'];?>" data-id="<?php echo $row['id']; ?>"> <?php echo $sta; ?></label>
                            </td>
                            <td>
                                <?php if($row['status'] == 2){?>
                                    <a target="_blank" href="print_kitchen.php?id=<?php echo $row['id'];?>&merchant=<?php echo $_SESSION['login']?>">Print</a>
                                <?php }?>
                            </td>
                            <td>
                                <a class="print-order" href="#" data-id="<?php echo $row['id']; ?>" data-invoice="<?php echo $row['invoice_no']; ?>">Print Receipt</a>
                            </td>
                            <td><a target="_blank" href="<?php echo $site_url; ?>/chat/chat.php?sender=<?php echo $_SESSION['login']?>&receiver=<?php echo $row['user_id'];?>"><i class="fa fa-comments-o" style="font-size:25px;"></i></a></td>
                            <td><a target="_blank" href="print.php?id=<?php echo $row['id'];?>&merchant=<?php echo $_SESSION['login']?>">Print</a></td>
                            <td class="table_number_<?php echo $row['id']?>"><?php echo $row['table_type'];?></td>
                            <td>
                                <?php
                                foreach ($product_code as $key)
                                {
                                    echo $key.'<br>'; }
                                ?>
                            </td>
                            <td class="products_namess product_name_<?php echo $row['id'];?> test_productss" ><?php foreach ($product_ids as $key )
                                {
                                    if(is_numeric($key))
                                    {
                                        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$key."'"));

                                        echo $product['product_name'].'<br>';
                                    }
                                    else
                                    {
                                        echo $key.'<br>';
                                    }
                                }
                                ?>
                            </td>
                            <td><?php   foreach ($remark_ids as $vall)
                                {

                                    echo $vall.'<br>';

                                } ?></td>
                            <td class="quantity_<?php echo $row['id'];?>"><?php
                                foreach ($quantity_ids as $key)
                                {
                                    echo $key;
                                    echo '<br>';
                                }
                                ?></td>
                            <td>
                                <?php
                                foreach ($amount_val as $key => $value){
                                    echo $value.'<br>';
                                }
                                ?>
                            </td>
                            <td class="amount_<?php echo $row['id'];?>">
                                <?php
                                $q_id = 0;
                                foreach ($amount_val as $key => $value){
                                    $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id ='".$key."'"));
                                    if($value == '0') { ?>
                                        <p class="pop_upss" data-id="<?php echo $row['id']; ?>"  style='margin-bottom: 0px;' data-prodid="<?php echo $key; ?>"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></p>
                                    <?php  }
                                    if( $quantity_ids[$key] && $value ) {
                                        echo $quantity_ids[$key] * $value.'<br>';
                                    } else {
                                        echo '0<br>';
                                    }
                                    $q_id++;
                                } ?>
                            </td>

                            <td class="total_order total_<?php echo $row['id']?>">
                                <?php
                                $total = 0;
								//echo "ad" ;
								//print_r($amount_val);
                                foreach ($amount_val as $key => $value){
									//echo $quantity_ids[$key] ;
									//echo $value ;
                                    if( $quantity_ids[$key] && $value ) {
                                        $total =  $total + ($quantity_ids[$key] *$value );
                                    } 
                                }
                                echo  $total;
                                ?>
                            </td>
                            <td><?php echo $row['wallet'];  ?></td>
                            <td class="location_<?php echo $row['id']; ?> new_tablee"><?php echo $row['location'];?></td>
                            <?php if($user_name['number_lock'] == 0){?>
                                <td><?php echo $user_name['mobile_number']; ?></td>
                            <?php }else {?>
                                <td></td>
                            <?php }?>





                            <td><a onclick="copy_orderDetail(<?php echo $row['id']?>)" href="#" class="delivery" id="<?php echo $row['id'];?>"><i class="fa fa-truck" style="font-size:25px;"></i></a></td>
                            <td><?php echo $row['wallet'];  ?></td>
                            <?php if($sta == "Done"){?>
                                <td><?php echo $user_name['account_type']; ?></td>
                            <?php }?>
                        </tr>
                        <?php   $i++; }
                        ?>
                        </tbody>
                    </table>

                    <div style="margin:0px auto;">
                        <ul class="pagination">
                            <?php
                            /*for($i = 1; $total_page_num && $i <= $total_page_num; $i++) {
                             if($i == $page) {
                              $active = "class='active'";
                             }
                             else {
                              $active = "";
                             }
                             echo "<li $active><a href='?page=$i'>$i</a></li>";
                            }*/
                            ?>
                        </ul>
                    </div>
                    <div>
                        <div class="modal fade" id="myScanModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content" style="width: 100%; min-height: 500px;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Statement</h4>
                                    </div>
                                    <div class="inline fields">
                                        <div style="display: inline-block;height: 50px;">
                                            <label style="display: inline-block;height: 50px;">Barcode</label>
                                            <input type="text" id="barcode" autofocus style="display: inline-block;height: 50px;">
                                        </div>
                                        <div style="display: inline-block;height: 50px;">
                                            <button style="width: 100px; height: 50px;" id="add_invoice">Add</button>
                                        </div>
                                    </div>
                                    <form id="scan">
                                        <div class="modal-body" style="padding-bottom:0;">
                                            <table style="width: 100%;">
                                                <thead>
                                                <th>No</th>
                                                <th>InvoiceNumber</th>
                                                <th>Amount</th>
                                                </thead>
                                                <tbody style="width: 100%;" id="scanned_data">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer" style="padding-bottom:2px;">
                                            <td>
                                                <span>Total</span>
                                                <span id="total_amount"></span>
                                            </td>
                                            <button style="width:200px;height:50px;">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Amount</h4>
                                    </div>
                                    <form id ="data">
                                        <div class="modal-body" style="padding-bottom:0px;">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="text" name="amount" id = "amount" class="form-control" value="" required>
                                                    <input type="hidden" id="id" name="id" value="">
                                                    <input type="hidden" id="p_id" name="p_id" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="padding-bottom:2px;">
                                            <button>Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        </main>
    </div>
    <!-- /.widget-body badge -->
</div>




<!-- /.widget-bg -->
<!-- /.content-wrapper -->
<?php include("includes1/footer.php"); ?>
</body>
</html>
<script type="text/javascript">

    function copy_orderDetail(id){
        var detailContent = "";
        var username = $("username");
        var dummy = document.createElement("input");
        document.body.appendChild(dummy);
        var product_name = $(".product_name_" + id).html().split("<br>");
        var product_qty = $(".quantity_"+id).html().split("<br>");
        var product_amount = $(".amount_"+id).html().split("<br>");
        dummy.setAttribute("id", "dummy_id");
        var detail = "User Name: " + $(".username_" + id).html() +" ";
        detail += "User Phone: " + $(".userphone_" + id).val() + " ";
        detail += "Merchant Name: " + $(".merchant_" + id).val() + " ";
        detail += "Merchant Phone: " + $(".merchantphone_" + id).val() + " ";
        detail += "Merchant Address: " + $(".merchantaddress_" + id).val() + " ";

        for(var i = 0; i < product_name.length - 1; i++){
            detail += "Product Name: " + product_name[i] + " ";
            detail += "Quantity: " + product_qty[i] + " ";
            var amount = product_amount[i].trim();
            if(product_amount[i].indexOf("class") > -1){
                amount = 0;
            }
            detail += "Amount: " + amount + " ";
        }
        detail += "Total: " + $(".total_" + id).html().trim() + "   ";
        detail += "Table Number: " + $(".table_number_" + id).html().trim() + "   ";
        detail += "Location: " + $(".location_" + id).html().trim() + "   ";
        document.getElementById("dummy_id").value= detail;

        dummy.select();

        document.execCommand("copy");

        alert("Send Delivery Service to Admin!");
    }

    function hasClass(element, className) {
        return (' ' + element.className + ' ').indexOf(' ' + className+ ' ') > -1;
    }

    $(document).ready(function(){

        function handleKeyPress (e) {
            if( hasClass( document.getElementById("myScanModal"), "show" ) ) {
                if (e.keyCode === 13) {
                    var barcodeRead = $("#barcode").val();
                    addOrderToDialog( barcodeRead );
                    $("#barcode").val('');
                }

            }
        }

        $("#add_invoice").click(function() {
            if( hasClass( document.getElementById("myScanModal"), "show" ) ) {
                var barcodeRead = $("#barcode").val();
                addOrderToDialog( barcodeRead );
                $("#barcode").val('');
                $("#barcode").focus();
            }
        });

        function empty(str){
            return !str || !/[^\s]+/.test(str);
        }

        function addOrderToDialog(barcode) {
            var orders = $("#scanned_data tr");
            var ids = [];
            orders.each(function(row, v) {
                $(this).find("td").each(function(cell, v) {
                    if( cell == 2 ) {
                        ids.push($(this).text());
                    }
                });
            });
            var res = barcode.split("-");
            if( res.length > 1 ) {
                var id = res[0];
                if( ids.indexOf(id) > -1 ) {
                    return;
                }
                var invoice_id = res[1];
                if( ! empty( id ) && ! empty( invoice_id ) ) {
                    $.ajax({
                        url : 'functions.php',
                        type: 'POST',
                        data: { id : id, invoice_no : invoice_id, method: 'getOrderDetailByIdAndInvoice'},
                        success:function(data){
                            if( data != null ) {
                                var obj = JSON.parse( data );
                                if( obj.length > 0 ) {
                                    var order = obj[0];
                                    if( parseInt(order['status']) != 0 ) {
                                        return;
                                    }
                                    var total = 0;
                                    for( var i = 0 ; i < order['product_name'].length ; i ++ ) {
                                        var amount = 0;
                                        if( order['product_qty'][i] && order['product_amt'][i] ) {
                                            amount = order['product_qty'][i] * order['product_amt'][i];
                                        } else {
                                            amount = 0;
                                        }
                                        total += amount;
                                    }
                                    var total_amount =  empty($("#total_amount").text()) ? 0 : parseFloat($("#total_amount").text());
                                    total_amount += total;
                                    $("#total_amount").text(total_amount);
                                    var list =
                                        '<tr><td>' + parseInt(document.getElementById("scanned_data").childElementCount + 1) + '</td>' +
                                        '<td>' + order['invoice_no'] + '</td>' +
                                        '<td style="display: none">' + order['id'] +'</td>' +
                                        '<td>' + total +  '</td></tr>';
                                    $("#scanned_data").append(list);
                                }
                            }
                        }
                    });
                }
            }
        }

        function updateOrder(id) {
            console.log(id);
            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: {id: id, status: 1},
                success: function (data) {
                    location.reload();
                }
            });
        }

        document.getElementById("barcode").addEventListener('keypress', handleKeyPress);

        function getCurrentTime() {
            var today = new Date();
            var hh = today.getHours();
            var mm = today.getMinutes();
            var ss = today.getSeconds();
            return hh + ':' + mm + ':' + ss;
        }

        function getCurrentDate() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            switch( mm ) {
                case 1:
                    mm = 'Jan';
                    break;
                case 2:
                    mm = 'Feb';
                    break;
                case 3:
                    mm = 'Mar';
                    break;
                case 4:
                    mm = 'Apr';
                    break;
                case 5:
                    mm = 'May';
                    break;
                case 6:
                    mm = 'Jun';
                    break;
                case 7:
                    mm = 'Jul';
                    break;
                case 8:
                    mm = 'Aug';
                    break;
                case 9:
                    mm = 'Sep';
                    break;
                case 10:
                    mm = 'Oct';
                    break;
                case 11:
                    mm = 'Nov';
                    break;
                case 12:
                    mm = 'Dec';
                    break;
            }
            return dd + '/' + mm + '/' + yyyy;
        }

        $("#scan_order").click(function() {
            $("#myScanModal").modal("show");
            $("#scanned_data").html('');
        });

        $(".print-order").click(function() {
            var id = $(this).attr("data-id");
            $.ajax({
                url : 'functions.php',
                type: 'POST',
                data: { id : id, method: 'getOrderDetail'},
                success:function(data){
                    if( data != null ) {
                        var obj = JSON.parse( data );
                        if( obj.length > 0 ) {
                            var order = obj[0];
                            data = {order: order, method: "pintOrder", date : getCurrentDate() , time : getCurrentTime()};
                            $.ajax( {
                                url : "functions.php",
                                type:"post",
                                data : data,
                                dataType : 'json',
                                success : function(data) {
                                    if( data.indexOf('print_setting_error') > -1 ) {
                                        alert("You need to set print ip address in profile page.");
                                    }
                                    alert(data);
                                }});
                        }
                    }
                }
            });
        });
        $(".status").click(function(){
            var data_id = $(this).attr("data-id");
            var status = $(this).attr("status");
            if(status == 0){
                $.ajax({
                    url : 'update_status.php',
                    type: 'POST',
                    data: {id:data_id, status: 2},
                    success:function(data){
                        //~ alert(1);
                        location.reload();
                    }
                });
            }
            if(status == 2){
                $.ajax({
                    url : 'update_status.php',
                    type: 'POST',
                    data: {id:data_id, status: 1},
                    success:function(data){
                        //~ alert(1);
                        location.reload();
                    }
                });
            }
        });
        /*adding new update */
        $(".pop_upss").click(function(){
            $("#myModal").modal("show");
            var dataid=$(this).data("id");
            var prodid=$(this).data("prodid");
            $("#id").val(dataid);
            $("#p_id").val(prodid);
        });

        $("form#scan").submit(function(e) {
            var orders = $("#scanned_data tr");
            orders.each(function(row, v) {
                $(this).find("td").each(function(cell, v) {
                    if( cell == 2 ) {
                        updateOrder($(this).text());
                    }
                });
            });
            $("#myScanModal").modal("hide");
            $("#scanned_data").html('');
            e.preventDefault();
            window.setTimeout( function() { window.location.reload(); }, 2000 );
        });

        $("form#data").submit(function(e) {
            console.log(e);
            e.preventDefault();
            var formData = new FormData(this);
            console.log($(this).serialize());
            var data = {amount: $("#amount").val()};
            $.ajax({
                url: 'update_amount.php',
                type: 'post',
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);
                    //alert(data);
                    //location.reload();
                }
            });
        });

    });
</script>
<script> window.setInterval('refresh()', 60000);
    function refresh() {
        window.location.reload();
    }
</script>
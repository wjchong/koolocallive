$(document).ready(function(){
    $(".sidebar-toggle").click(function(){
        if($("aside.site-sidebar").hasClass("displayed")){
            $("aside.site-sidebar").removeClass("displayed").addClass("notdisplayed");
        }else{
            $("aside.site-sidebar").removeClass("notdisplayed").addClass("displayed");
        }
    })
    $(".heart.fa").click(function() {
        var className = $(this).attr('class');
        var favorite = "0";
        if(className.indexOf("fa-heart-o") > -1){
            favorite = "1";
        }
        var data = {method: "favorite", favorite: favorite, merchant_id: $(".merchant_id").val(), user_id: $(".user_id").val() };
        $.ajax({
            url:"functions.php",
            type:"post",
            data:data,    
            success:function(data){
                console.log(data);
            
            }
        });
        $(this).toggleClass("fa-heart fa-heart-o");
    });

    $(".language_option").change(function(e){
        window.location.href="?language="+e.target.value;
    });
    var unread_array = [];
    var unread_num = 0;
    setInterval(function(){ 
        var data = {id: $(".user_id").val(), method: "getUnreadMsg"};
        unread_array = [];
        unread_num = 0;
        $.ajax({
            url:"functions.php",
            type:"post",
            data:data,    
            dataType: 'json',
            success:function(data){
                if(data.length > 0){
                    for(var i = 0; i < data.length; i++){
                        var obj = new Object();
                        obj.sender = data[i].sender;
                        obj.num = data[i].num;
                        unread_array.push(obj);
                        unread_num += parseInt(data[i].num);
                        $(".unread_num").html(unread_num);
                    }
                } else {
                    $(".unread_num").html("");
                }
            
            }
        }); 
        
    }, 3000);

    var unPrintedOrders = [];
    setInterval(function() {
        unPrintedOrders = [];
        var data = {id: $(".user_id").val(), method: "getUnPrintedOrder"};
        $.ajax( {
            url : "functions.php",
            type:"post",
            data : data,
            dataType : 'json',
            success : function(data) {
                console.log(data);
                if( data.length > 0 ) {
                    for( var i = 0 ; i < data.length ; i ++ ) {
                        var order = data[i];
                        updateOrder( order );
                    }
                }
            }
        } );
    }, 5000);

    function updateOrder(order) {
        console.log(order);
        if( order['id'] ) {
            console.log(order);
            var status = order['status'];
            //&& order['wallet'] != ""
            if(status == 0 && order['printed'] != 1 && order['printed'] != '1' && order['user_id'] != 0 && order['user_id'] != '0'  ) {
                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: {id: order['id'], printed: 1, method : 'updatePrinted'},
                    success: function (data) {
                        console.log(data);
                        printOrder(order)
                    }
                });
            }
        }
    }

    function printOrder( order ) {
        var data = {order: order, method: "pintOrder", date : getCurrentDate() , time : getCurrentTime()};
        $.ajax( {
            url : "functions.php",
            type:"post",
            data : data,
            dataType : 'json',
            success : function(data) {
                if( data.indexOf( 'print_setting_error' ) > -1 ) {
                    alert("You need to set print ip address in profile page.");
                } else {
                    console.log(data);
                }
            }});
    }

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

    $(".unread").click(function(e){
        if(unread_array.length > 0){
            var sender_id = $(".sender_id").val();
            var len = unread_array.length;
            window.open('/chat/chat.php?sender='+sender_id+'&receiver='+unread_array[len - 1].sender, '_blank')
            unread_num = unread_num - unread_array[len-1].num;
            $(".unread_num").html(unread_num);
            unread_array.splice(len-1, 1); 
        }
             
    });
});
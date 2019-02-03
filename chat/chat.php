<?php 
    include("../config.php");

   // session_start();
    if(isset($_GET['receiver'])){
        $receiver = $_GET['receiver'];
    } else $receiver = "0";

    if(isset($_GET['sender'])){
        $sender = $_GET['sender'];
    }
    $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$sender'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/rangeslider.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">        
    <link href="assets/css/slick.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/slick-theme.css" rel="stylesheet" type="text/css"/>
    
    <link href="assets/css/emojionearea.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

</head> 
<body>
    <div class="full-outer">
        <audio id="myAudio">
          <source src="/notification.mp3" type="audio/mpeg">
        </audio>
        <input type="hidden" class="sender" value="<?php echo $_GET['sender'];?>" />
        <input type="hidden" class="receiver" value="<?php echo $receiver;?>" />
        <div class="box-outer">
           
            <div class="left-box">
                <div class="top-logo">
                    <h2>Chat Room</h2>
                </div> 
                <div class="side-btm smooth-scroll">           
                    <ul class="side-navv">
                        <li class="nav-profile">
                            <a href="{{route('UserProfile')}}" class="ui-link">
                                <div class="nav-avatar" style="background-image: url(assets/img/user.png)"></div>
                                <h5> <?php echo $user['name'];?></h5>
                            </a>
                        </li>
                        <!-- <li class="nav-list">
                            <a href="{{ route('UserSearch" class="ui-link">
                                <img src="assets/img/flame.png"><span class="side-nav-txt">Find Matches</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="{{ route('UserMatches" class="ui-link">
                                <img src="assets/img/menu_match.png"><span class="side-nav-txt">Matches</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="{{ route('UserGetPreferences" class="ui-link">
                                <img src="assets/img/menu_discovery.png"><span class="side-nav-txt">Discovery Settings</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="{{ route('UserSettings')}}" class="ui-link">
                                <img src="assets/img/menu_appsettings.png"><span class="side-nav-txt">Settings</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="{{ route('UserMessages" class="ui-link">
                                <img src="assets/img/actionbar_matches_active.png"><span class="side-nav-txt">Chats</span>
                            </a>
                        </li>
                        <li class="nav-list">
                            <a href="{{ route('UserHelp" class="ui-link">
                                <img src="assets/img/menu_support.png"><span class="side-nav-txt">Help</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            
            </div>
            <div class="center-box cht">
                <div id="chat-loader" class="chat-load">
                    <div class="chat-load-outer">
                        <div class="chat-load-inner">
                            <img src="assets/img/flame.png">
                            <h5>Welcome to Flamer chat...</h5>
                        </div>
                    </div>
                </div>
                <div id="chat-conversation">
                    <div id="chat-header" class="msg-nav">
                    
                    </div>
                    <div id="chat-outer" class="msg smooth-scroll">

                        <div id="chat-container">

                        </div>
                    
                    </div>
                    <div id="cht-btm-lst"></div>
                    <div class="btm-msg">
                        <div class="input-field">
                            <input placeholder="Send a message..." id="chat-input" type="text" class="validate">          
                            
                        </div>
                        <button id="chat-send" class="btn">
                            <img src="assets/img/chat_send_normal.png">
                        </button>
                    </div>
                </div>

            </div>

            <div class="right-box">
                <div class="search-top">                    
                    <div class="input-group stylish-input-group">
                        <h4>Contacts</h4>
                    </div>
                </div>
                <div id="contact-container" class="search-list smooth-scroll"> 
                </div>
            </div>
            <style type="text/css">
                
            </style>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.nicescroll.min.js"></script>    
    <script src="assets/js/jquery.simple.thumbchanger.js"></script>
    <script src="assets/js/rangeslider.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/emojionearea.js"></script>
    <script type="text/javascript" src="assets/js/swiper.min.js"></script>
    <script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
   
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.4/socket.io.js"></script>
-->
<script type="text/javascript">
    $(document).ready(function(){
        // $("#chat-input").emojioneArea({
        //     pickerPosition: "top"
        // });
        var login_users = JSON.parse(localStorage.getItem("login_users"));
            
        var contactList;
        var chatList;
        //var user_id = {{ $user->id }};
        var contact_id = "";
        var currentContact;
        var chatLoader = $('#chat-loader');
        var chatContainer = $('#chat-container');
        var contactContainer = $('#contact-container');
        var chatInput = $('#chat-input');
        var chatSend = $('#chat-send');
        var socketState = false;
        var socketClient;
        var profilePlaceholder = "assets/img/user.png";
        var profileURL = "{{ route('UserOtherProfile', 1) }}".slice(0, -1);
        var today = new Date();

        var sender = $(".sender").val();
        var receiver = $(".receiver").val();
        function getReceiverUser(){
            var data = {method: "getReceiverUser", id:"<?php echo $receiver;?>"};
            $.ajax({
                url:"functions.php",
                type:"post",
                data:data,    
                success:function(data){
                    var json_data = JSON.parse(data);
                    showContacts(json_data);
                    //$(".msg-list-bx[data-user-id="+receiver+"] a").addClass("active");
                }
            });
        }
        getReceiverUser(sender);
        // Chat Socket Class
        chatSockets = function (contact) {
            this.id = contact;
            this.receiver = {id: receiver};
            this.socket = undefined;
        }   
        chatSockets.prototype.initialize = function() {
            this.socket = io('http://koofamilies.com:3000', { query: "sender="+this.id });
            

            this.socket.on('connected', function (data) {
                socketState = true;
                chatInput.enable();
            });

            this.socket.on('message', function (data) {
                if(data.message){
                    chatContainer.append(messageTemplate(data, currentContact));
                    var chtbxheight = $("#chat-container").outerHeight(true);
                    $("#chat-outer").animate({scrollTop: chtbxheight }, 100);
                }
            });
            this.socket.on('disconnect', function (data) {
                socketState = false;
            });
        }
        
        chatSockets.prototype.updateUserStatus = function() {
            try {
                this.socket.emit('check_login', {sender: this.id}); 
                this.socket.emit('set', 'is_it_ok', function (response) {
                    console.log(response);
                });
            } catch(e) {
            }
        }
    
        chatSockets.prototype.sendMessage = function(message, date, time) {
            try {
                this.socket.emit('send message', { receiver: this.receiver.id, message: message, date:date, time:time }); 
            } catch(e) {
            }
        }
        

        chatSockets.prototype.switchReceiver = function(contact){
            this.receiver = contact;
        };

        socketClient = new chatSockets(sender);
        socketClient.initialize();
        socketClient.updateUserStatus();
        
        function getChatHistory(current_date){
            //var current_date = getCurrentDate(date);
            var data = {method: "getChatHistory", sender: <?php echo $sender; ?>, receiver: <?php echo $receiver;?>, date: current_date};

            $.ajax({
                url:"functions.php",
                type:"post",
                data:data,    
                dataType: 'json',
                success:function(data){
                    if(data.length > 0){
                        for(var i = 0;  i < data.length; i++){
                            chatContainer.prepend(messageTemplate(data[i], ""));
                        }
                        chatContainer.prepend("<h5 class='date-header'>"+current_date+"</h5>");
                    }
                    chatContainer.prepend("<div style='text-align:center'><button class='btn btn-primary chat-more'>Load More</button></div>");
                    
                    $(".chat-more").click(function(e){
                        var previous_date = getYesterdayDate(today, 1);
                        $(this).remove();
                        getChatHistory(previous_date);
                    });
                    //$(".msg-list-bx[data-user-id="+receiver+"] a").addClass("active");
                }
            });
        }

        getChatHistory(getCurrentDate(today));
        
        function showContacts(contact){
            contactContainer.append(contactTemplate(contact));
            
        }
        function contactTemplate(contact) {
            element = $(''
                + '<div class="msg-list-bx" data-user-id="'+ contact.id +'" data-user-index="'+contact.index+'">'
                    + '<a href="/chat/chat.php?sender='+sender+'&receiver='+contact.id+'">'
                        + '<div class="msg-list-img-outer">'
                            + '<img src="'+ profilePlaceholder +'">'
                        + '</div>'
                        + '<div class="msg-list-right">'
                            + '<h5>'+ contact.name
                            + '</h5>'
                        + '</div>'
                    + '</a>'
                + '</div>');
            element.click(function(){

                receiverID = $(this).data('user-id');
                currentContact = $(this).data('user-index');

                $("#chat-conversation").css('visibility', 'visible');

                chatContainer.html('');
                chatInput.clear();
                chatLoader.hide();
                // chatInput.disable();
                showUserMessage(currentContact);
                socketClient.switchReceiver(contactList[currentContact]);
            });

            return element;
        }

        function messageTemplate(message, contactIndex) {
            if(message.sender){
                direction = message.sender == <?php echo $sender;?> ? "right" : "left";
            } else {
                direction = message.type == "sent" ? "right" : "left";
            }
           
            element = $("<div>", {class: "msg-txt"});

            element.append($("<p>", {class: "mgss", text: message.message}));
            element.append($('<p class="time"></p>'));
            
            element = $('<div class="msg-bxxx '+direction+"-msg"+'">').append(element);
            
            return element;
        }

        function showUserMessage(contactIndex) {
            $.get('{{ url("userApi/getUserMessage") }}', { sender_id: user_id, receiver_id: contactList[contactIndex].id, limit: 100, skip: 0 }, function(response) {
                
                if(response.success) {
                    $("#chat-header").html(showChatHeader(contactList[contactIndex]));
                    $.each(response.messages, function(index, value) {
                        chatContainer.append(messageTemplate(value, contactIndex));
                        // $("time.timeago").timeago();
                    });
                } else {
                    $("#chat-header").html(showChatHeader(contactList[contactIndex]));
                }
                setCSS();
            });
        }

        function showChatHeader(header) {

            // console.log('Header', header);

            if(header.picture == "") {
                header.picture = profilePlaceholder;
            }

            element = $('<div>', {class: "img-outer"});
            element.append($('<img src="'+header.picture+'">'));
            element = $('<a>', {href: profileURL+header.id }).append(element);
            element.append($('<h4>', {text: header.name}));

            return element;
        }

        function showURLUserChat() {
            if(contact_id != null) {
                chatLoader.hide();
                $("#chat-conversation").css('visibility', 'visible');
                showUserMessage(contact_id);
            }
        }

        // Chat Input

        chatInput.enable = function() {
            // console.log('Chat Input Enable');
            this.prop( "disabled", false );
        };

        chatInput.clear = function() {
            // console.log('Chat Input Cleared');
            this.val("");
        };

        chatInput.disable = function() {
            // console.log('Chat Input Disable');
            this.prop( "disabled", true );
        };

        chatInput.keypress(function (e) {
            if (e.which == 13) {
                if(receiver > 0){
                    sendMessage(chatInput);
                    return false;    //<---- Add this line
                }
            }
        });

        chatSend.on('click', function() {
            if(receiver > 0){
                sendMessage(chatInput);
            }
            
        });
        
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        
        function getCurrentDate(date){
            var dd = date.getDate();
            var mm = date.getMonth()+1; //January is 0!
            var yyyy = date.getFullYear();
            
            mm = checkTime(mm);
            return yyyy + "-" + mm + "-" + dd;
        }
        
        function getYesterdayDate(date, prev){
            date.setDate(date.getDate() - prev);
            var dd = date.getDate();
            var mm = date.getMonth()+1; //January is 0!
            var yyyy = date.getFullYear();
            
            mm = checkTime(mm);
            return yyyy + "-" + mm + "-" + dd;
        }
        function sendMessage(input) {
            text = input.val().trim();
            if(socketState && text != '') {
                message = {};
                message.type = 'sent';
                message.message = text;
                message.time = new Date();
                message.status = "unread";
                var date = new Date();
                var h = date.getHours();
                var m = date.getMinutes();
                var s = date.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                var time = h + ":" + m + ":" + s;
                
                var date = getCurrentDate(date);
                socketClient.sendMessage(text, date, time); 
                
                chatContainer.append(messageTemplate(message, ""));
                $(".emojionearea-editor").html("");
                chatInput.clear();
                var chtbxheight = $("#chat-container").outerHeight(true);
                $("#chat-outer").animate({scrollTop: chtbxheight }, 100);
                
                var x = document.getElementById("myAudio"); 
                
                 x.play(); 
               
            }
        }
    });


// $('#chat-conversation').animate({scrollTop: 200});


</script>

    <script type="text/javascript">
        function submitform1()
        {
        document.paymentIndex.submit();
        }
        function submitform2()
        {
        document.paymentIndex1.submit();
        }
    </script>

    <script src="assets/js/scripts.js"></script>

    <script type="text/javascript">


</script>



</body>
</html>
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var debug = require('debug')('Flamer:sockets');
var request = require('request');
var port = '3000';
var express = require('express');
var router = express.Router();

var mysqlClientLib,mysqlClient;
mysqlClientLib = require('./libs/mysql-client');
mysqlClient = mysqlClientLib.mysqlClient();

server.listen(port);

global.KOO = {
    loginList: []
};



io.on('connection', function (socket) {
    
    debug('new connection established');
    debug('socket.handshake.query.sender', socket.handshake.query.sender);
    
    socket.join(socket.handshake.query.sender);

    socket.emit('connected', 'Connection to server established!');
    socket.on('send message', function(data) {
        data.sender = socket.handshake.query.sender;
       
        /*mysqlClient.query("SELECT * FROM users where login_status=1 and id=?",
            [data.receiver],
            function(err,info){
                if(err){
                    console.log(err);
                }
                var status = "unread";
                if(info.length > 0 ) status = "read";
                mysqlClient.query( "INSERT INTO chat_history SET sender=?,receiver=?, message=?, date=?, time=?, status=?",
                    [data.sender, data.receiver, data.message, data.date, data.time, status],
                    function(err,info){
                        if(err){
                            console.log(err);
                        }
                });
                socket.broadcast.to(data.receiver).emit('message', data);
        });*/
        var status = "unread";
        mysqlClient.query( "INSERT INTO chat_history SET sender=?,receiver=?, message=?, date=?, time=?, status=?",
            [data.sender, data.receiver, data.message, data.date, data.time, status],
            function(err,info){
                if(err){
                    console.log(err);
                }
				//send push notification 
				var g_url='https://www.koofamilies.com/Noti.php';
				var options = {
				  url:g_url,
				  method: 'POST',
				   json: {sender_id:data.sender,reciever_id:data.receiver,msg:data.message},
				  headers: {
					  "Content-Type": "application/json"
				  }
				};
				request(options, function (error, response, body) {
					if(error) { return error;}
					
					console.log(body);
				});  
				
        });
        socket.broadcast.to(data.receiver).emit('message', data);
        socket.on('set', function (status, callback) {
        console.log(status);
        callback('ok');
		});
    });
     socket.on('set', function (status, callback) {
        console.log(status);
        callback('ok');
    });
    socket.on('check_login', function(data){
        mysqlClient.query("UPDATE users SET login_status=1 where id=?",
            [data.sender],
            function(err,info){
                if(err){
                    console.log(err);
                }           
                io.emit('login_signal', info);       
        });
        mysqlClient.query("SELECT * FROM users where login_status=1 and id=?",
            [data.sender],
            function(err,info){
                if(err){
                    console.log(err);
                }
                var userdata = {
                    user : info[0],
                    user_socket :socket
                };
                global.KOO.loginList.push(userdata);
        });
    });
    socket.on('get_unread_data', function(data){
        mysqlClient.query("SELECT sender, COUNT(id) num FROM chat_history WHERE STATUS = 'unread' and receiver=? GROUP BY sender",
            [data.sender],
            function(err,info){
                if(err){
                    console.log(err);
                }
                io.emit('unread_message', info);
        });
    });
    socket.on('login_status', function(data){
        mysqlClient.query("UPDATE users SET login_status=1 where id=?",
            [data.sender],
            function(err,info){
                if(err){
                    console.log(err);
                }
                
                socket.broadcast.emit('send_login_signal', info);
        });
        mysqlClient.query("SELECT * FROM users where login_status=1",
            function(err,info){
                if(err){
                    console.log(err);
                }
                io.emit('send_login_signal', info);
                //socket.broadcast.emit('send_login_signal', info);
        });
        
    });

    socket.on('disconnect', function(data) {
        /*var disconnect_id = "";
        for(var i = 0; i < global.KOO.loginList.length; i++){
            if(global.KOO.loginList[i].user_socket == socket){
                disconnect_id = global.KOO.loginList[i].user.id;
                global.KOO.loginList.splice(i, 1);
            }
        }
        mysqlClient.query("UPDATE users SET login_status=0 where id=?",
            [disconnect_id],
            function(err,info){
                if(err){
                    console.log(err);
                }
        });*/
        debug('disconnect', data);
    });
});
/**
 * Created by Administrator on 8/12/2016.
 */

"use strict";

var mysql = require("mysql");

var database_name   = 'kooexcha_demo';

function getMySqlClient() {
    
    var mysqlClient = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database : 'koofamil_B277'
    });
    
    mysqlClient.connect(function(err) {              // The server is either down
        if(err) {                                     // or restarting (takes a while sometimes).
            console.log('error when connecting to db:', err);
            setTimeout(getMySqlClient, 2000); // We introduce a delay before attempting to reconnect,
        }                                     // to avoid a hot loop, and to allow our node script to
    });                                     // process asynchronous requests in the meantime.
                                          // If you're also serving http, display a 503 error.
    mysqlClient.on('error', function(err) {
        console.log('db error', err);
        if(err.code === 'PROTOCOL_CONNECTION_LOST') { // Connection to the MySQL server is usually
            getMySqlClient();                         // lost due to either server restart, or a
        } else {                                      // connnection idle timeout (the wait_timeout
            throw err;                                  // server variable configures this)
        }
    });

    mysqlClient.query('CREATE DATABASE IF NOT EXISTS ' + database_name, function(err) {
        if ( err && err.number != mysql.ERROR_DB_CREATE_EXISTS ) {
            throw err;
        }
    });
    //mysqlClient.useDatabase(database_name);

    return mysqlClient;
}

exports.mysqlClient = getMySqlClient;
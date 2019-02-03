<?php 
    include("../config.php");

    if(isset($_POST['method']) && ($_POST['method'] == "getReferralUsers")){
        $referral_id = $_POST['id'];
        
        $sql_referral = "SELECT referral_id, id, name
                        FROM users
                        WHERE referred_by = '".$referral_id."'";
        $result = mysqli_query($conn,$sql_referral);
        $array_referral = array();
        while ($row=mysqli_fetch_row($result)){
            $item = array("id"=> $row[1], "name"=> $row[2]);
            array_push($array_referral, $item);
            // $id = $row[0];
            // $sql_first = "SELECT referral_id, id, name
            //                 FROM users
            //                 WHERE referred_by = '".$id."'";
            // $result1 = mysqli_query($conn,$sql_first);
            // while ($row1=mysqli_fetch_row($result1)){
            //     $item = array("id"=> $row1[1], "name"=> $row1[2]);
            //     array_push($array_referral, $item);
            //     $id1 = $row1[0];
            //     $sql_second = "SELECT referral_id, id, name
            //                     FROM users
            //                     WHERE referred_by = '".$id1."'";
            //     $result2 = mysqli_query($conn,$sql_second);
            //     while($row2 = mysqli_fetch_row($result2) ){
            //         $item = array("id"=> $row2[1], "name"=> $row2[2]);
            //         array_push($array_referral, $item);
            //     }
            //}
        }
        echo json_encode($array_referral);
    }
    if(isset($_POST['method']) && ($_POST['method'] == "getReceiverUser")){
        $receiver_id = $_POST['id'];

        $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$receiver_id."'"));
        
        echo json_encode($result);
    }
    
    if(isset($_POST['method']) && ($_POST['method'] == "newMessage")){

        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $message = $_POST['message'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $status = $_POST['status'];
        //$result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$receiver_id."'"));
        mysqli_query($conn, "INSERT INTO chat_history SET sender='$sender',receiver='$receiver', message='$message', date='$date', time='$time', status='$status'");
        $result = array(
            "result" => "success"
        );
        echo json_encode($result);
    }
    if(isset($_POST['method']) && ($_POST['method'] == "getChatHistory")){

        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $date = $_POST['date'];
        //$result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id ='".$receiver_id."'"));
        $sql = "
            SELECT *
            FROM (
                SELECT *
                FROM chat_history
                WHERE DATE = '$date' AND sender = '$sender' AND receiver = '$receiver'
                
                UNION ALL
                
                SELECT *
                FROM chat_history
                WHERE DATE = '$date' AND receiver = '$sender' AND sender = '$receiver' ) a
            ORDER BY a.time desc
        ";
        $result = mysqli_query($conn,$sql);
        $array_history = array();
        while ($row=mysqli_fetch_row($result)){
            $item = array("id"=> $row[0], "sender"=> $row[1], 'receiver'=> $row[2], 'message'=> $row[3], 'time'=> $row[5]);
            array_push($array_history, $item);
        }

        $sql = "UPDATE chat_history SET STATUS = 'read' WHERE receiver = '$sender' AND sender= '$receiver' AND STATUS = 'unread'";
        mysqli_query($conn,$sql);
        echo json_encode($array_history);
        
    }
?>
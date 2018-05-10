<?php
    require('./libs/database/connect-db.php');
    $access_token = 'QPUPUnMzGhO//A8J2Qi1nmBXgEW89hciaaxNExeLVgxa8cjYtvnF9TZQF3TEjEOVA5HhS6dTRT2Tp4F0I3JhC0QWrQdmlBiL/6bhuazJI/juOxmvFx31NX7RWv9z19gbUZAdPIEuAURaHPy7TnDNkQdB04t89/1O/w1cDnyilFU=';

    function correctCode($message, $user_id){
        $sharp_prefix = substr($message, 0, 1);
        if($sharp_prefix != "#"){
            return false;
        }

        $existing_code_sql = "SELECT id, name, lastname FROM tbl_authorize WHERE code = '$message'";
        $existing_result = mysqli_query($conn, $existing_code_sql);
        if(mysqli_num_rows($existing_result) == 0){
            return false;
        }

        $existing_row = $existing_result->fetch_assoc();
        $line_id = $existing_row['line'];
        if(isset($line_id) && !empty($line_id)){
            sendMessage("Code นี้ได้ลงทะเบียนไปแล้ว");
            return false;
        }

        $permission_id = $existing_row['id'];
        $update_user_id_sql = "UPDATE tbl_authorize SET line = '$user_id' WHERE id = $permission_id";
        $update_user_sql_result = mysqli_query($conn, $update_user_id_sql);
        if($update_user_sql_result) {
            sendMessage("คุณ".$existing_row['name']." ".$existing_row['lastname']." ลงทะเบียนเรียบร้อยแล้ว");
            return false;
        }
    }

    function hasPermission($user_id){
        $fetch_permission = "SELECT id FROM tbl_authorize WHERE line = '$user_id' AND status = 'A'";
        $results = mysqli_query($conn, $fetch_permission);
        if(mysqli_num_rows($results) > 0){
            return true;
        }else{
            return false;
        }
    }

    function sendMessage($body_text){
        $messages = [ 'type' => 'text', 'text' => $body_text];
        $url = 'https://api.line.me/v2/bot/message/reply';
        $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],
        ];
        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }
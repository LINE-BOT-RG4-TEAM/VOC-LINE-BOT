<?php
    if(isset($_GET["error"])) {
        echo "<h3>ไม่สามารถเชื่อมต่อกับ LINE Notify ได้</h3>";
        echo "<h4>".$_GET["error_description"]."</h4>";
        exit();
    }

    // get access token and save it to database
    $token_uri = getenv("LINE_NOTIFY_TOKEN_URI");
    $redirect_uri = getenv("LINE_NOTIFY_REDIRECT_URI");
    $client_id = getenv("LINE_NOTIFY_CLIENT_ID");
    $client_secret = getenv("LINE_NOTIFY_CLIENT_SECRET");
    $code = $_GET["code"];

    $headers = [
        'Content-Type' => 'application/x-www-form-urlencoded'
    ];

    $fields = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_uri);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $res = curl_exec($ch);
    curl_close($ch);

    if ($res == false)
        throw new Exception(curl_error($ch), curl_errno($ch));
    
    $json = json_decode($res);
    $status_code = $json->status;
    if($status_code != 200){
        echo "{$status_code}: ไม่สามารถออก access token ได้ กรุณาลองใหม่อีกครั้ง";
        exit();
    }

    require("./libs/database/connect-db.php");
    $state = trim($_GET["state"]);
    $access_token = $json->access_token;
    $insert_access_token = "
        INSERT INTO tbl_notify(name, access_token)
        VALUES('{$state}', '{$access_token}')
    ";
    $results = mysqli_query($conn, $insert_access_token);
    if(mysqli_error($conn)){
        die("เพิ่มข้อมูล access token ไม่สำเร็จ: ".mysqli_error($conn));
    }
    $message = "เชื่อมต่อกับ LINE Notify สำเร็จ หากท่านเลือกกลุ่มเพื่อแจ้งเตือน กรุณาดึง LINE Notify เข้าไปในกลุ่มเพื่อรับการแจ้งเตือน";
    echo $message;
    exit();
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

    // get type of access_token
    $status_header = [
        "Authorization: Bearer {$access_token}"
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $status_header);
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/status");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $access_token_results = curl_exec($ch);
    $json = json_decode($access_token_results);
    $target = $json->target;
    $targetType = $json->targetType;

    $insert_access_token = "
        INSERT INTO tbl_notify(name, target, targetType, access_token)
        VALUES('{$state}', '{$target}', '{$targetType}', '{$access_token}')
    ";
    $results = mysqli_query($conn, $insert_access_token);
    if(mysqli_error($conn)){
        die("เพิ่มข้อมูล access token ไม่สำเร็จ: ".mysqli_error($conn));
    }
    if($targetType === "GROUP") {
        $message = "เชื่อมต่อกับกลุ่ม `$target` เพื่อรับการแจ้งเตือนผ่าน LINE Notify สำเร็จ กรุณาดึง LINE Notify เข้ากลุ่มเพื่อรับการแจ้งเตือน";
    } else if($targetType === "USER") {
        $message = "เชื่อมต่อกับ `$target` เพื่อรับการแจ้งเตือนผ่าน LINE Notify สำเร็จ";
    }
    echo $message;
    exit();
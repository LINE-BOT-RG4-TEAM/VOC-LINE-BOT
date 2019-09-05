<?php
    require('./libs/database/connect-db.php');
    require('./libs/utils/date_thai.php');
    require('./libs/utils/date_utils.php');

    // check holiday
    $todaytime = strtotime('today');
    $todaydate = date('Y-m-d', $todaytime);
    $fetch_holiday = "SELECT * FROM tbl_holiday WHERE status = 'A' AND holiday_date = '$todaydate'";
    $holiday_list = mysqli_query($conn, $fetch_holiday);

    if(isWeekend($todaydate) || mysqli_num_rows($holiday_list) > 0){
        return;
    }

    $fetch_notify_list = "SELECT `target`, access_token FROM tbl_notify WHERE `status` = 'A'";
    $notify_list = mysqli_query($conn, $fetch_notify_list) or die($fetch_notify_list);

    $notify_uri = "https://notify-api.line.me/api/notify";
    while($notify_row = $notify_list->fetch_assoc()){
        $access_token = $notify_row->access_token;
        $headers = [
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer $access_token"
        ];

        $message = [
            "message" => "\n\nรายงานข้อร้องเรียนสถานะรอและกำลังดำเนินการมากกว่าเท่ากับ 10 วัน \n\nประจำวันที่ ".DateThai(date("Y-m-d"))." \n\nhttps://voc-bot.herokuapp.com/south.php?NUMBER=@10"
        ];

        $ch = curl_init($notify_uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }
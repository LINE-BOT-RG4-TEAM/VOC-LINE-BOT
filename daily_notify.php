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

    // get complaint results
    $fetch_existing_complaint = "SELECT main_office, COUNT(main_office) AS count_complaint ".
                                "FROM tbl_complaint ".
                                "WHERE number_of_day>='10' AND complaint_status <> 'ปิด' ".
                                "GROUP BY main_office ".
                                "HAVING COUNT(main_office) > 0 ".
                                "ORDER BY main_office ASC";
    $complaint_list = mysqli_query($conn, $fetch_existing_complaint);
    if(mysqli_num_rows($complaint_list) > 0){
        $prepare_message = "\n\nรายงานข้อร้องเรียนสถานะรอและกำลังดำเนินการมากกว่าเท่ากับ 10 วัน ประจำวันที่ ".DateThai(date("Y-m-d"));
        $prepare_message .= getStringComplaintList($complaint_list);
        $prepare_message .= "\n\nhttps://voc-bot.herokuapp.com/south.php?NUMBER=@10";
        $message = [
            "message" => $prepare_message
        ];
    } else {
        $message = [
            "message" => "\n\nไม่มีข้อร้องเรียนสถานะกำลังดำเนินการหรือรอดำเนินการที่มากกว่าเท่ากับ 10 วัน ในวันที่ ".DateThai(date("Y-m-d"))
        ];
    }

    $fetch_notify_list = "SELECT `target`, access_token FROM tbl_notify WHERE `status` = 'A'";
    $notify_list = mysqli_query($conn, $fetch_notify_list) or die($fetch_notify_list);

    $notify_uri = "https://notify-api.line.me/api/notify";
    while($notify_row = $notify_list->fetch_assoc()){
        $access_token = $notify_row["access_token"];
        $headers = [
            "Authorization: Bearer ".$access_token
        ];

        $ch = curl_init($notify_uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($message));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    function getStringComplaintList($complaint_list){
        $complaint_string_list = "";
        while($complaint = $complaint_list->fetch_assoc()){
            $complaint_string_list .= "\n  » {$complaint["main_office"]} จำนวน `{$complaint["count_complaint"]} เรื่อง`";
        }
        return $complaint_string_list;
    }
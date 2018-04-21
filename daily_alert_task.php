<?php
    require('./libs/database/connect-db.php');
    require('./libs/utils/date_thai.php');

    $group_id_list = [];
    $fetch_group_list = "SELECT group_id FROM tbl_line_group WHERE status = 'A'";
    $group_list = mysqli_query($conn, $fetch_group_list);
    while($group = $group_list->fetch_assoc()){
        array_push($group_id_list, $group['group_id']);
    }

    $messages = [ 
        'type' => 'uri', 
        'label' => 'รายงานข้อร้องเรียนรอและกำลังดำเนินการมากกว่าเท่ากับ 10 วัน ประจำวันที่ '.DateThai(date("Y-m-d")),
        'uri' => 'https://voc-bot.herokuapp.com/south.php?NUMBER=@10'
    ];
    $url = 'https://api.line.me/v2/bot/message/push';
    $data = [
            'to' => $group_id_list,
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
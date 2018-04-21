<?php
    require('./libs/database/connect-db.php');
    require('./libs/utils/date_thai.php');

    $messages = [ 
        'type' => 'uri', 
        'label' => 'รายงานข้อร้องเรียนรอและกำลังดำเนินการมากกว่าเท่ากับ 10 วัน ประจำวันที่ '.DateThai(date()),
        'uri' => 'https://voc-bot.herokuapp.com/south.php?NUMBER=@10'
    ];
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
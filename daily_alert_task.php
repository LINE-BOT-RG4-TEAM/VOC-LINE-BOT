<?php
    require('./libs/database/connect-db.php');
    require('./libs/utils/date_thai.php');
    $access_token = 'QPUPUnMzGhO//A8J2Qi1nmBXgEW89hciaaxNExeLVgxa8cjYtvnF9TZQF3TEjEOVA5HhS6dTRT2Tp4F0I3JhC0QWrQdmlBiL/6bhuazJI/juOxmvFx31NX7RWv9z19gbUZAdPIEuAURaHPy7TnDNkQdB04t89/1O/w1cDnyilFU=';

    $fetch_group_list = "SELECT group_id FROM tbl_line_group WHERE status = 'A'";
    $group_list = mysqli_query($conn, $fetch_group_list);
    while($group = $group_list->fetch_assoc()){
        $messages = [ 
            'type' => 'uri', 
            'label' => 'รายงานข้อร้องเรียนรอและกำลังดำเนินการมากกว่าเท่ากับ 10 วัน \nประจำวันที่ '.DateThai(date("Y-m-d")),
            'uri' => 'https://voc-bot.herokuapp.com/south.php?NUMBER=@10'
        ];
        $url = 'https://api.line.me/v2/bot/message/push';
        $data = [
                'to' => $group['group_id'],
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
    
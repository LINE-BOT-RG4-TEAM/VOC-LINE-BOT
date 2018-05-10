<?php
    require('./libs/utils/date_thai.php');
    echo "Daily Alert :\n\nรายงานข้อร้องเรียนสถานะรอและกำลังดำเนินการมากกว่าเท่ากับ 10 วัน\n\nประจำวันที่ ".DateThai(date("Y-m-d"))." \n\nhttps://voc-bot.herokuapp.com/south.php?NUMBER=@10";
<?php
    date_default_timezone_set('Asia/Bangkok');
    function isToday($otherDate){
        return (strtotime('today') == strtotime($otherDate));
    }
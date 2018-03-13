<?php
    require('../libs/database/connect-db.php');
    require('../libs/utils/utils.php');

    $target_path = uploadXLSXFile($_FILES['vocfile']);
    $namedDataArray = getDataFromXLSXPath($target_path);
    clearComplaintData($conn);
    insertComplaintData($conn, $namedDataArray);
    $number_complaint = countComplaintData($conn);
    echo "ได้เพิ่มข้อมูลแล้วทั้งหมด ".$number_complaint." ข้อมูล";
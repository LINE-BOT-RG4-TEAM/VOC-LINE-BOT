<?php
    require('../libs/PHPExcel/Classes/PHPExcel.php');
    include('../libs/PHPExcel/Classes/PHPExcel/IOFactory.php');
    date_default_timezone_set('Asia/Bangkok');

    function getMainOfficeByOfficeCode($officeCode){
        switch(substr($officeCode, 0, 1)){
            case "J":
                return "กฟต.1";
                break;
            case "K":
                return "กฟต.2";
                break;
            case "L":
                return "กฟต.3";
                break;
            default:
                return "";
                break;
        }
    }

    function convertToStandardDate($raw_date){
        // $raw_date = d/m/Y H:m:s
        if(!isset($raw_date) || empty($raw_date)){
            return NULL;
        }
        $thaiDateTimeArray = explode(" ", $raw_date);
        $thaiDateWithSlash = $thaiDateTimeArray[0];
        $thaiDateArray = explode("/", $thaiDateWithSlash);
        $year = (int)($thaiDateArray[2]) - 543;
        $thaiDate = date_create_from_format('Y-m-d', $year."-".$thaiDateArray[1]."-".$thaiDateArray[0]);
        return $thaiDate;
    }

    function getDiffDate($sent_date){
        if(!is_null($sent_date)){
            $diff = $sent_date->diff(new DateTime('now'));
            return $diff->days;
        }else{
            throw new Exception('sent_date\'s null');
        }
    }

    function getDataFromXLSXPath($xlsxPath){
        // load xlsx file with its path
        $inputFileType = PHPExcel_IOFactory::identify($xlsxPath);  
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);  
        $objReader->setReadDataOnly(true);  
        $objPHPExcel = $objReader->load($xlsxPath);  

        // set config -> activesheet, highestRow, highestColumn and get heading data
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $headingsArray = $objWorksheet->rangeToArray('A7:'.$highestColumn.'7', null, true, true, true);
        $headingsArray = $headingsArray[7];

        // collect data within $namedDataArray
        $r = -1;
        $namedDataArray = array();
        for ($row = 8; $row <= $highestRow; ++$row) {
            ++$r;
            $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, true, true);
            foreach($headingsArray as $columnKey => $columnHeading) {
                $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
            }
        }
        return $namedDataArray;
    }

    function uploadXLSXFile($file){
        $filename = $file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $target_path = "../uploads-voc-files/".basename(date('d-m-').(date("Y")+543)).".".$ext;
        if(!move_uploaded_file($file['tmp_name'], $target_path)) {
            die(error_get_last());
        }
        return $target_path;
    }

    function clearComplaintData($conn){
        $sql = "DELETE FROM tbl_complaint";
        mysqli_query($conn, $sql);
    }

    function insertComplaintData($conn, $namedDataArray){
        $count_complaint = 0;
        foreach($namedDataArray as $row){
            if($row['ผลการดำเนินการ'] == "Closed" || $row['ผลการดำเนินการ'] == "ยกเลิก"){
                continue;
            }
            $count_complaint++;
            $main_office = getMainOfficeByOfficeCode($row['รหัสการไฟฟ้า']);
            $office_code = $row['รหัสการไฟฟ้า'];
            $office_name = $row['การไฟฟ้า'];
            $complaint_id = $row['เลขที่คำร้องส่งถึง กฟภ.'];

            $sent_date = convertToStandardDate($row['วันที่คำร้องส่งถึง กฟภ.']);
            $received_date = convertToStandardDate($row['วันที่รับข้อร้องเรียน']);
            $settlement_date = convertToStandardDate($row['วันที่ปิดข้อร้องเรียน']);

            $complainant_name = $row['ชื่อผู้ร้องเรียน'];
            $complaint_type = $row['ประเภทข้อร้องเรียน'];
            $sub_complaint_type = $row['หัวข้อย่อย'];
            $complaint_location = $row['สถานที่เกิดข้อร้องเรียน'];
            $tel_contact = $row['เบอร์โทรศัพท์'];
            $complaint_status = $row['ผลการดำเนินการ'];
            $number_of_day = getDiffDate($sent_date, $received_date, $settlement_date);

            // check null
            $sent_date = isset($sent_date) ? $sent_date->format("Y-m-d"):NULL;
            $received_date = isset($received_date) ? $received_date->format("Y-m-d"):NULL;
            $settlement_date = isset($settlement_date) ? $received_date->format("Y-m-d"):NULL;

            $sql = "INSERT INTO tbl_complaint(main_office, office_code, office_name, complaint_id, sent_date, received_date, settlement_date, complainant_name, complaint_type, sub_complaint_type, complaint_location, tel_contact, complaint_status, number_of_day) ".
                    "VALUES('$main_office','$office_code','$office_name','$complaint_id','$sent_date','$received_date','$settlement_date','$complainant_name','$complaint_type','$sub_complaint_type','$complaint_location','$tel_contact','$complaint_status','$number_of_day')";
            $row_affected = mysqli_query($conn, $sql) or trigger_error($conn->error."[$sql]");
        }
    }

    function countComplaintData($conn){
        $sql = "SELECT COUNT(*) AS count_complaint FROM tbl_complaint";
        $results = mysqli_query($conn, $sql) or trigger_error($conn->error."[$sql]");    
        $row = $results->fetch_assoc();
        return $row['count_complaint'];
    }
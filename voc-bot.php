<?php
require('./libs/database/connect-db.php');
$access_token = 'FuAKF3ts4w0mtRwFuVSmTmKy3Qnvru2iWrDFhrkfLiy+eoDhyJsIXusrccWzx5JlBRy2NFGnvS+UV3y9jrqG4TdomrK6cn2goKJ6NocFCBS9fPaNEOar75EsM6CherpQT/iRv8Q40gDVQQUGb9Sy6wdB04t89/1O/w1cDnyilFU=';
 
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data

if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];
			$lineid = $event['source']['userId'];		
			$addpos = strpos($text,"@");
			$lengh = strlen($text);
			$lengh1 =$lengh-1;
			// Get replyToken
            $replyToken = $event['replyToken'];
         
            $regis_code = substr($text,0,1); // เก็บตัวอักษรแรก
//---------------------------------เก็บ UID ลง DATABASE-----------------------------------------------------//		 
if($regis_code == "#"){
		
					$sql_regis = "UPDATE tbl_authorize SET line ='$lineid' WHERE code ='$text'";
					mysqli_query($conn,$sql_regis);
					mysqli_close($conn);
					$txtans = "ลงทะเบียนเรียบร้อย".$reans1;
		                  
		      
			$messages = [ 'type' => 'text',
			 		'text' => $txtans    
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
 						echo $result . "\r\n";
		      }
//******************************************************************************************************//
//----------------------------------------เอา UID ค้นหาในฐานข้อมูล-----------------------------------------//
		 $sql_line = "SELECT * FROM tbl_authorize WHERE line LIKE '%".$lineid."%'";
		 $query_line = mysqli_query($conn,$sql_line);
		 $re = mysqli_num_rows($query_line); //<<<<<ใส่ผลลัพธ์ที่ได้ลงในตัวแปร $re
//*******************************************************************************************************//
		 if($re <> 0){
		
		 
		 
		 // ตำแหน่ง@อยู่ตัวแรก เช่น @15
	     if($addpos == 0){
			 $datenum = substr($text,$addpos+1,$lengh1);
			 $sql = "SELECT * FROM tbl_complaint WHERE number_of_day<".$datenum;
			 $mode4 = "https://voc-bot.herokuapp.com/south.php?NUMBER=".$text; //เรียกหน้าภาค
			              }
			
						 
		 if($addpos > 1){ 
			 if($addpos == $lengh1){ 
			       $main_office = substr($text,0,$addpos); 
			       $sql = "SELECT * FROM tbl_complaint WHERE office_name LIKE '%".$main_office."%' OR main_office LIKE '%".$main_office."%' ";
				   $datenum1 = 99999;
				   $mode4 = "https://voc-bot.herokuapp.com/req_office.php?REQ=".$main_office."&REQ2=".$datenum1;
				                   }
			 if($addpos < $lengh1){
				 $main_office = substr($text,0,$addpos); 
				 $datenum = substr($text,$addpos+1,$lengh1); 
				 
			     $sql = "SELECT * FROM tbl_complaint WHERE number_of_day<".$datenum." AND office_name LIKE '%".$main_office."%' OR main_office LIKE '%".$main_office."%'";
			     $mode4 = "https://voc-bot.herokuapp.com/req_office.php?REQ=".$main_office."&REQ2=".$datenum;	 			
				 	
					 			 } 
						 }
						 
		 if($addpos == 1){
			 if($addpos == $lengh1){ $main_office = substr($text,0,1); $sql = "SELECT * FROM request WHERE MAIN_OFFICE LIKE '%".$main_office."%' ";}
			 if($addpos < $lengh1){$main_office = substr($text,0,1); $datenum = substr($text,$addpos+1,$lengh1); $datenum1 = -$datenum;
			 $sql = "SELECT * FROM request WHERE MAIN_OFFICE LIKE '%".$main_office."%' AND DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$datenum1;
			 
			 }
			 $mode4 = "https://raiingphu.com/psq/req_display.php?NUMBER=".$text;
			 }
						 
						 
						 
						 
						 
		 
         $query = mysqli_query($conn,$sql);
		 $mode1 = mysqli_num_rows($query);
		 while($result=mysqli_fetch_array($query))
		 {$mode = iconv("tis-620","utf-8",$result["OFFICE"]);
		 
		 }
		 
		 
	     mysqli_close($conn);
		 
		 
            // Build message to reply back
            //$messages = [
            //  'type' => 'text',
			  
           //    'text' => "ค้นพบ  ".$mode1."  รายการ   ".$mode4    //."  [".$KVA." KVA]"
             
           // ];
		   if($mode1 == 0 or $addpos == 0 and $first = substr($text,0,1) <> "@"){
			   //$messages = ['type' => 'text',
			  // 'text' => "กรุณาตรวจสอบการใช้คำค้นหา"    
             //    ];
				break; 
				 } else 
				 {
			      $messages = array(
			     'type'=> 'template',
				'altText'=> 'ค้นพบ',
				'template'=>array(
						           'type'=>'buttons',
								   'text'=> "ค้นพบ  ".$mode1." รายการ",
								   'actions'=>array(
								   
								   array('type'=> 'uri','label'=> 'รายละเอียด','uri'=> $mode4)
								   
					                  )
								   )
			                   );}
 
            // Make a POST Request to Messaging API to reply to sender
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
 
            echo $result . "\r\n";
		 }
        }
    }
}

echo '<a href="test.php">test</a>';


<?php
$access_token = 'QPUPUnMzGhO//A8J2Qi1nmBXgEW89hciaaxNExeLVgxa8cjYtvnF9TZQF3TEjEOVA5HhS6dTRT2Tp4F0I3JhC0QWrQdmlBiL/6bhuazJI/juOxmvFx31NX7RWv9z19gbUZAdPIEuAURaHPy7TnDNkQdB04t89/1O/w1cDnyilFU=';
 
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
         
		 $serverName = "localhost";
         $userName = "raiingph_psq";
         $userPassword = "12345678";
         $dbName = "raiingph_psq";
         $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
         mysqli_set_charset($conn,"utf8");
		 $regis_code = substr($text,0,1); // เก็บตัวอักษรแรก
//---------------------------------เก็บ UID ลง DATABASE-----------------------------------------------------//		 
		 if($regis_code == "#"){
			$col_position = strpos($text,":");
			$lenght_text = strlen($text);
			$u_ser = substr($text,1,$col_position-1);
			$p_ass = substr($text,$col_position+1,$lengh);
			$sql_regis = "UPDATE author SET line ='$lineid' WHERE user ='$u_ser'";
			mysqli_query($conn,$sql_regis);
			mysqli_close($conn);
					 
			 }
//******************************************************************************************************//
		 $sql_line = "SELECT * FROM author WHERE line LIKE '%".$lineid."%'";
		 $query_line = mysqli_query($conn,$sql_line);
		 $re = mysqli_num_rows($query_line);
		 if($re <> 0){
		
		 
		 
		 // ตำแหน่ง@อยู่ตัวแรก เช่น @15
	     if($addpos == 0){
			 $datenum = substr($text,$addpos+1,$lengh1);
			 $datenum1 = -$datenum;
			 $sql = "SELECT * FROM request WHERE DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$datenum1;
			 $mode4 = "https://raiingphu.com/psq/req_display.php?NUMBER=".$text; //เรียกหนาภาค
			              }
			
						 
		 if($addpos > 1){ 
			 if($addpos == $lengh1){ 
			       $main_office = substr($text,0,$addpos); 
			       $sql = "SELECT * FROM request WHERE OFFICE LIKE '%".$main_office."%' OR MAIN_OFFICE LIKE '%".$main_office."%' ";
				   $datenum1 = 0;
				   $mode4 = "https://raiingphu.com/psq/req_office.php?REQ=".$main_office."&REQ2=".$datenum1;
				                   }
			 if($addpos < $lengh1){
				 $main_office = substr($text,0,$addpos); 
				 $datenum = substr($text,$addpos+1,$lengh1); 
				 $datenum1 = -$datenum;
			     $sql = "SELECT * FROM request WHERE DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$datenum1." AND (OFFICE LIKE '%".$main_office."%' OR MAIN_OFFICE LIKE '%".$main_office."%')";
			     $mode4 = "https://raiingphu.com/psq/req_office.php?REQ=".$main_office."&REQ2=".$datenum1;	 			
				 	
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


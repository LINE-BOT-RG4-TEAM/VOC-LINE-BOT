<!DOCTYPE html> 
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
<title>jQuery Mobile Web App</title>
<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
</head> 
<body> 
<?php
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		//$strHour= date("H",strtotime($strDate));
		//$strMinute= date("i",strtotime($strDate));
		//$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
function DateDiff($strDate1)
	 {
				return (strtotime(date("Y/m/d")) - strtotime($strDate1) )/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }

$NUMBER = $_GET['REQ'];
$serverName = "localhost";
         $serverName = "localhost";
          $userName = "raiingph_psq";
         $userPassword = "12345678";
         $dbName = "raiingph_psq";
         $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
         mysqli_set_charset($conn,"utf8");
		 $sql = "SELECT * FROM request WHERE REQ_NO LIKE '%".$NUMBER."%' ";
         $query = mysqli_query($conn,$sql);
?>
<div data-role="page" id="page">
	<div data-role="header" data-theme="b">
		<h1>ข้อมูลข้อร้องเรียน</h1>
	</div>
	<div data-role="content">	
		<?php
while($result=mysqli_fetch_array($query))
      		 {   
			 $strDate = $result["PEA_DATE_RECIVE"];
			 echo "เลขที่คำร้อง :"."<br>";
		     echo $result["REQ_NO"]."<br><br>";
			 echo "วันที่รับคำร้อง :"."<br>";
			 echo DateThai($strDate)."<br><br>";
			 echo "จำนวนวัน :"."<br>";
			 echo DateDiff($strDate)."<br><br>";
			 echo "หน่วยงาน :"."<br>";
			 echo $result["OFFICE"]."<br><br>";
			 echo "ชื่อผู้ร้องเรียน :"."<br>";
		     echo $result["REQ_NAME"]."<br><br>";
			 echo "เบอร์โทรศัพท์ :"."<br>";
			 echo $result["PHONE_NUM"]."<br><br>";
			 echo "ประเภทข้อร้องเรียน :"."<br>";
			 echo $result["TYPE"]."<br><br>";
			 echo "หัวข้อย่อย :"."<br>";
			 echo $result["SUB_TYPE"]."<br><br>";
			 }
?>	
<h2><a href="#" class="ui-btn" data-rel="back" > BACK</a></h2>
	</div>
    
	<div data-role="footer" data-theme="b">
		<h4>PEA</h4>
        
</div>
</body>
</html>
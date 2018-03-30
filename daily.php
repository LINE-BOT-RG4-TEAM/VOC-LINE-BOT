<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>รายงานข้อร้องเรียน</title>
		<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
		<?php
			require('./libs/database/connect-db.php');

			function DateThai($strDate){
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

			function DateDiff($strDate1){
				return (strtotime(date("Y/m/d")) - strtotime($strDate1) )/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
			}

			$NUMBER = $_GET['REQ'];
			$sql = "SELECT * FROM tbl_complaint WHERE number_of_day>=15";
			$query = mysqli_query($conn,$sql);
			$num_of_find = mysqli_num_rows($query);
			$sql_near = "SELECT * FROM tbl_complaint WHERE number_of_day>=10 AND number_of_day<=15";
			$query_near = mysqli_query($conn,$sql_near);
			$num_of_find_near = mysqli_num_rows($query_near);
		?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<?php
				$date_n = date("Y-m-d");
				echo "<h1>ข้อมูลข้อร้องเรียน ".Datethai($date_n)."</h1>"
				?>	
			</div>
			<div data-role="header" data-theme="c"><h4>กฟต.1</h4></div>
			<div data-role="content">	
				<?php       
				
				echo "<a href ='south.php?NUMBER=@15'>"."ยังไม่ปิด ".$num_of_find." รายการ</a>";
				echo "<a href ='south1.php'>"."รอดำเนินการเกิน 1 วัน  ".$num_of_find_near." รายการ</a>";
				echo "<a href ='south1.php'>"."ต้องปิดภายใน 20 วัน  ".$num_of_find_near." รายการ</a>>";
				echo "<a href ='south1.php'>"."ต้องเร่งรัดปิด 10 วัน  ".$num_of_find_near." รายการ</a>";
				echo "<a href ='south1.php'>"."ปิดแล้ว  ".$num_of_find_near." รายการ</a>";
				echo "<a href ='south1.php'>"."ปิดภายใน 15 วัน  ".$num_of_find_near." รายการ</a>";
				echo "<a href ='south1.php'>"."% ปิดภายใน15 วัน/ปิดแล้ว  ".$num_of_find_near." รายการ</a>";
				
				?>
			</div>
			<div data-role="footer" data-theme="b">
				<h4>PEA</h4>
			</div>
		</div>
	</body>
</html>

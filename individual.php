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
<?php
require('./libs/database/connect-db.php');
require('./libs/utils/date_thai.php');
require('./libs/utils/date_utils.php');
$office_code = $_GET['office_code'];
//$notify_id = $_GET['notify_id'];
$sql_select = "SELECT * FROM tbl_complaint WHERE office_code LIKE '%".$office_code."%' AND number_of_day >=0";
$query = mysqli_query($conn,$sql_select);

?> 
<body> 

<div data-role="page" id="page">
	<div data-role="header">
		<h1>รายงานข้อขร้องเรียน</h1>
	</div>
	<div data-role="content">	
		
				<?php
				$a = 1;
				while($row = mysqli_fetch_array($query))
				{
						if($row["received_date"]== Null){
						$strDate1 = "รอดำเนินการ";
						}else{
						$strDate = $row["received_date"];
						$strDate1 = DateThai($strDate);
						}
						echo $a.".คำร้องเลขที่ ".$row["complaint_id"]."<br>";
						echo "วันที่รับคำร้อง ".$strDate1."<br>";
						echo "จำนวนวัน ".$row["number_of_day"]."<br>";
						echo "ชื่อผู้ร้องเรียน ".$row["complainant_name"]."<br>";
						echo "เบอร์โทรศัพท์ ".$row["tel_contact"]."<br>";
						echo "ประเภทข้อร้องเรียน ".$row["complaint_type"]."<br>";
						echo "หัวข้อย่อย ".$row["sub_complaint_type"]."<br>";
						echo "สถานะข้อร้องเรียน ".$row["complaint_status"]."<br><br>";
						$a= $a +1 ;		
				}
				$a= 0;
				?>
				
	</div>
	<div data-role="footer">
		<h4>PEA</h4>
	</div>
</div>



</body>
</html>
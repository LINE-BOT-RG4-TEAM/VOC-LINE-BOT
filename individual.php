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
	$office_name = $_GET['office_name'];
	$log_id = $_GET['log_id'];
	$sql_log_id = "SELECT * FROM tbl_individual_log WHERE id = ".$log_id;
	$query_sql_log_id = mysqli_query($conn,$sql_log_id);
	$obj_query = mysqli_fetch_array($query_sql_log_id);
	if($obj_query["accept_status"] == "Y"){
		echo '<script type="text/javascript">';
      	echo 'window.location.href="req_office1.php?REQ='.$office_name.'&REQ2=10";';
      	echo '</script>';
		}
	else if($obj_query["accept_status"] == "N"){
		$sql_con = "UPDATE tbl_individual_log SET accept_status = 'Y',accept_timestamp = NOW() WHERE id = ".$log_id;
		mysqli_query($conn,$sql_con);
		echo '<script type="text/javascript">';
      	echo 'window.location.href="req_office1.php?REQ='.$office_name.'&REQ2=10";';
      	echo '</script>';		
		}
?> 




</body>
</html>
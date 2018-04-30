<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INDIVIDUAL_NOTIFY</title>
</head>
<body>
<?php
require('./libs/database/connect-db.php');
require('./libs/utils/date_thai.php');
require('./libs/utils/date_utils.php');
$sql_select_officename = "SELECT * FROM tbl_complaint WHERE (complaint_status LIKE '%กำลังกำเนินการ%' OR complaint_status LIKE '%รอดำเนินการ%') AND number_of_day >= 10 GROUP BY office_name";
$officename_list = mysqli_query($conn,$sql_select_officename);
while($obj_office_name = mysqli_fetch_array($officename_list))
{
	echo $obj_office_name["office_name"]."".$obj_office_name["number_of_day"]."<br>";
	
	}
echo "sfdsfsefdsfe";


?>
</body>
</html>
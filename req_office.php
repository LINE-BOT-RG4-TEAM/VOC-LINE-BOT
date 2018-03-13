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
$NUMBER = $_GET['REQ'];
$NUMBER2 = $_GET['REQ2'];
$serverName = "localhost";
$userName = "raiingph_psq";
$userPassword = "12345678";
$dbName = "raiingph_psq";
$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
mysqli_set_charset($conn,"utf8");
$sql = "SELECT * , COUNT(OFFICE) AS NUM FROM request WHERE (MAIN_OFFICE LIKE '%".$NUMBER."%' OR OFFICE LIKE '%".$NUMBER."%')  AND DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$NUMBER2." GROUP BY OFFICE HAVING(COUNT(OFFICE)>0)";
$query = mysqli_query($conn,$sql);
$mode1 = mysqli_num_rows($query);
while($ofname = mysqli_fetch_array($query)){ $ofname1 = $ofname["MAIN_OFFICE"];}

?>
<div data-role="page" id="page">
	<div data-role="header" data-theme="b">
		<h1>ข้อมูลข้อร้องเรียน </h1>
	</div>
    <div data-role="content">
   			<?php 
			
			echo "ข้อร้องเรียน  ".$ofname1;	?>
	</div>
	<div data-role="content">	
		<ul data-role="listview">
			<?php
			mysqli_data_seek($query,0);
			
		$a = 1;
		while($result=mysqli_fetch_array($query))
		 {
			 
			 echo "<li><a href ='req_office1.php?REQ=".$result["OFFICE"]."&REQ2=$NUMBER2'>".$a.".".$result["OFFICE"]."  จำนวน  ".$result["NUM"]." เรื่อง</a></li>";;
			 $a =$a +1;
		 		 }
				 $a = 0;
				 mysqli_close($conn);
			?>
		</ul>
      <h2><a href="#" class="ui-btn" data-rel="back" > BACK</a></h2>
  </div>
	<div data-role="footer" data-theme="b">
		<h4>PEA</h4>
	</div>
</div>



</body>
</html>
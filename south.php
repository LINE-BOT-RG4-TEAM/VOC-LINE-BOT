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
require('./libs/database/connect-db.php');
$NUMBER = $_GET['NUMBER'];
$addpos = strpos($NUMBER,"@");
$lengh = strlen($NUMBER);
$lengh1 =$lengh-1;
echo $NUMBER;
         
		
	     if($addpos == 0){
			 $datenum = substr($NUMBER,$addpos+1,$lengh1);
			 $datenum1 = -$datenum;
			 $sql = "SELECT * , COUNT(main_office) AS NUM FROM request WHERE number_of_day<".$datenum." GROUP BY main_office HAVING(COUNT(office_name)>0)";;
			
			             }
		
		 
		 
		 

						 
		
		 
		 
		 //$sql = "SELECT * FROM request WHERE DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$NUMBER;
         $query = mysqli_query($conn,$sql);
		 
?>
</body>
</html>
<div data-role="page" id="page">
	<div data-role="header" data-theme="b">
		<h1>ข้อมูลข้อร้องเรียน </h1>
	</div>
    <div data-role="content">
   			<?php 
			
			echo "ข้อร้องเรียน  ".$NUMBER;	?>
	</div>
	<div data-role="content">
   		<ul data-role="listview">
        <?php
		$a = 1;
		while($result=mysqli_fetch_array($query))
		 {
			 
			 echo "<li><a href ='req_office.php?REQ=".$result["main_office"]."&REQ2=$datenum1'>".$a.".".$result["main_office"]."  จำนวน  ".$result["NUM"]." เรื่อง</a></li>";
			 $a =$a +1;
		 		 }
				 $a = 0;
				 mysqli_close($conn);
			?>
		</ul>		
	</div>
	<div data-role="footer" data-theme="b">
		<h4>PEA</h4>
	</div>
</div>
</body>
</html>

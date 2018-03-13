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
$NUMBER = $_GET['NUMBER'];
$addpos = strpos($NUMBER,"@");
$lengh = strlen($NUMBER);
$lengh1 =$lengh-1;
echo $NUMBER;
         $serverName = "localhost";
          $userName = "raiingph_psq";
         $userPassword = "12345678";
         $dbName = "raiingph_psq";
         $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
         mysqli_set_charset($conn,"utf8");
		 // ตำแหน่ง@อยู่ตัวแรก//////////
	     if($addpos == 0){
			 $datenum = substr($NUMBER,$addpos+1,$lengh1);
			 $datenum1 = -$datenum;
			 $sql = "SELECT * , COUNT(MAIN_OFFICE) AS NUM FROM request WHERE DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$datenum1." GROUP BY MAIN_OFFICE HAVING(COUNT(OFFICE)>0)";;
			
			             }
		/////////////////////////	
		 
		 
		 
		 if($addpos == 4){ //ถ้าตำแหน่ง @ อยู่ตัวที่ 4
			 if($addpos == $lengh1){ $main_office = substr($NUMBER,0,4); $sql = "SELECT * FROM request WHERE OFFICE_ID LIKE '%".$main_office."%' ";}
			 if($addpos < $lengh1){$main_office = substr($NUMBER,0,4); $datenum = substr($NUMBER,$addpos+1,$lengh1);
			 $sql = "SELECT * FROM request WHERE OFFICE_ID LIKE '%".$main_office."%' AND DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$datenum;
			 } 
			 }
						 
		 if($addpos == 1){
			 if($addpos == $lengh1){ $main_office = substr($NUMBER,0,1); $sql = "SELECT * , COUNT(OFFICE) AS NUM FROM request WHERE MAIN_OFFICE LIKE '%".$main_office."%' GROUP BY OFFICE HAVING(COUNT(OFFICE)>0)"; $datenum1 = 0;}
			 if($addpos < $lengh1){$main_office = substr($NUMBER,0,1); $datenum = substr($NUMBER,$addpos+1,$lengh1); $datenum1 = -$datenum;
			 $sql = "SELECT * , COUNT(OFFICE) AS NUM FROM request WHERE MAIN_OFFICE LIKE '%".$main_office."%' 
			 AND DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$datenum1." GROUP BY OFFICE HAVING(COUNT(OFFICE)>0)";
			 }
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
			 
			 echo "<li><a href ='req_office.php?REQ=".$result["MAIN_OFFICE"]."&REQ2=$datenum1'>".$a.".".$result["MAIN_OFFICE"]."  จำนวน  ".$result["NUM"]." เรื่อง</a></li>";
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
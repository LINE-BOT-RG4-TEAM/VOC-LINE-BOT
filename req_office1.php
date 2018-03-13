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
$sql = "SELECT * FROM request WHERE OFFICE LIKE '%".$NUMBER."%' AND DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$NUMBER2;
$sql_type = "SELECT * FROM request WHERE OFFICE LIKE '%".$NUMBER."%' AND DATEDIFF(PEA_DATE_RECIVE,NOW())<=".$NUMBER2." GROUP BY TYPE";
$query = mysqli_query($conn,$sql);
$query_type = mysqli_query($conn,$sql_type);
$mode1 = mysqli_num_rows($query);
while($ofname = mysqli_fetch_array($query)){ $ofname1 = $ofname["OFFICE"];}

?>
<div data-role="page" id="page">
	<div data-role="header" data-theme="b">
		<h1>ข้อมูลข้อร้องเรียน </h1>
	</div>
    <div data-role="content">
   			<?php 
			
			echo "ข้อร้องเรียน  ".$ofname1." จำนวน ".$mode1."  เรื่อง";	
			
			mysqli_data_seek($query,0);
			?>
	</div>
    
    
    <?php
	while($result_type = mysqli_fetch_array($query_type)){
	echo '<div data-role="content">';
	echo '<u><b>ด้าน'.$result_type["TYPE"].'</b></u>';
	echo '</div>';
	       
		   while($result = mysqli_fetch_array($query)){
			   if($result["TYPE"] == $result_type["TYPE"]){
			  echo '<div data-role="content">'; 
			  echo '<ul data-role="listview">';
			  echo "<li><a href ='req_display_det.php?REQ=".$result["REQ_NO"]."'>"." -คำร้องเลขที่ ".$result["REQ_NO"]."</a></li>";
			  echo '</ul>';
			  echo '</div>';
			   }
			    
			   
			   }
	
	     mysqli_data_seek($query,0);
	
	
	
	
	}
	?>
  <div data-role="content">
  <h2><a href="#" class="ui-btn" data-rel="back" > BACK</a></h2>
	</div>  
  
	<div data-role="footer" data-theme="b">
		<h4>PEA</h4>
	</div>
</div>



</body>
</html>
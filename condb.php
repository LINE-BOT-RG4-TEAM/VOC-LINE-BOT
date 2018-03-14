<?php
require('./libs/database/connect-db.php');
$codee = "#GCCW1G3Q";
$sql = "SELECT * FROM tbl_authorize WHERE code=".$codee;
$query = mysqli_query($conn,$sql);
 while($result=mysqli_fetch_array($query))
		 {
	 $t = $result["line"];
		 	 }
//mysqli_close($conn);
echo "testtttttt     ".$t;

?>

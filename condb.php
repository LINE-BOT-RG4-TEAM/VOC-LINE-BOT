<?php
require('./libs/database/connect-db.php');
$codee = "#GCCW1G3Q";
$sql = "SELECT * FROM tbl_authorize WHERE code LIKE '%".$codee."%'";
$query = mysqli_query($conn,$sql);
$mode1 = mysqli_num_rows($query);
 while($result = mysqli_fetch_array($query))
		 {
	 $t = $result['name'];
		 	 }
mysqli_close($conn);
echo $t."   ".$mode1;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
  require('./libs/database/connect-db.php');
    
$name = $_POST["textfield3"];
$lastname = $_POST["textfield2"];
$position = $_POST["textfield"];
$code = $_POST["password"];
  echo $name.$lastname.$position.$code;



$sql_insert ="INSERT INTO tbl_authorize(name,lastname,position,code) VALUES('$name','$lastname','$position','$code')";
mysqli_query($conn,$sql_insert);

  
?>
</head>

<body>
</body>
</html>

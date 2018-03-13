<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
$name = $_POST["textfield3"];
$lastname = $_POST["textfield2"];
$position = $_POST["textfield"];
$code = $_POST["password"];
  echo $name.$lastname.$position.$code;
$url = parse_url(getenv("mysql://b9effd8882e09d:95317074@us-cdbr-iron-east-05.cleardb.net/heroku_c9af4d376fc017f?reconnect=true"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
$conn = new mysqli($server, $username, $password, $db);
if($conn){
echo "connected";
}
else{
echo "fail toconnect";
}
mysqli_set_charset($conn,"utf8");
$sql_insert ="INSERT INTO tbl_authorize(name,lastname,position,code)VALUES('$name','$lastname','$position','$code')";
mysqli_query($conn,$sql_insert);
mysqli_close($conn);
  
?>
</head>

<body>
</body>
</html>

<?php
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
//echo "Hello LINE BOT";
?>

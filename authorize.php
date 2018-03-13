<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Authorize</title>

<SCRIPT language="javascript">
function randomStringp() {
var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZ0123456789";
var string_length = 8;
var password = "";
for (var i=0; i<string_length; i++) {
var rnum = Math.floor(Math.random() * chars.length);
password += chars.substring(rnum,rnum+1);
}
document.randgen.password.value = "#" + password;
}
</SCRIPT>
</head>
		<body>
        		<div align="center">
        			<h1>ลงทะเบียน VOC-BOT</h1>
     			</div>
        
				<div align="center">
                
					<table width="600" border="1">
 						 <tr>
    							<td width="300"><div align="right">ชื่อ</div></td>
    							<td width="300"><input type="text" name="textfield3" id="textfield3" /></td>
						 </tr>
                         
						 <tr>
    							<td><div align="right">นามสกุล</div></td>
    							<td><input type="text" name="textfield2" id="textfield2" /></td>
   
  						 </tr>
                         
 						 <tr>
    							<td><div align="right">ตำแหน่ง</div></td>
    							<td><input type="text" name="textfield" id="textfield" /></td>
    
  						</tr>
                        
  						<tr>
    							<td><div align="right">รหัสยืนยัน</div></td>
   								<td><form name="randgen"><input name="password" id=”"password" type="text" onfocus="randomStringp()" value="" />
         							<input name="" type="button" onClick="randomStringp()" value="GEN">
    							</td>
                                </form>
    					<tr>
    							<td ></td>
        						<td><div align="center"><input type="submit" value="ตกลง" /></div></td>
      					</tr>

				</table>
                
			</div>
	</body>

</html>
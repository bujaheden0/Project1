<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
		<link rel="stylesheet" href="/css/app.css">
		<link rel="stylesheet" type="text/css" href="Main.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href="js/jquery-ui.min.css" rel="stylesheet">
<script language = "JavaScript">
function confirmDelete(){
	return confirm('คุณได้ทำการสมัครสมาชิกเรียบร้อย กรุราตวรจสอบอีเมลของท่าน');
}
</script>
</head>

<body>
<div class="header">
	<div class="top-bar">
		<div class="top-menu-bar">
			<ul class="top-menu">
				<li style="background:#708090;"><a href=""><i class="fa fa-handshake-o" aria-hidden="true"></i> ฝากขายสินค้า</a></li>
				
			</ul>
		</div><!--top-menu-bar-->
	</div><!--top-bar-->
		<div class="middle-bar">
		<div class="middle-menu-bar">
			<div class="brand">
			<a href="#">EZShopping.com</a>
			</div>
			
		</div><!--middle-menu-bar-->
	</div><!--middle-bar-->
</div><!--Header-->
<div class="contianer">

?>
<center><FONT Size="30">สมัครสมาชิก</FONT></center>
</h3>
	<form method="post" enctype = "multipart/form-data" action="instrument_add.php">
	<center>
		<input type="hidden" name="sup_id" value="<?php echo $sup_id;?>">
		<p>อีเมล: <input type="text" name="email" ></input><br><br></p>
		<p>ชื่อ-นามสกุล: <input type="text" name="name"></input><br><br></p>
		รหัสผ่าน: <input type="password" name="password"></input><br><br>
		เบอร์โทร: <input type="text" name="tel"></input><br><br>
		ชื่อบัญชี: <input type="text" name="accname"></input><br><br>
		เลขบัญชี: <input type="text" name="accnum"></input><br><br>
		ที่อยู่: <input type="text" name="address"></input><br><br>
		ชื่อธนาคาร:	<select name= "brand">
					<option value = 'ธนาคารกรุงเทพ' >ธนาคารกรุงเทพ</option>	
					<option value = 'ธนาคารไทยพาณิชย์' >ธนาคารไทยพาณิชย์</option>
					<option value = 'ธนาคารกรุงไทย' >ธนาคารกรุงไทย</option>
					<option value = 'ธนาคารออมสิน' >ธนาคารออมสิน</option>
					<option value = 'ธนาคารกสิกรไทย' >ธนาคารกสิกรไทย</option>
				</select><br><br> 	
		รูป :<input type="file" name="file" id="file"><br><br>
		<button type="submit" class="btn btn-primary" >ยืนยัน</button> 
		<button type="reset" class="btn btn-primary">reset</button>
		</center>
		
	</form>
	</div>

</body>
</html>
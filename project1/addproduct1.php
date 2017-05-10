<!DOCTYPE html>
<html lang="">
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
	return confirm('ท่านต้องการเพิ่มใช่หรือไม่');
}
</script>
<style>
	
	form.input{
		color:green;
		font-size: 12px;
	}

	form.input > *:not(br) {
    color:black;
    font:14px tahoma;
	}
</style>
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
<div class="container">
<div class="brand">
     	<ul class="nav nav-pills">
        <li role="presentation" class="active"><a href="#">เพิ่มสินค้าใหม่</a></li>
		 <li role="presentation"><a href="#">ขายอยู่</a></li>
		 </ul>
		 </div>
  </div>
  </div>
	<div class="contianer">
<center><br><FONT Size="30">เพิ่มสินค้า</FONT></center>
</h3>
	<form method="post" enctype = "multipart/form-data" action="addproduct2.php" class="input">
	<center>
		<p> ชื่อสินค้า  : <input type="text" name="Pname"></input></p>
		<p> รายละเอียดสินค้า   <textarea name="Pdes"></textarea></p> 
		<p>  หมวดหมู่    :	<select name= "Ptype">
					<option value = 'คียบอร์ด' >คียบอร์ด</option>	
					<option value = 'มอนิเตอร์' >มอนิเตอร์</option>
					<option value = 'เมาส์' >เมาส์</option>
					<option value = 'หูฟัง' >หูฟัง</option>
				</select></p>
		<p> ราคา    : <input type="text" name="Pprice"></input></p>
		<p> คลัง      : <input type="text" name="Pstock"></input><p>
		รูป 	<input type="file" name="img"/><br><br>
		<input type="submit" value="Submit" onClick="return confirmDelete();"> <input type="reset" value="Reset">
		</center>
		</form>
	</div>

	</body>
</html>
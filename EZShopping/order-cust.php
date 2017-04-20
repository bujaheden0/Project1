
<?php
session_start();
if(!$_POST) {
	exit;
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Store</title>
<link rel="stylesheet" type="text/css" href="order.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
	.container{
		width:960px;
	}
	form {
		margin: 20px auto;
		width: 95%;
		border: solid 0px;
		font-size: 12px;
		color: green;
	}
	form  > * {
		font: 14px tahoma;
		padding: 3px;	
	}
	input {
		width: 200px;
	}
	textarea {
		width: 417px;
		height: 40px;
		resize: none;
		overflow: auto;
	}
	input, select, textarea {
		margin: 3px;
		background: #ffc;
		border: solid 1px gray;
	}
	[name=name]{
		width: 200px;
	}
	[name=phone] {
		width: 200px;
	}
	label {
		font-size: 12px;
		color: green;
		display: inline-block;
	}
	select {
		width: 207px;
	}
	h2.warning {
		text-align: left !important;
	}
	span#forget-pswd {
		width: 425px;
		display: block;
		text-align: right;
		margin: -5px 0px 10px 0px;
	}
	span#forget-pswd a {
		font-size: 12px;
	}
	.footer{
		background: Gainsboro;
		padding:5px;
	}

	.footer button.confirm{
		float: right;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
$(function() {
	$('button#cust-info').click(function() {
		$('form').submit();
	});
	
	$('button.confirm').click(function() {
		if(!confirm('ยืนยันการสั่งซื้อ')) {
			return false;
		}
		$.ajax({
			url: 'order-check-email.php',
			data: $('[name=email],[name=cust_id]').serializeArray(),
			dataType:'html',
			type: 'post',
			beforeSend: function() {
				$.blockUI({message:'<h3>กำลังตรวจสอบรายการสั่งซื้อ</h3>'});
			},
			success: function(result) {
				if(result.length > 0) {
					alert(result);
				}
				else {
					$('form').attr('action', "order-confirm.php");
					$('button[type=submit]').click();					
				}
			},
			complete: function() {
				$.unblockUI();
			}			
		});
	});

	$('button.index').click(function() {
		location.href = "main.php";
	});
	
	$('button.back').click(function() {
		location.href = "order-cart.php";
	})
	
});
</script>
</head>
<body>
<div class="header">
	<div class="container">
	<a href="main.php"><h1>EZShopping.com</h1></a>
	<ul>
		<li>ตะกร้าสินค้า</li>
		<li style="background: #B0C4DE;">ที่อยู่ในการจัดส่ง</li>
		<li>ยืนยันการสั่งซื้อ</li>
		<li>ช่องทางการชำระเงิน</li>
	</ul>
	</div>
</div>
<div id="container">
<div id="content">
<form method="post">
<?php
include "dblink.php";
$data = array();
$email = $_SESSION['email'];
$pswd = $_SESSION['password'];
if($_POST['email']) {
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];
	$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$pswd'";
	$r = mysqli_query($link, $sql);
	if(mysqli_num_rows($r)==0) {
		echo '<h2 class="warning">ไม่พบข้อมูล  ท่านอาจใส่อีเมลหรือรหัสผ่านผิด</h2>';
	}
	else {
		$data = mysqli_fetch_array($r);
	}
}
?>
<!-- ถ้าเป็นลูกค้าเก่าที่โพสต์อีเมลและรหัสผ่านเข้ามาถูกต้อง ข้อมูลในตัวแปร $data จะถูกนำไปเติมลงในฟอร์ม 
 	  แต่หากเป็นลูกค้าใหม่ หรือกรณีใส่อีเมล/รหัสผ่านผิด ตัวแปร $data จะเป็นค่าว่างจึงไม่มีข้อมูลเติมลงในฟอร์ม -->

	<span>กรุณาใส่ข้อมูลของท่านให้ครบสมบูรณ์และชัดเจน สำหรับการจัดส่งสินค้า</span><br>
    <input type="hidden" name="cust_id" value="<?php echo $data['cust_id'];?>">
	<input type="email" name="email" placeholder="อีเมล *" required value="<?php echo $email;?>">
    <input type="password" name="pswd" placeholder="รหัสผ่าน *" maxlength="20" required value="<?php echo $pswd;?>">
    <button type="button" id="cust-info">ใช้ข้อมูลเดิม</button>
    <label>ถ้าเคยสั่งซื้อสินค้า ให้ใส่อีเมลและรหัสผ่าน <br>แล้วคลิกที่ปุ่มนี้ หากต้องการใช้ข้อมูลเดิม</label>
    <span id="forget-pswd"><a href="#">ลืมรหัสผ่าน</a></span>
    <input type="text" name="name" placeholder="ชื่อ และ นามสกุล" required value="<?php echo $data['name'];?>"> <input type="text" name="phone" placeholder="โทรศัพท์ *" required value="<?php echo $data['phone'];?>">  ชื่อ - นามสกุล  เบอร์โทรศัพท์<br>
    <textarea name="address" placeholder="ที่อยู่ *" required><?php echo $data['address'];?></textarea> ที่อยู่<br>
    
    <!--<select name="payment">
    	<option>วิธีชำระเงิน</option>
        <option value="bank-transfer">- โอนผ่านธนาคาร</option>
     </select> โทรศัพท์ - วิธีชำระเงิน-->
     <button type="submit" style="display:none;"></button>
</form>
	<div class="footer">
	<button class="index btn btn-primary">&laquo; หน้าแรก</button>
	<button class="back btn btn-primary">&laquo; ย้อนกลับ</button>
	<button class="confirm btn btn-primary">ขั้นตอนต่อไป &raquo;</button>
	</div>
</div>
</div>
</body>
</html>
<?php mysqli_close($link); ?>
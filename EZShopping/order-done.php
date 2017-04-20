<?php
session_start();
if(!$_POST) {
	exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Online Store</title>
<link rel="stylesheet" type="text/css" href="order.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
	.container{
		width: 960px;
	}
	div#panel > img {
		width: 64px;
		margin-right: 20px;
		float: left;
		vertical-align: top;
	}
	div#panel > div#text-done {
		float: left;
		width: 550px;
	}
	#text-done span {
		font-size: 18px;
		color: white;
		margin-top: 20px;
	}
	#order-detail {
		font-size: 14px !important;
		padding: 20px;
	}

	.order-done{
		background: #F8F8FF;
		width: 850px;
		margin:auto;
		
	}
	#text-done{
		width:850px;
		background:#2F4F4F;
		margin: auto;
		padding: 10px;
	}

	.order-done span.id{
		color:blue;
		font-weight: bold;
	}

	.order-done span.amount{
		color:green;
		font-weight: bold;
	}

	.order-done span.bank{
		color:#191970;
		font-weight: bold;
		margin-left: 20px;
	}

	.order-done span.notice1{
		color:red;
		font-weight: lighter;
		margin-left: 20px;
	}
	.order-done span.notice2{
		
		font-weight:bold;
		
	}
	.footer{
		background:#DCDCDC;
		padding:5px;
		height: 44px;

	}
	.footer button.end{
		float: right;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script>
$(function() {
	$('button.end').click(function() {
		location.href = "main.php";
	});
});
</script>
</head>
<body>
<div class="header">
	<div class="container">
	<a href="main.php"><h1>EZShopping.com</h1></a>
	<ul>
		<li>ตะกร้าสินค้า</li>
		<li>ที่อยู่ในการจัดส่ง</li>
		<li>ยืนยันการสั่งซื้อ</li>
		<li style="background: #B0C4DE;">ช่องทางการชำระเงิน</li>
	</ul>
	</div>
</div>
<div id="container">
<div id="content">
<?php
include "dblink.php";
$cust_id = $_POST['cust_id'];
$email = $_POST['email'];
$pswd = $_POST['pswd'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$phone = $_POST['phone'];

	$sql = "REPLACE INTO customers (cust_id,email,password,firstname,lastname,address,phone,verufy) VALUES(
			'$cust_id', '$email', '$pswd', '$firstname', '$lastname', '$address', '$phone','')";



mysqli_query($link, $sql);
//ถ้าเป็นลูกค้าใหม่ให้อ่านค่า id ของข้อมูลที่พึ่งเพิ่มลงในตาราง customers
//ทั้งนี้หากเป็นลูกค้าเก่า จะมีค่า id เดิมโพสต์มากับฟอร์มแล้ว
if(empty($cust_id)) {
	$cust_id = mysqli_insert_id($link);
}
//สร้างรายการสั่งซื้อของลูกค้าคนนี้
$sql = "INSERT INTO orders (cust_id,order_date,paid,delivery,recieve) VALUES('$cust_id', NOW(), 'no', 'no','no')";
$r = mysqli_query($link, $sql);
$order_id = mysqli_insert_id($link);

$sid = session_id();
$sql = "SELECT * FROM cart WHERE session_id = '$sid'";
$r = mysqli_query($link, $sql);

//นำข้อมูลจากตาราง cart มาเพิ่มลงในตาราง  order_details ทีละแถวจนครบ
while($cart = mysqli_fetch_array($r)) {
	$pro_id = $cart['pro_id'];
	$quan = $cart['quantity'];
	$attr = $cart['attribute'];
	$sql = "INSERT INTO order_details (order_id,pro_id,attribute,quantity,recieve) VALUES('$order_id', '$pro_id', '$attr', '$quan','no')";
	mysqli_query($link, $sql);
}
//หลังจากคัดลอกข้อมูลของลูกค้ารายนั้นจากตาราง cart ไปจัดเก็บแล้ว ก็ลบข้อมูลในตาราง cart ทิ้ง
$sql = "DELETE FROM cart WHERE session_id = '$sid'";
mysqli_query($link, $sql);
 
mysqli_close($link);
$amount = $_SESSION['amount'];
?>
	
		<div class="order-done">
    	<div id="text-done">
    		<span>การสั่งซื้อเสร็จเรียบร้อย</span>
    		</div>
            <div id="order-detail">
				<b>รหัสการสั่งซื้อ:</b> <span class="id"><?php echo $order_id; ?></span> <br>
				<b>รวมเป็นเงินทั้งสิ้น:</b> <span class="amount"><?php echo $amount; ?> บาท</span>   <br>
				<b>ช่องทางการโอนเงิน : </b><br>
					<span class="bank">1 ธนาคาร ไทยพาณิชย์ สาขา... ชื่อบัญชี... หมายเลข.... </span><br>
					<span class="bank">2 ธนาคาร กสิกรไทย  สาขา... ชื่อบัญชี... หมายเลข.... </span><br>
					<span class="bank">3 ธนาคาร กรุงเทพ     สาขา... ชื่อบัญชี... หมายเลข.... </span><br>
					<span class="bank">4 ธนาคาร กรุงไทย สาขา... ชื่อบัญชี... หมายเลข.... </span><br><br>
                    
 				<span class="notice1"><i>หลังการโอนเงิน ให้เข้ามาที่หน้าแรกของเว็บไซต์แล้วคลิกที่ปุ่ม "แจ้งการโอนเงิน"</i></span><br>
 				<span class="notice1"><i><b>กรุณาชำระเงินภายใน 24 ชม</b> มิฉะนั้นข้อมูลการสั่งซื้อของท่านอาจจะถูกยกเลิก</i></span><br><br>

				<span class="notice2">ท่านสามารถตรวจสอบข้อมูลต่างๆเกี่ยวกับการสั่งซื้อสินค้าของท่าน เช่น
				รหัสการสั่งซื้อ, สถานะการโอนเงิน, การจัดส่ง โดยเข้ามาที่หน้าแรกของเว็บไซต์แล้วคลิกที่ปุ่ม "ประวัติการสั่งซื้อ"</span><br><br>

				
    		</div>
    	<div class="footer">
    		<button class="end btn btn-success">เสร็จสิ้นการสั่งซื้อ</button>
    	</div>
    </div>
    <br class="clear">
</div>
</div>
</div>
</body>
</html>
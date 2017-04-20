<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Online Store</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="order.css">
<style type="text/css">
	body{
		margin:auto;
	}
	
	table {
		margin: 10px auto;
		border-collapse: collapse;
	}
	tr:nth-of-type(odd) {
		background: #CFC;
	}
	tr:nth-of-type(even) {
		background: #ddd;
	}
	tr:last-child td {
		border-top: solid 1px white;
		background: powderblue !important;
		padding: 5px;
		font-weight: bold;
		text-align: center;	
	}
	tr:last-child td:first-child {
		
	}
	tr:last-child td:nth-child(2) {
		
	}
	th {
		background: green;
		color: yellow;
		padding: 5px;
		text-align: center;
	}
	td {
		padding: 3px;
	}
	th:not(:last-child), td:not(:last-child) {
		border-right: solid 1px white;
	}
	
	td:nth-child(1) {
		width: 230px;
	}
	td:nth-child(2) {
		width: 130px;
		text-align: center;
	}
	td:nth-child(3) {
		width: 70px;
		text-align: center;
		
	}		
	td:nth-child(4) {
		width: 70px;
		text-align: center;
	}
	td:nth-child(5), td[colspan]+td {
		width: 80px;
		text-align: center;
	}
	td:nth-child(6) {
		width: 120px;
		text-align: center;
	}

	.address td:nth-child(1){
		width: 140px;
	}

	.address td:nth-child(2){
		width: 230px;
	}
	.address td:nth-child(3){
		width: 140px;
	}
	.address td:nth-child(4){
		width: 130px;
	}
	[name=quantity] {
		width: 50px;
		text-align: center;
	}
	form {
		display: none;
	}
	caption {
		text-align: left;
		padding: 3px;
	}
	table+span {
		font-style: italic;
		display: block;
		width: 760px;
		text-align: right;
		color: brown;
		font-size: 15px;
	}

	span{
		
		margin:auto;
		

	}
	.out-of-stock {
		color:red;
		text-align:center;
		display: block;
	}

	.footer{
		background: Gainsboro;
		padding:5px;
	}

	.footer button.cancle {
		float: right;
	}
	.footer button.confirm{
		float:right;
		margin-right: 5px;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script>
$(function() {
	$('button.confirm').click(function() {
		$('form').attr('action', "order-done.php");
		$('form').submit();
	});

	$('button.index').click(function() {
		location.href = "main.php";
	});

	$('button.cancle').click(function(){

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
		<li style="background: #B0C4DE;">ยืนยันการสั่งซื้อ</li>
		<li>ช่องทางการชำระเงิน</li>
	</ul>
	</div>
</div>


<div class="container">
<div id="content">
<?php
include "dblink.php";
$cust_id = $_POST['cust_id'];
$email = $_POST['email'];
$pswd = $_POST['pswd'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];	

$sid = session_id();
$sql = "SELECT cart.*, products.pro_name, products.price FROM cart
			LEFT JOIN products
			ON cart.pro_id = products.pro_id
			WHERE session_id = '$sid'";
$result = mysqli_query($link, $sql);
$num_items =  mysqli_num_rows($result);
?>
<table border="0">
<tr><th>ชื่อสินค้า</th><th>จำนวน</th><th>ราคา</th><th>รวม</th></tr>
<?php
$grand_total = 0;
while($cart = mysqli_fetch_array($result)) {
	//แทนที่ ","ด้วย <br> เพื่อแยกแต่ละคุณลักษณะไว้คนละบรรทัด
	$attr = preg_replace("/,/", "<br>", $cart['attribute']);
	$price = number_format($cart['price']);
	$sub_total = number_format($cart['quantity'] * $cart['price']);
	echo "<tr>";
	echo "<td>{$cart['pro_name']}</td>";
	echo "<td>{$cart['quantity']}</td>";
	echo "<td>$price</td>";
	echo "<td>$sub_total</td>";
	
	$grand_total += $cart['quantity'] * $cart['price'];
}

//เก็บผลรวมไว้ในเซสชั่นเพื่อนำไปแสดงผลในขั้นตอนสุดท้ายที่เพจ order-done.php
$_SESSION['amount'] = number_format($grand_total);  	
?>
<tr><td colspan="3">รวมทั้งหมด</td><td><?php echo number_format($grand_total); ?></td></tr>
</table>

<table class="address" border="0">
	<tr><th>ชื่อ</th><th>ที่อยู่</th><th>เบอร์โทรศัพท์</th></tr>
	<?php
	echo "<tr>";
	echo "<td>$name</td>";
	echo "<td>$address</td>";
	echo "<td>$phone</td>";
	?>
</table>
<form method="post">
<input type="hidden" name="cust_id" value="<?php echo "$cust_id";?>">
<input type="hidden" name="email" value="<?php echo "$email";?>">
<input type="hidden" name="pswd" value="<?php echo "$pswd";?>">
<input type="hidden" name="name" value="<?php echo "$name";?>">
<input type="hidden" name="address" value="<?php echo "$address";?>">
<input type="hidden" name="phone" value="<?php echo "$phone";?>">
<button type="submit" style="display:none;"></button>
</form>   
<div class="footer">
<button class="index btn btn-primary">&laquo; หน้าแรก</button>
<button class="cancle btn btn-danger">ยกเลิกการสั่งซื้อ</button>
<button class="confirm btn btn-success">ยืนยันการสั่งซื้อ</button>

</div>
</div>

</div>
</div>
<script type="text/javascript" src="main.js"></script>
</body>
</html>
<?php mysqli_close($link); ?>
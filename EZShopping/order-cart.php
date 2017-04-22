
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

</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script>
$(function() {
	$('button.save-change').click(function() {
		var id = $(this).attr('data-id');
		$('form [name=item_id]').val(id);
		var tr = $(this).parent().parent();  //หาแถวของปุ่มที่ถูกคลิก
		var q = tr.find('input[name=quantity]').val();
		if(!$.isNumeric(q)) {
			alert('จำนวนต้องเป็นเลขจำนวนเต็มเท่านั้น');
			return false;
		}
		$('form [name=action]').val('save-change');
		$('form [name=quantity]').val(q);
		$('form').submit();
	});
	
	$('button.delete').click(function() {
		if(!confirm('ยืนยันการลบรายการนี้ออกจากรถเข็น')) {
			return false;
		}
		var id = $(this).attr('data-id');
		$('form [name=action]').val('delete');
		$('form [name=item_id]').val(id);
		$('form').submit();
	});
	
	$('button.next').click(function() {
		$('form').attr('action', "order-cust.php");
		$('form').submit();
	});

	$('button.index').click(function() {
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
		<li style="background: #B0C4DE;">ตะกร้าสินค้า</li>
		<li>ที่อยู่ในการจัดส่ง</li>
		<li>ยืนยันการสั่งซื้อ</li>
		<li>ช่องทางการชำระเงิน</li>
	</ul>
	</div>
</div>


<div class="container">
<div id="content">
<?php
include "dblink.php";

if($_POST) {
	$item_id = $_POST['item_id'];
	if($_POST['action'] == "save-change") {
		$quan = intval($_POST['quantity']);
		$sql = "SELECT cart.pro_id, products.quantity FROM cart 
		 			LEFT JOIN products ON cart.pro_id = products.pro_id
					WHERE cart.item_id = '$item_id'";
		$r = mysqli_query($link, $sql);
		$pro = mysqli_fetch_array($r);
		$old_quan = $_POST['quantity'] + $pro['quantity'];	
		if($quan > $pro['quantity']) {
			echo '<br><span class="out-of-stock">จำนวนสินค้าในสต๊อกมีไม่เพียงพอกับจำนวนที่ท่านระบุ</span>';
		}
		else {
			$sql = "UPDATE cart SET quantity = '$quan' WHERE item_id = '$item_id'";
			mysqli_query($link, $sql);
		}
	}
	else if($_POST['action'] == "delete") {
		$sql = "DELETE FROM cart WHERE item_id = '$item_id'";
		mysqli_query($link, $sql);	
	}
}

$sid = session_id();
$sql = "SELECT cart.*, products.pro_name, products.price FROM cart
			LEFT JOIN products
			ON cart.pro_id = products.pro_id
			WHERE session_id = '$sid'";
$result = mysqli_query($link, $sql);
$num_items =  mysqli_num_rows($result);
if($num_items == 0) {
	echo '<center><h2 class="warning">ไม่มีสินค้าในรถเข็น</h2></center>';
}
else {
?>
<table border="0">
<caption>พบสินค้าในรถเข็นทั้งหมด: <?php echo $num_items; ?> รายการ </caption>
<tr><th>ชื่อสินค้า</th><th>คุณลักษณะ</th><th>จำนวน</th><th>ราคา</th><th>รวม</th><th>แก้ไข</th></tr>
<?php
$grand_total = 0;
while($cart = mysqli_fetch_array($result)) {
	//แทนที่ ","ด้วย <br> เพื่อแยกแต่ละคุณลักษณะไว้คนละบรรทัด
	$attr = preg_replace("/,/", "<br>", $cart['attribute']);
	$price = number_format($cart['price']);
	$sub_total = number_format($cart['quantity'] * $cart['price']);
	echo "<tr>";
	echo "<td>{$cart['pro_name']}</td>";
	echo "<td>$attr</td>";
	echo '<td><input type="number" name="quantity" min="1" value="'. $cart['quantity'] . '"></td>';
	echo "<td>$price</td>";
	echo "<td>$sub_total</td>";
	echo '<td>
					<button class="save-change" data-id="' . $cart['item_id'] . '">บันทึก</button>
					<button class="delete" data-id="' . $cart['item_id'] . '">ลบ</button>
			</td>';
	$grand_total += $cart['quantity'] * $cart['price'];
}

//เก็บผลรวมไว้ในเซสชั่นเพื่อนำไปแสดงผลในขั้นตอนสุดท้ายที่เพจ order-done.php
$_SESSION['amount'] = number_format($grand_total);  	
?>
<tr><td colspan="4">รวมทั้งหมด</td><td><?php echo number_format($grand_total); ?></td><td>&nbsp;</td></tr>
</table>
<span>หากมีการแก้ไขจำนวนสินค้ารายการใด ให้คลิกปุ่ม "บันทึก" ที่รายการนั้นด้วยทุกครั้ง</span> <br>
<form method="post">
	<input type="hidden" name="action">
	<input type="hidden" name="item_id">
    <input type="hidden" name="quantity">
</form>
<?php
}		//end if (ถ้ามีสินค้าในรถเข็น)
?>
<div class="button">
<button class="index btn btn-primary">&laquo; หน้าแรก</button>
<?php
	if($num_items > 0){
		if(isset($_SESSION['user'])) { 
		echo '<button class="next btn btn-primary">ขั้นตอนถัดไป &raquo;</button>';
	}
	}
?>
</div>
</div>

</div>
</div>
<script type="text/javascript" src="main.js"></script>
</body>
</html>
<?php mysqli_close($link); ?>
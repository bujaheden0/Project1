<?php 
session_start();
	if($_SESSION['sup_id'] == "")
	{
		echo "Please Login!";
		exit();
	}

$sup_id = $_SESSION['sup_id'];
 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Data Store</title>
<style>
	@import "global.css";
	caption {
		text-align: left;
		padding-bottom: 3px !important;
	}
	td:nth-child(1) {
		width: 100px;
	}
	td:nth-child(2) {
		width: 100px;
		text-align: left !important;
	}
	td:nth-child(3) {
		width: 130px;
		text-align: left !important;
	}
	td:nth-child(4) {
		width: 80px;
	}
	td:nth-child(5) {
		width: 120px;
		text-align: center;
	}
	td:nth-child(6) {
		width: 200px;
		text-align: left !important;
	}
	td:nth-child(7) {
		width: 100px;
	}
	td:nth-child(8) {
		width: 100px;
	}
	table th {
		background: green;
		color: yellow;
		padding: 5px;
		border-right: solid 1px white;
		font-size:12px;
	}
	tr:nth-of-type(odd) {
		background: lavender;
	}
	tr:nth-of-type(even) {
		background: whitesmoke;
	}
	td {
		text-align: center;
		vertical-align: top;
		padding: 3px 0px 3px 3px;
		border-right: solid 1px white;
	}
	td a:hover {
		color: red;
	}
	p#pagenum {
		width: 90%;
		text-align: center;
		margin: 5px;
	}
	#dialog {
		display: none;
		font-size: 14px !important;
	}
	#form-sup [type=text],  #form-sup textarea{
		width: 370px;
		background: lavender;
		border: solid 1px gray;
		padding: 3px;
		margin-bottom: 3px;
		font-size: 14px;
	}
	#form-sup textarea {
		resize: none;
		overflow: auto;
	}
	td:last-child a {
		font-size: 11px;
		border: solid 1px #999;
		display: inline-block;
		padding: 2px;
		text-decoration: none;
		color:blue;
		border-radius: 3px;
	}
	td:last-child a:hover {
		color:red;
		background: #ffc;
	}
	td img {
		height: 16px;
		vertical-align: top;
	}
	form {
		float: right;
	}
	form button {
		float: none !important;
		font-size: 13px;
		background: steelblue;
		color: white;
		border-radius: 5px;
	}
	a.disable {
		cursor: default;
		background: whitesmoke !important;
		color: silver !important;
	}
	a.disable:hover {
		background: whitesmoke !important;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
$(function() {
	$('a.enable').click(function() {
		ajaxSend($(this), 'confirm');
	});
	$('a.delete').click(function() {
		ajaxSend($(this),'delete');
	});
});

function ajaxSend(a, action) {
	if(!confirm('ยืนยันการกระทำนี้')) {
		return;
	}
	var payID = a.attr('data-id');
	var orderID = a.attr('data-order');
	var custID = a.attr('data-cust');
	var d = {'action':action, 'order_id':orderID, 'pro_id':payID, 'cust_id':custID};
	$.ajax({
		url: 'payment-action.php',
		data: d,
		dataType: 'html',
		type: 'post',
		beforeSend: function() {
			$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
		},
		success: function(result) {
			location.reload();
		},
		complete: function() {
			$.unblockUI();
		}
	})	;
}
</script>
</head>

<body>
<?php include "top.php"; ?>
<article>
<?php
include "dblink.php";
include "lib/pagination.php";
/*SELECT payments.*, customers.email
 			FROM payments LEFT JOIN customers ON payments.cust_id = customers.cust_id 
 			ORDER BY pay_id DESC*/
$sql = "SELECT order_details.*,orders.*,customers.*,products.pro_name,products.price
FROM orders LEFT JOIN order_details ON order_details.order_id = orders.order_id RIGHT JOIN customers ON orders.cust_id = customers.cust_id RIGHT JOIN products on order_details.pro_id = products.pro_id
WHERE order_details.pro_id IN (SELECT products.pro_id FROM products WHERE sup_id = '$sup_id')
ORDER BY item_id";
$result = page_query($link, $sql, 20);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}
?>
<table>
<caption>
	<?php 	echo "รายการแจ้งโอนเงินลำดับที่  $first - $last จาก $total"; ?>
</caption>
<tr><th>รหัสการสั่งซื้อ</th><th>ชื่อสินค้า</th><th>ราคา</th><th>จำนวน</th><th>เวลา</th><th>ชื่อผู้ซื้อ</th><th>ที่อยู่ผู้ซื้อ</th><th>คำสั่ง</th></tr>
<?php
while($pay = mysqli_fetch_array($result)) {
	$class = 'enable';
	$img_pay = "images/no.png";
	if($pay['delivery']=='yes') {
		$class = 'disable';
		$img_pay = "images/yes.png";
	}
?>
<tr>
	<td><?php echo $pay['order_id'];; ?></td>
    <td><?php echo $pay['pro_name']; ?></td>
    <td><?php echo $pay['price']*$pay['quantity']; ?></td>
    <td><?php echo $pay['quantity']; ?></td>
    <td><?php echo $pay['order_date']; ?></td>
    <td><?php echo $pay['name']; ?></td>
    <td><?php echo $pay['address']; ?></td>
		
    <td>
    		<img src="<?php echo $img_pay; ?>">
    		<a href="#" class="<?php echo $class; ?>" 
            		data-id="<?php echo $pay['pro_id']; ?>" 
            		data-order="<?php echo $pay['order_id']; ?>">ส่งของแล้ว</a>
     		<!--<a href="#" class="delete" data-id="<?php echo $pay['pay_id']; ?>">ลบ</a>-->
    </td>
</tr>
<?php
}
?>
</table>
<?php
if(page_total() > 1) { 	 //ให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
	echo '<p id="pagenum">';
	page_echo_pagenums();
	echo '</p>';
}
?>
</article>
</body>
</html>
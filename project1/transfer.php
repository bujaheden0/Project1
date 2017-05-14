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
		padding-bottom: 3px;
	}
	#c1 {
		width: 50px;
	}
	#c2 {
		width: 100px;
	}
	#c3 {
		width: 100px;
	}
	#c4 {
		width: 250px;
	}
	#c5 {
		width: 150px;
	}
	#c6 {
		width: 110px;
	}
	#c7 {
		width: 110px;
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
		vertical-align: top;
		padding: 3px 0px 3px 5px;
		border-right: solid 1px white;
	}
	td:first-child, td:last-child {
		text-align: center;
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
</style>
<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
$(function() {
	$('#add-sup').click(function() {  //คลิกปุ่ม "เพิ่มผู้จัดส่งสินค้า"
		$('#form-sup')[0].reset();
		$('#action').val('add');
 		showDialog();
	});

	
	$('#send').click(function() {		//คลิกปุ่ม "ส่งข้อมูล" ที่อยู่ในไดอะล็อก
		var data = $('#form-sup').serializeArray();
		ajaxSend(data);
	});
	
	$('button.edit').click(function() {
		var orderID = $(this).attr('data-id');
		var url = "transfer-detail.php?tran_id=" + orderID ;
		location.href = url;
	});	
	
	$('button.del').click(function() {
		if(!(confirm("ยืนยันการลบรายการโอนดังกล่าว"))) {
			return;
		}
		var id = $(this).attr('data-id');
		ajaxSend({'action': 'del', 'tran_id': id});
	});
		
});

function showDialog() {
	$('#dialog').dialog({
		title: 'รายการโอนเงินที่',
		width: 'auto',
		modal: true,
		position: { my: "center top", at: "center top", of: $('nav')}
	});	
}
function ajaxSend(dataJSON) {
	$.ajax({
		url: 'transfer-action.php',
		data: dataJSON,
		type: 'post',
		dataType:"html",
		beforeSend: function() {
			$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
		},
		complete: function() {
			$.unblockUI();
			location.reload();
		}
	});
}
 

</script>
</head>

<body><?php include "top.php"; ?>
<article>
<?php
include "dblink.php";
include "lib/pagination.php";
$sum1 = 0;
$sql1 = "SELECT * FROM `transfer` WHERE sup_id = '$sup_id' AND tran_status = 'yes'";
$result1 = page_query($link, $sql1, 20);
$first = page_start_row();
$row = $first;
$index = 0;
while($sup1 = mysqli_fetch_array($result1)) {
	
 	//echo $sup1['tran_amount']; 
	$row++;
	$sum1 += $sup1['tran_amount'];
}
?>
<center><h1>ยอดรายได้ทั้งหมด = <?php echo "$sum1"?></h1></center>
<?php

$sql = "SELECT * FROM `transfer` WHERE sup_id = '$sup_id'";
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
	<?php 	echo "รายการโอนเงิน  $first - $last จากทั้งหมด $total  "; ?>
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"><col id="c4"><col id="c5"><col id="c6"></colgroup>
<tr><th>ลำดับ</th><th>วันที่พักบัญชี</th><th>บัญชีผู้รับ</th><th>ชื่อ</th><th>จำนวนเงิน</th><th>สถานะการโอน</th></tr>
<?php
$row = $first;
$index = 0;
while($sup = mysqli_fetch_array($result)) {
	if(!empty($sup['website'])) {
		$sup['sup_name'] = "<a href=\"{$sup['website']}\" target=\"_blank\">{$sup['sup_name']}</a>";
	}
?>
<tr>
	<td><?php echo $row; ?></td>
    <td><?php echo $sup['tran_date']; ?></td>
    <td><?php echo $sup['account']; ?></td>
    <td><?php echo $sup['name']; ?></td>
    <td><?php echo $sup['tran_amount']; ?></td>
    <td><?php echo $sup['tran_status']; ?></td>
    
</tr>
<?php
	$row++;
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

<div id="dialog">
<form id="form-sup">
<input type="hidden" name="action" id="action" value="">
รายการที่ :<br>
<input type="text" name="sup_id" id="sup-id" value="" disabled=""><br>
บัญชี :<br>
<input type="text" name="address" id="address" disabled=""><br>
จำนวนเงินที่ต้องชำระ :<br>
<input type="text" name="contact-name" id="contact-name"  disabled=""></textarea><br><br>


<?php
$cust_id = $_GET['orderID'];
$sql2 = "SELECT * FROM order_tran where tran_id = '$cust_id' ";
$result2 = page_query($link, $sql2, 20);
$first2 = page_start_row();
$last2 = page_stop_row();
$total2 = page_total_rows();
if($total2 == 0) {
	$first2 = 0;
}
?>
<table>
<caption>
	<?php 	echo "รายการโอนเงิน  $first2 - $last2 จากทั้งหมด $total2"; ?>
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"></colgroup>
<tr><th>ลำดับ</th><th>ชื่อสินค้า</th><th>ราคา</th></tr>
<?php
$row2 = $first2;
while($sup2 = mysqli_fetch_array($result2)) {
?>
<tr>
	<td><?php echo $row2; ?></td>
    <td><?php echo $sup2['ort_name']; ?></td>
    <td><?php echo $sup2['ort_price']; ?></td>
</tr>
<?php
	$row2++;
}
?>
</table>


<form  method="post" enctype="multipart/form-data">
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Upload Image">
</form>
<br>

<button type="button" id="send">ส่งข้อมูล</button>
</form>
</div>

</article>
</body>
</html>
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
	tr:last-child td {
		border-top: solid 1px white;
		background: powderblue !important;
		padding: 5px;
		font-weight: bold;
		text-align: center !important;	
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
/*$(function() {
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
		var order_tranID = $(this).attr('data-id');
		var url = "order-tran_submit1.php?order_tran_id=" + order_tranID ;
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
}*/
 

</script>
</head>

<body><?php include "top.php"; ?>
<article>
<?php
include "dblink.php";
include "lib/pagination.php";
$sum = 0;
$sql = "SELECT order_tran.*,orders.*,customers.*,products.pro_name
FROM order_tran
LEFT JOIN orders ON order_tran.order_id = orders.order_id 
LEFT JOIN order_details ON order_details.order_id = orders.order_id 
RIGHT JOIN customers ON customers.cust_id = orders.cust_id
RIGHT JOIN products ON products.pro_id = order_details.pro_id
WHERE order_details.pro_id IN (SELECT products.pro_id FROM products WHERE sup_id = '$sup_id') 
AND tran_id = 0";
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
	<?php 	echo "รายการโอนเงิน  $first - $last จากทั้งหมด $total"; ?>
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"><col id="c4"><col id="c5"><col id="c6"></colgroup>
<tr><th>ลำดับ</th><th>วันที่ซื้อ</th><th>ชื่อสินค้า</th><th>จำนวนเงิน</th><th>จำนวนชิ้น</th><th>ชื่อผู้ซื้อ</th></tr>
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
    <td><?php echo $sup['order_date']; ?></td>
    <td><?php echo $sup['pro_name']; ?></td>
    <td><?php echo $sup['price']; ?></td>
    <td><?php echo $sup['quantity']; ?></td>
    <td><?php echo $sup['name']; ?></td>

    
</tr>
<?php
	$row++;
	$sum += $sup['price'];
}
?>
	<tr>
<td>รวม</td><td></td><td></td><td><?php echo $sum;?></td>
<td>จำนวนเงินที่จะได้รับ <h5><font color="red">  ( ค่าธรรมเนียม 5% จากเดิม </font></h5></td>
<td><?php echo $sum*0.95 ;?> บาท<h5><font color="red">  <?php echo $sum;?> บาท )</font></h5></td>
</tr>
</table>



<?php
include "dblink.php";
//include "lib/pagination.php";

$sql = "SELECT order_tran.*,orders.*,customers.*,products.pro_name, suppliers.sub_accname,suppliers.sup_accnum,suppliers.sup_id
FROM order_tran
LEFT JOIN orders ON order_tran.order_id = orders.order_id 
LEFT JOIN order_details ON order_details.order_id = orders.order_id 
RIGHT JOIN customers ON customers.cust_id = orders.cust_id
RIGHT JOIN products ON products.pro_id = order_details.pro_id
RIGHT JOIN suppliers ON suppliers.sup_id = products.sup_id
WHERE order_details.pro_id IN (SELECT products.pro_id FROM products WHERE sup_id = '$sup_id') 
AND tran_id = 0";
$result = page_query($link, $sql, 20);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}
$row = $first;
$index = 0;
$th=mktime(gmdate("H")+7,gmdate("i"),gmdate("s"),gmdate("y"),gmdate("d"),gmdate("m")+11);
$format="Y-m-d H:i:s";
$str=date($format,$th);
$sup = mysqli_fetch_array($result);
?>

	<form method="post" enctype = "multipart/form-data" action="gg.php">
	<center>
		<input type="hidden" name="sup_id" value="<?php echo $sup_id;?>">
		<input type="hidden" name="date" value="<?php echo $str;?>"></input><br>
		<input type="hidden" name="sub_accname" value="<?php echo $sup['sub_accname'];?>"></input><br>
		<input type="hidden" name="sup_accnum" value="<?php echo $sup['sup_accnum'];?>"></input><br>
		<input type="hidden" name="sum" value="<?php echo $sum*0.95;?>"></input><br>
		<button type="submit" class="btn btn-primary" >ยืนยัน</button> 
		
		</center>
		
	</form>
  </article>  
</body>
</html>
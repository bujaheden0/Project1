<?php 
include "check-login.php";
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
		width: 50px;
	}
	td:nth-child(2) {
		width: 250px;
		text-align: left !important;
	}
	td:nth-child(3) {
		width: 200px;
		text-align: center; !important;
	}
	td:nth-child(4) {
		width: 80px;
	}
	td:nth-child(5) {
		width: 80px;
	}
	td:nth-child(6), td[colspan]+td{
		width: 80px;
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
	
	tr:last-child td {
		border-top: solid 1px white;
		background: powderblue !important;
		padding: 5px;
		font-weight: bold;
		text-align: center !important;	
	}
	
	caption > div {
		float: right;
		color: purple;
	}
	caption > div > button {
		float: none !important;
	}
	caption > div > img {
		height: 16px;
		float:none;
		vertical-align: bottom;
	}
	section#customer {
		margin: 20px 0px 20px 60px;
		font-size: 14px;
	}
	section#customer > span {
		display: inline-table;
		width: 80px;
		font-weight: bold;
		margin: 2px;
	}
	hr {
		width: 85%;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
$(function() {
	$('button#delivery').click(function() {
		if(!confirm('ยืนยันการจัดส่งสินค้าแล้ว')) {
			return;
		}
		var orderID = $(this).attr('data-id');
		$.ajax({
			url: 'order-delivery.php',
			data: {'order_id': orderID},
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
	});
});

</script>
</head>

<body>
<?php include "top.php"; ?>
<article>
<?php
include "dblink.php";
include "lib/pagination.php";
$cust_id = $_GET['tran_id'];
$sql = "SELECT * FROM order_tran where tran_id = '$cust_id' ";
$result = page_query($link, $sql, 20);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}
?>
<center> รายละเอียด </center>

<table>
<caption>
	<?php 	echo "รายการโอนเงิน  $first - $last จากทั้งหมด $total"; ?>
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"></colgroup>
<tr><th>ลำดับ</th><th>ชื่อสินค้า</th><th>ราคา</th></tr>
<?php
$row = $first;
$total;
while($sup = mysqli_fetch_array($result)) {
?>
<tr>
	<td><?php echo $row; ?></td>
    <td><?php echo $sup['name']; ?></td>
    <td><?php echo $sup['price']; ?></td>
    <?php
    $sum += $sup['price'];
    ?>
</tr>
<?php
	$row++;
}
?>
<tr>
<td>รวม</td>
<td>จำนวนที่ต้องโอน</td>
<td><?php echo $sum*0.95 ;?> บาท<h5><font color="red">  ( จากเดิม <?php echo $sum;?> บาท )</font></h5></td>
</tr>
</table><br>
<?php
	include "dblink.php";
	if($_POST){
		$sql = "UPDATE transfer SET tran_status = 'yes' WHERE tran_id = '$cust_id'";
		mysqli_query($link,$sql);
			$tran_id = mysqli_insert_id($link);
			if(is_uploaded_file($_FILES['file']['tmp_name'])){
			if($_FILES['file']['error'] != 0) {
				$err = "กรุณาเลือกไฟล์รูปภาพ";
			}
			else{
				$file = $_FILES['file']['tmp_name'];
				$content = addslashes(file_get_contents($file));

				$sql = "INSERT INTO transfer_images (tran_id,img_content) VALUES('$cust_id', '$content')";
				mysqli_query($link,$sql);
			}
		}
	mysqli_close($link);
	header("Location: transfer.php");
	}
?>
<center>
<?php

include "dblink.php";
	include "lib/IMGallery/imgallery-no-jquery.php";
	$pay_id = $_POST['id'];//////////////////
	$sql = "SELECT * FROM transfer_images where tran_id = '$cust_id'";///////////////////////
	$r = mysqli_query($link, $sql);
	//นำเอารูปมาเก็บไว้ 
if(mysqli_num_rows($r) > 0) {
			echo "<br>";
			$src = "read-image4.php?id=";//quary sql ไฟล์ read-image.php
			gallery_thumb_width(250);
			while($img =mysqli_fetch_array($r)) {
				gallery_echo_img($src . $img['img_id']);
			}
		}
	
?>  

<form  method="post" enctype="multipart/form-data">
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Upload Image">
</form>
<br>
<a href="transfer.php">กลับ</a></center>
</article>
</body>
</html>
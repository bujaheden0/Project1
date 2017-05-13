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
	#form-search {
		width: 750px;
		margin: auto;
	}
	div#search-col1 {
		display: inline-table;
		width: 300px;
	}
	div#search-col2 {
		display: inline-table;
		width: 400px;
	}
	#form-search [type=number] {
		width: 90px;
	}
	#form-search * {
		margin-bottom: 3px;
	}
	table {
		min-width: 840px;
	}
	caption {
		text-align: left;
		padding-bottom: 2px;
	}
	caption button {
		margin-left: 3px;
	}
	#c1 {
		width: 60px;
	}
	#c2 {
		width: 330px;
	}
	#c3 {
		width: 340px;
	}
	#c4 {
		width: 110px;
	}
	table th {
		background: green;
		color: yellow;
		padding: 5px;
		border: solid 1px white;
		font-size:12px;
	}
	tr:nth-of-type(odd) {
		background: #ddd;
	}
	tr:nth-of-type(even) {
		background: #ccf;
	}
	td {
		vertical-align: top;
		padding: 3px 0px 3px 5px;
		border: solid 1px white;
	}
	td:first-child, td:first-child {
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
	#form-pro * {
		padding: 3px;
		margin-bottom: 3px;
	}
	[type=text],  [type=number], textarea, select {
		background: #eee;
		border: solid 1px gray;
	}
	#pro-name {
		width: 460px;
	}
	#detail {
		width: 460px;
		resize: none;
		overflow: auto;
		height: 60px;
	}
	#category {
		width: 158px ;
	}
	#supplier {
		width: 307px;
	}	
	#price, .attr-name, span#propname {
		width: 150px;
		display: inline-block;
	}
	#quantity, .attr-value, span#propval {
		width: 300px;
	}	
	span#propname, span#propval {
		margin-bottom: 0px !important;
	}
	.form-img {
		margin: 0px;
	}
	span.tag {
		width: auto;
		text-align: right;
		font-weight: bold;
		color: green;
		margin-right: 5px;
		display: inline-block;
	}
	.hidden {
		display: none;
	}
</style>
<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.form.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
var fileNo = 1;
var fileCount = 5;

$(function() {
	$('#bt-search').click(function() {
		if($(':radio[name=field]:checked').val() == "category") {
			$('#field-text').val($('#cat-search option:selected').text());
		}
		else if($(':radio[name=field]:checked').val() == "supplier") {
			$('#field-text').val($('#sup-search option:selected').text());
		}
		$('#form-search').submit();
	});
	
	$('#bt-add-pro').click(function() {
 		showDialog();
	});
	
	$('#bt-send').click(function(event) {
		var data = $('#form-pro').serializeArray();
		ajaxSend(data);
	});
	
	fileCount = $('[type=file]').length;
	for(i = 1; i <= fileCount; i++) {
		$('#bt-upload' + i).click(function() {
			uploadFile();
		});
	}
	
	$('button.edit').click(function() {
		var id = $(this).attr('data-id');
		window.open('product-edit.php?id=' + id);
	});
	
	$('button.del').click(function() {
		if(!(confirm("ยืนยันการลบสินค้ารายการนี้"))) {
			return;
		}
		var id = $(this).attr('data-id');
		$.ajax({
			url: 'product-delete.php',
			data: {'action': 'del', 'pro_id': id},
			type: 'post',
			dataType: "html",
			beforeSend: function() {
				$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
			},
			success: function(result) {
				location.reload();
			},
			complete: function() {
				$.unblockUI();
			}
		})			
	});
	
});

function resetForm() {
	$('#form-pro')[0].reset();
	$('input:file').clearInputs();  //อยู่ในไลบรารี form.js
}

function showDialog() {
	fileNo = 1;
	resetForm();
	$('#dialog').dialog({
		title: 'เพิ่มสินค้า',
		width: 'auto',
		modal: true,
		position: { my: "center top", at: "center top", of: $('nav')}
	});	
}

/*function ajaxSend(dataJSON) {
	$.ajax({
		url: 'product-add.php',
		data: dataJSON,
		type: 'post',
		dataType: "html",
		beforeSend: function() {
			$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
		},
		success: function(result) {
			$('#bt-upload' + fileNo).click();
		},
		complete: function() {
			//$.unblockUI();
		}
	});
}

/*function uploadFile() {
	if(fileNo > fileCount) {
		return;
	}
	var input = '#file' + fileNo;
	$('#form-img'  + fileNo).ajaxForm({
		dataType: 'html',
		beforeSend: function() {
			if($(input).val().length != 0) {
				$.blockUI({message:'<h3>กำลังอัปโหลดภาพที่ ' + fileNo + '</h3>'});
			}
		}, 
		success: function(result) {	},
		complete: function() { 
			fileNo++;
			if(fileNo <= fileCount) {
				$('#bt-upload' + fileNo).click();
			}
			else {
				fileNo = 1;
				$('#dialog').dialog('close');
				$.unblockUI();
				location.reload();
			}
		}			
	});
}*/
</script>
</head>

<body>
<?php include "top.php"; ?>
<article>
<?php
include "dblink.php";
include "lib/pagination.php";

$sql = "SELECT * FROM categories";
$r_cat= mysqli_query($link, $sql);
$sql = "SELECT sup_id, sup_name FROM suppliers";
$r_sup = mysqli_query($link, $sql);
?>

<?php
$field = "ทั้งหมด";
$sql = "SELECT products.*, categories.cat_name,  suppliers.sup_name 
 			FROM products
			LEFT JOIN categories 
			ON products.cat_id = categories.cat_id			
			LEFT JOIN suppliers 
			ON products.sup_id = suppliers.sup_id WHERE products.sup_id = '$sup_id'";
						
if(($_GET['field'] == "price") && is_numeric($_GET['price_val'])) {
	$sql .= " WHERE price " . $_GET['price_op'] . " " . $_GET['price_val'];
	$field = "ราคา " . $_GET['price_op'] . " " . $_GET['price_val'];
}
else if(($_GET['field'] == "quantity") && is_numeric($_GET['quan_val'])) {
	$sql .= " WHERE quantity " . $_GET['quan_op'] . " " . $_GET['quan_val'];
	$field = "จำนวนที่มี " .  $_GET['quan_op'] . " " . $_GET['quan_val'];
}
else if(($_GET['field'] == "pro_name") && !empty($_GET['pro_key'])) {
	$sql .= " WHERE pro_name LIKE '%" . $_GET['pro_key'] . "%'";
	$field = "ชื่อสินค้า: '" .  $_GET['pro_key'] . "'";
}
else if($_GET['field'] == "category") {
	$sql .= " WHERE products.cat_id = " . $_GET['cat'];
	$field = "หมวดหมู่: " . $_GET['field_text']; 
}
else if($_GET['field'] == "supplier") {
	$sql .= " WHERE products.sup_id = " . $sup_id;
	$field = "ผู้จัดส่ง: "  . $_GET['field_text']; 
}
$sql .= " ORDER BY pro_id DESC";
$result = page_query($link, $sql, 10);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}
?>

<table border="0">
<caption>
<?php 	echo "สินค้าลำดับที่  $first - $last จาก $total  ($field)"; ?>
<button id="bt-add-pro">เพิ่มสินค้า</button> 
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"><col id="c4"></colgroup>
<?php
include "lib/IMGallery/imgallery-no-jquery.php";
$row = $first;
while($pro = mysqli_fetch_array($result)) {
?>
<tr>
	<td><?php echo $row; ?></td>
    <td>
	<span class="tag">ชื่อสินค้า:</span><?php echo $pro['pro_name']; ?><br>
    <span class="tag">ราคา:</span><?php echo $pro['price']; ?><br> 
    <span class="tag">จำนวนที่มี:</span><?php echo $pro['quantity']; ?> <br>
    <span class="tag">รูปภาพ:</span><br>
 	 <?php
		$sql = "SELECT * FROM product_images WHERE pro_id = {$pro['pro_id']}";
		$r = mysqli_query($link, $sql);
		if(mysqli_num_rows($r) > 0) {
			echo "<br>";
			$src = "read-image.php?id=";
			gallery_thumb_width(50);
			while($img =mysqli_fetch_array($r)) {
				gallery_echo_img($src . $img['img_id']);
			}
		}
	?>   
    </td> 
    <td>
     <span class="tag">รายละเอียด:</span><?php echo $pro['detail']; ?><br>
     <span class="tag">หมวดหมู่:</span><?php echo $pro['cat_name']; ?><br>
     <span class="tag">ผู้จัดส่ง:</span><?php echo $pro['sup_name']; ?><br>
     <span class="tag">คุณลักษณะ:</span>
	 <?php
		$sql = "SELECT * FROM attributes WHERE pro_id = {$pro['pro_id']}";
		$r = mysqli_query($link, $sql);
		if(mysqli_num_rows($r) > 0) {
			echo "<br>";
			while($attr =mysqli_fetch_array($r)) {
				echo "- " .  $attr['attr_name'] . ": " . $attr['attr_value'] . "<br>";
			}
		}
		else {
			echo " - <br>";
		}
	?>
    </td>
     <td>
    	<button class="edit" data-id="<?php echo $pro['pro_id']; ?>">แก้ไข</button> 
    	<button class="del" data-id="<?php echo $pro['pro_id']; ?>">ลบ</button>
    </td>
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
<form id="form-pro" method="post" enctype="multipart/form-data" action="product-add.php">
<input type="hidden" name="pro_id" value="<?php echo $pro_id;?>">
<input type="text" name="pro_name" id="pro-name" placeholder="ชื่อสินค้า1"><br>
<textarea name="detail" id="detail" placeholder="รายละเอียดของสินค้า"></textarea><br>
<input type="text" name="price" id="price" placeholder="ราคาต่อหน่วย">
<input type="text" name="quantity" id="quantity" placeholder="จำนวนสินค้า"><br>
<select name="category" id="category">
	<option>หมวดหมู่ของสินค้า</option>
    <?php 
	mysqli_data_seek($r_cat, 0);
	while($cat = mysqli_fetch_array($r_cat)) {
		echo "<option value=\"{$cat['cat_id']}\">- {$cat['cat_name']}</option>";
	}
	?>
</select>
<select name="supplier" id="supplier">
	<option>ผู้จัดส่งสินค้า (Supplier)</option>
    <?php 
	mysqli_data_seek($r_sup, 0);
	while($sup = mysqli_fetch_array($r_sup)) {
		echo "<option value=\"{$sup['sup_id']}\">- {$sup['sup_name']}</option>";
	}
	?>
</select>
<br><br>
<!--<span id="propname">คุณลักษณะสินค้า (เช่น สี)</span>
<span id="propval">ค่าของคุณลักษณะ (คั่นด้วย ","  เช่น ฟ้า, ขาว, แดง, ดำ)</span><br>
<input type="text" name="attr_name[]" class="attr-name" placeholder="ชื่อคุณลักษณะ (1)">
<input type="text" name="attr_value[]"  class="attr-value" placeholder="ค่าของคุณลักษณะ (1)"><br>
<input type="text" name="attr_name[]" class="attr-name" placeholder="ชื่อคุณลักษณะ (2)">
<input type="text" name="attr_value[]" class="attr-value" placeholder="ค่าของคุณลักษณะ (2)"><br>
<input type="text" name="attr_name[]" class="attr-name" placeholder="ชื่อคุณลักษณะ (3)">
<input type="text" name="attr_value[]" class="attr-value" placeholder="ค่าของคุณลักษณะ (3)"><br>-->

<br>
	ภาพสินค้า #1: <input type="file" name="file" id="file">
    <button type="submit" id="bt-send">ส่งข้อมูล</button> (ภาพสินค้าจะใช้ภาพแรกเป็นภาพหลัก)
</form>
<br>

</div>
</article>
</body>
</html>
<?php mysqli_close($link);  ?>
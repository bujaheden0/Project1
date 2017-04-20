<?php include "include/header.php" ?>
<style>
	
	#head {
		padding: 5px !important;
	}
	h3 {
		text-align: center;
		color: navy;
	}
	
	
	#container{
		width:960px;
		margin:auto;
	}
	#content{
		width:960px;
		height:auto;
		background: #B0C4DE;
	}
	.header-paid{
		width:960px;
		height: 40px;
		background: #2F4F4F;
		margin-top: 10px;
	}
	.header-paid span{
		font-size: 20px;
		font-weight: bold;
		color: white;
		margin-left: 10px;
		line-height: 40px;
	}
	#bottom{
		width:960px;
		background: #A9A9A9;
		padding: 3px;
	}

	.content{
		width: 500px;
		background:;
		margin: auto;
		padding: 20px;
	}

	input[type="password"] {
    	width:250px;
    	margin-bottom: 5px;
	}

	input[type=email]{
		width: 250px;
		margin-bottom: 5px;
	}
	input[name=order_id]{
		width: 250px;
		margin-bottom: 5px;
	}
	input[name=location]{
		width: 116px;
		margin-bottom: 5px;
	}
	input[type="number"]{
		width: 123px;
		margin-bottom: 5px;
	}
	input[name=date]{
		width: 100px;
	}
	input[name=hour]{
		width: 70px;
	}
	input[name=min]{
		width: 72px;
	}
	select{
		width: 130px;
		margin: 0px;
		padding: 0px;

	}
	.warning{
		text-align: center;
		color: red;
		margin: 0px;
	}
	form.input{
		color:green;
		font-size: 12px;
	}

	form.input > *:not(br) {
    color:black;
    font:14px tahoma;
	}
	.submit{
		float: right;
	}
</style>
<script>
$(function() {
	$('[name=date]').datepicker({dateFormat: 'yy/mm/dd'});
	
	$('button#submit').click(function() {
		if($('[name=bank] option:selected').index() == 0) {
			alert('กรุณาเลือกธนาคาร');
			return false;
		}
		$('button[type=submit]').click();
	});

	$('button#index').click(function() {
		location.href = "main.php";
	});
	
});
</script>
<div id="container">
<div class="header-paid">
	<span>แจ้งการจ่ายเงิน</span>
</div>
<div id="content">
<div class="content">
<?php
$err = "";
$email = $_SESSION['email'];
$pswd = $_SESSION['password'];
if($_POST) {
	include "dblink.php";
	include "lib/IMager/imager.php";
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];
 	$sql = "SELECT cust_id FROM customers WHERE email = '$email' AND
 	password = '$pswd'";
 	$r = mysqli_query($link, $sql);
 	$row = mysqli_fetch_array($r);
 	if(mysqli_num_rows($r)==1){
 	$cust_id = $row[0];

	$order_id = $_POST['order_id'];
	$sql = "SELECT COUNT(*) FROM orders WHERE order_id = '$order_id' AND cust_id = '$cust_id'";
	$r = mysqli_query($link,$sql);
	$row = mysqli_fetch_array($r);
	$c = $row[0];
	if($c == 1){
	$bank = $_POST['bank'];
	$location =  $_POST['location'];
	$bath = $_POST['bath'];
	$satang = $_POST['satang'];
	if(!empty($satang)) {
		$bath .= ".$satang";
	}
	else {
		$bath .= ".00";
		}
	$h = $_POST['hour'];
	$m = $_POST['min'];
	$dt = $_POST['date'] . " $h:$m";
	$sql = "INSERT INTO payments (order_id,cust_id,bank,location,amount,transfer_date,confirm) VALUES
		('$order_id','$cust_id','$bank','$location','$bath','$dt','no')";
		mysqli_query($link,$sql);
		$pay_id = mysqli_insert_id($link);
		if(is_uploaded_file($_FILES['file']['tmp_name'])){
		if($_FILES['file']['error'] != 0) {
			$err = "กรุณาเลือกไฟล์รูปภาพ";
		}
		else{
			$file = $_FILES['file']['tmp_name'];
			$content = addslashes(file_get_contents($file));

			$sql = "INSERT INTO payments_images (pay_id,img_content) VALUES('$pay_id', '$content')";
			
		}
	}
		
	if(!mysqli_query($link, $sql)) {
			$err = "ไม่สามารถบันทึกข้อมูล กรุณาตรวจสอบการใส่ข้อมูลของท่าน";
	  }
	else {
			echo "<h2>เราจัดเก็บข้อมูลการโอนเงินของท่านแล้ว<br>
				 และจะทำการตรวจสอบในลำดับต่อไป<br>
				ขอบคุณค่ะ</h2>";
		 }
	}
	else {
		$err = "ไม่พบรหัสการสั่งซื้อ : $order_id";
	}
}
else {
		$err = "ท่านใส่อีเมลหรือรหัสผ่านไม่ถูกต้อง";
	}
	if($err != "") {
		echo '<h2 class="warning">'. $err . "</h2>";
	}
		
	mysqli_close($link);
}
if(!$_POST || $err != "") {
?>	
<form class="input" method="post" enctype="multipart/form-data">
	กรุณาใส่ข้อมูลให้ครบสมบูรณ์ เพื่อป้องกันข้อผิดพลาดในการตรวจสอบ <br>	
    <input type="email" name="email" placeholder="อีเมล *" required value="<?php echo $email;?>"> อีเมล ที่ท่านใช้ในการสั่งซื้อ <br>
    <input type="password" name="pswd" placeholder="รหัสผ่าน *" required  value="<?php echo $pswd;?>"> รหัสผ่าน ที่ท่านใช้ในการสั่งซื้อ <br>
    <input type="text" name="order_id" placeholder="รหัสการสั่งซื้อ *" required> รหัสการสั่งซื้อ ที่ท่านได้รับทางอีเมล<br>
    <select name="bank">
    	<option>โอนผ่านธนาคาร *</option>
        <option value="ไทยพาณิชย์">- ไทยพาณิชย์</option>
		<option value="กรุงเทพ">- กรุงเทพ</option>
        <option value="กสิกรไทย">- กสิกรไทย</option>
        <option value="กรุงไทย">- กรุงไทย</option>
      </select> 
	 
	 <input type="text" name="location" placeholder="สาขา/รหัสตู้ ATM *" required>
	 <br>
	<input type="number" name="bath" placeholder="จำนวนเงิน (บาท) *" required>
    <input type="number" name="satang" placeholder="สตางค์"> บาท - สตางค์<br>
    <input type="text" name="date" placeholder="วันเดือนปี *" required readonly>
    <input type="number" name="hour" placeholder="ชั่วโมง *" min="0" max="23" required>
    <input type="number" name="min" placeholder="นาที *"  min="0" max="59" required> 
    วันเดือนปี - เวลา (ชั่วโมง นาที)
    <input type="file" name="file" id="file">
    <button type="submit" style="display:none;"></button>
</form>
<?php
$show_submit = true;
}
?>
</div>
<div id="bottom">
<button id="index">&laquo; หน้าแรก</button>
<div class="submit">
<?php
if($show_submit) {
	echo '<button id="submit">ส่งข้อมูล &raquo;</button>';
}
?>
</div>
</div>
</div>
</div>
</body>
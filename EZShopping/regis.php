<?php 
include "include/header.php";
session_start();  
?>

<div class="container">
	<div class="register">
<?php
if($_POST) {
	include "dblink.php";
				
	$name = $_POST['name'];
	$email = $_POST['email'];	
	$pw1 = $_POST['pswd'];
	$pw2 = $_POST['pswd2'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$err = "";
	if($pw1 !== $pw2) {
		$err .= "<li>ใส่รหัสผ่านทั้งสองครั้งไม่ตรงกัน</li>";
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err .= "<li>อีเมลไม่ถูกต้องตามรูปแบบ</li>";
	}
	
	//ตรวจสอบว่าอีเมลนี้ใช้สมัครไปแล้วหรือยัง
	$sql = "SELECT COUNT(*) FROM customers WHERE email = '$email'";
	$rs = mysqli_query($link, $sql);
	$data = mysqli_fetch_array($rs);
	if($data[0] != 0) {
		$err  .= "<li>อีเมลนี้เป็นสมาชิกอยู่แล้ว</li>";
	}		
	
	if($_POST['captcha'] !== $_SESSION['captcha']) {
		$err .= "<li>ใส่อักขระไม่ตรงกับในภาพ</li>";
	}
	//ถ้ามีข้อผิดพลาดอะไรบ้าง ก็แสดงออกไปทั้งหมด
	if($err != "") {
		echo '<div>';
		echo '<h3 class="red">เกิดข้อผิดพลาดดังนี้คือ</h3>';
		echo "<ul class=\"red\">$err</ul>";
		echo '</div>';
	}
	else {	//ถ้าไม่มีข้อผิดพลาด
		$pw1 = md5($pw1);
		$rand = mt_rand(100000, 999999);	  //verify code
		$sql = "INSERT INTO customers (email,password,name,address,phone,verify) 
		VALUES('$email','$pw1','$name','$address','$phone','$rand')";
	
		mysqli_query($link, $sql);
		
		//ส่งรหัสยืนยันไปทางอีเมล
		ini_set("SMTP", "smtp.totisp.net");
		include "thaimailer.php";
		mail_from("admin<admin@example.com>");
		mail_to("<$email>");
		mail_subject("รหัสยืนยันการสมัครสมาชิก");
		mail_body("รหัสการยืนยันคือ: $rand");
		@mail_send();
		echo "<center>";
		echo "<h3>จัดเก็บข้อมูลของท่านเรียบร้อยแล้ว</h3><br>";
		echo "เราได้จัดส่งรหัสการยืนยันไปทางอีเมลที่ท่านใช้สมัครแล้ว<br>";
		echo 'กรุณานำรหัสดังกล่าวมายืนยันหลังจากล็อกอินเข้าสู่ระบบตามปกติ</a><br><br>';
		echo '<a href="main.php">กลับหน้าหลัก</a>';;
		echo "</center>";
		mysqli_close($link);
		exit('</body></html>');
	}
	mysqli_close($link);
}
?>

<div class="form-regis">
<div class="regis-header">
<h3>สมัครสมาชิก</h3>
</div>
<div class="regis-form">
<form name="register" method="post">
		<input type="text" name="name" placeholder="ชื่อและนามสกุลของท่าน" 
        	value="<?php echo stripslashes($_POST['name']); ?>" required><br>
		<input type="email" name="email" placeholder="อีเมล์ของท่านสำหรับเป็นล็อกอิน" 
        value="<?php echo stripslashes($_POST['email']); ?>" required><br>
        <input type="text" name="address" placeholder="ที่อยู่ของท่าน" required><br>
        <input type="text" name="phone" placeholder="เบอร์โทรศัพท์ของท่าน" required><br>
        <input type="password" name="pswd" placeholder="รหัสผ่าน" required><br>
    	<input type="password" name="pswd2" placeholder="ใส่รหัสผ่านซ้ำ" required><br>
       <?php
	 	include "AntiBotCaptcha/abcaptcha.php";
		captcha_text_length(5);
		captcha_echo();
	 	?>
       <input type="text" name="captcha" placeholder="อักขระในภาพ" required>
      <br>
     <span>
     
     <button>สมัครสมาชิก</button><br class="clear">
     </span>
</form>
</div>

</div>


</div>
</div>
</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"crossorigin="anonymous"></script>
</body>
</html>
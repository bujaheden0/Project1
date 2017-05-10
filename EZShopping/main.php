<?php include "include/header.php" ?>
<div class="container">
<div class="content">
<div class="content-left">
<div class="login">
<?php
include "dblink.php";

//ตรวจสอบว่าเก็บข้อมูลการเข้าสู่ระบบไว้ในคุกกี้ หรือไม่
//ถ้ามี ให้กำหนดให้ตัวแปรได้เลย เพื่อให้เทียบเท่ากับการโพสต์ขั้นมาจากฟอร์ม
if(isset($_COOKIE['email']) && isset($_COOKIE['pswd'])) {
	$_POST['email'] = $_COOKIE['email'];
	$_POST['pswd'] = $_COOKIE['pswd'];
}

if($_POST) {
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];

	$sql = "SELECT * FROM customers
		 		WHERE  email = '$email' AND password = '$pswd'";
	
	$rs = mysqli_query($link, $sql);
	$data = mysqli_fetch_array($rs);
	if(mysqli_num_rows($rs) == 0) {
		$err  = '<span class="err">ท่านใส่อีเมล<br>หรือรหัสผ่านไม่ถูกต้อง</span>';
	}	
	else {
		if(!empty($data['verify'])) {
			mysqli_close($link);
			header("location: verify.php");
			ob_end_flush();
			exit;
		}
		
		if($_POST) {
			$expire = time() + 30*24*60*60;
			setcookie("email", "$email");
			setcookie("pswd", "$pswd");
		}
		
		 $_SESSION['user'] = $data['name'];
		 $_SESSION['email'] = $data['email'];
		 $_SESSION['password'] = $data['password'];
	}
}
mysqli_close($link);
?>

	
	
<?php 
	 if(!isset($_SESSION['user'])) {  
?>

    <?php 
    if($_POST){
    echo $err;
    } ?>
    <div class="login-head">
   	<fieldset><h3><i class="fa fa-user" aria-hidden="true"></i>  สมาชิกเข้าสู่ระบบ</h3></div>
	<form id="login" method="post">
    	 <a href="regis.php">สมัครสมาชิก</a> |
         <a href="verify.php">ยืนยันสมาชิก</a><br>
  		<input type="email" name="email" placeholder="อีเมล" required><br>
    	<input type="password" name="pswd" placeholder="รหัสผ่าน"  required><br>
        
         <a href="forget-password.php" id="forget">ลืมรหัสผ่าน</a>
    	<button>เข้าสู่ระบบ</button>  
    </form>
    </fieldset>
 <?php  
 }
 	else {
?>
	<fieldset><h3>เข้าสู่ระบบเรียบร้อยแล้ว</h3>
		<div class="user">
    	<h5><?php echo $_SESSION['user']; ?></h5><br>
    	<li>
    		<a href="logout">ออกจากระบบ</a>
    	</li>
    	
    	</div>
    	
	</fieldset>
<?php
	}
?>
</div><!--LOGIN-->
<div class="menu-left">
	<?php 
include "dblink.php";
include "lib/pagination.php";
$sql = "SELECT * FROM categories LIMIT 20";
$r = mysqli_query($link, $sql);
$self = $_SERVER['PHP_SELF'];
$h = $self . "?catid=";
echo "<li><a href=\"$h\" class=\"category\">ALL</a></li>";
while($cat = mysqli_fetch_array($r)) {
	$h = $self . "?catid=" . $cat['cat_id'] . "&catname=" . $cat['cat_name'];
	echo "<li><a href=\"$h\" class=\"category\">". $cat['cat_name'] . "</a></li>";
}
?>
</div>
</div>
<div class="content-right">
	<div class="show-product">
<?php
$field = "ทั้งหมด";
$sql = "SELECT *  FROM products ";
if(isset($_GET['catid']) && !empty($_GET['catid'])) {
	$cat_id  = $_GET['catid'];
	$sql .= "WHERE cat_id  = '$cat_id' ";
	$field = $_GET['catname'];
}
$sql .= "ORDER BY pro_id DESC";
$result = page_query($link, $sql, 10);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}	
	
 	echo "รายการสินค้า: $field  (ลำดับที่  $first - $last จาก $total)"; 
?>
    <br>

<?php
include "lib/IMGallery/imgallery-no-jquery.php";
while($pro = mysqli_fetch_array($result)) {
	 $id =  $pro['pro_id'];
	 $src = "read-image.php?pro_id=" . $pro['pro_id'];
	 $status = "มีสินค้า";
	 $quan_cur = $pro['quantity_current'];
	 if($quan_cur == 0){
	 	$status = "สินค้าหมด";
	 }
 ?>
<section class="section-pro">
	<div class="div-img"><?php gallery_echo_img($src); ?></div>
    <div class="div-summary">
    	<div class="div-rating">
    	<span class="star-img" id="star-img-<?php echo $id; ?>">
        	<script> updateStar(<?php echo $id; ?>); </script>
        </span>
    </div>

    <?php
    	echo "<span class=\"status\">สถานะ :" . $status ."</span><br>";
		echo "<a href=# class=\"pro-name\" data-id=\"$id\">". $pro['pro_name'] . "</a><br>";
		
		?>
    </div>
       <br>
    <div class="div-price">
    <?php
    	echo  "<span class=\"price\">" . number_format($pro['price']) . " บาท</span>";
    ?>
    </div>
    <div class="div-detail">
    <?php
    echo "<button class=\"more-detail btn btn-default\" data-id=\"$id\" >BUY</button>";
    ?>
    </div>
</section> 
<?php
}
?>
</div>
</div>
</div><!--Content-->
</div><!--Container-->
<div class="page">
<br>
<center>
		<?php
	if(page_total() > 1) { 	 //ให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
		echo '<div id="pagenum">';
		page_echo_pagenums();
		echo '</div>';
	}
?>
</center>
</div>
<div id="dialog"></div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"crossorigin="anonymous"></script>
<script type="text/javascript" src="main.js"></script>
</body>
</html>
<?php mysqli_close($link);  ?>
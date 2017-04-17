<?php 
session_start(); 
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Index Html</title>
	<link rel="stylesheet" type="text/css" href="Main.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href="js/jquery-ui.min.css" rel="stylesheet">
<style type="text/css">
	.div-detail button{
		background:#2F4F4F ;
	}

	.div-detail button:hover{
		background:#B0C4DE;
	}

</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.form.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
$(function() {
	
	$('button.more-detail, a.pro-name').click(function() {
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: 'product-load.php',
			data: {'id': id},
			dataType: 'html',
			beforeSend: function() {
				$.blockUI({message:'<h3>กำลังโหลดข้อมูล...</h3>'});
			},
			success: function(result) {
				$.unblockUI();
				$('#dialog').html(result);
				$('#dialog').dialog({
					title: 'รายละเอียดสินค้า',
					modal: true,
					width: 'auto',
					position: { my: "center top", at: "center top+70px", of: window}
				});
				$('.ui-dialog-titlebar-close').focus();
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});
	
	//ใช้ on() เพราะปุ่มในไดอะล็อกถูกโหลดมาทีหลังเพจ
	$(document).on('click', 'button#dialog-add-cart', function() {
		if(!$.isNumeric($('#dialog-quantity').val())) {
			alert('กรุณาใส่จำนวนสินค้าเป็นตัวเลข');
			return false;
		}
		var err = false;
		$('#dialog select').each(function(index, value) {
			if($(this).children('option:selected').index()==0) {  //ถ้าไม่ได้เลือกคุณลักษณะ
				alert('กรุณาเลือก: ' + $(this).val());
				err = true;
				return false;
			} 
		});
		
		if(err) {
			return;
		}
		
		$.ajax({
			type: 'post',
			url: 'cart-add.php',
			data: $('#dialog-form').serializeArray(),
			dataType: 'html',
			beforeSend: function() {
				$('#dialog').block({message:'<h3>กำลังหยิบใส่รถเข็น...</h3>'});
			},
			success: function(result) {
				if(result.length > 0) {
					$('#dialog').unblock();
					alert(result);
				}
				else {
				cartCount();
				$('#dialog').block({message:'<h3>เพิ่มสินค้าในรถเข็นแล้ว...</h3>', timeout:2000, showOverlay:false, 
				 							css: {padding:'2px 20px', background:'#ffc', color:'green', width: 'auto'}});
				}
			}
		});
	});
	
	$('button#order').click(function() {  //เมื่อคลิกปุ่มสั่งซื้อที่อยู่ตรงรถเข็น
		location.href = "order-cart.php";	
	});
	
	cartCount(); //ให้อ่านข้อมูลในรถเข็นมาแสดงทันทีที่เปิดเพจ (อาจเปิดไปเพจอื่นแล้วกลับมาที่หน้าหลักอีก)
	
});

function cartCount() {  //ฟังก์ชั่นสำหรับอ่านข้อมูลในรถเข็น
	$.ajax({
		type: 'post',
		url: 'cart-count.php',
		dataType: 'html',
		success: function(result) {	
			$('#cart-count').html(result);
		}
	});
}
</script>
</head>
<body>

<div class="header">
	<div class="top-bar">
		<div class="top-menu-bar">
			<ul class="top-menu">
				<li style="background:#708090;"><a href=""><i class="fa fa-handshake-o" aria-hidden="true"></i> ฝากขายสินค้า</a></li>
				<li><a href="">Administrator</a></li>
			</ul>
		</div><!--top-menu-bar-->
	</div><!--top-bar-->
		<div class="middle-bar">
		<div class="middle-menu-bar">
			<div class="brand">
			<a href="#">EZShopping.com</a>
			</div>
			<div class="search">
			<form class="navbar-form">
        
          <input type="text" class="form-control" style="width: 320px" placeholder="Search">
        <span><button class="btn">Search</button></span>
      </form>
			</div>
			<div class="cart">

			<a href="" id="order"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
			<span id="cart-count"><B>0</B></span>
			<button id="order">Cart</button>
			</div>
		</div><!--middle-menu-bar-->
	</div><!--middle-bar-->
	<div class="bottom-bar">
	<div class="bottom-menu">
			<ul>
  			<li><a href="order-history.php">ประวัติการสั่งซื้อ</a></li>
  			<li><a href="">วิธีการสั่งซื้อสินค้า</a></li>
  			<li><a href="order-paid.php">แจ้งการจ่ายเงิน</a></li>
  			<li><a href="">แจ้งคืนสินค้า</a></li>
  			<li><a href="">แจ้งปัญหาสินค้า</a></li>
			</ul>
		</div>
		</div>
</div><!--Header-->

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
		
		if($_POST['save_account']) {
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
    <?php echo $err; ?>
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
 ?>
<section class="section-pro">
	<div class="div-img"><?php gallery_echo_img($src); ?></div>
    <div class="div-summary">
    <?php
		echo "<a href=# class=\"pro-name\" data-id=\"$id\">". $pro['pro_name'] . "</a><br>";
		?>
    </div>
    <div class="div-rating">
    	<span class="star-img" id="star-img-<?php echo $id; ?>">
        	<script> updateStar(<?php echo $id; ?>); </script>
        </span>
    </div>
    <div class="div-price">
    <?php
    	echo  "<span class=\"price\">" . number_format($pro['price']) . " บาท</span>";
    ?>
    </div>
    <div class="div-detail">
    <?php
    echo "<button class=\"more-detail btn btn-default\" data-id=\"$id\">BUY</button>";
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
<br class="clear">
<div id="dialog"></div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"crossorigin="anonymous"></script>
<script type="text/javascript" src="main.js"></script>
</body>
</html>
<?php mysqli_close($link);  ?>
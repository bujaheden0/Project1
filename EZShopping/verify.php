<?php 
session_start(); 
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Index Html</title>
	

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.form.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
</script>
<style type="text/css">
	.container{
		width:960px;
		margin:auto;
	}
	.content{
		width:960px;
		background: #B0C4DE;
		padding-bottom: 20px;
		margin-top: 20px;
	}

	.confirm{
		width:960px;
		background: #2F4F4F;
		color: white;	
		padding: 10px ;
		margin-top: 20px;
	}

	.confirm h3{
		margin:0px;
		margin-left: 15px;
	}

	.form-confirm{
		width:500px;
		
		margin:auto;
		
		padding-left: 90px; 
		margin-top: 20px;
	}

	.form-confirm button{
		color: black;
		margin-left: 120px;
	}
	[type=text] {
		width: 305px !important;
		margin:2px; 
	}


	.container{
	margin:0 auto;
	
}
.content{
	width: 960px;
	margin:0 auto;
}
.header{
	
	height:auto;
}
.top-bar{
	width: 100%;
	height:30px;
	background: #B0C4DE;
}
.middle-bar{
	height:100px;
	background: #2F4F4F;

}
.bottom-bar{
	height:auto;
	background: #B0C4DE;


}
.top-menu-bar{
	background: #B0C4DE;
	height: 30px;
	margin:0 auto;
	width:960px;
}
.middle-menu-bar{
	background:#2F4F4F;
	height: 100px;
	margin:0 auto;
	width:960px;

}

.top-menu{
	float:right;
	margin:0px;
}
.top-menu li{
	float: left;
	width:110px;
	background:steelblue;
	line-height: 30px;
	text-align: center;
	margin-left:1px;
	border-radius: 2px;
}
.top-menuli a:hover{
	text-decoration: none;
}

.bottom-menu{
	margin:auto;
	width: 960px;
}


.top-menu li a{
	color:white;
}
.middle-menu-bar a{
	line-height: 100px;
	font-size:40px;
	color:white;
	margin-left: 20px;

}
.middle-menu-bar a:hover{
	text-decoration: none;
	color:white;
}
.brand{
	float: left;
}

.search{
	line-height: 100px;
	margin: 0px;
	padding: 0px;
	float:left;
}

.search form{
	margin: 0;
}
.cart{
	float: right;
	margin-bottom:0px;
	padding: 0px;
	width:150px;
	height: 100px;
}
.cart a{
	color:white;
}
.cart button{
	 
}
#cart-count{
		background-color:#B0C4DE;  
		border-radius: 5px;
		padding: 5px;
		color:#2F4F4F ;
		font-weight: bold;
}


li{
	list-style: none;
}
a{
	text-decoration: none;
}
ul{
	margin:0;
}

.bottom-menu ul{
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #B0C4DE;
}

.bottom-menu li {
    float: left;
}

.bottom-menu li a {
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.bottom-menu li a:hover {
    background-color: white;
}
</style>
</head>
<body>

<div class="header">
	<div class="top-bar">
		<div class="top-menu-bar">
			<ul class="top-menu">
				<li style="background:#708090;"><a href=""><i class="fa fa-handshake-o" aria-hidden="true"></i> ฝากขายสินค้า</a></li>
				
			</ul>
		</div><!--top-menu-bar-->
	</div><!--top-bar-->
		<div class="middle-bar">
		<div class="middle-menu-bar">
			<div class="brand">
			<a href="main.php">EZShopping.com</a>
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
  			<li><a class="active" href="#home"></a></li>
  			<li><a href="#news"></a></li>
  			<li><a href="#contact"></a></li>
  			
			</ul>
		</div>
		</div>
</div><!--Header-->
<div class="container">
<div class="content">
	<?php
if($_POST) {
	include "dblink.php";
				
	$code = $_POST['code'];
	$email = $_POST['email'];
	$target = $_POST['target'];
	$err = "";
	$msg = "";
	
	//ถ้าเลือกการยืนยันรหัส
	if($target == "verify") {
		$sql = "UPDATE customers SET verify = '' 
		 			WHERE  email = '$email' AND verify = '$code'";
					
	 	$rs = mysqli_query($link, $sql);
		
		//ถ้าเกิดการเปลี่ยนแปลง แสดงว่าใส่รหัสถูกต้อง
		if(mysqli_affected_rows($link) == 0) {
			$err = "ท่านใส่อีเมลหรือรหัสยืนยันไม่ถูกต้อง";
		}
		else {
			$msg = "การยืนยันของท่านเสร็จเรียบร้อยแล้ว";
		}
	}
	
	//ถ้าขอให้ส่งรหัสไปให้ใหม่
	else if($target == "re-code") {
		//กรณีนี้เราต้องอ่านรหัสจากตาราง แล้วส่งไปทางอีเมล
		$sql = "SELECT verify FROM customers WHERE email = '$email'";
		$rs = mysqli_query($link, $sql);
		$data = mysqli_fetch_array($rs);
		
		if(mysqli_num_rows($rs)==0) {  
			$err  = "ไม่พบอีเมลที่ท่านระบุ";		//ถ้าไม่มีข้อมูลแสดงว่าใส่อีเมลผิด
		}		
		else if(empty($data[0])) {
			$err = "ท่านยืนยันรหัสนี้ไปแล้ว";
		}
		else {
			$code = $data[0];
			ini_set("SMTP", "smtp.totisp.net");
			include "thaimailer.php";
			mail_from("admin<admin@example.com>");
			mail_to("<$email>");
			mail_subject("รหัสยืนยันการสมัครสมาชิก");
			mail_body("รหัสการยืนยันคือ: $code");
			if(mail_send()) {  //แม้ส่งสำเร็จ แต่ให้เหมือนกับเกิดข้อผิดพลาด
				$err = "ส่งรหัสการยืนยันไปทางอีเมลแล้ว";
			}
			else {
				$err = "เกิดข้อผิดพลาดในการส่งอีเมล";
			}
		}
	}

	if($err != "") {
		echo '<div>';
		echo "<h3 class=\"red\">$err</h3>";
		echo '</div>';
	}
	else if($msg != "") {
		echo "<h3>$msg</h3><br>";
		echo '<a href="index.php">กลับหน้าหลัก</a>';
		mysqli_close($link);
		exit('</body></html>');
	}
	mysqli_close($link);
}
?>
<div class="confirm">
<h3>ยืนยันการสมัครสมาชิก</h3>
</div>
<div class="form-confirm">
<form method="post">
		<input type="radio" name="target" value="verify" checked>ยืนยันการสมัคร
        <input type="radio" name="target" value="re-code">ขอรหัสใหม่(ใส่แค่อีเมลแล้วส่งข้อมูล) <br>
		<input type="text" name="email" placeholder="อีเมล" required><br>
        <input type="text" name="code" placeholder="รหัสยืนยันที่ได้รับทางอีเมล"><br>
      	<span>
     		<button>ส่งข้อมูล</button><br class="clear">
     	</span>
</form>

</div>
</div>
	
</div>
</body>
</html>
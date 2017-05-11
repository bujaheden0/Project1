<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
		<link rel="stylesheet" href="/css/app.css">
		<link rel="stylesheet" type="text/css" href="Main.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href="js/jquery-ui.min.css" rel="stylesheet">
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
			<a href="#">EZShopping.com</a>
			</div>
			
		</div><!--middle-menu-bar-->
	</div><!--middle-bar-->
<?php

	include "lib/IMager/imager.php";
	include "dblink.php";
	
	$Brand = $_POST['Brand'];
	$email = $_POST['email'];	
	$name = $_POST['name'];
	$password = $_POST['password'];
	$tel = $_POST['tel'];
	$accname = $_POST['accname'];
	$accnum = $_POST['accnum'];
	$address = $_POST['address'];
	$status = "no";
	//$i= $_POST['images'];


	
    //if($action == "add"){//Action Add
        //Upload Image
        
	//}


	$connect = mysqli_connect("localhost","root","","store");	
	mysqli_set_charset($connect, "utf8");

	$sql = 'insert into suppliers (sub_email,sup_name,sup_password,phone,sub_accname,sup_accnum,sub_brand,address,status)
	VALUES ("'.$email.'","'.$name.'","'.$password.'","'.$tel.'","'.$accname.'","'.$accnum.'","'.$Brand.'","'.$address.'","'.$status.'")';
	$result = mysqli_query($connect,$sql);

	$sup_id = mysqli_insert_id($connect);
		if(is_uploaded_file($_FILES['file']['tmp_name'])){
		if($_FILES['file']['error'] != 0) {
			$err = "กรุณาเลือกไฟล์รูปภาพ";
		}
		else{
			$file = $_FILES['file']['tmp_name'];
			$content = addslashes(file_get_contents($file));

			$sql = "INSERT INTO suppiers_image (sup_id,img_content) VALUES('$sup_id', '$content')";
			
		}
	}
	?>
<br>
<center>
<form method="post" action="instrument.php">
		<input type=submit value="Back to Register"><br>
		</form>
<form action ="login1.php">
<p><input type ="submit" value ="Back to Homepage"></p></center>
</form>
</body>
</html>
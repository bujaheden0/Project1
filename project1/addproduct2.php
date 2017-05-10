<?php
	session_start();
	if($_SESSION['SID'] == "")
	{
		echo "Please Login!";
		exit();
	}



?>

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

/*if($_FILES["images"]["name"] != "") {
            $file_name = $_FILES["images"]["name"];
            $file_ext = substr($file_name, strripos($file_name, '.'));
            $equipmentImage = date("Ymdhis").$file_ext;
            if(move_uploaded_file($_FILES["images"]["tmp_name"],"image/".$equipmentImage)) { 
            }
        }*/

	

	/*$Brand = $_POST['Brand'];
	$email = $_POST['email'];	
	$name = $_POST['name'];
	$password = $_POST['password'];
	$tel = $_POST['tel'];
	$accname = $_POST['accname'];
	$accnum = $_POST['accnum'];*/
	//$i= $_POST['images'];


	
    //if($action == "add"){//Action Add
        //Upload Image
        
	//}


	$connect = mysqli_connect("localhost","root","","ezshopping");	
	mysqli_set_charset($connect, "utf8");

	$sql = 'insert into product (Pname,Pdes,Ptype,Pprice,Pstock)
	VALUES ("'.($_POST['Pname']).'","'.($_POST['Pdes']).'","'.($_POST['Ptype']).'","'.($_POST['Pprice']).'","'.($_POST['Pstock']).'")';
	$result = mysqli_query($connect,$sql);
	//$sql = 'select * from instrument where Serial_no = "'.$Serial.'"' ;
?>
	
<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
  
      	<ul class="nav nav-pills">
        <li role="presentation" ><a href="#">เพิ่มสินค้าใหม่</a></li>
		 <li role="presentation" class="active"><a href="#">ขายอยู่</a></li>
		 </ul>
    
    </div>
  </div>
</nav>
<?php

	$sql = 'select * from product' ;
	$result = mysqli_query($connect,$sql);
	echo '<table border =1 align = "center">';
	echo '<tr bgcolor = #00ffff>';
		 echo '<td>'.'รหัสสินค้า'.'</td>';
		 echo '<td>'.'ชื่อสินค้า'.'</td>'; 
		 echo '<td>'.'รายละเอียดสินค้า'.'</td>';
		 echo '<td>'.'หมวดหมู่'.'</td>';
		 echo '<td>'.'ราคา'.'</td>';
		 echo '<td>'.'คลัง'.'</td>';
	     echo '</tr>';
	while($row = mysqli_fetch_assoc($result)){
		echo '<tr bgcolor = #ffff99>';
		 echo '<td>'.$row['PID'].'</td>';
		 echo '<td>'.$row['Pname'].'</td>';
		 echo '<td>'.$row['Pdes'].'</td>';
		 echo '<td>'.$row['Ptype'].'</td>';
		 echo '<td>'.$row['Pprice'].'</td>';
		 echo '<td>'.$row['Pstock'].'</td>';
	
	     echo '</tr>';
	
	}
echo '</table>';
?>
<br><center>
<form method="post" action="addproduct1.php">
		<input type=submit value="Back to Add product"><br>
		</form>
<form action ="index.php">
<p><input type ="submit" value ="Back to Homepage"></p>
</form>
</center>
</body>
</html>
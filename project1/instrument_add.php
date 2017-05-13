<?php
if($_POST){
	include "dblink.php";
	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = $_POST['password'];
	$tel = $_POST['tel'];
	$accname = $_POST['accname'];
	$accnum = $_POST['accnum'];
	$address = $_POST['address'];
	$brand = $_POST['brand'];
	$status = "no";

	$sql = "INSERT INTO suppliers (sup_name,address,phone,sup_password,sub_accname,sub_email,sup_accnum,status,sub_brand) VALUES ('$name','$address','$tel','$password','$accname','$email','$accnum','$status','$brand')";
	mysqli_query($link,$sql);
	$sup_id = mysqli_insert_id($link);
	if(is_uploaded_file($_FILES['file']['tmp_name'])){
			$file = $_FILES['file']['tmp_name'];
			$content = addslashes(file_get_contents($file));
			$sql = "INSERT INTO suppliers_images (sup_id,img_content) VALUES('$sup_id', '$content')";
			mysqli_query($link,$sql);
			
		
	}
	
	mysqli_close($link);
}
header( "location:login1.php" );
?>
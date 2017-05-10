<html>

<style type="text/css">
p.big {font-size: 50px}
</style>




<?php

	session_start();
	$connect = mysqli_connect("localhost","root","","store");
	$sql= "SELECT * FROM suppliers WHERE sub_email = '".($_POST['user'])."' 
	and sup_password = '".($_POST['password'])."'";
	$result = mysqli_query($connect,$sql);
	$row = mysqli_fetch_assoc($result);


	if(!$row){
		echo '<p align ="center" style="color:red">'.'บัญชีผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง'.'</p>';
		include("login1.php");
		//header("location:login1.php");
		 
	}
	else {

			$_SESSION["sup_id"] = $row["sup_id"];
			$_SESSION["status"] = $row["status"];

			session_write_close();

			if($row["status"] == "yes")
			{
				header("location:product.php");
			}

	}

?>


</html>
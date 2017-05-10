<?php
	session_start();
	if($_SESSION['SID'] == "")
	{
		echo "Please Login!";
		exit();
	}



?>

<html>
	<h3 align ="center">
<body>

<FONT Size="30">Update</FONT><br><br>
	<?php
		
		$connect = mysqli_connect("localhost","root","","ezshopping");
		mysqli_set_charset($connect, "utf8");
			$sql = 'SELECT * from selleruser where SID="'.$_POST['id'].'";';
			$result = mysqli_query($connect,$sql);
	
	while($row = mysqli_fetch_array($result)){
	echo '<form method = "post" action="setting3.php">';

	echo 'รหัสลูกค้า &nbsp&nbsp <input type="text" name="a" value="'.$row[0].'" readonly="true" ><br>';
	echo 'อีเมล &nbsp&nbsp <input type="text" name="b" value="'.$row[1].'" ><br>';
	echo 'ชื่อ-นามสุกล &nbsp&nbsp <input type="text" name="c" value="'.$row[2].'"><br>';
	echo 'รหัสผ่าน &nbsp&nbsp <input type="text" name="y" value="'.$row[3].'"><br>';
	echo 'เบอร์โทร &nbsp&nbsp <input type="text" name="e" value="'.$row[4].'"><br>';
	echo 'ชื่อบัญชี &nbsp&nbsp <input type="text" name="f" value="'.$row[5].'"><br>';
	echo 'เลขบัญชี &nbsp&nbsp <input type="text" name="g" value="'.$row[6].'"><br>';
	echo 'ชื่อธนาคาร &nbsp&nbsp <input type="text" name="u" value="'.$row[7].'"><br>';
	echo '<td><input name ="update" type="submit" value="Update"></td>'."\n";
	
	echo '</form>';
	}
	
	
mysqli_close($connect);
	?>


</html>
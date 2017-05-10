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
	<?php
		$a=$_POST['a'];
		$b=$_POST['b'];
		$c=$_POST['c'];
		$y=$_POST['y'];
		$e=$_POST['e'];
		$f=$_POST['f'];
		$g=$_POST['g'];
		$u=$_POST['u'];
		$connect = mysqli_connect("localhost","root","","ezshopping");
		//UPDATE `instrument` SET Price = '100' where Serial_no = "ee"
			$sql = 'update selleruser set Spassword = '.$y.' where SID = "'.$a.'"';
	
			$result = mysqli_query($connect,$sql);
				if($result) {
				echo '<FONT Size="30">Complete</FONT>';
			} else {
				
				 echo 'no complete';
			}
	
mysqli_close($connect);
	?>

<br><br><br><form method="post" action="setting.php">
		<input type=submit value="Back to update">
		</form>

<form action ="index.php">
<p><input type ="submit" value ="Back to Homepage"></p>
</form>
</html>
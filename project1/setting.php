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
	
</head>
<body>
<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
  
      	<ul class="nav nav-pills">
         <li role="presentation" class="active"><a href="#">ตั้งค่าโปรไฟล์</a></li>
		 </ul>
    
    </div>
  </div>
</nav>
<?php
	$connect = mysqli_connect("localhost","root","","ezshopping");
	mysqli_set_charset($connect, "utf8");
	$sql = 'select * from selleruser where SID=1' ;
	$result = mysqli_query($connect,$sql);
	$result = mysqli_query($connect,$sql);
	$numrows = mysqli_num_rows($result);
	$numfields = mysqli_num_fields($result);
	echo '<table border =1 align = "center">';
	echo '<tr bgcolor = #00ffff>';
		 echo '<td>'.'รหัสลูกค้า'.'</td>';
		 echo '<td>'.'อีเมล'.'</td>'; 
		 echo '<td>'.'ชื่อ-นามสุกล'.'</td>';
		 echo '<td>'.'รหัสผ่าน'.'</td>';
		 echo '<td>'.'เบอร์โทร'.'</td>';
		 echo '<td>'.'ชื่อบัญชี'.'</td>';
		 echo '<td>'.'เลขบัญชี'.'</td>';
		 echo '<td>'.'ชื่อธนาคาร'.'</td>';
		 echo '<td>'.'อัพเดท'.'</td>';
	     echo '</tr>';
	while ($row = mysqli_fetch_array($result)){
			echo'<form name="frmDelete'.$row['SID'].'"method="post" action="setting2.php">'."\n";
				echo '<tr bgcolor = #cc99ff>';	
				
				for ($i=0; $i<$numfields; $i++){
						echo '<td>'.$row[$i].'&nbsp;</td>'."\n";
				}
				echo '<input type ="hidden" name="id" value="'.$row['SID'].'">'."\n";
				echo '<td><input name="update" type ="submit" value ="UPDATE" ></td>'."\n";
				echo '</tr>'."\n";
				echo '</form>'."\n";
			}
echo '</table>';
?>
<br><center>

<form action ="index.php">
<p><input type ="submit" value ="Back to Homepage"></p>
</form>
</center>
</body>
</html>
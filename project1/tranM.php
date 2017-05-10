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
       
		 <li role="presentation" class="active"><a href="#">การโอนเงิน</a></li>
		 </ul>
    
    </div>
  </div>
</nav>
<?php
	$connect = mysqli_connect("localhost","root","","ezshopping");
	mysqli_set_charset($connect, "utf8");
	$sql = 'select * from account' ;
	$result = mysqli_query($connect,$sql);
	echo '<table border =1 align = "center">';
	echo '<tr bgcolor = #00ffff>';
		 echo '<td>'.'ครั้งที่'.'</td>';
		 echo '<td>'.'รหัสสินค้า'.'</td>'; 
		 echo '<td>'.'ชื่อผู้ซื้อ'.'</td>';
		 echo '<td>'.'ระยะเวลารอดำเนินการ'.'</td>';
		 echo '<td>'.'จำนวนทีซื้อ'.'</td>';
		 echo '<td>'.'จำนวนเงิน'.'</td>';
		 echo '<td>'.'สถานะ'.'</td>';
	     echo '</tr>';
	while($row = mysqli_fetch_assoc($result)){
		echo '<tr bgcolor = #ffff99>';
		 echo '<td>'.$row['TID'].'</td>';
		 echo '<td>'.$row['PID'].'</td>';
		 echo '<td>'.$row['Cname'].'</td>';
		 echo '<td>'.$row['Ttime'].'</td>';
		 echo '<td>'.$row['Pstock'].'</td>';
		 echo '<td>'.$row['Pprice'].'</td>';
		 echo '<td>'.$row['Tstatus'].'</td>';
	     echo '</tr>';
	     if($row['Tstatus']=="โอนแล้ว"){
	     $total=$row['Pprice'];
	 }
		
	}echo "ยอดรวม = ".$total;
echo '</table>';
?>
<br><center>

<form action ="index.php">
<p><input type ="submit" value ="Back to Homepage"></p>
</form>
</center>
</body>
</html>
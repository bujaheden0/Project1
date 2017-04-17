<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
include "dblink.php";
include "lib/IMGallery/imgallery-no-jquery.php";
$sql = "SELECT * FROM payments";
$r = mysqli_query($link,$sql);
while($pro = mysqli_fetch_array($r)) {
	 $id =  $pay['pay_id'];
	 $src = "read-image1.php?pay_id=" . $pay['pay_id'];
	
?>
<div class="div-img"><?php gallery_echo_img($src); ?>
	<?php 
}
	 ?>
</div>
</body>
</html>

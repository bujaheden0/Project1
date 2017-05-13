
<?php


include "dblink.php";
	include "lib/IMGallery/imgallery-no-jquery.php";
	$pay_id = $_POST['id'];//////////////////
	$sql = "SELECT * FROM payments_images ";///////////////////////
	$r = mysqli_query($link, $sql);
	//นำเอารูปมาเก็บไว้ 
if(mysqli_num_rows($r) > 0) {
			echo "<br>";
			$src = "read-image2.php?id=";//quary sql ไฟล์ read-image.php
			gallery_thumb_width(250);
			while($img =mysqli_fetch_array($r)) {
				gallery_echo_img($src . $img['img_id']);
			}
		}
	
?>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"crossorigin="anonymous"></script>
<script type="text/javascript" src="main.js"></script>

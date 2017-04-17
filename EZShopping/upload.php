<?php 
include "dblink.php";
	if(is_uploaded_file($_FILES['file']['tmp_name'])){
		if($_FILES['file']['error'] != 0) {
			echo "File Uploaded Error!";
		}
		else{
			$file = $_FILES['file']['tmp_name'];
			$content = addslashes(file_get_contents($file));
			$name = $_FILES['file']['name'];
			$type = $_FILES['file']['type'];
			$size = $_FILES['file']['size'];

			$sql = "INSERT INTO image(file_name,file_type,file_size,file_content) VALUES('$name','$type','$size','$content')";

			mysqli_query($link,$sql);
		}
	}
 ?>
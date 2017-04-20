<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
include "dblink.php";
	if($_POST){
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
}
 ?>
 <form  method="post" enctype="multipart/form-data">
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Upload Image">
</form>

</body>
</html>
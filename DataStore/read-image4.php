<?php
include "dblink.php";
$id = $_GET['id'];
$sql = "SELECT img_content FROM transfer_images WHERE img_id = $id";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_array($result);
header("Content-Type: image/jpeg");
echo $data['img_content'];
mysqli_close($link);
?>

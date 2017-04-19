<?php
include "dblink.php";
sleep(1);
$action = $_POST['action'];
if($action == "update"){
	$pro_id = $_POST['pro_id'];
	$order_id = $_POST['order_id'];
	$sql = "UPDATE order_details SET recieve = 'yes' WHERE pro_id = '$pro_id' and order_id = '$order_id'";
	$result = mysqli_query($link,$sql);
	if(!$result){
		die("FAILED" . mysqli_error($link));
	}
}

mysqli_close($link);
?>
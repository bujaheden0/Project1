<?php
//include "check-login.php";
include "dblink.php";
sleep(1);
$action = $_POST['action'];
$pay_id = $_POST['pay_id'];

if($action == "confirm") {
	$order_id = $_POST['order_id'];
	$pro_id = $_POST['pro_id'];
	/*
	$sql = "UPDATE payments SET confirm = 'yes' WHERE pay_id = '$pay_id'";
	mysqli_query($link, $sql);*/
	
	$sql = "UPDATE order_details SET delivery = 'yes' WHERE order_id = '$order_id' and pro_id = '$pro_id'" ;
	mysqli_query($link, $sql);
}
else if($action == "delete") {
	$sql = "DELETE FROM payments WHERE pay_id = '$pay_id'";
	mysqli_query($link, $sql);	
}

mysqli_close($link);
?>
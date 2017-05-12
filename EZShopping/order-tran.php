<?php
include "dblink.php";
sleep(1);
$action = $_POST['action'];

if($action == "insert"){
	$pro_id = $_POST['pro_id'];
	$order_id = $_POST['order_id'];
	$sql = "SELECT * FROM products WHERE pro_id = '$pro_id'";
	$r = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($r);
	$pro_name = $data['pro_name'];
	$pro_price = $data['price'];
	$sql = "SELECT quanity FROM order_details WHERE pro_id = '$pro_id' and order_id = '$order_id'";
	$r = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($r);
	$quanity = $data['quanity'];
	$total_price = $quanity * $pro_price;
	$sql = "INSERT INTO order_tran (name,price,tran_id,quantity,order_id) VALUES ('eieieiie','10','','1','1111111')";
	mysqli_query($link,$sql);
}

mysqli_close($link);
?>
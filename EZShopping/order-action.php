<?php
include "dblink.php";
sleep(1);
$action = $_POST['action'];

if($action == "update"){
	$pro_id = $_POST['pro_id'];
	$order_id = $_POST['order_id'];
	$sql = "UPDATE order_details SET recieve = 'yes' WHERE pro_id = '$pro_id' and order_id = '$order_id'";
	$result = mysqli_query($link,$sql);

	$sql = "SELECT * FROM products WHERE pro_id = '$pro_id'";
	$r = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($r);
	$pro_name = $data['pro_name'];
	$pro_price = $data['price'];
	$sql = "SELECT quantity FROM order_details WHERE pro_id = '$pro_id' and order_id = '$order_id'";
	$r = mysqli_query($link,$sql);
	$data = mysqli_fetch_array($r);
	$quantity = $data['quantity'];
	$total_price = $quantity * $pro_price;
	$sql = "INSERT INTO order_tran (name,price,tran_id,quantity,order_id) VALUES ('$pro_name','$total_price','0','$quantity','$order_id')";
	mysqli_query($link,$sql);
}

mysqli_close($link);
?>
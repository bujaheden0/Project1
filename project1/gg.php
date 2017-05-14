<?php 
session_start();
	if($_SESSION['sup_id'] == "")
	{
		echo "Please Login!";
		exit();
	}

$sup_id = $_SESSION['sup_id'];

 ?>
<?php
if($_POST){
	include "dblink.php";
	$id = $_POST['sup_id'];
	$date = $_POST['date'];
	$sub_accname = $_POST['sub_accname'];
	$sup_accnum = $_POST['sup_accnum'];
	$sum = $_POST['sum'];
	$status = "no";

	$sql = "INSERT INTO transfer (tran_date,account,name,tran_amount,tran_status,sup_id) VALUES ('$date','$sup_accnum','$sub_accname','$sum','no','$sup_id')";
	mysqli_query($link,$sql);

	$tran_id = mysqli_insert_id($link);
	$sql2 = "UPDATE order_tran
LEFT JOIN orders ON order_tran.order_id = orders.order_id 
LEFT JOIN order_details ON order_details.order_id = orders.order_id 
RIGHT JOIN customers ON customers.cust_id = orders.cust_id
RIGHT JOIN products ON products.pro_id = order_details.pro_id
RIGHT JOIN suppliers ON suppliers.sup_id = products.sup_id
SET order_tran.tran_id = '$tran_id'
WHERE order_details.pro_id IN (SELECT products.pro_id FROM products WHERE sup_id = '$sup_id ') 
AND tran_id = 0";
	mysqli_query($link,$sql2);
	
	$sup_id = mysqli_insert_id($link);
	
	
	mysqli_close($link);
}
header( "location:transfer.php" );
?>
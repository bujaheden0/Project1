<?php
if($_POST){
	include "dblink.php";


	$sql = "INSERT INTO transfer (tran_date,account,name,tran_amount,tran_status,sup_id) VALUES ('10/08/23 16:06 pm',123456789,'tanawut1',7090,'no',1)";
	mysqli_query($link,$sql);
	$sup_id = mysqli_insert_id($link);
	
	
	mysqli_close($link);
}
//header( "location:transfer.php" );
?>
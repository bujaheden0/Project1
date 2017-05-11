<?php 
	session_start();
	if($_SESSION['sup_id'] == "")
	{
		echo "Please Login!";
		exit();
	}
$sup_id = $_SESSION['sup_id'];
}
include "dblink.php";
if($_POST['action'] == "add") {
	$name = $_POST['sup_name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$contact = $_POST['contact_name'];
	$website = $_POST['website'];
	$sql = "REPLACE INTO suppliers 
	 		 	VALUES('', '$name', '$address', '$phone', '$contact', '$website')";
	mysqli_query($link, $sql);
}
if($_POST['action'] == "edit") {
	$name = $_POST['sup_name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$sub_accname = $_POST['sub_accname'];
	$sub_accnum = $_POST['sub_accnum'];
	
	$id = $_POST['sup_id'];
	$sql = "UPDATE suppliers SET sup_name = '$name', address = '$address', phone = '$phone', sub_accname = '$sub_accname', sub_accnum = '$sub_accnum' WHERE sup_id = '$id'";
	mysqli_query($link, $sql);
}
if($_POST['action'] == "del") {
	$id = $_POST['sup_id'];
	$sql = "DELETE FROM suppliers WHERE sup_id = $id";
	mysqli_query($link, $sql);
}
mysqli_close($link);
?>
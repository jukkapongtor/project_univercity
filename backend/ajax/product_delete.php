<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 5");
	echo "<script>window.location='../#ajax/product_list.php';</script>";
?>
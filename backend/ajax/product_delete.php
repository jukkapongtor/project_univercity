<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 5");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product_size WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 6");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product_image WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 7");
	echo "<script>window.location='../#ajax/product_list.php';</script>";
?>
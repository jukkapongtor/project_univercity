<?php
	session_start();
	include("../../include/function.php");
	connect_db();



	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_quality='$_GET[delete_quality_id]'")or die("ERROR : backend quality_delete_quality_id line 8");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM quality WHERE product_quality='$_GET[delete_quality_id]'")or die("ERROR : backend quality_delete_quality_id line 9");
	echo "<script>window.location='../#ajax/quality_edit.php';</script>";
?>
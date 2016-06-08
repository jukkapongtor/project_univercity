<?php
	session_start();
	include("../../include/function.php");
	connect_db();

	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE product_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 6");
	list($type_name)=mysqli_fetch_row($query_type);
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 8");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM quality WHERE quality_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 9");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM type WHERE product_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 10");
	
	$folder = iconv("utf-8","tis-620",$type_name);
	rmdir("../../images/{$folder}");
	echo "<script>window.location='../#ajax/type_edit.php';</script>";
?>
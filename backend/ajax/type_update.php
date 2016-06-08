<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	
	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE product_type='$_POST[type_id]'")or die("ERROR : backend type_delete_type_id line 6");
	list($type_name)=mysqli_fetch_row($query_type);
	$sql= "UPDATE type SET type_name='$_POST[type_name]' WHERE product_type='$_POST[type_id]'";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type_update line 9");
	$folder_old = iconv("utf-8","tis-620",$type_name);
	$folder_new = iconv("utf-8","tis-620",$_POST['type_name']);

	rename("../../images/{$folder_old}","../../images/{$folder_new}");
	echo "<script>window.location='../#ajax/type_edit.php'</script>";

?>
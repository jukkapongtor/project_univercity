<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	
	echo "<meta charset='utf-8'>";
	$sql= "UPDATE quality SET quality_name='$_POST[quality_name]',quality_type='$_POST[edit_product_type]' WHERE product_quality='$_POST[quality_id]'";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend quality_update line 9");

	echo "<script>window.location='../#ajax/quality_manage.php'</script>";

?>
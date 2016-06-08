<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();

	if(empty($_POST['type_name'])){
		echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');window.location='../#ajax/type_add.php'</script>";
	}else{
		mysqli_query($_SESSION['connect_db'],"INSERT INTO type VALUES('','$_POST[type_name]')")or die("ERROR : backend type_insert line 10");
		$folder = "$_POST[type_name]";
		$folder = iconv("utf-8","tis-620",$folder);
		mkdir("../../images/{$folder}");
		echo "<script>alert('เพิ่มประเภทสินค้าเรียบร้อย');window.location='../#ajax/type_add.php'</script>";
	}

?>
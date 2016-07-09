<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();

	if(empty($_POST['quality_name'])||empty($_POST['product_type'])){
		echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');window.location='../#ajax/quality_manage.php'</script>";
	}else{
		mysqli_query($_SESSION['connect_db'],"INSERT INTO quality VALUES('','$_POST[quality_name]','$_POST[product_type]')")or die("ERROR : backend quality_insert line 10");
		echo "<script>alert('เพิ่มหมวดหมู่สินค้าเรียบร้อย');window.location='../#ajax/quality_manage.php'</script>";
	}

?>
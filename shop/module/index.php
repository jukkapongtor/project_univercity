<?php
	session_start();
	include ('../../include/function.php');
	connect_db();
	include ('function.php');
	switch ($_GET['data']) {
		case "addproduct_cart":addproduct_cart();break;
		case "amounttotal_cart":amounttotal_cart();break;
		case "sale_product":sale_product();break;
		case "not_sale_product":not_sale_product();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='../index.php'</script>";break;
	}

?>
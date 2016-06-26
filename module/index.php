<?php
	session_start();
	echo "<meta charset='utf-8'>";
	include ('../include/function.php');
	connect_db();
	include ('function.php');
	switch ($_GET['data']) {
		case "provinces";provinces();break;
		case "districts";districts();break;
		case "zipcode";zipcode();break;
		case "addproduct_cart";addproduct_cart();break;
		case "amounttotal_cart";amounttotal_cart();break;
		case "plus_like";plus_like();break;
		case "lower_like";lower_like();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='../index.php'</script>";break;
	}

?>
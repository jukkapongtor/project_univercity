<?php
	session_start();
	include ('function.php');
	connect_db();
	switch ($_GET['data']) {
		case "provinces";provinces();break;
		case "districts";districts();break;
		case "zipcode";zipcode();break;
		case "add_cart";add_cart();break;
		case "amounttotal_cart";amounttotal_cart();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
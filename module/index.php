<?php
	include ('function.php');
	connect_db();
	switch ($_GET['data']) {
		case "provinces";provinces();break;
		case "districts";districts();break;
		case "zipcode";zipcode();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
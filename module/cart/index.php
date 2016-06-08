<?php
	switch ($action) {
		case 'add2cart':add2cart();break;
		case 'show_cart':show_cart();break;

		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
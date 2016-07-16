<?php
	switch ($action) {
		case 'show_cart':show_cart();break;
		case 'cancel_cart':cancel_cart();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
<?php
	switch ($action) {
		case 'webboard':webboard();break;
		case 'form_webboard':form_webboard();break;
		case 'add_webboard':add_webboard();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
<?php
	switch ($action) {
		case 'list_webblog':list_webblog();break;
		case 'webblog_detail':webblog_detail();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
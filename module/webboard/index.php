<?php
	switch ($action) {
		case 'webboard':webboard();break;
		case 'form_webboard':form_webboard();break;
		case 'add_webboard':add_webboard();break;
		case 'webboard_detail':webboard_detail();break;
		case 'insert_subwebboard':insert_subwebboard();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
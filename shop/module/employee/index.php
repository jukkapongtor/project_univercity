<?php
	switch ($action) {
		case 'show_worktime':show_worktime();break;
		case 'show_salary':show_salary();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
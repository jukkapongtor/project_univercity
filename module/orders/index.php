<?php
	switch ($action) {
		case 'order_insert':order_insert();break;
		case 'order_list':order_list();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
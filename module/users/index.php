<?php
	switch ($action) {
		case 'register': register(); break;
		case 'insert_user' : insert_user();	break;
		case 'data_users' : data_users();	break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
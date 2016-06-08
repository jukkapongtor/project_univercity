<?php
	switch ($action) {
		case 'list_product':list_product();break;
		case 'product_detail':product_detail();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
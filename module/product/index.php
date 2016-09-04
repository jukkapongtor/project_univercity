<?php
	switch ($action) {
		case 'list_product':list_product();break;
		case 'product_detail':product_detail();break;
		case 'comment_product':comment_product();break;
		case 'delete_comment':delete_comment();break;
		case 'update_comment':update_comment();break;
		default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
	}

?>
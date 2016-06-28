<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta chaset='utf-8'>";
	mysqli_query($_SESSION['connect_db'],"UPDATE orders SET order_status='3',tracking_id='กำลังจัดเตรียมสินค้า' WHERE order_id='$_GET[order_id]'");
	echo "<script>window.location='../#ajax/manage_order.php'</script>";


?>
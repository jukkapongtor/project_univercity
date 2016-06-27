<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : "";
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_id='{$order_id}'")or die("ERROR module function line 9");
	$Rows = mysqli_num_rows($query_order);
	echo "adasdasdasdasd";
?>
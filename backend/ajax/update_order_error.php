<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta chaset='utf-8'>";
	mysqli_query($_SESSION['connect_db'],"UPDATE orders SET order_status='5',tracking_id='$_GET[message_error]' WHERE order_id='$_GET[order_id]'");
	$query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product_id,size_id,amount FROM order_detail WHERE order_id = '$_GET[order_id]'")or die("ERROR : update order error line 7");
	while(list($product_id,$size_id,$total_amount)=mysqli_fetch_row($query_orderdetail)){
		$query_product_size = mysqli_query($_SESSION['connect_db'],"SELECT product_amount_web FROM product_size WHERE product_id='$product_id' AND size_id='$size_id'")or die("ERROR : update order error  line 9");
		list($product_amount_web)=mysqli_fetch_row($query_product_size);
		$sum = $product_amount_web + $total_amount;
		$update_amount_web = "UPDATE product_size SET product_amount_web='$sum' WHERE product_id='$product_id' AND size_id='$size_id'";
		mysqli_query($_SESSION['connect_db'],$update_amount_web)or die("ERROR : update order error line 13");		
	}
	echo "<script>window.location='../#ajax/manage_order.php'</script>";


?>
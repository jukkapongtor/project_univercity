<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta charset='utf-8'>";
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
	$update_order = "UPDATE orders SET order_status='$_GET[status]' WHERE order_id='$_GET[order_id]'";
	mysqli_query($_SESSION['connect_db'],$update_order)or die("ERROR change_order line 8");
	if($_GET['status']==5){
		$query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,order_detail.amount FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id WHERE order_detail.order_id = '$_GET[order_id]'")or die("ERROR : order function line 82");
		    while(list($product_size_id,$total_amount)=mysqli_fetch_row($query_orderdetail)){
		    	$query_product_size = mysqli_query($_SESSION['connect_db'],"SELECT product_amount_web FROM product_size WHERE product_size_id='$product_size_id'")or die("ERROR : order function line 19");
		    	list($product_amount_web)=mysqli_fetch_row($query_product_size);
		    	$sum = $product_amount_web + $total_amount;
		  		$update_amount_web = "UPDATE product_size SET product_amount_web='$sum' WHERE product_size_id='$product_size_id'";
		  		mysqli_query($_SESSION['connect_db'],$update_amount_web)or die("ERROR change_order line 23");		
		    }
	}
	echo "<script>swal({title:'',text: \"แก้ไขสถานะการสั่งซื้อสินค้าเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/manage_order.php';})</script>";

?>
</body>
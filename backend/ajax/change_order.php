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

	echo "<script>swal({title:'',text: \"แก้ไขสถานะการสั่งซื้อสินค้าเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/manage_order.php';})</script>";

?>
</body>
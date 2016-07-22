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
	$product_id = $_GET['product_id'];
	$sql_delete_product_image="DELETE FROM product_image WHERE product_id='$product_id'";
	$sql_delete_product="DELETE FROM product WHERE product_id='$product_id'";
	$sql_delete_product_size="DELETE FROM product_size WHERE product_id='$product_id'";
	mysqli_query($_SESSION['connect_db'],$sql_delete_product_image)or die("ERROR : backend type_delete_type_id line 7");
	mysqli_query($_SESSION['connect_db'],$sql_delete_product)or die("ERROR : backend type_delete_type_id line 5");
	mysqli_query($_SESSION['connect_db'],$sql_delete_product_size)or die("ERROR : backend type_delete_type_id line 6");
	
	echo "<script>swal({title:'',text: \"ลบสินค้าเรียบร้อย\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/product_list.php';})</script>";
?>
</body>
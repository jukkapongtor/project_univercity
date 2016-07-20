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
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 5");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product_size WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 6");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product_image WHERE product_id='$_GET[product_id]'")or die("ERROR : backend type_delete_type_id line 7");
	echo "<script>swal({title:'',text: \"ลบสินค้าเรียบร้อย\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/product_list.php';})</script>";
?>
</body>
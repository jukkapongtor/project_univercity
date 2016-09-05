<?php
	session_start();
	include("../../include/function.php");
	echo "<meta charset='utf-8'>";
	connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_quality='$_GET[delete_quality_id]'")or die("ERROR : backend quality_delete_quality_id line 13");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM quality WHERE product_quality='$_GET[delete_quality_id]'")or die("ERROR : backend quality_delete_quality_id line 14");
	echo "<script>swal({title:'',text: \"ลบหมวดหมู่สินค้าเรียบร้อย\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/quality_manage.php';})</script>";
?>
</body>
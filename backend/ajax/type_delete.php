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
	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name_eng FROM type WHERE product_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 6");
	list($type_name_eng)=mysqli_fetch_row($query_type);
	mysqli_query($_SESSION['connect_db'],"DELETE FROM product WHERE product_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 8");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM quality WHERE quality_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 9");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM type WHERE product_type='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 10");
	mysqli_query($_SESSION['connect_db'],"DELETE FROM size WHERE type_id='$_GET[delete_type_id]'")or die("ERROR : backend type_delete_type_id line 11");
	
	$folder = iconv("utf-8","tis-620",$type_name_eng);
	rmdir("../../images/{$folder}");
	echo "<script>swal({title:'',text: \"ลบประเภทสินค้าเรียบร้อย\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
?>
</body>
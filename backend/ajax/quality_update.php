<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php	
	echo "<meta charset='utf-8'>";
	if(!empty($_FILES['quality_image']['name'])){
		$image=",quality_image='".$_FILES['quality_image']['name']."'";
		copy($_FILES['quality_image']['tmp_name'],"../../images/icon/".$_FILES['quality_image']['name']);
	}else{
		$image="";
	}
	$sql= "UPDATE quality SET quality_name='$_POST[quality_name]',quality_type='$_POST[edit_product_type]'$image WHERE product_quality='$_POST[quality_id]'";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend quality_update line 9");

	echo "<script>swal({title:'',text: 'แก้ไขหมวดหมู่สินค้าเรียบร้อย',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/quality_manage.php';})</script>";
?>
</body>
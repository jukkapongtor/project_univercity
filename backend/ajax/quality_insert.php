<?php
	session_start();
	echo "<meta charset='utf8'>";
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
	if(empty($_POST['quality_name'])||empty($_POST['product_type'])){
		echo "<script>swal({title:'',text: 'กรุณากรอกข้อมูลให้ครบถ้วน',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/quality_manage.php';})</script>";
	}else{
		$query_quality=mysqli_query($_SESSION['connect_db'],"SELECT quality_name FROM quality WHERE quality_name='$_POST[quality_name]'")or die("ERROR : backend quality_insert line 17");
		$row = mysqli_num_rows($query_quality);
		if(empty($row)){
			if(!empty($_FILES['quality_image']['name'])){
				$image=$_FILES['quality_image']['name'];
				copy($_FILES['quality_image']['tmp_name'],"../../images/icon/".$_FILES['quality_image']['name']);
			}else{
				$image="";
			}
			mysqli_query($_SESSION['connect_db'],"INSERT INTO quality VALUES('','$_POST[quality_name]','$_POST[product_type]','$image')")or die("ERROR : backend quality_insert line 16");

			echo "<script>swal({title:'',text: 'เพิ่มหมวดหมู่สินค้าเรียบร้อย',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/quality_manage.php';})</script>";
		}else{
			echo "<script>swal({title:'',text: 'ชื่อหมวดหมู่สินค้านี้มีในระบบแล้ว กรุณาเพิ่หมวดหมู่สินค้าชนิดอื่น',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/quality_manage.php';})</script>";
		}
	}

?>
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
	$number=0;
	$new_cntunit = array();
	foreach ($_POST['unit_name'] as  $value) {
		if(!empty($value)){
			array_push($new_cntunit,$value);
			$number++;
		}
	}
	unset($_POST['unit_name']);
	$_POST['unit_name']=$new_cntunit;
	if(empty($number)){
		echo "<script>swal({title:'',text: 'กรุณากรอกข้อมูลให้ครบถ้วน',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
	}else{
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type")or die("ERROR : backend type_insert line 14");
		$double=0;
		while(list($type_name)=mysqli_fetch_row($query_type)){
			if($type_name==$_POST['type_name']){
				$double=1;
			}
		}
		if($double==0){
			mysqli_query($_SESSION['connect_db'],"INSERT INTO type VALUES('','$_POST[type_name]','$_POST[type_name_eng]')")or die("ERROR : backend type_insert line 13");
			$query_type=mysqli_query($_SESSION['connect_db'],"SELECT product_type FROM type ORDER BY product_type DESC")or die("ERROR : backend type_insert line 14");
			list($type_id)=mysqli_fetch_row($query_type);
			for($i=0;$i<count($_POST['unit_name']);$i++){
				$query_size = mysqli_query($_SESSION['connect_db'],"SELECT size_name FROM size WHERE type_id='$type_id' AND size_name='".$_POST['unit_name'][$i]."'")or die("ERROR : backend type update line 33");
				$row = mysqli_num_rows($query_size);
				if(empty($row)){
					mysqli_query($_SESSION['connect_db'],"INSERT INTO size VALUES('','".$_POST['unit_name'][$i]."','$type_id')")or die("ERROR : backend type_insert line 20");
				}
			}
			
			$folder = "$_POST[type_name_eng]";
			$folder = iconv("utf-8","tis-620",$folder);
			mkdir("../../images/{$folder}");
			echo "<script>swal({title:'',text: 'เพิ่มประเภทสินค้าเรียบร้อย',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
		}else{
			echo "<script>swal({title:'',text: 'ชื่อประเภทสินค้านี้มีในระบบแล้ว กรุณาเพิ่มชื่อประเภทสินค้าชนิดอื่น',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
		}
		
	}

?>
</body>
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
	$number="";
	foreach ($_POST['unit_name'] as  $value) {
		$number=$value;
	}
	if(empty($_POST['type_name'])||empty($number)){
		echo "<script>swal({title:'',text: 'กรุณากรอกข้อมูลให้ครบถ้วน',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
	}else{
		mysqli_query($_SESSION['connect_db'],"INSERT INTO type VALUES('','$_POST[type_name]','$_POST[type_name_eng]')")or die("ERROR : backend type_insert line 13");
		$query_type=mysqli_query($_SESSION['connect_db'],"SELECT product_type FROM type ORDER BY product_type DESC")or die("ERROR : backend type_insert line 14");
		list($type_id)=mysqli_fetch_row($query_type);
		$sql_size = "INSERT INTO size VALUES('','".$_POST['unit_name'][0]."','$type_id')";
		for($i=1;$i<count($_POST['unit_name']);$i++){
			$sql_size.=",('','".$_POST['unit_name'][$i]."','$type_id')";
		}
		$query_type=mysqli_query($_SESSION['connect_db'],$sql_size)or die("ERROR : backend type_insert line 20");
		$folder = "$_POST[type_name_eng]";
		$folder = iconv("utf-8","tis-620",$folder);
		mkdir("../../images/{$folder}");
		echo "<script>swal({title:'',text: 'เพิ่มประเภทสินค้าเรียบร้อย',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
	}

?>
</body>
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
	$numer=1;
	$sql_insert = "INSERT INTO buy_supply VALUES";
	foreach ($_POST['supply_name'] as $key => $value) {
		if(!empty($value)){
			if($numer!=1){
				$sql_insert .=",";

			}
			$date = date("Y-m-d H:i:s");
			$sql_insert .= "('','".$_POST['supply_name'][$key]."','".$_POST['supply_amount'][$key]."','".$_POST['supply_price'][$key]."','".$_POST['supply_unit'][$key]."','$date')";
			$numer++;
		}
	}
	mysqli_query($_SESSION['connect_db'],$sql_insert)or die("ERROR : supplyes_update line 18");

	echo "<script>swal({title:'',text: \"บันทึกค่าใใช้จ่ายวัสดุสิ้นเปลืองเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/supplyes_manage.php';})</script>";
?>
</body>
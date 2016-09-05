<?php
session_start();
include("../../include/function.php");
connect_db();
?>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
date_default_timezone_set('Asia/Bangkok');


	for($i=0;$i<count($_POST['salary']);$i++){
		$update_salary = "UPDATE working SET salary='".$_POST['salary'][$i]."' WHERE working_id='".$_POST['working_id'][$i]."'";
		mysqli_query($_SESSION['connect_db'],$update_salary);
	}
	echo "<script>swal({title:'',text: 'อัพเดทเงินเดือนพนักงานเรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]'})</script>";

	
?>
</body>
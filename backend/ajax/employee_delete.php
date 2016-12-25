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
	mysqli_query($_SESSION['connect_db'],"DELETE FROM employee WHERE employee_id='$_GET[employee_id]'")or die("ERROR : backend employee delete line 5");
	echo "<script>swal({title:'',text: \"ลบพนักงานเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_manage.php';})</script>";
?>
</body>
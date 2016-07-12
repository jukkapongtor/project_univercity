<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
?>
<head>
	<title></title>
</head>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการข้อมูลพนักงาน</a></li>
			<li><a href="#">ข้อมูลพนักงาน</a></li>

		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>

<body>
	<a href="ajax/employee_form_id.php"><button class="btn btn-primary" type="submit"> <img src="../images/icon/add.png" width="26px" ></button></a>

</body>
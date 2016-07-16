<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	mysqli_query($_SESSION['connect_db'],"DELETE FROM employee WHERE employee_id='$_GET[employee_id]'")or die("ERROR : backend employee delete line 5");

	echo "<script>window.location='../#ajax/employee_manage.php';</script>";
?>
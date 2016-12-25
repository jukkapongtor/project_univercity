<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	mysqli_query($_SESSION['connect_db'],"DELETE FROM webblog WHERE id_blog='$_GET[id_blog]'")or die("ERROR : backend webblog delete line 5");
	echo "<script>window.location='../#ajax/manage_webblog.php';</script>";
?>
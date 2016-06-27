<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();

	$img =$_FILES['featured_image']['name'];
	if (empty($img)) {
		$img="";
	}else{
	copy($_FILES['featured_image']['tmp_name'],"../../images/webblog/$img");
	}

	if (empty($_POST['title_blog'])|| empty($_POST['detail'])|| empty($_POST['typeblog'])) {
			
			echo "<script> alert('กรุณากรอกข้อมูลให้ครบ');window.location='../#ajax/manage_webblog.php' </script>";
	}else{

	$date = date("Y-m-d H:i:s");

	$sql = "INSERT INTO webblog VALUES ('','$_POST[title_blog]','$img','$_POST[review_detail]','$_POST[detail]','0','0','$_POST[typeblog]','$date') ";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend insert_webblog line 16");
		
	echo "<script></script>";
}	


?>
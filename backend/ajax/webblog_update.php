<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
		if($_FILES['webblog_image']['size']>2048000){
			echo "<script> alert('รูปภาพมีขนาดหใญ่กว่าที่ระบบกำเนิด 2 MB กรุณาเลือกรูปที่มีขนาดน้อยกว่า');window.location='../#ajax/manage_webblog.php' </script>";
		}

	if(empty($_POST['title_blog'])|| empty($_POST['detail'])|| empty($_POST['typeblog'])) {
			//echo "<script> alert('กรุณากรอกข้อมูลให้ครบ');window.location='../#ajax/manage_webblog.php' </script>";
	}else{
		$img =$_FILES['webblog_image']['name'];
		
		if (empty($img)) {
			$img="";
		}else{
		copy($_FILES['webblog_image']['tmp_name'],"../../images/webblog/$img");
		$img = ",featured_image='$img'";
		}

		$date = date("Y-m-d H:i:s");


		$sql ="UPDATE webblog SET title_blog='$_POST[title_blog]',review_detail='$_POST[review_detail]',detail='$_POST[detail]',type_blog='$_POST[typeblog]',blog_date='$date' $img WHERE id_blog='$_POST[blog]'" or die("ERROR : backend webblog update line 20");


		mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend insert_webblog line 25");

		echo "$sql";


		//echo "<script>window.location='../#ajax/manage_webblog.php';</script>";
	
}

?>
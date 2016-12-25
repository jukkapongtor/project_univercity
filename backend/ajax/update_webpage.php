<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta charset='utf-8'>";

	
	
	if(!empty($_FILES['logo_image']['name'])){
		copy($_FILES['logo_image']['tmp_name'],"../../images/icon/".$_FILES['logo_image']['name']);
		$image1 = ",logo = '".$_FILES['logo_image']['name']."'";
	}else{
		$image1 = "";
	}
	if(!empty($_FILES['image_content2']['name'])){
		copy($_FILES['image_content2']['tmp_name'],"../../images/webpage/".$_FILES['image_content2']['name']);
		$image2 = ",image_content2 = '".$_FILES['image_content2']['name']."'";
	}else{
		$image2 = "";
	}
	if(!empty($_FILES['image_content3']['name'])){
		copy($_FILES['image_content3']['tmp_name'],"../../images/webpage/".$_FILES['image_content3']['name']);
		$image3 = ",image_content3 = '".$_FILES['image_content3']['name']."'";	
	}else{
		$image3 = "";
	}
	$sql_update = "UPDATE web_page SET nameshop='$_POST[name_shop]',header_detail_shop='$_POST[head_content1]',detail_shop='$_POST[content1]',header_content2='$_POST[head_content2]',content2='$_POST[content2]',header_content3='$_POST[head_content3]',content3='$_POST[content3]' $image1 $image2 $image3 WHERE web_page_id='1'";

	mysqli_query($_SESSION['connect_db'],$sql_update)or die("ERROR : update webpage line 27");
	echo "<script>window.location='../#ajax/manage_website.php'</script>";
	

?>
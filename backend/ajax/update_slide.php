<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta charset='utf-8'>";

	if($_FILES['image_slide']['size'][0]>1536000){
		echo "<script>alert('รูปภาพที่ 1 มีขนาดเกิน 1.5 MB กรุณาเลือกรูปภาพที่มีขนาดน้อยกว่า 1.5 MB');window.location='../#ajax/manage_slideshow.php'</script>";
	}
	if($_FILES['image_slide']['size'][1]>1536000){
		echo "<script>alert('รูปภาพที่ 2 มีขนาดเกิน 1.5 MB กรุณาเลือกรูปภาพที่มีขนาดน้อยกว่า 1.5 MB');window.location='../#ajax/manage_slideshow.php'</script>";
	}
	if($_FILES['image_slide']['size'][2]>1536000){
		echo "<script>alert('รูปภาพที่ 3 มีขนาดเกิน 1.5 MB กรุณาเลือกรูปภาพที่มีขนาดน้อยกว่า 1.5 MB');window.location='../#ajax/manage_slideshow.php'</script>";
	}
	if($_FILES['image_slide']['size'][3]>1536000){
		echo "<script>alert('รูปภาพที่ 4 มีขนาดเกิน 1.5 MB กรุณาเลือกรูปภาพที่มีขนาดน้อยกว่า 1.5 MB');window.location='../#ajax/manage_slideshow.php'</script>";
	}

	for($i=0;$i<4;$i++){
		if(!empty($_FILES['image_slide']['name'][$i])){
			copy($_FILES['image_slide']['tmp_name'][$i],"../../images/slide/".$_FILES['image_slide']['name'][$i]);
			$image = ",slide_image='".$_FILES['image_slide']['name'][$i]."'";
		}else{
			$image ="";
		}
		$sql = "UPDATE slide SET header_slide='".$_POST['header_slide'][$i]."',slide_detail='".$_POST['slide_detail'][$i]."' $image WHERE slide_id='".($i+1)."'";
		mysqli_query($_SESSION['connect_db'],$sql);
	}
	echo "<script>alert('อัพเดทภาพไลด์สำหรับใช้หน้าเว็บไซต์ เรียบร้อย');window.location='../#ajax/manage_slideshow.php'</script>";
	
?>
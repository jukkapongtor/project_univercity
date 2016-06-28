<?php
function check_transfer(){
	if(empty($_FILES['image_transfer']['name'])){
		echo "<script>alert('กรุณาเลือกไฟล์ก่อนทำการยืนยันการชำระเงิน');window.location='index.php?module=users&action=data_users&menu=3'</script>";
	}else{
		$image_name = $_FILES['image_transfer']['name'];
		copy($_FILES['image_transfer']['tmp_name'],"images/transfer/".$_FILES['image_transfer']['name']);
		$date = date("Y-m-d H:i:s");
		$sqli_insert_transfer= "INSERT INTO transfer VALUES('','$image_name','$date','$_POST[order_id]')";
		$sqli_update_order = "UPDATE orders SET order_status ='2',tracking_id='กรุณารอการตรวจสอบจากเจ้าของร้าน' WHERE order_id ='$_POST[order_id]'";

		mysqli_query($_SESSION['connect_db'],$sqli_insert_transfer);
		mysqli_query($_SESSION['connect_db'],$sqli_update_order);
		echo "<script>alert('ยืนยันการชำระเงิน');window.location='index.php?module=users&action=data_users&menu=3'</script>";
	}
	
}
?>
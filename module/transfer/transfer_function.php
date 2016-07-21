<?php
function check_transfer(){
	if(empty($_FILES['image_transfer']['name'])){
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<script>swal({title:'',text: \"กรุณาเลือกไฟล์ก่อนทำการยืนยันการชำระเงิน\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=users&action=data_users&menu=3&order_status=1';})</script>";
	}else{
		$image_name = $_FILES['image_transfer']['name'];
		copy($_FILES['image_transfer']['tmp_name'],"images/transfer/".$_FILES['image_transfer']['name']);
		$date = date("Y-m-d H:i:s");
		$sqli_insert_transfer= "INSERT INTO transfer VALUES('','$image_name','$date','$_POST[order_id]')";
		$sqli_update_order = "UPDATE orders SET order_status ='2',tracking_id='กรุณารอการตรวจสอบจากเจ้าของร้าน' WHERE order_id ='$_POST[order_id]'";

		mysqli_query($_SESSION['connect_db'],$sqli_insert_transfer);
		mysqli_query($_SESSION['connect_db'],$sqli_update_order);
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<script>swal({title:'',text: \"ยืนยันการชำระเงิน\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=users&action=data_users&menu=3&order_status=2';})</script>";
	}
	
}
?>
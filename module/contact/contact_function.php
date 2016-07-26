<?php
function insert_contact(){

	if(!empty($_SESSION['login_name'])){
		$query_user = mysqli_query($_SESSION['connect_db'],"SELECT email FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR :  contact line 5");
        list($email)=mysqli_fetch_row($query_user);
	}
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	$username = (empty($_SESSION['login_name']))?"$_POST[username]":$_SESSION['login_name'];
    $email =(empty($email))?"$_POST[email]":$email;
	$type_user=(empty($_SESSION['login_name']))?"ผู้ใช้งานทั้วไป":"สมาชิก";
	$date_send = date("Y-m-d H:i:s");
	$sql_insert_contact = "INSERT INTO contactus VALUES('','$username','$email','$_POST[message]','$type_user','$date_send','1')";
	mysqli_query($_SESSION['connect_db'],$sql_insert_contact)or die("ERROR ERROR :  contact line 13");

	echo "<script>swal({title:'',text: \"ส่งข้อความไปยังเจ้าของร้านแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.history.back();});</script>";
}
?>
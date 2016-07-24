<?php
    session_start();
    echo "<meta charset='utf8'>";
    include("../../include/function.php");
    date_default_timezone_set('Asia/Bangkok');
    connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
	if(empty($_POST['oldpasswd'])||empty($_POST['newpasswd'])||empty($_POST['connewpasswd'])){
		echo "<script>swal({title:'',text: 'คุณกรอกข้อมูลไม่ครบ กรุณากรอกข้อมูลให้ครบก่อนทำการยืนยัน',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='../#ajax/admin_form.php';})</script>";
	}else{
		$query_users = mysqli_query($_SESSION['connect_db'],"SELECT passwd FROM users WHERE username= '$_SESSION[login_name]'")or die("ERROR : users function line 238");
		list($passwd)=mysqli_fetch_row($query_users);

		if($passwd!=$_POST['oldpasswd']){
			echo "<script>swal({title:'',text: 'รหัสเดิมไม่ถูกต้อง กรุณาตรวจสอบรหัสเดิมของคุณให้ถูกต้อง',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='../#ajax/admin_form.php';})</script>";
		}elseif($_POST['newpasswd']!=$_POST['connewpasswd']){
			echo "<script>swal({title:'',text: 'การยืนยันรหัสผ่านไม่สอดคล้องกัน กรุณาตรวจสอบความถูกต้อง',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='../#ajax/admin_form.php';})</script>";
		}else{

		mysqli_query($_SESSION['connect_db'],"UPDATE users SET passwd='$_POST[newpasswd]' WHERE username ='$_SESSION[login_name]'")or die("ERROR : update password users function line 246 ");
		echo "<script>swal({title:'',text: \"รหัสผ่านของท่านถูกแก้ไขเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/admin_form.php';})</script>";
		}
	}
?>

</body>
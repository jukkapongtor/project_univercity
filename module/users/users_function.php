<?php
function register(){
	echo "<form method='post' action='index.php?module=users&action=insert_user'>";
	echo "<div class='container-fluid'>";
		echo "<div class='col-md-12' style='border-bottom:1px solid #ddd;margin-top:20px;'>";
			echo "<center><font style='font-size:50px'><b>สมัครสมาชิก</b></font></center>";
		echo "</div>";
		echo "<div class='col-md-3' style='margin-top:20px'> </div>";
		echo "<div class='col-md-2' style='margin-top:20px'>";
			echo "<p style='font-size:25px'><b>กรอกอิเมล์</b></p>";
			echo "<p style='font-size:25px'><b>ชื่อผู้ใช้งาน</b></p>";
			echo "<p style='font-size:25px'><b>รหัสผ่าน</b></p>";
			echo "<p style='font-size:25px;margin-top:70px'><b>ยืนยันรหัสผ่าน</b></p>";
		echo "</div>";
		echo "<div class='col-md-5' style='margin-top:20px'>";
			echo "<p><input type='email' class='form-control' name='user_email' placeholder='Email...'></p>";
			echo "<p><input type='text' class='form-control' name='username' placeholder='Username...'></p>";
			echo "<p><input type='password' class='form-control' name='passwd' placeholder='Password ...'></p>";
			echo "<p><font style='font-size:18px'>รหัสผ่านจะต้องเป็นตัวเลข ภาษาอังกฤษ อักขระพิเศษ ยกเว้น คอมม่า(,) ซิงเกิลโค๊ด(') และดับเิ้ลโค๊ด(\") จำนวน 4-16 หลัก</font></p>";
			echo "<p><input type='password' class='form-control' name='conpasswd' placeholder='Confirm password...'></p>";
		echo "</div>";
		echo "<div class='col-md-2' style='margin-top:20px'> </div>";
		echo "<div class='col-md-12' style='margin-top:20px'>";
			echo "<center><input type='checkbox' name='condition' value='1'><font style='font-size:22px'>&nbsp;ยอมรับ&nbsp;<a href='#'>เงื่อนไขการให้บริการ</a></font></center>";
		echo "</div>";
		echo "<div class='col-md-3' style='margin-top:20px'> </div>";
		echo "<div class='col-md-6' style='margin-top:20px;margin-bottom:50px;'>";
			echo "<center><button class='btn btn-sm btn-success' type='submit'><font style='font-size:20px;'>ยืนยันการลงทะเบียน</font></button>&nbsp;&nbsp;&nbsp;<a href='index.php'><button class='btn btn-sm btn-danger'type='button'><font style='font-size:20px;'>ยกเลิกการลงทะเบียน</font></button></a></center>";
		echo "</div>";
		echo "<div class='col-md-3' style='margin-top:20px'> </div>";
	echo "</div>";
	echo "</form>";
}

function insert_user(){
	if(empty($_POST['user_email']) or empty($_POST['username']) or empty($_POST['passwd']) or empty($_POST['conpasswd']) or empty($_POST['condition'])){
		echo "<script> alert('กรุณากลับไปกรอกข้อมูลให้ครบ !!'); window.location='index.php?module=users&action=register'</script>";
	}else{

	$query_users= mysqli_query($_SESSION['connect_db'],"SELECT username,email FROM users")or die("ERROR :");
	while(list($username,$email)=mysqli_fetch_row($query_users)){
		if($_POST['username']==$username){
			echo "<script>alert('username มีอยู่ในะบบแล้ว');window.location='index.php?module=users&action=register'</script>";
		}
		if($_POST['user_email']==$email){
			echo "<script>alert('e-mail มีอยู่ในะบบแล้ว');window.location='index.php?module=users&action=register'</script>";
		}
	}
	if($_POST['passwd']!=$_POST['conpasswd']){
		echo "<script>alert('Password กับ Confirm Password ไม่สอดคล้องกัน');window.location='index.php?module=users&action=register'</script>";
	}	
	mysqli_query($_SESSION['connect_db'],"INSERT INTO users VALUES ('$_POST[username]','$_POST[passwd]','','','','','','','$_POST[user_email]','3' )") or die ("ERROR : users_function line 36 ") ;
	echo "<script>window.location='index.php'</script>";
	}




}

?>
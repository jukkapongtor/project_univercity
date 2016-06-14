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

function data_users(){
	echo "<div class='container-fluid' style='padding:0px;height:630px;'>";
		echo "<div class='col-md-3 datausers_menu'>";
		$query_users = mysqli_query($_SESSION['connect_db'],"SELECT fullname,lastname,image FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
		list($fullname,$lastname,$image)=mysqli_fetch_row($query_users);
			echo "<p><center><img src='images/user/$image' width='150' height='150'></center></p><br>";
			echo "<p align='center'><img src='images/icon/black-user-shape.png' width='24' style='margin-top:-8px'>&nbsp;<font size='5'><b>ยินดีต้อนรับ</b></font></p>";
			$name = (empty($fullname)AND empty($lastname))?"ไม่ระบุชื่อหรือนามสกุล":"$fullname $lastname";
			echo "<p class='font20' style='padding-left:18px;'><b>ชื่อ : </b>$fullname $lastname</p>";
			switch ($_GET['menu']) {
				case '1': $action_menu_user1 ="active-datausers-menu";$action_menu_user2 ="";$action_menu_user3 ="";$action_menu_user4 ="";$action_menu_user5 =""; break;
				case '2': $action_menu_user1 ="";$action_menu_user2 ="active-datausers-menu";$action_menu_user3 ="";$action_menu_user4 ="";$action_menu_user5 =""; break;
				case '3': $action_menu_user1 ="";$action_menu_user2 ="";$action_menu_user3 ="active-datausers-menu";$action_menu_user4 ="";$action_menu_user5 =""; break;
				case '4': $action_menu_user1 ="";$action_menu_user2 ="";$action_menu_user3 ="";$action_menu_user4 ="active-datausers-menu";$action_menu_user5 =""; break;
				case '5': $action_menu_user1 ="";$action_menu_user2 ="";$action_menu_user3 ="";$action_menu_user4 ="";$action_menu_user5 ="active-datausers-menu"; break;
			}
			echo "<a href='index.php?module=users&action=data_users&menu=1'><p class='font20 margin0 $action_menu_user1'>&nbsp;&nbsp;<b>ข้อมูลส่วนตัว</p></a>";
			echo "<a href='index.php?module=users&action=data_users&menu=2'><p class='font20 margin0 $action_menu_user2'>&nbsp;&nbsp;สินค้าในตะกร้า</p></a>";
			echo "<a href='index.php?module=users&action=data_users&menu=3'><p class='font20 margin0 $action_menu_user3'>&nbsp;&nbsp;สถานะการชำระเงิน</p></a>";
			echo "<a href='index.php?module=users&action=data_users&menu=4'><p class='font20 margin0 $action_menu_user4'>&nbsp;&nbsp;สถานะการส่งสินค้า</p></a>";
			echo "<a href='index.php?module=users&action=data_users&menu=5'><p class='font20 margin0 $action_menu_user5'>&nbsp;&nbsp;ประวัติการซื้อสินค้า</b></p></a>";
		echo "</div>";
		echo "<div class='col-md-9'>";
				switch ($_GET['menu']) {
					case '1': edit_user(); break;				
					//default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
				}
		echo "</div>";
	echo "</div>";
}
function edit_user(){
	$query_users = mysqli_query($_SESSION['connect_db'],"SELECT * FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
	list($username,$passwd,$fullname,$lastname,$address,$image,$phone,$email,$type)=mysqli_fetch_row($query_users);
	echo "<h1 style='background:#649d6c;color:white;padding:5px 10px;'>แก้ไขข้อมูลส่วนตัว</h1>";
	echo "<div class='col-md-12' style='border-bottom:2px solid #ddd'>";
		echo "<p class='font20'><b>รายละเอียดข้อมูลผู้ใช้</b></p>";
		echo "<table style='margin-left:40px;'>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>อีเมล์</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'>&nbsp;$email</p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>ชื่อผู้ใช้งาน</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'>&nbsp;$username</p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td colspan='3'>";
					echo "<a href='#' data-toggle='modal' data-target='#changepasswd' style='text-decoration: underline;'><p class='font20'><b>เปลี่ยนรหัสผ่าน</b></p></a>";
					echo "<div class='modal fade' id='changepasswd' tabindex='-1' role='dialog' style='margin-top:50px;'>";
					  echo "<div class='modal-dialog' role='document'>";
					    echo "<div class='modal-content'>";
					     echo " <div class='modal-header'>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					       <h1 class='modal-title' style='margin:-10px 10px;margin-bottom:-20px;'><b>เปลี่ยนรหัสผ่าน</b></h1>";
					     echo "</div>";
					     echo "<div class='modal-body'>";
					     	echo "<form action='index.php?module=users&action=update_passwd' method='post'>";
					     	echo "<center><table style='width:60%'>";
					     		echo "<tr><td class='font20'><p><b>รหัสผ่านปัจจุบัน</b></p></td><td><b><p>&nbsp;:&nbsp;</p></b></td><td><p><input class='form-control' type='password' name='oldpasswd' placeholder='Old Password'></p></td></tr>";
					     		echo "<tr><td class='font20'><p><b>รหัสผ่านใหม่</b></p></td><td><b><p>&nbsp;:&nbsp;</p></b></td><td><p><input class='form-control' type='password' name='newpasswd' placeholder='New Password'></p></td></tr>";
					     		echo "<tr><td class='font20'><p><b>ยืนยันรหัสผ่านใหม่</b></p></td><td><b><p>&nbsp;:&nbsp;</p></b></td><td><p><input class='form-control' type='password' name='connewpasswd' placeholder='Confirm New Password'></p></td></tr>";
					     	echo "</table>";
					     	echo "<br><button class='btn btn-sm btn-success' type='submit'><font class='font20'>บันทึกการเปลี่ยนแปลง</font></button>&nbsp;&nbsp;&nbsp;<button class='btn btn-sm btn-danger' type='button' class='close' data-dismiss='modal' aria-label='Close'><font class='font20'>ยกเลิกการเปลี่ยนแปลง</font></button>";
					     	echo "</center>";
					     	echo "</form>";
					     echo "</div>";
					    echo "</div>";
					  echo "</div>";
					echo "</div>";  
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
	echo "<div class='col-md-12' >";
		echo "<p class='font20'><b>ที่อยู่ที่ใช้ในการจัดส่ง</b></p>";
		echo "<center><table><from>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>ชื่อ</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td width='70%'>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='fullname' placeholder='Fullname' value='$fullname'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>นามสกุล</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='lastname' placeholder='Lastname' value='$lastname'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>จังหวัด</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><select name='province'><option>เลือกจังหวัด</option></select></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>เขต/อำเภอ</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><select name='county'><option>เลือกอำเภอ</option></select></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>แขวง/ตำบล</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><select name='district'><option>เลือกตำบล</option></select></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>รหัสไปรษณีย์</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='postcode' placeholder='Postcode'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>เบอร์โทรศัพท์</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='phone' placeholder='Phone' value='$phone'></p>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center>";
		echo "<p align='right' class='font20'><button class='btn btn-success' type='submit'><b>บันทึกข้อมูล</b></button></p>";
	echo "</div>";
}

function update_passwd(){

	if(empty($_POST['oldpasswd'])||empty($_POST['newpasswd'])||empty($_POST['connewpasswd'])){
		echo "<script>alert('คุณกรอกข้อมูลไม่ครบ กรุณากรอกข้อมูลให้ครบก่อนทำการยืนยัน');window.location='index.php?module=users&action=data_users&menu=1';</script>";
	}else{
		$query_users = mysqli_query($_SESSION['connect_db'],"SELECT passwd FROM users WHERE username= '$_SESSION[login_name]'")or die("ERROR : users function line 238");
		list($passwd)=mysqli_fetch_row($query_users);
		
		if($passwd!=$_POST['oldpasswd']){
			echo "<script>alert('รหัสเดิมไม่ถูกต้อง กรุณาตรวจสอบรหัสเดิมของคุณให้ถูกต้อง');window.location='index.php?module=users&action=data_users&menu=1';</script>";
		}elseif($_POST['newpasswd']!=$_POST['connewpasswd']){
			echo "<script>alert('การยืนยันรหัสผ่านไม่สอดคล้องกัน กรุณาตรวจสอบความถูกต้อง');window.location='index.php?module=users&action=data_users&menu=1';</script>";
		}

		mysqli_query($_SESSION['connect_db'],"UPDATE users SET passwd='$_POST[newpasswd]' WHERE username ='$_SESSION[login_name]'")or die("ERROR : update password users function line 246 ");
		echo "<script>alert('รหัสผ่านของท่านถูกแก้ไขเรียบร้อยแล้ว');window.location='index.php?module=users&action=data_users&menu=1';</script>";


	}

}
?>
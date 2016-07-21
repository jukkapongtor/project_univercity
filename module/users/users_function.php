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
			echo "<center><input type='checkbox' name='condition' value='1'><font style='font-size:22px'>&nbsp;ยอมรับ&nbsp;<a data-toggle='modal' data-target='#condition' style='text-decoration:none;cursor:pointer'>เงื่อนไขการให้บริการ</a></font></center>";
?>
				<div class="modal fade" id="condition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">เงื่อนไขการให้บริการ</h4>
				      </div>
				      <div class="modal-body">
				        ...
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				      </div>
				    </div>
				  </div>
				</div>
<?php
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
		
		echo "<script>swal({title:'',text: \"กรุณากลับไปกรอกข้อมูลให้ครบ !!\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=register';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	}else{

	$query_users= mysqli_query($_SESSION['connect_db'],"SELECT username,email FROM users")or die("ERROR :");
	while(list($username,$email)=mysqli_fetch_row($query_users)){
		if($_POST['username']==$username){
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			echo "<script>swal({title:'',text: \"username มีอยู่ในะบบแล้ว\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=register';})</script>";
		}
		if($_POST['user_email']==$email){
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			echo "<script>swal({title:'',text: \"e-mail มีอยู่ในะบบแล้ว\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=register';})</script>";
		}
	}
	if($_POST['passwd']!=$_POST['conpasswd']){
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<script>swal({title:'',text: \"Password กับ Confirm Password ไม่สอดคล้องกัน\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=register';})</script>";
	}	
	mysqli_query($_SESSION['connect_db'],"INSERT INTO users VALUES ('$_POST[username]','$_POST[passwd]','','','','','$_POST[user_email]','3','','','','','','','','','' )") or die ("ERROR : users_function line 36 ") ;
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<script>swal({title:'',text: \"สมัครสมาชิกเสร็จสิ้น สามารถลงชื่อเข้าใช้งานระบบได้แล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php';})</script>";
	}




}

function data_users(){
	echo "<div class='container-fluid' style='padding:0px;height:980px;'>";
		echo "<div class='col-md-3 datausers_menu'>";
		$query_users = mysqli_query($_SESSION['connect_db'],"SELECT fullname,lastname,image FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
		list($fullname,$lastname,$image)=mysqli_fetch_row($query_users);
		$image = (empty($image))?"user.png":$image;
			echo "<p><center><img src='images/user/$image' id='blah' width='150' height='150'></center></p><br>";
			echo "<p align='center'><img src='images/icon/black-user-shape.png' width='24' style='margin-top:-8px'>&nbsp;<font size='5'><b>ยินดีต้อนรับ</b></font></p>";
			$name = (empty($fullname)AND empty($lastname))?"ไม่ระบุชื่อหรือนามสกุล":"$fullname $lastname";
			echo "<p class='font20' style='padding-left:18px;'><b>ชื่อ : </b>$name</p>";
			switch ($_GET['menu']) {
				case '1': $action_menu_user1 ="active-datausers-menu";$action_menu_user2 ="";$action_menu_user3 ="";$action_menu_user4 ="";$action_menu_user5 =""; break;
				case '2': $action_menu_user1 ="";$action_menu_user2 ="active-datausers-menu";$action_menu_user3 ="";$action_menu_user4 ="";$action_menu_user5 =""; break;
				case '3': $action_menu_user1 ="";$action_menu_user2 ="";$action_menu_user3 ="active-datausers-menu";$action_menu_user4 ="";$action_menu_user5 =""; break;
				case '4': $action_menu_user1 ="";$action_menu_user2 ="";$action_menu_user3 ="";$action_menu_user4 ="active-datausers-menu";$action_menu_user5 =""; break;
			}
			echo "<a href='index.php?module=users&action=data_users&menu=1'><p class='font20 margin0 $action_menu_user1'>&nbsp;&nbsp;<b>ข้อมูลส่วนตัว</p></a>";
			$quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 64");
	        list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
	        if($sellstatus==1){
			echo "<a href='index.php?module=users&action=data_users&menu=2'><p class='font20 margin0 $action_menu_user2'>&nbsp;&nbsp;สินค้าในตะกร้า</p></a>";
			echo "<a href='index.php?module=users&action=data_users&menu=3&order_status=1'><p class='font20 margin0 $action_menu_user3'>&nbsp;&nbsp;สถานะการซื้อสินค้า</p></a>";
			echo "<a href='index.php?module=users&action=data_users&menu=4&order_status=4'><p class='font20 margin0 $action_menu_user4'>&nbsp;&nbsp;ประวัติการซื้อสินค้า</b></p></a>";
			}
		echo "</div>";
		echo "<div class='col-md-9'>";
				switch ($_GET['menu']) {
					case '1': edit_user(); break;
					case '2': show_cart(); break;				
					case '3': order_list(); break;
					case '4': order_success(); break;	
					//default: echo "<script>alert('เกิดข้อผิดพลาดในการใช้งาน ระบบจะนำคุณไปยังหน้าหลัก');window.location='index.php'</script>";break;
				}
		echo "</div>";
	echo "</div>";
}
function edit_user(){
	$query_users = mysqli_query($_SESSION['connect_db'],"SELECT * FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
	list($username,$passwd,$fullname,$lastname,$image,$phone,$email,$type,$house_no,$village_no,$alley,$lane,$road,$sub_district,$district,$province,$postal_code)=mysqli_fetch_row($query_users);
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
		echo "<form action='index.php?module=users&action=update_users' method='post' enctype='multipart/form-data'><center><table width='80%'>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>รูปภาพ</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td colspan='4'>";
					echo "<p class='font16'><input type='file' name='user_image' multiple onchange=\"document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])\"></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>ชื่อ</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td colspan='4'>";
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
				echo "<td colspan='4'>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='lastname' placeholder='Lastname' value='$lastname'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>บ้านเลขที่</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='house_no' placeholder='House NO.' value='$house_no'></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;หมู่</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='village_no' placeholder='Village NO.' value='$village_no'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>ตรอก</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='alley' placeholder='Alley' value='$alley'></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;ซอย</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='lane' placeholder='Lane' value='$lane'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>ถนน</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td colspan='4'>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='road' placeholder='Road' value='$road'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td width='18%'>";
					echo "<p class='font20'><b>จังหวัด</b></p>";
				echo "</td>";
				echo "<td width='5%'>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td width='27%'>";
					echo "<p class='font20'>";
					echo "<select id='select_provinces' name='province' style='width:100%'>";
						echo "<option value='null'>เลือกจังหวัด</option>";
						$query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces")or die("ERROR : users function line 235");
						while(list($province_id,$province_name)=mysqli_fetch_row($query_provinces)){
							if($province==$province_name){
								echo "<option value='$province_id' selected='selected'>$province_name</option>";
								$isset_province = $province_id;
							}else{
								echo "<option value='$province_id'>$province_name</option>";
							}
							
						}
					echo "</select></p>";
				echo "</td>";
				echo "<td width='18%'>";
					echo "<p class='font20'><b>&nbsp;เขต/อำเภอ</b></p>";
				echo "</td width='5%'>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td width='27%'>";
					echo "<p class='font20'><select id='select_districts' name='districts' style='width:100%'>";
					if(empty($district)){
						echo "<option value='null'>เลือกอำเภอ</option>";
					}else{
						$query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province'")or die("ERROR : users function line 259");
						while(list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict)){
							if($district == $amphure_name){
								echo "<option value='$amphure_id' selected='selected'>$amphure_name</option>";
								$isset_district = $amphure_id;
							}else{
								echo "<option value='$amphure_id'>$amphure_name</option>";
							}
						}
					}	
					echo "</select></p>";
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
					echo "<p class='font20'><select id='select_subdistricts' name='subdistrict' style='width:100%'>";
					if(empty($sub_district)){
						echo "<option value='null'>เลือกตำบล</option>";
					}else{
						$query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district'")or die("ERROR : users function line 259");
						while(list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict)){
							if($sub_district == $disrtict_name){
								echo "<option value='$disrtict_code' selected='selected'>$disrtict_name</option>";
							}else{
								echo "<option value='$disrtict_code'>$disrtict_name</option>";
							}
						}
					}
					echo "</select></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;รหัสไปรษณีย์</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><input class='form-control' tyle='text' id='zipcode' name='zipcode' placeholder='Postcode' value='$postal_code'></p>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>เบอร์โทรศัพท์</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;: </b></p>";
				echo "</td>";
				echo "<td colspan='4'>";
					echo "<p class='font20'><input class='form-control' tyle='text' name='phone' placeholder='Phone' value='$phone'></p>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center><br>";
		echo "<p align='right' class='font20'><button type='submit' class='btn btn-success' ><b>บันทึกข้อมูล</b></button></form></p>";
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
			echo "string";
		}elseif($_POST['newpasswd']!=$_POST['connewpasswd']){
			echo "<script>alert('การยืนยันรหัสผ่านไม่สอดคล้องกัน กรุณาตรวจสอบความถูกต้อง');window.location='index.php?module=users&action=data_users&menu=1';</script>";
		}

		mysqli_query($_SESSION['connect_db'],"UPDATE users SET passwd='$_POST[newpasswd]' WHERE username ='$_SESSION[login_name]'")or die("ERROR : update password users function line 246 ");
		echo "<script>alert('รหัสผ่านของท่านถูกแก้ไขเรียบร้อยแล้ว');window.location='index.php?module=users&action=data_users&menu=1';</script>";


	}

}
function update_users(){
	$query_address = mysqli_query($_SESSION['connect_db'],"SELECT provinces.PROVINCE_NAME,amphures.AMPHUR_NAME,districts.DISTRICT_NAME FROM provinces LEFT JOIN amphures ON provinces.PROVINCE_ID = provinces.PROVINCE_ID LEFT JOIN districts ON amphures.AMPHUR_ID=districts.AMPHUR_ID WHERE provinces.PROVINCE_ID='$_POST[province]' AND amphures.AMPHUR_ID='$_POST[districts]' AND districts.DISTRICT_CODE='$_POST[subdistrict]'")or die("ERROR : users function line 312");
	list($province,$district,$subdistrict)=mysqli_fetch_row($query_address);

	if(!empty($_FILES['user_image']['name'])){
		copy($_FILES['user_image']['tmp_name'],"images/user/".$_FILES['user_image']['name']);
		$image=",image='".$_FILES['user_image']['name']."'";
	}else{
		$image="";
	}
	$update_users = "UPDATE users SET fullname='$_POST[fullname]',lastname='$_POST[lastname]',phone='$_POST[phone]',house_no='$_POST[house_no]',village_no='$_POST[village_no]',alley='$_POST[alley]',lane='$_POST[lane]',road='$_POST[road]',sub_district='$subdistrict',district='$district',province='$province',postal_code='$_POST[zipcode]' $image WHERE username='$_SESSION[login_name]'";
	mysqli_query($_SESSION['connect_db'],$update_users)or die("ERROR : users function line 312");
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<script>swal({title:'',text: \"บันทึกข้อมูลผู้ใช้เสร็จสิ้น\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=data_users&menu=1';})</script>";
}

?>
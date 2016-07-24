<?php
	session_start();
	date_default_timezone_set('Asia/Bangkok');
	include("../../include/function.php");
	connect_db();

?>
<script>
	$(document).ready(function() {
        $('#select_provinces').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $(this).val()},
                url: '../module/index.php?data=provinces',
                success: function(data) {$('#select_districts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_provinces:"null",select_districts:"null"},
                url: '../module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_districts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $('#select_provinces').val(),select_districts: $(this).val()},
                url: '../module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_subdistricts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_districts: $(this).val()},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
    });
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">ข้อมูลเจ้าของร้าน <?php echo "$_SESSION[login_name]"; ?></a></li>
		</ol>
	</div>
</div>

<?php
	echo "<div class='container-fluid datauser_edit_user'>";
	$query_users = mysqli_query($_SESSION['connect_db'],"SELECT * FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
	list($username,$passwd,$fullname,$lastname,$image,$phone,$email,$type,$employee_id,$house_no,$village_no,$alley,$lane,$road,$sub_district,$district,$province,$postal_code)=mysqli_fetch_row($query_users);
	echo "<h4 style='background:#649d6c;color:white;padding:5px 10px;border-bottom:2px solid #3e7445;'>แก้ไขข้อมูลส่วนตัว</h4>";
	echo "<div class='col-md-12 ' style='border-bottom:2px solid #ddd'>";
		echo "<p class='font20'><b>รายละเอียดข้อมูลผู้ใช้</b></p>";
		echo "<table style='margin-left:100px;'>";
			echo "<tr>";
				echo "<td rowspan='3'><img src='../images/user/$image' id='blah' width='90' height='90' style='margin:0px 50px 10px 0px;border-radius:45px;border:3px solid #aaa'></td>";
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
					       <h4 class='modal-title' style='margin:-10px 10px;margin-bottom:-20px;'><b>เปลี่ยนรหัสผ่าน</b></h4>";
					     echo "</div>";
					     echo "<div class='modal-body'>";
					     	echo "<form  class='ajax-link' action='ajax/update_passwd_admin.php' method='post'>";
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
	echo "<div class='col-md-12' style='margin-top:20px;' >";
		echo "<p class='font20'><b>ที่อยู่ที่ใช้ในการจัดส่ง</b></p>";
		echo "<form  class='ajax-link' action='ajax/update_data_admin.php'' method='post' enctype='multipart/form-data'><center><table width='80%'>";
			echo "<tr>";
				echo "<td>";
					echo "<p class='font20'><b>รูปภาพ</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td colspan='4'>";
					echo "<p class='font16' style='margin-left:15px;'><input type='file' name='user_image' multiple onchange=\"document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])\"></p>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='fullname' placeholder='Fullname' value='$fullname'></p>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='lastname' placeholder='Lastname' value='$lastname'></p>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='house_no' placeholder='House NO.' value='$house_no'></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;หมู่</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='village_no' placeholder='Village NO.' value='$village_no'></p>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='alley' placeholder='Alley' value='$alley'></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;ซอย</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
				echo "</td>";
				echo "<td>";
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='lane' placeholder='Lane' value='$lane'></p>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='road' placeholder='Road' value='$road'></p>";
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
					echo "<p class='container-fluid font20'>";
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
					echo "<p class='container-fluid font20'><select id='select_districts' name='districts' style='width:100%'>";
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
					echo "<p class='container-fluid font20'><select id='select_subdistricts' name='subdistrict' style='width:100%'>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' id='zipcode' name='zipcode' placeholder='Postcode' value='$postal_code'></p>";
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
					echo "<p class='container-fluid font20'><input class='form-control' tyle='text' name='phone' placeholder='Phone' value='$phone'></p>";
				echo "</td>";
			echo "</tr>";
		echo "</table></center><br>";
		echo "<p align='right' class='container-fluid font20'><button type='submit' class='btn btn-success' ><b>บันทึกข้อมูล</b></button></form></p>";
	echo "</div>";
	echo "</div>";
?>
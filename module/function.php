<?php
function provinces(){
	$provinces = isset($_POST['select_provinces']) ? $_POST['select_provinces'] : "";
	$query_districts = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID='{$provinces}'")or die("ERROR module function line 9");
	$Rows = mysqli_num_rows($query_districts);
	if ($Rows > 0) {
		echo "<option value='null'>เลือกอำเภอ</option>";
		while(list($amphur_id,$amphur_name)=mysqli_fetch_row($query_districts)){
			echo "<option value='$amphur_id'>$amphur_name</option>";
		}
	}else{
		if($sprint_year==""){
			echo "<option>เลือกอำเภอ</option>";
		}else{
			echo "<option>ไม่ปรากฎอำเภอ</option>";
		}
	    
	}
}

function districts(){
	$districts = isset($_POST['select_districts']) ? $_POST['select_districts'] : "";
	$provinces = isset($_POST['select_provinces']) ? $_POST['select_provinces'] : "";
	$query_subdistricts = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID='{$provinces}' AND AMPHUR_ID='{$districts}'")or die("ERROR module function line 9");
	$Rows = mysqli_num_rows($query_subdistricts);
	if ($Rows > 0) {
		echo "<option value='null'>เลือกตำบล</option>";
		while(list($subdistricts_code,$subdistricts_name)=mysqli_fetch_row($query_subdistricts)){
			echo "<option value='$subdistricts_code'>$subdistricts_name</option>";
		}
		
	}else{
		if($districts=="null"){
			echo "<option>เลือกตำบล</option>";
		}else{
			echo "<option>ไม่ปรากฎตำบล</option>";
		}
	    
	}
}

function zipcode(){
	$districts = isset($_POST['select_districts']) ? $_POST['select_districts'] : "";
	$query_zipcode = mysqli_query($_SESSION['connect_db'],"SELECT zipcode FROM zipcodes WHERE district_code='{$districts}' ")or die("ERROR module function line 9");
	$Rows = mysqli_num_rows($query_zipcode);
	if ($Rows > 0) {
		list($zipcode)=mysqli_fetch_row($query_zipcode);
			echo "$zipcode";
	}else{
		if($districts=="null"){
			echo "";
		}else{
			echo "ไม่ปรากฎรหัสไปรษณีย์";
		}
	    
	}
}
function addproduct_cart(){

		$_SESSION['cart_id'][$_POST['product_size_id']] =array("product_id"=>"$_POST[product_id]","amount"=>"$_POST[amount]");	
		
}
function amounttotal_cart(){

		$_SESSION['total_amount']=$_POST['amounttotal_cart'];	
		
}
function plus_like(){
	 mysqli_query($_SESSION['connect_db'],"INSERT INTO like_status VALUES('','webboard','$_POST[webboard_id]','$_SESSION[login_name]')")or die("ERROR : imodule function line 68");
}
function lower_like(){
	mysqli_query($_SESSION['connect_db'],"DELETE FROM like_status WHERE like_name_id = '$_POST[webboard_id]' AND username ='$_SESSION[login_name]' AND like_name='webboard'")or die("ERROR : imodule function line 71");
}
function close_web(){
		$_SESSION['web_close']=1;
		echo "<script>window.location='../index.php'</script>";
}
function edit_webboard(){
	echo "<form action='index.php?module=webboard&action=update_webboard' method='post'>";
		$query_webboard=mysqli_query($_SESSION['connect_db'],"SELECT webboard_detail FROM webboard WHERE webboard_id ='$_POST[webboard_id]'")or die("ERROR users function line 64");
		list($webboard_detail)=mysqli_fetch_row($query_webboard);
		echo "<input type='hidden' name='webboard_id' value='$_POST[webboard_id]'>";
		echo "<textarea class='form-control' name='webboard_detail' style='height:120px;'>$webboard_detail</textarea>";
		echo "<p align='right'><button type='submit' class='btn btn-sm btn-success' style='margin-top:10px;'>แก้ไข</button></p>";
	echo "</form>";
}
function select_address(){
	if($_POST['address']=="user"){
		$query_users = mysqli_query($_SESSION['connect_db'],"SELECT * FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
		list($username,$passwd,$fullname,$lastname,$image,$phone,$email,$type,$house_no,$village_no,$alley,$lane,$road,$sub_district,$district,$province,$postal_code)=mysqli_fetch_row($query_users);
		echo "<center><table width='80%'>";
		echo "<tr>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>ชื่อ</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>นามสกุล</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>บ้านเลขที่</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>จังหวัด</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>เขต/อำเภอ</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>แขวง/ตำบล</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>รหัสไปรษณีย์</b></p>";
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
				echo "<p class='font20'><b><font color='red'>*</font>เบอร์โทรศัพท์</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td colspan='4'>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='phone' placeholder='Phone' value='$phone'></p>";
			echo "</td>";
		echo "</tr>";
	echo "</table></center>";
	echo "<p align='right'><button type='submit' class='btn btn-success font20'>ยืนยันการสั่งซื้อและอัปเดทข้อมูลผู้ใช้</button>";
	echo "&nbsp;&nbsp;<button type='button' class='btn btn-danger font20' data-dismiss='modal'>ยกลเิก</button></p>";
	}else{
	echo "<center><table width='80%'>";
		echo "<tr>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>ชื่อ</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
			echo "</td>";
			echo "<td colspan='4'>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='fullname' placeholder='Fullname'></p>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>นามสกุล</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td colspan='4'>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='lastname' placeholder='Lastname'></p>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>บ้านเลขที่</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='house_no' placeholder='House NO.'></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;หมู่</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='village_no' placeholder='Village NO.'></p>";
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
				echo "<p class='font20'><input class='form-control' tyle='text' name='alley' placeholder='Alley'></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;ซอย</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='lane' placeholder='Lane'></p>";
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
				echo "<p class='font20'><input class='form-control' tyle='text' name='road' placeholder='Road'></p>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td width='18%'>";
				echo "<p class='font20'><b><font color='red'>*</font>จังหวัด</b></p>";
			echo "</td>";
			echo "<td width='5%'>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td width='27%'>";
				echo "<p class='font20'>";
				echo "<select id='select_provinces2' name='province' style='width:100%'>";
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
				echo "<p class='font20'><b><font color='red'>*</font>เขต/อำเภอ</b></p>";
			echo "</td width='5%'>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td width='27%'>";
				echo "<p class='font20'><select id='select_districts2' name='districts' style='width:100%'>";
					echo "<option value='null'>เลือกอำเภอ</option>";
				echo "</select></p>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>แขวง/ตำบล</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><select id='select_subdistricts2' name='subdistrict' style='width:100%'>";
					echo "<option value='null'>เลือกตำบล</option>";
				echo "</select></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>รหัสไปรษณีย์</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><input class='form-control' tyle='text' id='zipcode2' name='zipcode' placeholder='Postcode'></p>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<p class='font20'><b><font color='red'>*</font>เบอร์โทรศัพท์</b></p>";
			echo "</td>";
			echo "<td>";
				echo "<p class='font20'><b>&nbsp;: </b></p>";
			echo "</td>";
			echo "<td colspan='4'>";
				echo "<p class='font20'><input class='form-control' tyle='text' name='phone' placeholder='Phone'></p>";
			echo "</td>";
		echo "</tr>";
	echo "</table></center>";
	echo "<p align='right'><button type='submit' class='btn btn-success font20'>ยืนยันการสั่งซื้อ</button>";
	echo "&nbsp;&nbsp;<button type='button' class='btn btn-danger font20' data-dismiss='modal'>ยกลเิก</button></p>";	
	}
?>
<script>
	$(document).ready(function() {
        $('#select_provinces').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $(this).val()},
                url: 'module/index.php?data=provinces',
                success: function(data) {$('#select_districts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_provinces:"null",select_districts:"null"},
                url: 'module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_districts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $('#select_provinces').val(),select_districts: $(this).val()},
                url: 'module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_subdistricts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_districts: $(this).val()},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
    });
	$(document).ready(function() {
        $('#select_provinces2').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $(this).val()},
                url: 'module/index.php?data=provinces',
                success: function(data) {$('#select_districts2').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_provinces:"null",select_districts:"null"},
                url: 'module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts2').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode2').val(data);}
            });
            return false;
        });
        $('#select_districts2').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $('#select_provinces2').val(),select_districts: $(this).val()},
                url: 'module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts2').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode2').val(data);}
            });
            return false;
        });
        $('#select_subdistricts2').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_districts: $(this).val()},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode2').val(data);}
            });
            return false;
        });
    });
</script>
<?php
}

function edit_comment(){
	$comment_proid = $_POST['comment_proid'];
	$query_comment = mysqli_query($_SESSION['connect_db'],"SELECT comment_detail FROM comment_product WHERE comment_proid='$comment_proid'")or die("ERROR module finction line 507");
	list($comment_detail)=mysqli_fetch_row($query_comment);

	echo "<div id='edit_comment_new_$comment_proid'>";
?>
	<form action='index.php?module=product&action=update_comment' method="post">
	<input type="hidden" name="comment_proid" value="<?php echo $comment_proid ?>">
	<textarea class='form-control' name='comment_detail' style='margin:5px;'><?php echo $comment_detail; ?></textarea>
	<p align="right">
		<input type="submit" class='btn btn-sm btn-success' value="แก้ไข">&nbsp;

<?php 
		echo "<input type='button' class='btn btn-sm btn-danger' value='ยกเลิก'' onclick='cancel_edit($comment_proid)'>";
?>
	</p>
	</form>
	</div>
<?php 
	echo "<div id='edit_comment_old_$comment_proid' style='display:none'>";
		echo "<p style='margin-left:30px;'><b>$comment_detail</b></p>"; 
?>
	</div>
	<script>
		function cancel_edit(comment_proid){
			$('#edit_comment_new_'+comment_proid).hide();
			$('#edit_comment_old_'+comment_proid).show();
		} 
	</script>
<?php
}	

?>
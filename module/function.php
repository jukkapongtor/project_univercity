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
?>
<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
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
	echo "<script>swal({title:'',text: \"บันทึกข้อมูลเจ้าของร้านเสร็จสิ้น\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='../#ajax/admin_form.php';})</script>";
?>
</body>
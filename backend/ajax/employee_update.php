<?php
session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();

	$img =$_FILES['employee_img']['name'];
		
		if (empty($img)) {
			$img="";
		}else{
		copy($_FILES['employee_img']['tmp_name'],"../../images/employee/$img");
		$img = ",employee_img='$img'";
		}

		$query = "UPDATE employee SET titlename='$_POST[titlename]', name_thai='$_POST[name_thai]', surname_thai='$_POST[surname_thai]', name_eng='$_POST[name_eng]', surname_eng='$_POST[surname_eng]', id_card='$_POST[id_card]', phone_number='$_POST[phone_number]', email='$_POST[email]', birth_date='$_POST[birth_date]', blood_group='$_POST[blood_group]', personnel_nationality='$_POST[personnel_nationality]', personnel_race='$_POST[personnel_race]', religious='$_POST[religious]', mate_status='$_POST[mate_status]', mate_name='$_POST[mate_name]', address_hrt='$_POST[address_hrt]', village_no_hrt='$_POST[village_no_hrt]', village_hrt='$_POST[village_hrt]', alley_hrt='$_POST[alley_hrt]', road_hrt='$_POST[road_hrt]', province_hrt='$_POST[province_hrt]', districts_hrt='$_POST[districts_hrt]', subdistrict_hrt='$_POST[subdistrict_hrt]', zipcode_hrt='$_POST[zipcode_hrt]', phone_hrt='$_POST[phone_hrt]', address_number='$_POST[address_number]', village_no='$_POST[village_no]', village='$_POST[village]', alley='$_POST[alley]', road='$_POST[road]', province='$_POST[province]', districts='$_POST[districts]', subdistrict='$_POST[subdistrict]', zipcode='$_POST[zipcode]', phone='$_POST[phone]', titlename_er='$_POST[titlename_er]', name_er='$_POST[name_er]', phone_er='$_POST[phone_er]', status_er='$_POST[status_er]' $img WHERE employee_id='$_POST[employee]'" or die("ERROR : backend employee update line 16");
			
			mysqli_query($_SESSION['connect_db'],$query)or die("ERROR : backend employee update line 18");


			
			echo "<script>window.location='../#ajax/employee_manage.php';</script>";
	

?>

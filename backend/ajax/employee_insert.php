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
	}

	
    $sql = "INSERT INTO employee VALUES ('','$img', '$_POST[titlename]', '$_POST[name_thai]', '$_POST[surname_thai]', '$_POST[name_eng]', '$_POST[surname_eng]', '$_POST[id_card]', '$_POST[phone_number]', '$_POST[email]', '$_POST[birth_date]', '$_POST[blood_group]', '$_POST[personnel_nationality]', '$_POST[personnel_race]', '$_POST[religious]', '$_POST[mate_status]', '$_POST[mate_name]', '$_POST[address_hrt]', '$_POST[village_no_hrt]', '$_POST[village_hrt]', '$_POST[alley_hrt]', '$_POST[road_hrt]', '$_POST[province_hrt]', '$_POST[districts_hrt]', '$_POST[subdistrict_hrt]', '$_POST[zipcode_hrt]', '$_POST[phone_hrt]', '$_POST[address_number]', '$_POST[village_no]', '$_POST[village]', '$_POST[alley]', '$_POST[road]', '$_POST[province]', '$_POST[districts]', '$_POST[subdistrict]', '$_POST[zipcode]', '$_POST[phone]', '$_POST[titlename_er]', '$_POST[name_er]', '$_POST[phone_er]', '$_POST[status_er]', '2') ";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend employee_insert line 16");

	echo "<script> window.location='../#ajax/employee_manage.php'</script>";

?>
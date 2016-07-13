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

	
    $sql = "INSERT INTO employee VALUES ('','$img', '$_PORT[titlename]', '$_PORT[name_thai]', '$_PORT[surname_thai]', '$_PORT[name_eng]', '$_PORT[surname_eng]', '$_PORT[id_card]', '$_PORT[phone_number]', '$_PORT[email]', '$_PORT[birth_date]', '$_PORT[blood_group]', '$_PORT[personnel_nationality]', '$_PORT[personnel_race]', '$_PORT[religious]', '$_PORT[mate_status]', '$_PORT[mate_name]', '$_PORT[address_hrt]', '$_PORT[village_no_hrt]', '$_PORT[village_hrt]', '$_PORT[alley_hrt]', '$_PORT[road_hrt]', '$_PORT[province_hrt]', '$_PORT[districts_hrt]', '$_PORT[subdistrict_hrt]', '$_PORT[zipcode_hrt]', '$_PORT[phone_hrt]', '$_PORT[address_number]', '$_PORT[village_no]', '$_PORT[village]', '$_PORT[alley]', '$_PORT[road]', '$_PORT[province]', '$_PORT[districts]', '$_PORT[subdistrict]', '$_PORT[zipcode]', '$_PORT[phone]', '$_PORT[titlename_er]', '$_PORT[name_er]', '$_PORT[phone_er]', '$_PORT[status_er]', '2') ";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend insert_webblog line 16");

	echo "<script> window.location='../#ajax/employee_manage.php'</script>";

?>
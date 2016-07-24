<?php
    session_start();
    echo "<meta charset='utf8'>";
    include("../../include/function.php");
    date_default_timezone_set('Asia/Bangkok');
    connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php

    $img =$_FILES['employee_img']['name'];
	if (empty($img)) {
		$img="";
	}else{
	copy($_FILES['employee_img']['tmp_name'],"../../images/employee/$img");
	}
	$username_em = $_POST['name_eng']."_".substr($_POST['surname_eng'], 0,2);
	$passwd = $_POST['id_card'];
	$double=0;
	$query_users= mysqli_query($_SESSION['connect_db'],"SELECT username FROM users")or die("ERROR : employee insert line 28");
	while(list($username)=mysqli_fetch_row($query_users)){
		if($username_em==$username){
			echo "<script>swal({title:'',text: 'รายชื่อพนักงานนี้มีอยู่ในระบบแล้ว',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_form.php'})</script>";
			$double=1;
		}
	}
	if($double==0){
		$query_employee =mysqli_query($_SESSION['connect_db'],"SELECT employee_id FROM employee ORDER BY employee_id DESC")or die("ERROR : employee insert line 32");
		list($max_employee)=mysqli_fetch_row($query_employee);
		$max_employee++;
		mysqli_query($_SESSION['connect_db'],"INSERT INTO users VALUES ('$username_em','$passwd','$_POST[name_thai]','$_POST[surname_thai]','$img','','','2','$max_employee','','','','','','','','','' )") or die ("ERROR : backend employee function line 36 ") ;

		$birth_day  = substr($_POST['birth_date'],0,2);
		$birth_month  = substr($_POST['birth_date'],3,2);
		$birth_year  = substr($_POST['birth_date'],6,4);
		$_POST['birth_date']= "$birth_year-$birth_month-$birth_day";
	    $sql = "INSERT INTO employee VALUES ('','$img', '$_POST[titlename]', '$_POST[name_thai]', '$_POST[surname_thai]', '$_POST[name_eng]', '$_POST[surname_eng]', '$_POST[id_card]', '$_POST[phone_number]', '$_POST[email]', '$_POST[birth_date]', '$_POST[blood_group]', '$_POST[personnel_nationality]', '$_POST[personnel_race]', '$_POST[religious]', '$_POST[mate_status]', '$_POST[mate_name]', '$_POST[address_hrt]', '$_POST[village_no_hrt]', '$_POST[village_hrt]', '$_POST[alley_hrt]', '$_POST[road_hrt]', '$_POST[province_hrt]', '$_POST[districts_hrt]', '$_POST[subdistrict_hrt]', '$_POST[zipcode_hrt]', '$_POST[phone_hrt]', '$_POST[address_number]', '$_POST[village_no]', '$_POST[village]', '$_POST[alley]', '$_POST[road]', '$_POST[province]', '$_POST[districts]', '$_POST[subdistrict]', '$_POST[zipcode]', '$_POST[phone]', '$_POST[titlename_er]', '$_POST[name_er]', '$_POST[phone_er]', '$_POST[status_er]', '2') ";
		mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend employee_insert line 16");
		?>
		<script>swal({title:'',text: 'เพิ่มพนักงานเรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_manage.php'})</script>
<?php
	}
?>
</body>
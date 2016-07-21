<?php
session_start();
include("../../include/function.php");
connect_db();
?>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
date_default_timezone_set('Asia/Bangkok');

if($_POST['btn_work']=="workin"){
	$query_working =mysqli_query($_SESSION['connect_db'],"SELECT working_in FROM working WHERE employee_id='$_POST[employee_id]' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'")or die("ERROR working line 16");
	$row = mysqli_num_rows($query_working);
	if(empty($row)){
		$date = date("Y-m-d H:i:s");
		$insert = "INSERT INTO working VALUES('','$date','','$_POST[employee_id]','')";
		mysqli_query($_SESSION['connect_db'],$insert)or die("ERROR working line 21");
		echo "<script>swal({title:'',text: \"ลงเวลาทำงานเรียบร้อย\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";
	}else{
		echo "<script>swal({title:'',text: \"บันทึการลงเวลาเรียบร้อยแล้ว\",type:'error',showCancelButton: false,confirmButtonColor: '#d85858',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";	
	}
		
}elseif($_POST['btn_work']=="workout"){
	$query_working =mysqli_query($_SESSION['connect_db'],"SELECT working_in FROM working WHERE employee_id='$_POST[employee_id]' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'")or die("ERROR working line 16");
	$row = mysqli_num_rows($query_working);
	if(empty($row)){
		echo "<script>swal({title:'',text: \"ยังไม่มีการลงเวลาเข้าทำงาน\",type:'error',showCancelButton: false,confirmButtonColor: '#d85858',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";	
	}else{
		$query_workout =mysqli_query($_SESSION['connect_db'],"SELECT working_out FROM working WHERE employee_id='$_POST[employee_id]' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'")or die("ERROR working line 16");
		list($working_out)=mysqli_fetch_row($query_workout);
		if($working_out=="0000-00-00 00:00:00"){
			$date = date("Y-m-d H:i:s");
			$update = "UPDATE working SET working_out='$date' WHERE employee_id='$_POST[employee_id]' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'";
			mysqli_query($_SESSION['connect_db'],$update)or die("ERROR working line 21");
			echo "<script>swal({title:'',text: \"ลงเวลาออกทำงานเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";
		}else{
			echo "<script>swal({title:'',text: \"ไม่สามารถลงเวลาออกได้อีก\",type:'error',showCancelButton: false,confirmButtonColor: '#d85858',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";	
		}
		
	}
}elseif($_POST['btn_work']=="btn_stopwork"){
	$query_working =mysqli_query($_SESSION['connect_db'],"SELECT working_in FROM working WHERE employee_id='$_POST[employee_id]' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'")or die("ERROR working line 16");
	$row = mysqli_num_rows($query_working);
	if(empty($row)){
		$date = date("Y-m-d H:i:s");
		$insert = "INSERT INTO working VALUES('','$date','$date','$_POST[employee_id]','$_POST[stop_work]')";
		mysqli_query($_SESSION['connect_db'],$insert)or die("ERROR working line 21");
		echo "<script>swal({title:'',text: \"ลงข้อมูลการลาเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";
	}else{
		$date = date("Y-m-d H:i:s");
		$_POST['stop_work'] = (empty($_POST['stop_work']))?"ไม่ระบุการลา":$_POST['stop_work'];
		$update = "UPDATE working SET working_out='$date',note='$_POST[stop_work]' WHERE employee_id='$_POST[employee_id]' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'";
		mysqli_query($_SESSION['connect_db'],$update)or die("ERROR working line 21");
		echo "<script>swal({title:'',text: \"ลงข้อมูลการลาเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/employee_detail.php?employee_id=$_POST[employee_id]';})</script>";
	}

	

}
?>
</body>
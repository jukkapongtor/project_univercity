<?php
function connect_db(){
	$_SESSION['connect_db']=mysqli_connect("mysql.hostinger.in.th","u718031275_1304","num13041994","u718031275_mufn") or die("Connect Error");
	mysqli_query($_SESSION['connect_db'],"SET NAMES utf8");
}
function get_module($module,$action){
	include("module/".$module."/index.php");
}
function check_login(){
	if(empty($_POST['username'])||empty($_POST['passwd'])){
		echo "<script>swal({title:'',text: \"กรุณากรอก username และ password เพื่อเข้าสู่ระบบ\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php';})</script>";
	}else{
		$user_form=$_POST['username'];
		$pwd_form=$_POST['passwd'];
		$query_user=mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,passwd,type FROM users WHERE username='$user_form' AND passwd='$pwd_form'")or die ("ERROR : user_function line 15");
		list($username,$fullname,$pwd,$type)=mysqli_fetch_row($query_user);
		if($user_form==$username AND $pwd_form==$pwd){
			$_SESSION['login_result']="true";
			$_SESSION['login_name']=$username;
			$_SESSION['login_type']=$type; //เก็บค่า user ประเภทไหน
			echo "$_SESSION[login_type]";
			if($_SESSION['login_type']==1){
				echo "<script>window.location='../backend/'</script>";	
			}elseif($_SESSION['login_type']==2){
				echo "<script>window.location='../shop/'</script>";	
			}elseif($_SESSION['login_type']==3){
				echo "<script>window.location='../'</script>";	
			}

		}else{
			echo "<script>swal({title:'',text: \"คุณกรอก username หรือ password ผิดผลาด กรุณาล็อคอินเข้าสู่ระบบใหม่\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php';})</script>";
		}
	}
}
function logout(){
	session_destroy();
	echo "<script>window.location='../index.php'</script>";
}


?>
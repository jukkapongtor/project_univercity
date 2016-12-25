<?php
function connect_db(){
	$_SESSION['connect_db']=mysqli_connect("localhost","root","","mumfern") or die("Connect Error");
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
function check_product($product_id_check){
	$product_new = array();		
	$product_sale = array();
	$product_best = array();
	$quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 42");
    list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
    $status_product=0;
	$query_recom_new =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type ORDER BY product.product_id DESC LIMIT 0,6 ");
    while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_new)){
      	$status_product = ($product_id==$product_id_check)?1:$status_product;
    }
    if($sellstatus==1){
	    $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type LEFT JOIN product_size ON product.product_id = product_size.product_id WHERE product_size.product_sprice_web !=0 GROUP BY product_name");
	    while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_sale)){
	        $status_product = ($product_id==$product_id_check)?2:$status_product;
	    }
	    $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng,order_detail.product_id FROM product LEFT JOIN type ON product.product_type =type.product_type LEFT JOIN order_detail ON order_detail.product_id = product.product_id GROUP BY  order_detail.product_id ORDER BY COUNT(order_detail.product_id) DESC  LIMIT 0,6 ");
	    while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_sale)){
	        $status_product = ($product_id==$product_id_check)?3:$status_product;
	    }
    }
	return $status_product;
}

?>
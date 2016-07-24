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
	echo "<meta charset='utf-8'>";
	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name,type_name_eng FROM type WHERE product_type='$_POST[type_id]'")or die("ERROR : backend type_delete_type_id line 6");
	list($type_name,$type_name_eng)=mysqli_fetch_row($query_type);
	$sql_type= "UPDATE type SET type_name='$_POST[type_name]',type_name_eng='$_POST[type_name_eng]' WHERE product_type='$_POST[type_id]'";
	//$query_size=mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id='$_POST[type_id]'")or die("ERROR : backend type update line 9");
	//$num_size=mysqli_num_rows($query_size);
	

	$query_size = mysqli_query($_SESSION['connect_db'],"SELECT size_name FROM size WHERE type_id='$_POST[type_id]' AND size_name='$_POST[unit_name]'")or die("ERROR : backend function size line 16");
   	$row = mysqli_num_rows($query_size);
   	//echo "SELECT size_name FROM size WHERE type_id='$_GET[product_type]' AND size_name='$_GET[new_size]'";
   	if($row>0){
        echo "<script>swal({title:'',text: 'ขนาดสินค้านี้มีในประเภทสินค้าแล้ว กรุณาเพิ่มขนาดสินค้าชนิดอื่น',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
   	}else{
   		if(!empty($_POST['unit_name'])){
        	mysqli_query($_SESSION['connect_db'],"INSERT INTO size VALUES('','$_POST[unit_name]','$_POST[type_id]')")or die("ERROR : backend function size line 31");
        }
        //echo "<script>swal({title:'',text: '',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
    
	/*
	$number=0;
	$unit_name = array();
	foreach ($_POST['unit_name'] as  $value) {
		if(!empty($value)){
			array_push($unit_name,$value);
			$number++;
		}
	}
	echo "$number";
	echo "$num_size";
	
	$size_id =array();
	while(list($product_size,$size_name)=mysqli_fetch_row($query_size)){
		array_push($size_id,$product_size);
	}
	if($num_size==$number){
		for($i=0;$i<$number;$i++){
			$sql="UPDATE size SET size_name='".$unit_name[$i]."' WHERE product_size='".$size_id[$i]."' AND type_id='$_POST[type_id]'";
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 25");
		}
	}elseif($num_size>$number){
		for($i=0;$i<$number;$i++){
			$sql="UPDATE size SET size_name='".$unit_name[$i]."' WHERE product_size='".$size_id[$i]."' AND type_id='$_POST[type_id]'";
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 30");
		}
		for($j=$i;$j<$num_size;$j++){
			$sql = "DELETE FROM size WHERE product_size='".$size_id[$j]."' AND type_id='$_POST[type_id]'";
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 35");
		}
	}elseif($num_size<$number){
		for($i=0;$i<$num_size;$i++){
			$sql="UPDATE size SET size_name='".$unit_name[$i]."' WHERE product_size='".$size_id[$i]."' AND type_id='$_POST[type_id]'";
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 40");
		}
		$sql = "INSERT INTO size VALUES('','".$unit_name[$i]."','$_POST[type_id]')";
		for($j=($i+1);$j<$number;$j++){
			$sql .= ",('','".$unit_name[$j]."','$_POST[type_id]')";
		}
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 46");
	}
	*/
		mysqli_query($_SESSION['connect_db'],$sql_type)or die("ERROR : backend type_update line 48");
		$folder_old = iconv("utf-8","tis-620",$type_name_eng);
		$folder_new = iconv("utf-8","tis-620",$_POST['type_name_eng']);
		if($folder_old!=$folder_new){
			rename("../../images/{$folder_old}","../../images/{$folder_new}");
		}
		
		echo "<script>swal({title:'',text: \"แก้ไขประเภทสินค้าเรียบร้อย\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
	}
	//echo "<script>window.location='../#ajax/type_manage.php'</script>";
	
?>
</body>
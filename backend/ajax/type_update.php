<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta charset='utf-8'>";
	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE product_type='$_POST[type_id]'")or die("ERROR : backend type_delete_type_id line 6");
	list($type_name)=mysqli_fetch_row($query_type);
	$sql_type= "UPDATE type SET type_name='$_POST[type_name]' WHERE product_type='$_POST[type_id]'";
	$query_size=mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id='$_POST[type_id]'")or die("ERROR : backend type update line 10");
	$num_size=mysqli_num_rows($query_size);
	$number=0;
	$unit_name = array();
	foreach ($_POST['unit_name'] as  $value) {
		if(!empty($value)){
			array_push($unit_name,$value);
			$number++;
		}
	}
	$size_id =array();
	while(list($product_size,$size_name)=mysqli_fetch_row($query_size)){
		array_push($size_id,$product_size);
	}
	if($num_size==$number){
		for($i=0;$i<$number;$i++){
			$sql="UPDATE size SET size_name='".$unit_name[$i]."' WHERE product_size='".$size_id[$i]."' AND type_id='$_POST[type_id]'";
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 27");
		}
	}elseif($num_size>$number){
		for($i=0;$i<$number;$i++){
			$sql="UPDATE size SET size_name='".$unit_name[$i]."' WHERE product_size='".$size_id[$i]."' AND type_id='$_POST[type_id]'";
			mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend type update line 31");
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
	mysqli_query($_SESSION['connect_db'],$sql_type)or die("ERROR : backend type_update line 48");
	$folder_old = iconv("utf-8","tis-620",$type_name);
	$folder_new = iconv("utf-8","tis-620",$_POST['type_name']);

	rename("../../images/{$folder_old}","../../images/{$folder_new}");
	echo "<script>window.location='../#ajax/type_manage.php'</script>";

?>
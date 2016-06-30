<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	echo "<meta charset='utf-8'>";
	if($_GET['data']=="quality"){
		$query_quality=mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality WHERE quality_type='$_POST[product_type]'")or die("ERROR : select product size line 7");
		echo "<option value=''>--เลือกหมวดหมู่สินค้า--</option>";
		while(list($product_quality,$quality_name)=mysqli_fetch_row($query_quality)){
			echo "<option value='$product_quality'>$quality_name</option>";
		}
	}elseif($_GET['data']=="size"){
		$query_size=mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id='$_POST[product_type]' ")or die("ERROR : product_add line 33");
		echo "<option value=''>--เลือกขนาดสินค้า--</option>";
		while(list($product_size,$size_name)=mysqli_fetch_row($query_size)){
		   	echo "<option value='$product_size'>$size_name</option>";
		}
	}
	elseif($_GET['data']=="type"){
		$query_type=mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : product_add line 51");
		echo "<option value=''>--เลือกประเภทสินค้า--</option>";
		while(list($product_type,$type_name)=mysqli_fetch_row($query_type)){
		   	echo "<option value='$product_type'>$type_name</option>";
		}
	}
	
?>
<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
	
	$image_name = $_FILES['product_image']['name'];
	if(empty($image_name)){
		$image ="";
	}else{
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE  product_type='$_POST[product_type]'")or die("ERROR : backend porduct insert line 12");
		list($type_name)=mysqli_fetch_row($query_type);
		$folder =($type_name=="เฟิร์น")?"fern":"$type_name";
		$folder =($folder=="กระถาง")?"pots":"$folder";
		copy($_FILES['product_image']['tmp_name'],"../../images/$folder/$image_name");
		$image =",product_image='$image_name'";
	}

	$stock=(empty($_POST['product_stock']))?"product_stock='0'":"product_stock='1'";
	$sql= "UPDATE product SET product_name='$_POST[product_name]',product_price_web='$_POST[product_price_web]',product_detail='$_POST[product_detail]',product_type='$_POST[product_type]',product_quality='$_POST[product_quality]',product_size='$_POST[product_size]',$stock  $image WHERE product_id='$_POST[product_id]'";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend quality_update line 9");

	echo "<script>window.location='../#ajax/product_list.php'</script>";

?>
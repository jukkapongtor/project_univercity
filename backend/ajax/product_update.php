<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
	$stock=(empty($_POST['product_stock']))?0:1;
	$sql = "UPDATE product SET product_name='$_POST[product_name]',product_detail='$_POST[product_detail]',product_type='$_POST[product_type]',product_quality='$_POST[product_quality]',product_stock='$stock' WHERE product_id='$_POST[product_id]'";
	mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend product update line 8");
	foreach ($_POST['product_size'] as $key => $value) {
		$_POST['product_size_old'][$key]=(empty($_POST['product_size_old'][$key]))?"":$_POST['product_size_old'][$key];
		$query_size = mysqli_query($_SESSION['connect_db'],"SELECT product_size_id FROM product_size WHERE product_id='$_POST[product_id]' AND size_id='".$_POST['product_size_old'][$key]."'")or die("ERROR : product update line 10");
		$row = mysqli_num_rows($query_size);
		
		if($row>0){
			$update_size ="UPDATE product_size SET size_id='".$_POST['product_size'][$key]."',product_price_shop='".$_POST['product_price_shop'][$key]."',product_price_web='".$_POST['product_price_web'][$key]."' WHERE product_id='$_POST[product_id]' AND size_id='".$_POST['product_size_old'][$key]."'";
			mysqli_query($_SESSION['connect_db'],$update_size)or die("ERROR : backend product update line 21");
		}else{
			$update_size = "INSERT INTO product_size VALUES('','$_POST[product_id]','".$_POST['product_size'][$key]."','0','0','0','".$_POST['product_price_shop'][$key]."','0','".$_POST['product_price_web'][$key]."','0')";
			mysqli_query($_SESSION['connect_db'],$update_size)or die("ERROR : backend product update line 21");
		}

	}
	
	echo "<script>alert('แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');window.location='../#ajax/product_list.php'</script>";

		
	
/*

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
*/

?>
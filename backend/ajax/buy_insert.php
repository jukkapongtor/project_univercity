<?php
session_start();
include("../../include/function.php");
connect_db();
echo "<meta charset='utf-8'>";
	$date = date("Y-m-d");
	$insert_buy_product = "INSERT INTO buy_product VALUES('','$_POST[product_id]','".$_POST['product_size_id'][0]."','".$_POST['amount_keep'][0]."','".$_POST['amount_shop'][0]."','".$_POST['amount_web'][0]."','".$_POST['buy_price'][0]."','$date')";
	for($i=1;$i<count($_POST['product_size_id']);$i++){
		$insert_buy_product .=",('','$_POST[product_id]','".$_POST['product_size_id'][$i]."','".$_POST['amount_keep'][$i]."','".$_POST['amount_shop'][$i]."','".$_POST['amount_web'][$i]."','".$_POST['buy_price'][$i]."','$date')";
	}
	mysqli_query($_SESSION['connect_db'],$insert_buy_product)or die("ERROR : backend buy insert line 11");
	foreach ($_POST['product_size_id'] as $key => $value) {
		$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_amount_keep,product_amount_shop,product_amount_web FROM product_size WHERE product_size_id='".$_POST['product_size_id'][$key]."'")or die("ERROR : backend buy insert line 14");
		list($product_amount_keep,$product_amount_shop,$product_amount_web)=mysqli_fetch_row($query_size);
		$product_amount_keep+=$_POST['amount_keep'][$key];
		$product_amount_shop+=$_POST['amount_shop'][$key];
		$product_amount_web+=$_POST['amount_web'][$key];
		$update_size ="UPDATE product_size SET product_amount_keep='$product_amount_keep',product_amount_shop='$product_amount_shop',product_amount_web='$product_amount_web' WHERE product_size_id='".$_POST['product_size_id'][$key]."'";
		mysqli_query($_SESSION['connect_db'],$update_size)or die("ERROR : backend buy insert line 19");
	}
	echo "<script>alert('เพิ่มรายการซื้อและอัพเดทจำนวนสินค้าเรียบร้อยแล้ว');window.location='../#ajax/buy_product.php'</script>";
	
?>
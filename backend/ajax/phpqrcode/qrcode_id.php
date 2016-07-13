<?php
	session_start();
	include("../../../include/function.php");
    connect_db();
    echo "<meta charset='utf-8'>";
	if(!empty($_POST['amount_qrcode'])&&!empty($_POST['product_id'])){
		unset($_SESSION['product_name']);
		unset($_SESSION['product_id']);
		$_SESSION['product_id']= $_POST['product_id'];
		foreach ($_SESSION['product_id'] as $key => $value){
			$query_product =mysqli_query($_SESSION['connect_db'],"SELECT product_name FROM product WHERE product_id='$value'");
			list($product_name)=mysqli_fetch_row($query_product);
			$_SESSION['product_name'][$key] = "$product_name";
			$_SESSION['product_id'][$key] = "http://mumfern.com/index.php?module=product&action=product_detail&product_id=$value";
		}
		echo "<script>window.location='../../#ajax/phpqrcode/index.php?amount=$_POST[amount_qrcode]'</script>";	
	}elseif(!empty($_GET['amount_qrcode'])){
		unset($_SESSION['product_id']);	
		unset($_SESSION['product_name']);	
		echo "<script>window.location='../../#ajax/phpqrcode/index.php?amount=$_GET[amount_qrcode]'</script>";
	}
?>
<?php
function addproduct_cart(){
		$_SESSION['cart_id'][$_POST['product_size_id']] =array("product_id"=>"$_POST[product_id]","amount"=>"$_POST[amount]");
		echo "$_POST[product_id] , $_POST[amount]";	
}
function amounttotal_cart(){
		$_SESSION['total_amount']=$_POST['amounttotal_cart'];	
		
}
function sale_product(){
		$index = $_GET['product_size_id'];
		$_SESSION['sale'][$index]=1;
		echo "<script>window.location='../index.php?module=cart&action=show_cart'</script>";
}
function not_sale_product(){
		$index = $_GET['product_size_id'];
		unset($_SESSION['sale'][$index]);
		echo "<script>window.location='../index.php?module=cart&action=show_cart'</script>";
}

?>
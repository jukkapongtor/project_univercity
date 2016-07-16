<?php
function addproduct_cart(){
		$_SESSION['cart_id'][$_POST['product_size_id']] =array("product_id"=>"$_POST[product_id]","amount"=>"$_POST[amount]");
		echo "$_POST[product_id] , $_POST[amount]";	
}
function amounttotal_cart(){
		$_SESSION['total_amount']=$_POST['amounttotal_cart'];	
		
}

?>
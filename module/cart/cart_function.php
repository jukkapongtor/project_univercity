<?php
function show_cart(){
	if(empty($_SESSION['cart_id'])){
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สินค้ายังไม่ถูกเพิ่มในตะกร้า</b></h1></center>";
	}else{
		foreach ($_SESSION['cart_id'] as $key => $value) {
			echo "$key => $value <br>";
		}
	}

}
?>
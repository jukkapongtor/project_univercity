<?php
function add2cart(){
	$product=mysqli_query($_SESSION['connect'],"SELECT product_name,product_price,product_type FROM product WHERE product_id='$_GET[product_id]'");
	list($product_name,$product_price,$product_type)=mysqli_fetch_row($product);
	if(empty($_SESSION['amount22'])){
		$_SESSION['amount22']=0;
	}
	if(empty($_SESSION['cart_id'])){ // ถ้าตะกร้าว่าง
		$_SESSION['cart_id']=array();	// กำหนดให้ session เป็น Array
		$_SESSION['amount22']=0;
	}
	if(!empty($_SESSION['cart_id'])){
		$cnt=count($_SESSION['cart_id']);
		for($i=0;$i<$cnt;$i++){
			if($_SESSION['cart_id'][$i]==$_GET['product_id']){
				echo "<script>alert('สินค้าชิ้นนี้มีในตะกร้าแล้ว')</script>";
				echo "<script>window.location='index.php?module=product&action=list_product&page=2'</script>";
			}
		}
	}
	//ถ้า id ที่ส่งมาไม่ซ้ำกับใน $_SESSION[$id];
	if(!in_array($_GET['product_id'],$_SESSION['cart_id'])){
		$_SESSION['cart_id'][]=$_GET['product_id'];	
		$_SESSION['cart_name'][]=$product_name;
		$_SESSION['cart_price'][]=$product_price;
		$_SESSION['cart_type'][]=$product_type;	
		$_SESSION['cart_amount'][]=1;
		$_SESSION['amount22']++;
	}
	echo "<script>window.location='index.php?module=product&action=list_product'</script>";
}
function show_cart(){

}
?>
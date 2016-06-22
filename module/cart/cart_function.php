<?php
function show_cart(){
	if(empty($_SESSION['cart_id'])){
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สินค้ายังไม่ถูกเพิ่มในตะกร้า</b></h1></center>";
	}else{
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการสินค้าในตะกร้า</b></h1></center>";
		echo "<table class='table table-hover table-striped'>";
			echo "<tr><th><p class='font20' align='center'><b>ลำดับ</b></p></th><th><p class='font20'><b>รูปภาพ</b></p></th><th><p class='font20'><b>ชื่อสินค้า</b></p></th><th><p class='font20' align='center'><b>ราคา(ต่อชิ้น)</b></p></th><th><p class='font20' align='center'><b>จำนวน</b></p></th><th><p class='font20' align='center'><b>รวมราคา</b></p></th></tr>";
		$num=1;
		$total_price=0;
		foreach ($_SESSION['cart_id'] as $key => $value) {
			$query_product =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product.product_price,type.type_name,product.product_image FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id ='$key'")or die("ERROR : cart function line 11");
			list($product_id,$product_name,$product_price,$type_name,$product_image)=mysqli_fetch_row($query_product);
			echo "<tr>";
				echo "<td><p class='font20' align='center'>$num</p></td>";
				$file = ($type_name=='เฟิร์น')?"fern":$type_name;
				$file = ($file=='กระถาง')?"pots":$file;
				if(empty($product_image)){
					$file ="icon";
					$product_image ="on-images.jpg";
				}
				echo "<td><img src='images/$file/$product_image' width='50px'></td>";
				echo "<td><p class='font20'>$product_name</p></td>";
				echo "<td><p class='font20' align='center'>".number_format($product_price)."</p></td>";


				echo "<td style='width:100px;'>";
				    echo "<div class='input-group'>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default' id='lower_incart_$product_id' type='button'>ลบ</button>";
				      echo "</span>";
				      echo "<p class='font20' align='center'><input type='text' class='form-control' id='product_amountincart_$product_id' value='$value' style='padding:0px 5px;width:50px;text-align:center'></p>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default' id='push_incart_$product_id' type='button'>บวก</button>";
				      echo "</span>";
				    echo "</div>";
				echo "</td>";
				$sum = $value * $product_price;
				$total_price+=$sum;
				echo "<td><p class='font20' align='right' id='sum_incart_$product_id'>".number_format($sum)."</p></td>";
			echo "</tr>";
			$num++;
		}
		echo "<tr><td colspan='5'><b><p class='font20' align='right'>รวมราคาสินค้าทั้งหมด</p></b></td><td><p class='font20' id='total_incart' align='right'>$total_price</p></td></tr>";
		echo "</table>";
		echo "<center><a href='index.php?module=orders&action=order_insert'><button class='btn btn-success'><p class='font20' style='margin-bottom:-5px;'>ยืนยันการซื้อสิินค้า</p></button></a>&nbsp;&nbsp;&nbsp;<a href='index.php?module=cart&action=cancel_cart'><button class='btn btn-danger'><p class='font20' style='margin-bottom:-5px;'>ยกเลิกการซื้อสินค้า</p></button></center>";
	}

}
function cancel_cart(){
	unset($_SESSION['total_amount']);
	unset($_SESSION['cart_id']);
	echo "<script>alert('ยกเลิกสินค้าทั้งหมดในนตะกร้าเรียบร้อยแล้ว');window.location='index.php?module=users&action=data_users&menu=2'</script>";
}
?>
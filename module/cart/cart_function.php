<?php
function show_cart(){
	if(empty($_SESSION['cart_id'])){
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สินค้ายังไม่ถูกเพิ่มในตะกร้า</b></h1></center>";
	}else{
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการสินค้าในตะกร้า</b></h1></center>";
		echo "<table class='table table-hover table-striped'>";
			echo "<tr><th><p class='font20' align='center'><b>ลำดับ</b></p></th><th><p class='font20'><b>รูปภาพ</b></p></th><th><p class='font20'><b>ชื่อสินค้า</b></p></th><th><p class='font20' align='center'><b>ขนาด</b></p></th><th><p class='font20' align='center'><b>ราคา(ต่อชิ้น)</b></p></th><th><p class='font20' align='center'><b>จำนวน</b></p></th><th><p class='font20' align='center'><b>รวมราคา</b></p></th></tr>";
		$num=1;
		$total_price=0;
	echo "<pre>".print_r($_SESSION['cart_id'],true)."</pre>";

		foreach ($_SESSION['cart_id'] as $key => $value) {
			$query_product =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id ='$value[product_id]'")or die("ERROR : cart function line 12");
			list($product_id,$product_name,$type_name)=mysqli_fetch_row($query_product);
			echo "<tr>";
				echo "<td><p class='font20' align='center'>$num</p></td>";
				$query_image = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id = '$value[product_id]'")or die("ERROR : cart function line 16");
				list($product_image)=mysqli_fetch_row($query_image);
				$path = (empty($product_image))?"icon/no-images.jpg":"$type_name/$product_image";
				echo "<td><img src='images/$path' width='50px'></td>";
				echo "<td><p class='font20'>$product_name</p></td>";
				//echo "<pre>".print_r($_SESSION['cart_id'],true)."</pre>";
				$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,size.size_name,product_size.product_amount_shop,product_size.product_amount_web,product_size.product_price_shop,product_size.product_sprice_shop,product_size.product_price_web,product_size.product_sprice_web  FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size   WHERE product_size.product_size_id='$key' AND product_size.product_id='$value[product_id]'")or die("ERROR : cart function line 19");
				list($product_size_id,$size_name,$product_amount_shop,$product_amount_web,$product_price_shop,$product_sprice_shop,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size);
				echo "<td><p class='font20' align='center'>$size_name</p></td>";
				echo "<td><p class='font20' align='center' id='price_$product_size_id'>$product_price_web</p></td>";
				echo "<input type='hidden' id='product_id_$product_size_id' value='$product_id'>";
				echo "<td style='width:100px;'>";
				    echo "<div class='input-group'>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default' id='lower_incart_$product_size_id' type='button'>ลบ</button>";
				      echo "</span>";
				      echo "<p class='font20' align='center'><input type='text' class='form-control' id='product_amountincart_$product_size_id' value='$value[amount]' style='padding:0px 5px;width:50px;text-align:center'></p>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default' id='push_incart_$product_size_id' type='button'>บวก</button>";
				      echo "</span>";
				    echo "</div>";
				echo "</td>";
				$sum_product = $product_price_web * $value['amount'];
				$total_price+=$sum_product;
				echo "<td><p class='font20' align='right' id='sum_incart_$product_size_id'>".number_format($sum_product)."</p></td>";
			echo "</tr>";
			$num++;
		}
		echo "<tr><td colspan='6'><b><p class='font20' align='right'>รวมราคาสินค้าทั้งหมด</p></b></td><td><p class='font20' id='total_incart' align='right'>$total_price</p></td></tr>";
		echo "</table>";
		echo "<center><a href='index.php?module=orders&action=order_insert'><button class='btn btn-success'><p class='font20' style='margin-bottom:-5px;'>ยืนยันการซื้อสิินค้า</p></button></a>&nbsp;&nbsp;&nbsp;<a href='index.php?module=cart&action=cancel_cart'><button class='btn btn-danger'><p class='font20' style='margin-bottom:-5px;'>ยกเลิกการซื้อสินค้า</p></button></center>";
	}
echo "<script>";
	echo "$(document).ready(function() {";
        if(!empty($_SESSION['cart_id'])){
            foreach ($_SESSION['cart_id'] as $key => $value) {
            	$query_amount = mysqli_query($_SESSION['connect_db'],"SELECT product_amount_web FROM product_size WHERE product_size_id = '$key'")or die("ERROR cart function line 54");
            	list($product_amount_web)=mysqli_fetch_row($query_amount);
                echo "$('#push_incart_$key').click(function() {";
                	echo "var product_id = document.getElementById('product_id_$key').value;";
                    echo "var price = parseInt(document.getElementById('price_$key').innerHTML);";
                    echo "var product_incart = document.getElementById('product_amountincart_$key').value;";
                    echo "var total_incart = parseInt(document.getElementById('total_incart').innerHTML);";
                    echo "var amount_incart = parseInt(document.getElementById('total_amountincart').innerHTML);";
                    echo "product_incart++;";
                    echo "if(product_incart<='$product_amount_web'){";
	                    echo "document.getElementById('product_amountincart_$key').value=product_incart;";
	                    echo "var sum = product_incart * price;";
	                    echo "var total = price + total_incart;";
	                    echo "amount_incart++;";
	                    echo "document.getElementById('sum_incart_$key').innerHTML =sum;";
	                    echo "document.getElementById('total_incart').innerHTML =total;";
	                    echo "document.getElementById('total_amountincart').innerHTML=amount_incart;";
	                    echo "$.post('module/index.php?data=addproduct_cart',{product_id:product_id,amount:product_incart,product_size_id:'$key'},function(data){";
	                    echo "});";
	                    echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:amount_incart},function(data){";
	                    echo "});";
					echo "}else{";
						echo "alert('จำนวนสินค้าไม่พอจำหน่าย');";
					echo "}";
                echo "});";
                echo "$('#lower_incart_$key').click(function() {";
                	echo "var product_id = document.getElementById('product_id_$key').value;";
                    echo "var price = parseInt(document.getElementById('price_$key').innerHTML);";
                    echo "var product_incart = document.getElementById('product_amountincart_$key').value;";
                    echo "var total_incart = parseInt(document.getElementById('total_incart').innerHTML);";
                    echo "var amount_incart = parseInt(document.getElementById('total_amountincart').innerHTML);";
                    echo "if(product_incart>0){";
                        echo "product_incart--;";
                        echo "document.getElementById('product_amountincart_$key').value=product_incart;";
                        echo "var sum = product_incart * price;";
                        echo "var total = total_incart - price ;";
                        echo "amount_incart--;";
                        echo "document.getElementById('sum_incart_$key').innerHTML =sum;";
                        echo "document.getElementById('total_incart').innerHTML =total;";
                        echo "document.getElementById('total_amountincart').innerHTML=amount_incart;";
                        echo "$.post('module/index.php?data=addproduct_cart',{product_id:product_id,amount:product_incart,product_size_id:'$key'},function(data){";
                        echo "});";
                        echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:amount_incart},function(data){";
                        echo "});";
                    echo "}";
                echo "});";
            }
        }
    echo "});";
echo "</script>";
}
function cancel_cart(){
	unset($_SESSION['total_amount']);
	unset($_SESSION['cart_id']);
	echo "<script>alert('ยกเลิกสินค้าทั้งหมดในนตะกร้าเรียบร้อยแล้ว');window.location='index.php?module=users&action=data_users&menu=2'</script>";
}
?>
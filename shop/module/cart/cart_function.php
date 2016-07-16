<?php
function show_cart(){
?>
<div class="menu-header">
	<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='#'>ตะกร้าสินค้า</a>  </p>
</div>
<a href='index.php?module=product&action=list_product'><p align="right" style="margin:5px "><button class="btn btn-info">ซื้อสินค้าต่อ</button></p></a><hr style="margin-top:0px;"><hr style="margin-top:-18px;">
<?php
	if(empty($_SESSION['cart_id'])){
		echo "<center><h4>ยังไม่มีสินค้าในตะกร้า</h4></center>";
	}else{
		echo "<center><h4>รายการสินค้าในตะกร้า</h4></center>";
		echo "<table class='table table-hover table-striped' style='font-size:13px'>";
		$total_price=0;
		echo "<input type='hidden' id='total_amountincart' value='$_SESSION[total_amount]'>";
		foreach ($_SESSION['cart_id'] as $key => $value) {
			$query_product =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id ='$value[product_id]'")or die("ERROR : cart function line 12");
			list($product_id,$product_name,$type_name)=mysqli_fetch_row($query_product);
			echo "<tr>";
				$query_image = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id = '$value[product_id]'")or die("ERROR : cart function line 16");
				list($product_image)=mysqli_fetch_row($query_image);
				$path = (empty($product_image))?"icon/no-images.jpg":"$type_name/$product_image";
				echo "<td><img src='../images/$path' width='100' height='130'></td>";
				echo "<td>";
					$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,size.size_name,product_size.product_amount_shop,product_size.product_amount_web,product_size.product_price_shop,product_size.product_sprice_shop,product_size.product_price_web,product_size.product_sprice_web  FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size   WHERE product_size.product_size_id='$key' AND product_size.product_id='$value[product_id]'")or die("ERROR : cart function line 19");
					list($product_size_id,$size_name,$product_amount_shop,$product_amount_web,$product_price_shop,$product_sprice_shop,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size);
					echo "<input type='hidden' id='product_id_$product_size_id' value='$product_id'>";
					echo "<p><b>$product_name ($size_name)</b></p>";
					echo "<p><b>ราคาต่อชิ้น</b> <font id='price_$product_size_id'>$product_price_shop</font> บาท</p>";
					echo "<center><div class='input-group' style='width:70%;margin-bottom:10px;'>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default btn-sm' id='lower_incart_$product_size_id' type='button'>ลบ</button>";
				      echo "</span>";
				      echo "<input type='text' class='form-control input-sm' id='product_amountincart_$product_size_id' value='$value[amount]' style='padding:0px 5px;text-align:center'>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default btn-sm' id='push_incart_$product_size_id' type='button'>บวก</button>";
				      echo "</span>";
				    echo "</div></center>";
				    $sum_product = $product_price_shop * $value['amount'];
					$total_price+=$sum_product;
				    echo "<p><b>รวมราคา </b><font id='sum_incart_$key'>".number_format($sum_product)."</font></p>";
				echo "</td>";
				/*
				echo "<td><p class='font20'>$product_name</p></td>";
				//echo "<pre>".print_r($_SESSION['cart_id'],true)."</pre>";
				$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,size.size_name,product_size.product_amount_shop,product_size.product_amount_web,product_size.product_price_shop,product_size.product_sprice_shop,product_size.product_price_web,product_size.product_sprice_web  FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size   WHERE product_size.product_size_id='$key' AND product_size.product_id='$value[product_id]'")or die("ERROR : cart function line 19");
				list($product_size_id,$size_name,$product_amount_shop,$product_amount_web,$product_price_shop,$product_sprice_shop,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size);
				echo "<td><p class='font20' align='center'>$size_name</p></td>";
				echo "<td><p class='font20' align='center' id='price_$product_size_id'>$product_price_web</p></td>";
				
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
				*/
			echo "</tr>";
		}
		echo "<tr><td colspan='2'><b><p class='font20' align='right'>รวมราคาสินค้าทั้งหมด </b><font id='total_incart'>$total_price</font></p></td></tr>";
		echo "</table>";
		echo "<center><div style='margin-bottom:10px'><a href='index.php?module=orders&action=order_insert'><button class='btn btn-success'><p class='font20' style='margin-bottom:-5px;'>สั่งซื้อสินค้า</p></button></a>&nbsp;&nbsp;&nbsp;<a href='index.php?module=cart&action=cancel_cart'><button class='btn btn-danger'><p class='font20' style='margin-bottom:-5px;'>ยกเลิกสั่งซื้อ</p></button></a></div></center>";
		
	}
echo "<script>";
	echo "$(document).ready(function() {";
        if(!empty($_SESSION['cart_id'])){
            foreach ($_SESSION['cart_id'] as $key => $value) {
            	$query_amount = mysqli_query($_SESSION['connect_db'],"SELECT product_amount_shop FROM product_size WHERE product_size_id = '$key'")or die("ERROR cart function line 54");
            	list($product_amount_shop)=mysqli_fetch_row($query_amount);
                echo "$('#push_incart_$key').click(function() {";
                	echo "var product_id = document.getElementById('product_id_$key').value;";
                    echo "var price = parseInt(document.getElementById('price_$key').innerHTML);";
                    echo "var product_incart = document.getElementById('product_amountincart_$key').value;";
                    echo "var total_incart = parseInt(document.getElementById('total_incart').innerHTML);";
                    echo "var amount_incart = document.getElementById('total_amountincart').value;";
                    echo "product_incart++;";
                    echo "if(product_incart<='$product_amount_shop'){";
	                    echo "document.getElementById('product_amountincart_$key').value=product_incart;";
	                    echo "var sum = product_incart * price;";
	                    echo "var total = price + total_incart;";
	                    echo "amount_incart++;";
	                    echo "document.getElementById('sum_incart_$key').innerHTML =sum;";
	                    echo "document.getElementById('total_incart').innerHTML =total;";
	                    echo "document.getElementById('total_amountincart').value=amount_incart;";
	                    echo "$.post('module/index.php?data=addproduct_cart',{product_id:product_id,amount:product_incart,product_size_id:'$key'},function(data){";
	                    echo "});";
	                    echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:amount_incart},function(data){";
	                    echo "});";
					echo "}";
                echo "});";
                echo "$('#lower_incart_$key').click(function() {";
                	echo "var product_id = document.getElementById('product_id_$key').value;";
                    echo "var price = parseInt(document.getElementById('price_$key').innerHTML);";
                    echo "var product_incart = document.getElementById('product_amountincart_$key').value;";
                    echo "var total_incart = parseInt(document.getElementById('total_incart').innerHTML);";
                    echo "var amount_incart = document.getElementById('total_amountincart').value;";
                    echo "if(product_incart>0){";
                        echo "product_incart--;";
                        echo "document.getElementById('product_amountincart_$key').value=product_incart;";
                        echo "var sum = product_incart * price;";
                        echo "var total = total_incart - price ;";
                        echo "amount_incart--;";
                        echo "document.getElementById('sum_incart_$key').innerHTML =sum;";
                        echo "document.getElementById('total_incart').innerHTML =total;";
                        echo "document.getElementById('total_amountincart').value=amount_incart;";
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
	echo "<script>swal({title:'',text: 'ยกเลิกสินค้าทั้งหมดในนตะกร้าเรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php';});</script>";

}
?>
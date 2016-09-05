<?php
function show_cart(){
	if(empty($_SESSION['cart_id'])){
		echo "<center><h3 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สินค้ายังไม่ถูกเพิ่มในตะกร้า</b></h3></center>";
	}else{
		echo "<center><h3 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการสินค้าในตะกร้า</b></h3></center>";
		echo "<div class='table-responsive'> ";
		echo "<table class='table table-hover table-striped '>";
			echo "<tr><th><p class='font20' align='center'><b>ลำดับ</b></p></th><th><p class='font20'><b>รูปภาพ</b></p></th><th><p class='font20'><b>ชื่อสินค้า</b></p></th><th><p class='font20' align='center'><b>ขนาด</b></p></th><th><p class='font20' align='center'><b>ราคา(ต่อชิ้น)</b></p></th><th><p class='font20' align='center'><b>จำนวน</b></p></th><th><p class='font20' align='center'><b>รวมราคา</b></p></th></tr>";
		$num=1;
		$total_price=0;
		foreach ($_SESSION['cart_id'] as $key => $value) {
			$query_product =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id ='$value[product_id]'")or die("ERROR : cart function line 12");
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
				$price = ($product_sprice_web!=0)?$product_sprice_web:$product_price_web;
				echo "<td><p class='font20' align='center' id='price_$product_size_id'>$price</p></td>";
				echo "<input type='hidden' id='product_id_$product_size_id' value='$product_id'>";
				echo "<td style='width:100px;'>";
				    echo "<div class='input-group'>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default' id='lower_incart_$product_size_id' type='button' style='padding:6px;background:#aa8383'><img src='images/icon/minus.png' width='20' height='20'></button>";
				      echo "</span>";
				      echo "<p class='font20' align='center'><input type='text' class='form-control' id='product_amountincart_$product_size_id' value='$value[amount]' disabled style='background:#fff;padding:0px 5px;width:50px;text-align:center;cursor: default;'></p>";
				      echo "<span class='input-group-btn'>";
				        echo "<button class='btn btn-default' id='push_incart_$product_size_id' type='button' style='padding:6px;background:#496a84'><img src='images/icon/add.png' width='20' height='20'></button>";
				      echo "</span>";
				    echo "</div>";
				echo "</td>";
				$sum_product = $price * $value['amount'];
				$total_price+=$sum_product;
				echo "<td><p class='font20' align='right' id='sum_incart_$product_size_id'>".number_format($sum_product)."</p></td>";
			echo "</tr>";
			$num++;
		}
		echo "<tr><td colspan='6'><b><p class='font20' align='right'>รวมราคาสินค้าทั้งหมด</p></b></td><td><p class='font20' id='total_incart' align='right'>$total_price</p></td></tr>";
		echo "</table>";
		echo "</div>";
		echo "<center><button class='btn btn-success' data-toggle='modal' data-target='#buyproduct'><p class='font20' style='margin-bottom:-5px;'>สั่งซื้อสินค้า</p></button>&nbsp;&nbsp;&nbsp;<a href='index.php?module=cart&action=cancel_cart'><button class='btn btn-danger'><p class='font20' style='margin-bottom:-5px;'>ยกเลิกสั่งซื้อ</p></button></a></center>";
		echo "<div class='modal fade' id='buyproduct' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
		  echo "<div class='modal-dialog ' role='document'>";
		    echo "<div class='modal-content'>";
		      echo "<div class='modal-header'>";
		        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
		        echo "<h2 class='modal-title' id='myModalLabel'><b>ฟอร์มการสั่งซื้อสินค้า</b></h2>";
		      echo "</div>";
		      echo "<form action='index.php?module=orders&action=order_insert' method='post'>";
		      echo "<div class='modal-body font20'>";
		      	echo "<p>กรุณากรอกข้อมูลตามที่มีการ <font color='red'>*&nbsp;</font>ข้างหน้า</p>";
		        echo "<p><b>เลือกข้อมูลผู้ซื้อสินค้า : </b><input type='radio' id='address1' name='address' value='user' checked='checked'> เลือกข้อมูลจากผู้ใช้ &nbsp;&nbsp;<input type='radio' name='address' id='address2' value='not_user' > ใช้ข้อมูลใหม่</p>";
		        echo "<div id='address_customer'>";
		        	$query_users = mysqli_query($_SESSION['connect_db'],"SELECT * FROM users WHERE username ='$_SESSION[login_name]'")or die("ERROR users function line 64");
					list($username,$passwd,$fullname,$lastname,$image,$phone,$email,$type,$employee_id,$house_no,$village_no,$alley,$lane,$road,$sub_district,$district,$province,$postal_code)=mysqli_fetch_row($query_users);
					echo "<center><table width='80%'>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b><font color='red'>*</font>ชื่อ</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
							echo "</td>";
							echo "<td colspan='4'>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='fullname' placeholder='Fullname' value='$fullname'></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b><font color='red'>*</font>นามสกุล</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
							echo "</td>";
							echo "<td colspan='4'>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='lastname' placeholder='Lastname' value='$lastname'></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b><font color='red'>*</font>บ้านเลขที่</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='house_no' placeholder='House NO.' value='$house_no'></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;หมู่</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='village_no' placeholder='Village NO.' value='$village_no'></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b>ตรอก</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='alley' placeholder='Alley' value='$alley'></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;ซอย</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;:&nbsp;</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='lane' placeholder='Lane' value='$lane'></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b>ถนน</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td colspan='4'>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='road' placeholder='Road' value='$road'></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td width='18%'>";
								echo "<p class='font20'><b><font color='red'>*</font>จังหวัด</b></p>";
							echo "</td>";
							echo "<td width='5%'>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td width='27%'>";
								echo "<p class='font20'>";
								echo "<select id='select_provinces' name='province' style='width:100%'>";
									echo "<option value='null'>เลือกจังหวัด</option>";
									$query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces")or die("ERROR : users function line 235");
									while(list($province_id,$province_name)=mysqli_fetch_row($query_provinces)){
										if($province==$province_name){
											echo "<option value='$province_id' selected='selected'>$province_name</option>";
											$isset_province = $province_id;
										}else{
											echo "<option value='$province_id'>$province_name</option>";
										}
										
									}
								echo "</select></p>";
							echo "</td>";
							echo "<td width='18%'>";
								echo "<p class='font20'><b><font color='red'>*</font>เขต/อำเภอ</b></p>";
							echo "</td width='5%'>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td width='27%'>";
								echo "<p class='font20'><select id='select_districts' name='districts' style='width:100%'>";
								if(empty($district)){
									echo "<option value='null'>เลือกอำเภอ</option>";
								}else{
									$query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province'")or die("ERROR : users function line 259");
									while(list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict)){
										if($district == $amphure_name){
											echo "<option value='$amphure_id' selected='selected'>$amphure_name</option>";
											$isset_district = $amphure_id;
										}else{
											echo "<option value='$amphure_id'>$amphure_name</option>";
										}
									}
								}	
								echo "</select></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b><font color='red'>*</font>แขวง/ตำบล</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><select id='select_subdistricts' name='subdistrict' style='width:100%'>";
								if(empty($sub_district)){
									echo "<option value='null'>เลือกตำบล</option>";
								}else{
									$query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district'")or die("ERROR : users function line 259");
									while(list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict)){
										if($sub_district == $disrtict_name){
											echo "<option value='$disrtict_code' selected='selected'>$disrtict_name</option>";
										}else{
											echo "<option value='$disrtict_code'>$disrtict_name</option>";
										}
									}
								}
								echo "</select></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b><font color='red'>*</font>รหัสไปรษณีย์</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><input class='form-control' tyle='text' id='zipcode' name='zipcode' placeholder='Postcode' value='$postal_code'></p>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>";
								echo "<p class='font20'><b><font color='red'>*</font>เบอร์โทรศัพท์</b></p>";
							echo "</td>";
							echo "<td>";
								echo "<p class='font20'><b>&nbsp;: </b></p>";
							echo "</td>";
							echo "<td colspan='4'>";
								echo "<p class='font20'><input class='form-control' tyle='text' name='phone' placeholder='Phone' value='$phone'></p>";
							echo "</td>";
						echo "</tr>";
					echo "</table></center>";
					echo "<p align='right'><button type='submit' class='btn btn-success font20'>ยืนยันการสั่งซื้อและอัปเดทข้อมูลผู้ใช้</button>";
		        	echo "&nbsp;&nbsp;<button type='button' class='btn btn-danger font20' data-dismiss='modal'>ยกลเิก</button></p>";
		        echo "</div>";
		      echo "</div>";
		      echo "</form>";
		    echo "</div>";
		  echo "</div>";
		echo "</div>";
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
        echo "$('#address1').click(function() {";
        	echo "$.post('module/index.php?data=select_address',{address:'user'},function(data){";
        		echo "$('#address_customer').html(data);";
            echo "});";
        echo "});";
		echo "$('#address2').click(function() {";
        	echo "$.post('module/index.php?data=select_address',{address:'notuser'},function(data){";
        		echo "$('#address_customer').html(data);";
            echo "});";
        echo "});";
    echo "});";
echo "</script>";
}
function cancel_cart(){
	unset($_SESSION['total_amount']);
	unset($_SESSION['cart_id']);
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<script>swal({title:'',text: \"ยกเลิกสินค้าทั้งหมดในนตะกร้าเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=data_users&menu=2';})</script>";
}
?>
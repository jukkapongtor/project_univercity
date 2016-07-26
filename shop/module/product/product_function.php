<?php
function list_product(){
	$keywd = (empty($_GET['keywd']))?"":$_GET['keywd'];
	$_SESSION['total_amount'] = (empty($_SESSION['total_amount']))?0:$_SESSION['total_amount'];
?>
	<div class="menu-header">
		<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='#'>รายการสินค้า</a>  </p>
	</div>
	<a href='index.php?module=cart&action=show_cart'><p align="right" style="margin:5px "><button class="btn btn-info">ตะกร้าสินค้า (<?php echo "$_SESSION[total_amount]";?>)</button></p></a><hr style="margin-top:0px;"><hr style="margin-top:-18px;">
	<div class="col-xs-12" style='margin-top:5px;padding:0px;'>
		<form method='get'>
		<input type='hidden' name='module' value="product">
		<input type='hidden' name='action' value="list_product">
		<div class="col-md-2 col-sm-1"></div>
		<div class="col-xs-9 col-md-7 col-sm-8">
			<input type="text" class="form-control input-sm" name='keywd' value="<?php echo "$keywd"; ?>" placeholder="Search...">
		</div>
		<div class="col-xs-3 col-md-2 col-sm-2">
			<button type="submit" class="btn btn-sm btn-primary" >ค้นหา</button>
		</div>
		<div class="col-md-2 col-sm-1"></div>
		</form>
	</div>
<?php
	
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,product_image.product_image,type.type_name_eng FROM product LEFT JOIN product_image ON product.product_id = product_image.product_id LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_name LIKE '%$keywd%'")or die("ERROR : shop product funtion line 18");
	$count_product =mysqli_num_rows($query_product);
	$total_page = ceil($count_product/12);
	if(empty($_GET['page'])){
		$page=1;
		$start_row=0;
	}
	else{
		$page=$_GET['page'];
		$start_row=($page-1)*12;
	}
	if($count_product>0){
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_name LIKE '%$keywd%' LIMIT $start_row,12")or die("ERROR : shop product funtion line 18");
	while (list($product_id,$product_name,$product_type)=mysqli_fetch_row($query_product)) {
		$query_image=mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'  ORDER BY product_image_id ASC");
		list($product_image)=mysqli_fetch_row($query_image);
?> 
		<div class="col-xs-6 col-sm-4 col-md-3" style='margin-top:10px;'>

			<a href='<?php echo "index.php?module=product&action=product_detail&product_id=$product_id";?>' style='text-decoration:none'><p align="center"><?php echo "<img src='../images/$product_type/$product_image' width='120' height='120' style='border-radius:60px;border:4px solid #ccc'>" ;?></p>
			<p align="center"><?php echo "$product_name";?></p></a>
		</div>
<?php
	}

	if($total_page>1){
	echo "<div class='col-xs-12'>";
		echo "<center><nav><ul class='pagination'>";
		  echo "<li><a href='index.php?module=product&action=list_product&page=1&keywd=$keywd' style='padding:5px;'>|<<</a></li>";
		  $preview = ($page-1);
		  $preview = ($preview<1)?1:$preview;
		  echo "<li><a href='index.php?module=product&action=list_product&page=$preview&keywd=$keywd' style='padding:5px;'><</a></li>";
	for($i=1;$i<=$total_page;$i++){
			$active = ($page==$i)?"active":"";
		  echo "<li class='$active'><a href='index.php?module=product&action=list_product&page=$i&keywd=$keywd' style='padding:5px;'>$i</a></li>";
	}	
		  $next = ($page+1);
		  $next = ($next>$total_page)?$total_page:$next;
		  echo "<li><a href='index.php?module=product&action=list_product&page=$next&keywd=$keywd' style='padding:5px;'>></a></li>";
		  echo "<li><a href='index.php?module=product&action=list_product&page=$total_page&keywd=$keywd' style='padding:5px;'>>>|</a></li>";
		echo "</ul></nav></center>";
	echo "</div>";
	}
	}else{
		echo "<br><br><br><br><center><h3><font color='red'>!!!</font> ไม่พบรายการที่ค้นหา <font color='red'>!!!</font></h3></center>";
	}
}
function product_detail(){
?>
	<div class="menu-header">
		<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='index.php?module=product&action=list_product'>รายการสินค้า</a> / <a href='#'>รายละเอียดสินค้า</a> </p>
	</div>
	<a href='index.php?module=cart&action=show_cart'><p align="right" style="margin:5px "><button class="btn btn-info">ตะกร้าสินค้า (<?php $_SESSION['total_amount'] = (empty($_SESSION['total_amount'] ))?0:$_SESSION['total_amount'] ;echo "$_SESSION[total_amount]";?>)</button></p></a><hr style="margin-top:0px;"><hr style="margin-top:-18px;">
<?php
	$query_product_detail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,product.product_detail,quality.quality_name,product.product_stock,type.type_name,type.type_name_eng FROM product LEFT JOIN quality ON product.product_quality = quality.product_quality LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id='$_GET[product_id]'")or die("ERROR : product_function line 196");
	list($product_name,$product_detail,$quality_name,$product_stock,$product_type,$type_name_eng)=mysqli_fetch_row($query_product_detail);

	$query_images_detail = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$_GET[product_id]'")or die("ERROR : product_function line 200");
	$count_image = mysqli_num_rows($query_images_detail);
?>
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
<?php
		for($i=0;$i<$count_image;$i++){
			$active = ($i==0)?"class='active'":"";
			echo "<li data-target='#carousel-example-generic' data-slide-to='$i' $active></li>";
		}
?>
	  </ol>
	  <!-- Wrapper for slides -->
<?php
	$number_image=1;
	echo "<div class='carousel-inner img_slide_detail' role='listbox'>";
	while(list($product_image_detail)=mysqli_fetch_row($query_images_detail)){
	  	$active = ($number_image==1)?"active":"";
	    echo "<div class='item  $active img_slide_detail'>";
	      echo "<img src='../images/$type_name_eng/$product_image_detail' style='width:100%height:100%' alt='...'>";
	      echo "<div class='carousel-caption'>";
	      echo "</div>";
	    echo "</div>";
	  $number_image++;
	}
	echo "</div>";
?>
	  <!-- Controls -->
	  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>

<?php
	echo "<table align='center' width='85%' style='margin:10px;font-size:14px;'>";
		echo "<tr>";
			echo "<td width='30%'><p><b>ชื่อสินค้า</b></p></td>";
			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
			echo "<td><p>$product_name</p></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td valign='top'><p><b>รายละเอียดสินค้า</b></p></td>";
			echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
			$product_detail =(empty($product_detail))?"ไม่มีรายละเอียดของข้อมูลสินค้า":$product_detail;
			echo "<td><p>$product_detail</p></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><p><b>ประเภทสินค้า</b></p></td>";
			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
			echo "<td><p>$product_type</p></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><p><b>หมวดหมู่สินค้า</b></p></td>";
			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
			echo "<td><p>$quality_name</p></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td valign='top'><p><b>ขนาดสินค้า</b></p></td>";
			echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan='3'>";
			$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,size.size_name,product_size.product_amount_shop,product_size.product_price_shop,product_size.product_sprice_shop FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id ='$_GET[product_id]'");
			$number=1;
			$rows_size = mysqli_num_rows($query_size);
			if($rows_size>0){
				while(list($product_size_id,$size_name,$product_amount_shop,$product_price_shop,$product_sprice_shop)=mysqli_fetch_row($query_size)){
					echo "<div class='col-xs-12'><p><b>ขนาดสินที่ $number : </b> $size_name</p></div>";	
					echo "<div class='col-xs-8' style='font-size:13px;'><p><b>ราคาสินค้า(Batn)</b></p></div>";
					echo "<div class='col-xs-4' style='font-size:13px;'><p>$product_price_shop</p></div>";
					echo "<div class='col-xs-8' style='font-size:13px;'><p><b>จำนวนสินค้า</b></p></div>";
					$product_amount_shop = ($product_amount_shop==0)?"สินค้าหมด":$product_amount_shop;
					if($product_amount_shop!="สินค้าหมด"){
						echo "<div class='col-xs-4' style='font-size:13px;'><p>$product_amount_shop</p></div>";
						echo "<div class='col-xs-2'></div>";
						echo "<div class='col-xs-7' >";
							echo "<div class='input-group' >";
								echo "<span class='input-group-btn' >";
									echo "<button class='btn btn-default' id='lower_indetail_$product_size_id' type='button' style='padding:6px;background:#aa8383'><img src='../images/icon/minus.png' width='20' height='20'></button>";
								echo "</span>";
									echo "<input type='text' class='form-control input-sm' id='product_amountindetail_$product_size_id' value='0'  disabled style='background:#fff;height:31px;text-align:center;cursor: default;' >";
								echo "<span class='input-group-btn'>";
									echo "<button class='btn btn-default' id='push_indetail_$product_size_id' type='button' style='padding:6px;background:#496a84'><img src='../images/icon/add.png' width='20' height='20'></button>";
								echo "</span>";
							echo "</div>";
						echo "</div>";
						echo "<div class='col-xs-2' style='font-size:12'>";
							echo "<input type='hidden' id='product_id' value='$_GET[product_id]'>";
							echo "<p align='center'><a id='add2cart_$product_size_id'><button type='button' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-shopping-cart'></span><b> หยิบสินค้า</b></button></a></p>";
						 echo "</div>";	
					}else{
						echo "<div class='col-xs-4' style='font-size:13px;'><p>$product_amount_shop</p></div>";
					}
					$number++;
				}
			}else{
				echo "<p>ไม่พบขนาดสินค้า</p>";
			}
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<script>";
		echo "$(document).ready(function() {";
			$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size_id,size_id,product_amount_shop FROM product_size WHERE product_size.product_id ='$_GET[product_id]'");
					$number=1;
			while(list($product_size_id,$size_id,$product_amount_shop)=mysqli_fetch_row($query_size)){
			echo "$('#push_indetail_$product_size_id').click(function() {";
	            echo "var product_indetail = document.getElementById('product_amountindetail_$product_size_id').value;";
	            echo "var max_product = $product_amount_shop;";
	            echo "product_indetail++;";
	            echo "if(product_indetail<=max_product){";
	            echo "document.getElementById('product_amountindetail_$product_size_id').value=product_indetail;";
	            echo "}";
	        echo "});";
	        echo "$('#lower_indetail_$product_size_id').click(function() {";
	            echo "var product_indetail = document.getElementById('product_amountindetail_$product_size_id').value;";
	            echo "if(product_indetail>=1){";
	                echo "product_indetail--;";
	                echo "document.getElementById('product_amountindetail_$product_size_id').value=product_indetail;";
	            echo "}";
	        echo "});";
        
	        echo "$('#add2cart_$product_size_id').click(function() {";

	                echo "stop=0;";
	                echo "var product_id = document.getElementById('product_id').value;";
	                if(!empty($_SESSION['cart_id'])){
	                    foreach ($_SESSION['cart_id'] as $key => $value) {
	                        echo "if('$key'=='$product_size_id'){";
	                        	echo "swal(\"\", \"สินค้าชิ้นนี้มีในตะกร้าแล้ว\",\"warning\");";
	                            echo "stop=1;";
	                        echo "}";
	                    }
	                }
	                echo "if(stop==0){";
	                echo "var product_indetail = parseInt(document.getElementById('product_amountindetail_$product_size_id').value);";
	                echo "if(product_indetail!=0){";
		                echo "$.post('module/index.php?data=addproduct_cart',{product_id:product_id,amount:product_indetail,product_size_id:$product_size_id},function(data){";
		                echo "});";
						$_SESSION['total_amount'] = (empty($_SESSION['total_amount']))?0:$_SESSION['total_amount'];

						echo "var total = product_indetail +$_SESSION[total_amount];";
		                echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:total},function(data){";
		                echo "});";
		                echo "swal({title:'',text: 'เพิ่มสินค้าลงในตะกร้าแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=product&action=product_detail&product_id="."'+product_id+'"."';})";
		                echo "}";
	                echo "}";
	        echo "});";
			}
		echo "});";
	echo "</script>";

}
?>
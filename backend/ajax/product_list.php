<?php
	session_start();

	include("../../include/function.php");
	connect_db();
?>
<?php
$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id FROM product")or die("ERROR : backend product list line 8");
while(list($product_id)=mysqli_fetch_row($query_product)){
echo "<script>";
echo "$(document).ready(function() {";
    echo "$('#product_type_$product_id').change(function() {";
    	echo "$.post('ajax/select_product_size.php?data=quality',{product_type: document.getElementById('product_type_$product_id').value},function(data){";
        	echo "$('#product_quality_$product_id').html(data);";
        echo "});";
		echo "$.post('ajax/select_product_size.php?data=size',{product_type: document.getElementById('product_type_$product_id').value},function(data){";
        	echo "$('#product_size1_$product_id').html(data);$('#product_size2_$product_id').html(data);$('#product_size3_$product_id').html(data);$('#product_size4_$product_id').html(data);$('#product_size5_$product_id').html(data);";
        echo "});";
    echo "});";
echo "});";
echo "</script>";


}

?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการรายการสินค้า</a></li>
			<li><a href="#">แสดงรายการสินค้า</a></li>

		</ol>
	</div>
</div>
<div class="container-fluid" style="border-bottom:1px solid #ddd;margin-bottom:20px;">
	<form  method="get" action="ajax/product_list_search.php">
	<div class="col-md-6">
		<h4>ค้นหาข้อมูลสินค้า</h4>
		<div class="col-md-10" style="margin-top:20px;padding:0px;" >
<?php
			$keywords = (empty($_GET['keywords']))?"":$_GET['keywords'];
			$getproduct_type=(empty($_GET['product_type']))?"":$_GET['product_type'];
			$getproduct_quality=(empty($_GET['product_quality']))?"":$_GET['product_quality'];

			$sql_type = (empty($_GET['product_type']))?"":"OR (type.product_type='$_GET[product_type]' AND type.type_name LIKE '%$keywords%')";
			$sql_quality = (empty($_GET['product_quality']))?"":"OR (quality.product_quality='$_GET[product_quality]' AND quality.quality_name LIKE '%$keywords%')";
			

		    echo "<input type='text' class='form-control' name='keywords' placeholder='Search...' value='$keywords'  style='height:30px;'>";
?>		
		</div>
		<div class="col-md-2" style="margin-top:20px;">
		    <button type="submit" class="btn btn-default btn-sm" style='height:30px;padding:2px 10px;'>Search</button>
		</div>
	</div>
	<div class="col-md-6">
		<h4>เลือกประเภทและหมวดหมู่สินค้าในการค้นหา</h4>
		<div class="col-md-6" style='padding:0px'>
			<p>เลือกประเภทสินค้า</p>
<?php
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : backend product list line 39");
		
		$chk = (empty($_GET['product_type']))?"checked='checked'":"";
			echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='product_type' value='' $chk>&nbsp;ไม่เลือกประเภท</p>";
		while (list($product_type,$type_name)=mysqli_fetch_row($query_type)) {
			$chk = ($getproduct_type==$product_type)?"checked='checked'":"";
			echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='product_type' value='$product_type' $chk>&nbsp;$type_name</p>";
		}
?>
		</div>
		<div class="col-md-6" style='padding:0px'>
			<p>เลือกหมวดหมู่สินค้า</p>
<?php
		$query_quality = mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality")or die("ERROR : backend product list line 49");
		
		$chk = (empty($_GET['product_quality']))?"checked='checked'":"";
			echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='product_quality' value='' $chk>&nbsp;ไม่เลือกประเภท</p>";
		while (list($product_quality,$quality_name)=mysqli_fetch_row($query_quality)) {
			$chk = ($getproduct_quality==$product_quality)?"checked='checked'":"";
			echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='product_quality' value='$product_quality' $chk>&nbsp;$quality_name</p>";
		}
?>
		</div>
	</div>
	</form>
</div>
<div class="container-fluid">
<?php
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,type.type_name,quality.quality_name FROM product LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN quality ON product.product_quality = quality.product_quality WHERE product.product_name LIKE '%$keywords%' $sql_type $sql_quality ")or die("ERROR : backend product list line 61");
	$count_product = mysqli_num_rows($query_product);
	$total_page = ceil($count_product/10);
	if(empty($_GET['page'])){
		$page=1;
		$start_row=0;
	}
	else{
		$page=$_GET['page'];
		$start_row=($page-1)*10;
	}
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product_image.product_image,type.type_name,product.product_type FROM product LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN quality ON product.product_quality = quality.product_quality LEFT JOIN product_image ON product.product_id = product_image.product_id WHERE product.product_name LIKE '%$keywords%' $sql_type $sql_quality ORDER BY product.product_id DESC  LIMIT $start_row,10")or die("ERROR : backend product list line 87");
	$number =0;
	while(list($product_id,$product_name,$product_image,$type_name,$type_id)=mysqli_fetch_row($query_product)){

		if(($number%5)==0){
			echo "<div class='col-md-1' style='margin-bottom:20px; height:300px;'></div>";
		}
		echo "<div class='col-md-2' style='margin-bottom:20px; height:300px;'>";
			echo "<center><p><img src='../images/$type_name/$product_image' width='100%' height='200px' style='border-radius:5px;'></p>";
			echo "<p>$product_name</p>";
			echo "<p><button class='btn btn-xs btn-warning' type='button' data-toggle='modal' data-target='#$product_id'>แก้ไขข้อมูล</button>";
			echo "&nbsp;<a href='ajax/product_delete.php?product_id=$product_id' onclick='return confirm(\"คุณต้องการลบรายการสินค้า$product_name ใช่หรือไม่\")'><button class='btn btn-xs btn-danger' type='button' >ลบข้อมูล</button></a></p></a></center>";
				echo "<div class='modal fade' id='$product_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
				  echo "<div class='modal-dialog modal-lg' role='document'>";
				    echo "<div class='modal-content'>";
				      echo "<div class='modal-header'>";
				        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
				        echo "<h4 class='modal-title' id='myModalLabel'>แก้ไขสินค้า$product_name</h4>";
				      echo "</div>";
				      echo "<div class='modal-body'>";
				      echo "<form action='ajax/product_update.php' method='post'>";
				      echo "<input type='hidden' name='product_id' value='$product_id'>";
				      	$query_product_detail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_detail,quality.quality_name,product.product_stock FROM product LEFT JOIN quality ON product.product_quality = quality.product_quality WHERE product.product_id='$product_id'")or die("ERROR : product_function line 196");
						list($product_detail,$quality_name,$product_stock)=mysqli_fetch_row($query_product_detail);
				        echo "<div class='container-fluid'>";
				        echo "<div class='col-md-5'>";
				        	$query_images_detail = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'")or die("ERROR : product_function line 200");
							    $number_image=1;
							    while(list($product_image_detail)=mysqli_fetch_row($query_images_detail)){
							    	if($number_image==1){
							    	echo "<div class='col-md-12'>";
										echo "<img src='../images/$type_name/$product_image_detail' width='100%' height='350' style='border-radius:5px;'>";
									echo "</div>";
									$number_image++;
									}
									echo "<div class='col-md-3' style='padding:5px'>";
										echo "<img src='../images/$type_name/$product_image_detail' width='100%' height='75' style='border-radius:5px;'>";
									echo "</div>";
								}
				        echo "</div>";
				        echo "<div class='col-md-7'>";
				        	echo "<table width='100%'>";
							    echo "<tr>";
							      	echo "<td width='25%'><p><b>ชื่อสินค้า</b></p></td>";
							      	echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      	echo "<td><p><input class='form-control' type='text' name='product_name' value='$product_name'></p></td>";
							    echo "</tr>";
							    echo "<tr>";
							      	echo "<td valign='top'><p><b>รายละเอียดสินค้า</b></p></td>";
							      	echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
							      	$product_detail =(empty($product_detail))?"ไม่มีรายละเอียดของข้อมูลสินค้า":$product_detail;
							      	echo "<td><p><textarea class='form-control' name='product_detail'>$product_detail</textarea></p></td>";
							    echo "</tr>";
							    echo "<tr>";
							      	echo "<td><p><b>ประเภทสินค้า</b></p></td>";
							        echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      	$query_type_edit=mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : product_add line 160");
									echo "<td><p><select class='form-control' id='product_type_$product_id'  name='product_type'>";
										echo "<option value=''>--เลือกประเภทสินค้า--</option>";
									    while(list($product_type_edit,$type_name_edit)=mysqli_fetch_row($query_type_edit)){
									    	$selected=($type_name==$type_name_edit)?"selected='selected'":"";
									    	echo "<option value='$product_type_edit' $selected>$type_name_edit</option>";
									    }
								    echo "</select></p></td>";
							    echo "</tr>";
							    echo "<tr>";
							      	echo "<td><p><b>หมวดหมู่สินค้า</b></p></td>";
							      	echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      	$query_quality_edit=mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality WHERE quality_type='$type_id'")or die("ERROR : product_add line 160");
							      	echo "<td><p><select class='form-control' id='product_quality_$product_id' name='product_quality'>";
							      	while(list($product_quality_edit,$quality_name_edit)=mysqli_fetch_row($query_quality_edit)){
									    $selected=($quality_name==$quality_name_edit)?"selected='selected'":"";
									    echo "<option value='$product_quality_edit' $selected>$quality_name_edit</option>";
									}
							      	echo "<p>$quality_name</p>";
							      	echo "</select></p></td>";
							    echo "</tr>";
							    echo "<tr>";
							      	echo "<td><p><b>สถานะสินค้า</b></p></td>";
							      	echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      	$stock = (empty($product_stock))?0:1;
							      	$checked = (empty($product_stock))?"":"checked='checked'";
							      	echo "<td><p><input type='checkbox' name='product_stock' value='$stock' $checked> สินค้าพร้อมจำหน่าย</p></td>";
							    echo "</tr>";
							    echo "<tr>";
							      	echo "<td valign='top'><p><b>ขนาดสินค้า</b></p></td>";
							      	echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
							      	echo "<td><div class='input_fields_wrap' >";
							      	$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size.size_id,size.size_name,product_size.product_amount_keep,product_size.product_amount_shop,product_size.product_amount_web,product_size.product_price_shop,product_size.product_sprice_shop,product_size.product_price_web,product_size.product_sprice_web FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id ='$product_id'");
							      	$num=1;
							      	$row_size = mysqli_num_rows($query_size);
							      	if($row_size>0){
							      		while(list($size_id,$size_name,$product_amount_keep,$product_amount_shop,$product_amount_web,$product_price_shop,$product_sprice_shop,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size)){
							      			if($num!=1){
							      				echo "<div class='remove col-md-12' style='margin-bottom:2px;padding:0px'>";
							      			}
							      			echo "<input type='hidden' name='product_size_old[]' value='$size_id'>";		
											echo "<div class='col-md-4' style='padding:0'><p>ขนาดสินที่ $num</p></div>";
											echo "<div class='col-md-6' style='padding:0'><p><select class='form-control' id='product_size$num"."_"."$product_id'  name='product_size[]'>";
											echo "<option value=''>--เลือกขนาดสินค้า--</option>";
											$query_size_edit =mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id='$type_id' ")or die("ERROR : backend product list line 206");
											while(list($size_id_edit,$size_name_edit)=mysqli_fetch_row($query_size_edit)){
												$selected_edit = ($size_name==$size_name_edit)?"selected='selected'":"";
												echo "<option value='$size_id_edit' $selected_edit>$size_name_edit</option>";
											}
										   	echo "</select></p></div>";
										   	if($num==1){
										   		echo "<button class='add_field_button btn btn-primary' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/add.png' width='12px' height='12px' ></button>";
										   	}else{
										   		echo "<button  class='remove_field btn btn-danger' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/minus.png' width='12px' height='12px' ></button>";
										   	}
											    	
										   	echo "<div class='col-md-12' style='padding:0'>";
											echo "<div class='col-md-4' style='padding:0;margin-bottom:4px'>ราคาบนเว็บ</div>";
											echo "<div class='col-md-6' style='padding:2px;;margin-bottom:4px'><input type='text' class='form-control' name='product_price_web[]' value='$product_price_web' style='margin-top:-5px;'></div>";
											echo "<div class='col-md-4' style='padding:0;margin-bottom:4px'>ราคาในร้าน</div>";
											echo "<div class='col-md-6' style='padding:2px;margin-bottom:4px'><input type='text' class='form-control' name='product_price_shop[]' value='$product_price_shop' style='margin-top:-5px;'></div>";
											echo "</div>";
								      		$num++;
								      		if($num!=1){
								      			echo "</div>";
								      		}	
							      		}
							      	}else{
							      		echo "<div class='col-md-4' style='padding:0'><p>ขนาดสินที่ $num</p></div>";
										echo "<div class='col-md-6' style='padding:0'><p><select class='form-control' id='product_size1"."_"."$product_id'  name='product_size[]'>";
										echo "<option value=''>--เลือกขนาดสินค้า--</option>";
										$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id='$type_id'")or die("ERROR : product list line 226");
										while(list($product_size,$size_name)=mysqli_fetch_row($query_size)){
										    echo "<option value='$product_size'>$size_name</option>";
										}
										echo "</select></p></div>";
										echo "<button class='add_field_button btn btn-primary' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/add.png' width='12px' height='12px' ></button>";
										echo "<div class='col-md-12' style='padding:0'>";
										echo "<div class='col-md-4' style='padding:0;margin-bottom:4px'>ราคาบนเว็บ</div>";
										echo "<div class='col-md-6' style='padding:2px;;margin-bottom:4px'><input type='text' class='form-control' name='product_price_web[]'style='margin-top:-5px;'></div>";
										echo "<div class='col-md-4' style='padding:0;margin-bottom:4px'>ราคาในร้าน</div>";
										echo "<div class='col-md-6' style='padding:2px;margin-bottom:4px'><input type='text' class='form-control' name='product_price_shop[]'style='margin-top:-5px;'></div>";
										echo "</div>";
							      	}
							      	echo "</div></td>";
							    echo "</tr>";
							echo "</table>";
				        echo "</div>";
				        echo "</div>";
				        echo "<p align='right'><button type='submit' class='btn btn-primary'>แก้ไขข้อมูล</button>";
					    echo "&nbsp;&nbsp;<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button></p>";
					    echo "</form>";
				      echo "</div>";//ปิด modal
				    echo "</div>";
				  echo "</div>";
				echo "</div>";
		echo "</div>";
		$number++;
		
		if(($number%5)==0){
			echo "<div class='col-md-1' style='margin-bottom:20px; height:300px;'></div>";
			$number=0;
		}
	}
	if($total_page>1){
	echo "<div class='col-md-12'>";
		echo "<center><nav><ul class='pagination'>";
		  echo "<li><a href='ajax/product_list_page.php?page=1&keywords=$keywords&product_type=$getproduct_type&product_quality=$getproduct_quality'>หน้าแรก</a></li>";
		  $preview = ($page-1);
		  $preview = ($preview<1)?1:$preview;
		  echo "<li><a href='ajax/product_list_page.php?page=$preview&keywords=$keywords&product_type=$getproduct_type&product_quality=$getproduct_quality'><<</a></li>";
	for($i=1;$i<=$total_page;$i++){
			$active = ($page==$i)?"active":"";
		  echo "<li class='$active'><a href='ajax/product_list_page.php?page=$i&keywords=$keywords&product_type=$getproduct_type&product_quality=$getproduct_quality'>$i</a></li>";
	}	
		  $next = ($page+1);
		  $next = ($next>$total_page)?$total_page:$next;
		  echo "<li><a href='ajax/product_list_page.php?page=$next&keywords=$keywords&product_type=$getproduct_type&product_quality=$getproduct_quality'>>></a></li>";
		  echo "<li><a href='ajax/product_list_page.php?page=$total_page&keywords=$keywords&product_type=$getproduct_type&product_quality=$getproduct_quality'>หน้าสุดท้าย</a></li>";
		echo "</ul></nav></center>";
	echo "</div>";
	}
?>
</div>

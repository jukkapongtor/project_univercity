<?php
	session_start();

	include("../../include/function.php");
	connect_db();
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
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
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
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product_image.product_image,type.type_name FROM product LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN quality ON product.product_quality = quality.product_quality LEFT JOIN product_image ON product.product_id = product_image.product_id WHERE product.product_name LIKE '%$keywords%' $sql_type $sql_quality ORDER BY product.product_id DESC  LIMIT $start_row,10")or die("ERROR : backend product list line 87");
	$number =0;
	while(list($product_id,$product_name,$product_image,$type_name)=mysqli_fetch_row($query_product)){

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
							      			echo "<td><p>$type_name</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td><p><b>หมวดหมู่สินค้า</b></p></td>";
							      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			echo "<td><p>$quality_name</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td><p><b>สถานะสินค้า</b></p></td>";
							      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			$stock = (empty($product_stock))?"ไม่พร้อมจำหน่าย":"พร้อมจำหน่าย";
							      			echo "<td><p>$stock</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td valign='top'><p><b>ขนาดสินค้า</b></p></td>";
							      			echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			echo "<td>";
							      			$query_size =mysqli_query($_SESSION['connect_db'],"SELECT size.size_name,product_size.product_amount_keep,product_size.product_amount_shop,product_size.product_amount_web,product_size.product_price_shop,product_size.product_sprice_shop,product_size.product_price_web,product_size.product_sprice_web FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id ='$product_id'");
							      			$num=1;
							      			$row_size = mysqli_num_rows($query_size);
							      			if($row_size>0){
							      			while(list($size_name,$product_amount_keep,$product_amount_shop,$product_amount_web,$product_price_shop,$product_sprice_shop,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size)){
							      				echo "<table>";
							      				echo "<tr><td><p><b>ขนาดสินที่ $num</b></td><td><p><b>&nbsp;:&nbsp;</b></p></td><td><p> $size_name</p></td></tr>";	
							      				echo "<tr><td><p><b>ราคาบนเว็บไซตฺ(Batn)</b></p></td><td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      				echo "<td><p>$product_price_web</p></td></tr>";
							      				echo "<tr><td><p><b>ราคาในร้าน(Batn)</b></p></td><td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      				echo "<td><p>$product_price_shop</p></td></tr>";
							      				echo "</table>";
							      				$num++;
							      			}
							      			}
							      			echo "</td>";
							      		echo "</tr>";
							      	echo "</table>";
				        echo "</div>";
				        echo "</div>";
				      echo "</div>";
				      echo "<div class='modal-footer'>";
				        echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
				        echo "<button type='button' class='btn btn-primary'>Save changes</button>";
				      echo "</div>";
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

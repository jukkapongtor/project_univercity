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
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product.product_image,type.type_name FROM product LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN quality ON product.product_quality = quality.product_quality WHERE product.product_name LIKE '%$keywords%' $sql_type $sql_quality ORDER BY product.product_id DESC  LIMIT $start_row,10")or die("ERROR : backend product list line 72");
	$number =0;
	while(list($product_id,$product_name,$product_image,$type_name)=mysqli_fetch_row($query_product)){

		if(($number%5)==0){
			echo "<div class='col-md-1' style='margin-bottom:20px; height:300px;'></div>";
		}
		echo "<div class='col-md-2' style='margin-bottom:20px; height:300px;'>";
			$folder = ($type_name=="เฟิร์น")?"fern":$type_name;
			$folder = ($folder=='กระถาง')?"pots":$folder;
			echo "<a href='ajax/product_detail_id.php?product_id=$product_id'><center><p><img src='../images/$folder/$product_image' width='100%' height='200px' style='border-radius:5px;'></p>";
			echo "<p>$product_name</p></a>";
			echo "<p><a href='ajax/product_edit_id.php?product_id=$product_id'><button class='btn btn-xs btn-warning' type='button' >แก้ไขข้อมูล</button></a>&nbsp;<a href='ajax/product_delete.php?product_id=$product_id' onclick='return confirm(\"คุณต้องการลบรายการสินค้า$product_name ใช่หรือไม่\")'><button class='btn btn-xs btn-danger' type='button' >ลบข้อมูล</button></a></p></a></center>";
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

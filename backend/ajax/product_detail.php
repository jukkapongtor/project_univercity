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
			<li><a href="#">รายละเอียดสินค้า</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="panel panel-default">
<?php
		$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product.product_price_web,product.product_detail,type.type_name,quality.quality_name,size.size_name,product.product_stock,product.product_image FROM product INNER JOIN type ON product.product_type = type.product_type INNER JOIN quality ON product.product_quality = quality.product_quality INNER JOIN size ON product.product_size = size.product_size WHERE product.product_id='$_GET[product_id]'")or die("ERROR : product_function line 47");
		list($product_id,$product_name,$product_price_web,$product_detail,$product_type,$product_quality,$product_size,$product_stock,$product_image)=mysqli_fetch_row($query_product);
		  echo "<div class='panel-heading'><h3>รายละเอียดสินค้า$product_name</h3></div>";
		  echo "<div class='panel-body'>";
		    echo "<div class='col-md-6'style='margin-top:20px'>";
		    	$folder = ($product_type=="เฟิร์น")?"fern":$product_type;
		    	$folder = ($folder=="กระถาง")?"pots":$folder;
				echo "<img src='../images/$folder/$product_image' width='100%' height='350' style='border-radius:5px;'>";
		    echo "</div>";
		    echo "<div class='col-md-6'style='margin-top:20px'>";
		    	$product_detail =(empty($product_detail))?"ไม่มีรายละเอียดของข้อมูลสินค้า":$product_detail;
				echo "<p style='font-size:14px'><b>รายละเอียดสินค้า :</b><br>&nbsp;&nbsp;&nbsp;&nbsp;$product_detail</p>";
				echo "<p style='font-size:14px'><b>ราคาสินค้า : </b> $product_price_web &nbsp;<b>บาท/(Bath)</b></p>";
				echo "<p style='font-size:14px'><b>ประเภทสินค้า : </b> $product_type</p>";
				echo "<p style='font-size:14px'><b>หมวดหมู่สินค้า : </b> $product_quality</p>";
				echo "<p style='font-size:14px'><b>ขนาดสินค้า : </b> $product_size</p>";
				echo "<p style='font-size:14px'><b>สถานะสินค้า : </b> $product_stock</p>";
		    echo "</div>";
		  echo "</div>";
?>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>
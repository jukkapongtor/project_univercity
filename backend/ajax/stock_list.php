<?php
	session_start();
	include("../../include/function.php");
	date_default_timezone_set('Asia/Bangkok');
	connect_db();

	$query_product_size = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,product_size.product_amount_keep,product_size.product_amount_web,product_size.product_amount_shop FROM product_size LEFT JOIN product ON product_size.product_id = product.product_id LEFT JOIN size ON product_size.size_id=size.product_size")or die("ERROR : stock list line 7");
	$number=1;
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการคลังสินค้า</a></li>
			<li><a href="#">รายการคลังสินค้า</a></li>
		</ol>
	</div>
</div>
	<center><h3 style='margin-top:0px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการคลังสินค้า</b></h3></center>
	<div class="panel panel-primary" style="margin-top:20px;">
	  <div class="panel-heading">จำนวนสินค้าที่มีในร้าน</div>
	  <div class="panel-body">
	    <?php
			echo "<table class='table table-bordered'>";
				echo "<tr><th><center>ลำดับ</center></th><th><center>ชื่อสินค้า</center></th><th><center>ขนาดสินค้า</center></th><th><center>จำนวนที่เก็บไว้</center></th><th><center>จำนวนบนเว็บไซต์</center></th><th><center>จำนวนในร้าน</center></th></tr>";
			while (list($product_name,$size_name,$product_amount_keep,$product_amount_web,$product_amount_shop)=mysqli_fetch_row($query_product_size)){
				echo "<tr>";
					echo "<td align='center'>$number</td>";
					echo "<td>$product_name</td>";
					echo "<td>$size_name</td>";
					echo "<td>$product_amount_keep</td>";
					echo "<td>$product_amount_web</td>";
					echo "<td>$product_amount_shop</td>";
				echo "</tr>";
				$number++;
			}
			echo "</table>";

		?>
	  </div>
	</div>


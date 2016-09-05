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
			<li><a style="text-decoration:none">หน้าหลัก</a></li>
			<li><a style="text-decoration:none">แจ้งเตือนสินค้าใกล้หมด</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
<center><h3 style='margin-top:0px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการจำนวนสินค้าที่ใกล้จะหมด</b></h3></center>
	<div class="panel panel-primary" style="margin-top:20px;">
	  <div class="panel-heading">จำนวนสินค้าที่มีในร้าน</div>
	  <div class="panel-body">
	    <table class="table table-striped">
			<tr><th><center>ลำดับ</center></th><th><center>ชื่อสินค้า</center></th><th><center>ขนาดสินค้า</center></th><th><center>จำนวนวบนเว็บไซต์</center></th><th><center>จำนวนในร้าน</center></th></tr>
<?php
		$query_product_amount = mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id, product_size.product_id,product.product_name,size.size_name,product_size.product_amount_web,product_size.product_amount_shop FROM product_size LEFT JOIN product ON product_size.product_id = product.product_id LEFT JOIN size ON product_size.size_id=size.product_size WHERE product_size.product_amount_web<3 OR product_size.product_amount_web<5")or die("ERROR : backend manage_website line 65");
		$num = 1;
		while(list($product_size_id,$product_id,$product_name,$size_id,$product_amount_web,$prduct_amount_shop)=mysqli_fetch_row($query_product_amount)){
			echo "<tr>";
				echo "<td align='center'>$num</td>";
				//echo "<td>$product_id</td>";
				echo "<td>$product_name</td>";
				echo "<td>$size_id</td>";
				$product_amount_web = ($product_amount_web<3)?"<font color='red'>$product_amount_web</font>":$product_amount_web;
				echo "<td>$product_amount_web</td>";
				$prduct_amount_shop = ($prduct_amount_shop<3)?"<font color='red'>$prduct_amount_shop</font>":$prduct_amount_shop;
				echo "<td>$prduct_amount_shop</td>";
				//echo "<td align='center'><button class='btn btn-sm btn-success' style='padding:0px 10px;'>เพิ่มจำนวน</button></td>";
			echo "</tr>";
			$num++;
		}
?>
		</table>

	  </div>
	</div>
</div>
</body>
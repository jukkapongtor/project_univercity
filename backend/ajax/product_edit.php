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
			<li><a href="#">แก้ไขสินค้า</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-2"></div>
	<div class="col-md-8">
<?php
		$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_price_web,product_detail,product_type,product_quality,product_size,product_stock FROM product WHERE product_id='$_GET[product_id]'")or die("ERROR : product_function line 26");
		list($product_id,$product_name,$product_price_web,$product_detail,$product_type,$product_quality,$product_size,$product_stock)=mysqli_fetch_row($query_product);
?>			<form method="post" action="ajax/product_update.php" enctype="multipart/form-data">
				<div class='col-md-12' style="margin-top:20px;">
					<div class="panel panel-default">
<?php
					  echo "<input type='hidden' name='product_id' value='$product_id'>";
					  echo "<div class='panel-heading'><h3>แก้ไขรายการสินค้า$product_name</h3></div>";
?>
					  <div class="panel-body">
					    กรุณากรอกข้อมูลให้ครบตามเครื่องหมาย *<br><br>
					    <table>
					    	<tr>
					    		<td><p align='right'><b>ชื่อสินค้า : </b></p></td>
					    		<td><input class='form-control' type='text' name='product_name' value='<?php echo "$product_name";?>'></td>
					    	</tr>
					    	<tr>
					    		<td><p align='right'><b>ประเภทสินค้า : </b></p></td>
					    		<td>
<?php			
							$query_type=mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : product_add line 21");
							echo "<select  name='product_type'>";
					    	while(list($type_id,$type_name)=mysqli_fetch_row($query_type)){
					    		$selected = ($product_type==$type_id)?"selected='selected'":"";
					    		echo "<option value='$type_id' $selected>$type_name</option>";
					    	}
					    	echo "</select>";
?>	
								</td>
					    	</tr>
					    	<tr>
					    		<td><p align='right'><b>หมวดหมู่สินค้า : </b></p></td>
					    		<td>
<?php			
							$query_quality=mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality")or die("ERROR : product_add line 33");
							echo "<select  name='product_quality'>";
					    	while(list($quality_id,$quality_name)=mysqli_fetch_row($query_quality)){
					    		$selected = ($product_quality==$quality_id)?"selected='selected'":"";
					    		echo "<option value='$quality_id'>$quality_name</option>";
					    	}
					    	echo "</select>";
?>			    			
					    		</td>
					    	</tr>
					    	<tr>
					    		<td><p align='right'><b>รายละเอียดสินค้า : </b></p></td>
					    		<td><textarea class='form-control'  name='product_detail'><?php echo "$product_detail";?></textarea></td>
					    	</tr>
					    	<tr>
					    		<td><p align='right'><b>ขนาดสินค้า : </b></p></td><td>
<?php			
							$query_size=mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size")or die("ERROR : product_add line 33");
							echo "<select  name='product_size'>";
					    	while(list($size_id,$size_name)=mysqli_fetch_row($query_size)){
					    		$selected = ($product_size==$size_id)?"selected='selected'":"";
					    		echo "<option value='$size_id'>$size_name</option>";
					    	}
					    	echo "</select>";
?>				    		
					    		</td>
					    	</tr>
					    	<tr>
						    	<td><p align='right'><b>รูปภาพ : </b></p></td>
						    	<td><input type='file' name='product_image'></td>
					    	</tr>
					    	<tr>
						    	<td><p align='right'><b>ราคาสินค้า : </b></p></td>
						    	<td><input class='form-control' type='text' name='product_price_web' value="<?php echo "$product_price_web";?>"></td>
					    	</tr>
					    	<tr>
						    	<td><p align='right'><b>สถานะสินค้า : </b></p></td>
<?php
								$chk = (empty($product_stock))?"":"checked='checked'";
						    	echo "<td><input type='checkbox' name='product_stock'  value='1' $chk>พร้อมจำหน่าย</td>";
?>
					    	</tr>
					    </table>
					    <p align="right"><input class='btn btn-sm btn-success' type='submit' value="แก้ไขข้อมูลสินค้า"></p>
					  </div>
					</div>
				</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>
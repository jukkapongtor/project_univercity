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
			<li><a href="#">เพิ่มรายการสินค้า</a></li>

		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<form method="post" action="ajax/product_insert.php" enctype="multipart/form-data">
	<div class='col-md-6' style="margin-top:20px;">
		<div class="panel panel-default">
		  <div class="panel-heading"><h3>ฟอร์มเพิ่มรายการสินค้า</h3></div>
		  <div class="panel-body">
		    กรุณากรอกข้อมูลให้ครบตามเครื่องหมาย *<br><br>
		    <table width="100%">
		    	<tr>
		    		<td width="30%"><p><b>ชื่อสินค้า</b></p></td>
		    		<td width="5%"><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td width="65%"><p><input class='form-control' type='text' name='product_name'></p></td>
		    	</tr>
		    	<tr>
		    		<td><p><b>ประเภทสินค้า</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td>
<?php			$query_type=mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : product_add line 21");
				echo "<p><select class='form-control'  name='product_type'>";
		    	while(list($product_type,$type_name)=mysqli_fetch_row($query_type)){
		    		echo "<option value='$product_type'>$type_name</option>";
		    	}
		    	echo "</select></p>";
?>	
					</td>
		    	</tr>
		    	<tr>
		    		<td><p><b>หมวดหมู่สินค้า</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td>
<?php			$query_quality=mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality")or die("ERROR : product_add line 33");
				echo "<p><select class='form-control' name='product_quality'>";
		    	while(list($product_quality,$quality_name)=mysqli_fetch_row($query_quality)){
		    		echo "<option value='$product_quality'>$quality_name</option>";
		    	}
		    	echo "</select></p>";
?>			    			
		    		</td>
		    	</tr>
		    	<tr>
		    		<td><p><b>ขนาดสินค้า</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td>
<?php			$query_size=mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size")or die("ERROR : product_add line 33");
				echo "<p><select class='form-control'  name='product_size'>";
		    	while(list($product_size,$size_name)=mysqli_fetch_row($query_size)){
		    		echo "<option value='$product_size'>$size_name</option>";
		    	}
		    	echo "</select></p>";
?>				    		
		    		</td>
		    	</tr>
		    	<tr>
		    		<td valign="top"><p><b>รายละเอียดสินค้า</b></p></td>
		    		<td valign="top"><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td><p><textarea class='form-control'  name='product_detail'></textarea></p></td>
		    	</tr>
		    	<tr>
			    	<td><p><b>รูปภาพ</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
			    	<td><p><input type='file' name='product_image'></p></td>
		    	</tr>
		    	<tr>
			    	<td><p><b>ราคาสินค้า</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
			    	<td><p><input class='form-control' type='text' name='product_price_web'></p></td>
		    	</tr>
		    	<tr>
			    	<td><p><b>สถานะสินค้า</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
			    	<td><p><input type='checkbox' name='product_stock' value='1'>&nbsp;&nbsp;พร้อมจำหน่าย</p></td>
		    	</tr>
		    </table>
		    <p align="right"><input class='btn btn-sm btn-success' type='submit' value="เพิ้มสินค้า"></p>
		  </div>
		</div>
	</div>
	<div class='col-md-6'>
		<div class="panel panel-default" style='margin-top:20px'>
		  <div class="panel-heading"><h3>รายการสินค้าที่ถูกเพิ่ม</h3></div>
		  <div class="panel-body">
		  	 แสดงรายการสินค้าที่ถูกเพิ่มล่าสุด 6 รายการ<br><br>
<?php
			$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_image,product_type FROM product ORDER BY product_id DESC LIMIT 0,6")or die("ERROR : backend product_add line 79");
			while(list($product_id,$product_name,$product_image,$product_type)=mysqli_fetch_row($query_product)){
				echo "<div class='col-md-6' style='margin-bottom:20px;'>";
					$folder = ($product_type==1)?"fern":"pots";
					echo "<center><a href='ajax/product_detail_id.php?product_id=$product_id'><img src='../images/$folder/$product_image' width='100%' height='200px'><br><b>$product_name</b></a></center>";
				echo "</div>";
			}
?>
		  </div>
		</div>
	</div>
		
</form>
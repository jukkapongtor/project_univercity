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
			<li><a href="#">จัดการประเภทสินค้า</a></li>
			<li><a href="#">เพิ่มประเภทสินค้า</a></li>

		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<form method="post" action="ajax/type_insert.php">
	<div class='col-md-6' style="margin-top:20px;">
		<div class="panel panel-default">
		  <div class="panel-heading"><h3>ฟอร์มเพิ่มประเภทสินค้า</h3></div>
		  <div class="panel-body">
		    <table>
		    	<tr>
		    		<td><p align='right'><b>ชื่อประเภทสินค้า : </b></p></td>
		    		<td><input class='form-control' type='text' name='type_name'></td>
		    	</tr>
		    </table>
		    <p align="right"><input class='btn btn-sm btn-success' type='submit' value="เพิ่มประเภทสินค้า"></p>
		  </div>
		</div>
	</div>
	<div class='col-md-6'>
		<div class="panel panel-default" style='margin-top:20px'>
		  <div class="panel-heading"><h3>รายการประเภทสินค้า</h3></div>
		  <div class="panel-body">
		  	 แสดงประเภทสินค้า <br><br>
<?php
			$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type ORDER BY product_type ASC")or die("ERROR : backend type_add line 42");
			while(list($product_type,$type_name)=mysqli_fetch_row($query_type)){
				echo "<div class='col-md-6' style='margin-bottom:20px;'>";
					echo "<b>$type_name</b>";
				echo "</div>";
			$query_type_number=mysqli_query($_SESSION['connect_db'],"SELECT COUNT(product_id) FROM product WHERE product_type='$product_type'")or die("ERROR : backend type_add line 47");
			list($count)=mysqli_fetch_row($query_type_number);
				echo "<div class='col-md-6' style='margin-bottom:20px;'>";
					echo "<b><span class='badge'>$count</span></b>";
				echo "</div>";
			}
?>
		  </div>
		</div>
	</div>
		
</form>
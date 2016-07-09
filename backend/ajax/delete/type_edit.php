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
			<li><a href="#">แก้ไขประเภทสินค้า</a></li>

		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
	<div class='col-md-6' style="margin-top:20px;">
		<div class="panel panel-default" >
		  <div class="panel-heading"><h3>รายการประเภทสินค้า</h3></div>
		  <div class="panel-body">
		  	 แสดงประเภทสินค้า <br><br>
<?php
			$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type ORDER BY product_type ASC")or die("ERROR : backend type_add line 42");
			while(list($product_type,$type_name)=mysqli_fetch_row($query_type)){
				echo "<div class='col-md-3' style='margin-bottom:20px;'>";
					echo "<b>$type_name</b>";
				echo "</div>";
			$query_type_number=mysqli_query($_SESSION['connect_db'],"SELECT COUNT(product_id) FROM product WHERE product_type='$product_type'")or die("ERROR : backend type_add line 47");
			list($count)=mysqli_fetch_row($query_type_number);
				echo "<div class='col-md-3' style='margin-bottom:20px;'>";
					echo "<b><span class='badge'>$count</span></b>";
				echo "</div>";
				echo "<div class='col-md-3' style='margin-bottom:20px;'>";
					echo "<b><a href='ajax/type_edit_type_id.php?edit_type_id=$product_type'><button class='btn btn-info btn-sm' type='button'>แก้ไขข้อมูล</button></a></b>";
				echo "</div>";
				echo "<div class='col-md-3' style='margin-bottom:20px;'>";
					echo "<b><a href='ajax/type_delete.php?delete_type_id=$product_type' onclick='return confirm(\"ข้อมูลที่เกี่ยวข้องกับ ประเภท$type_name จะถูกลบทั้งหมด คุณต้องการที่จะลบข้อมูลใช่หรือไม่\")'><button class='btn btn-danger btn-sm' type='button'>ลบข้อมูล</button></a></b>";
				echo "</div>";
			}
?>
		  </div>
		</div>
	</div>
<form method="post" action="ajax/type_update.php">
	<div class='col-md-6' style='margin-top:20px'>
<?php
	if(!empty($_GET['edit_type_id'])){
		echo "<div class='panel panel-default'>";
		  echo "<div class='panel-heading'><h3>ฟอร์มแก้ไขประเภทสินค้า</h3></div>";
		  echo "<div class='panel-body'>";
		    echo "<table>";
		    	echo "<tr>";
		    	$query_typeanme = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE product_type ='$_GET[edit_type_id]'")or die("ERROR : backend type_edit line 54");
		    	list($type_name)=mysqli_fetch_row($query_typeanme);
		    		echo "<td><p align='right'><b>ชื่อประเภทสินค้า : </b></p></td>";
		    		echo "<td><input class='form-control' type='text' name='type_name' value='$type_name'></td>";
		    		echo "<input type='hidden' name='type_id' value='$_GET[edit_type_id]'>";
		    	echo "</tr>";
		    echo "</table>";
		    echo "<p align='right'><input class='btn btn-sm btn-danger' type='submit' value='แก้ไขประเภทสินค้า'></p>";
		  echo "</div>";
		echo "</div>";
	}
?>
	</div>
		
</form>
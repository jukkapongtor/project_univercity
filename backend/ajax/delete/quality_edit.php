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
		  <div class="panel-heading"><h3>รายการหมวดหมู่สินค้า</h3></div>
		  <div class="panel-body">
		  	 แสดงหมวดหมู่สินค้า <br><br>
<?php
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : backend quality_add line 27");
		while(list($type_id,$type_name)=mysqli_fetch_row($query_type)){
			echo "<div class='col-md-12'><b><font style='border-bottom:3px double;font-size:18px;'>$type_name</font></b></div>";
			$query_quality = mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality WHERE quality_type='$type_id' ORDER BY product_quality ASC")or die("ERROR : backend quality_add line 42");
			while(list($product_quality,$quality_name)=mysqli_fetch_row($query_quality)){
				echo "<div class='col-md-4' style='margin-bottom:20px;'>";
					echo "<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$quality_name</b>";
				echo "</div>";
			$query_quality_number=mysqli_query($_SESSION['connect_db'],"SELECT COUNT(product_id) FROM product WHERE product_quality='$product_quality'")or die("ERROR : backend quality_add line 47");
			list($count)=mysqli_fetch_row($query_quality_number);
				echo "<div class='col-md-2' style='margin-bottom:20px;'>";
					echo "<b><span class='badge'>$count</span></b>";
				echo "</div>";
				echo "<div class='col-md-3' style='margin-bottom:20px;'>";
					echo "<b><a href='ajax/quality_edit_quality_id.php?edit_quality_id=$product_quality'><button class='btn btn-info btn-sm' quality='button'>แก้ไขข้อมูล</button></a></b>";
				echo "</div>";
				echo "<div class='col-md-3' style='margin-bottom:20px;'>";
					echo "<b><a href='ajax/quality_delete.php?delete_quality_id=$product_quality' onclick='return confirm(\"ข้อมูลที่เกี่ยวข้องกับ หมวดหมู่$quality_name จะถูกลบทั้งหมด คุณต้องการที่จะลบข้อมูลใช่หรือไม่\")'><button class='btn btn-danger btn-sm' type='button'>ลบข้อมูล</button></a></b>";
				echo "</div>";
			}
		}
?>
		  </div>
		</div>
	</div>
<form method="post" action="ajax/quality_update.php">
	<div class='col-md-6' style='margin-top:20px'>
<?php
	if(!empty($_GET['edit_quality_id'])){
		echo "<div class='panel panel-default'>";
		  echo "<div class='panel-heading'><h3>ฟอร์มแก้ไขหมวดหมู่สินค้า</h3></div>";
		  echo "<div class='panel-body'>";
		    echo "<table>";
		    	echo "<tr>";
		    	$query_typeanme = mysqli_query($_SESSION['connect_db'],"SELECT quality_name FROM quality WHERE product_quality ='$_GET[edit_quality_id]'")or die("ERROR : backend type_edit line 54");
		    	list($quality_name)=mysqli_fetch_row($query_typeanme);
		    		echo "<td><p align='right'><b>ชื่อหมวดหมู่สินค้า : </b></p></td>";
		    		echo "<td><input class='form-control' type='text' name='quality_name' value='$quality_name'></td>";
		    		echo "<input type='hidden' name='quality_id' value='$_GET[edit_quality_id]'>";
		    	echo "</tr>";
		    echo "</table>";
		    echo "<p align='right'><input class='btn btn-sm btn-danger' type='submit' value='แก้ไขหมวดหมู่สินค้า'></p>";
		  echo "</div>";
		echo "</div>";
	}
?>
	</div>
		
</form>
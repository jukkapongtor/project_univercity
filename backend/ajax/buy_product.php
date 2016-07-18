<?php
	session_start();
	include("../../include/function.php");
  date_default_timezone_set('Asia/Bangkok');
	connect_db();
?>
<script>
$(document).ready(function() {
    $('#product_type').change(function() {
    	$.ajax({
            type: 'POST',
            data: {product_type: document.getElementById('product_type').value},
            url: 'ajax/select_product_size.php?data=quality',
            success: function(data) {$('#product_quality').html(data);}
        });
    	return false;
    });

    $('#product_quality').change(function() {
    	$.ajax({
            type: 'POST',
            data: {product_quality: document.getElementById('product_quality').value},
            url: 'ajax/function.php?data=product_list',
            success: function(data) {$('#product_list').html(data);}
        });
    	return false;
    });
});
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการค่าใช้จ่าย</a></li>
			<li><a href="#">ต้นทุนสินค้า</a></li>
		</ol>
	</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">รายการต้นทุนสินค้า</h3>
  </div>
  <div class="panel-body">
<?php
	$date = date("Y-m-d");
?>
  <div class="col-md-12">
  	<p><b>รายการต้นทุนประจำวันที่ : </b><?php echo "$date"; ?></p>
  </div>
  <div class="col-md-6">
  	<p><b>เลือกประเภทสินค้าและหมวดหมู่สินค้า</b></p>
  	<div class="container-fluid">
  		<div class="col-md-4"><p>เลือกประเภทสินค้า</p></div>
	  	<div class="col-md-8"> 
	  		<select class="form-control" id="product_type">
	  			<option>--เลือกประเภทสินค้า--</option>
<?php
			$query_type=mysqli_query($_SESSION['connect_db'],"SELECT * FROM type")or die("ERROR backend buy product line 42 ");
			while (list($type_id,$type_name)=mysqli_fetch_row($query_type)) {
				echo "<option value='$type_id'>$type_name</option>";
			}
?>
	  		</select>
	  	</div>	
  	</div>
  	<div class="container-fluid">
  		<div class="col-md-4"><p>เลือกหมวดหมู่สินค้า</p></div>
	  	<div class="col-md-8">
	  		<select class="form-control" id="product_quality">
	  			<option>--เลือกหมวดหมู่สินค้า--</option>
	  		</select>
	  	</div>	
  	</div>
  	<div class="container-fluid" id='product_list' style="padding:0px;"></div>
  </div>
  <div class="col-md-6" id='product_detail'>
  	
  </div>
  </div>
</div>

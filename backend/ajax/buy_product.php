<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(' <div class="remove" style="margin-bottom:20px"><div class="col-md-1" style="margin-bottom:20px">ประเภท </div><div class="col-md-2" style="margin-bottom:20px"><input type="text" class="form-control" name="mytext[]"></div><div class="col-md-1" style="margin-bottom:20px">ชื่อสินค้า</div><div class="col-md-2" style="margin-bottom:20px"><input type="text" class="form-control" name="mytext[]"></div><div class="col-md-1" style="margin-bottom:20px">จำนวน</div><div class="col-md-1" style="margin-bottom:20px"><input type="text" class="form-control" name="mytext[]"></div><div class="col-md-1" style="margin-bottom:20px">ราคา(หน่วย)</div><div class="col-md-2" style="margin-bottom:20px"><input type="text" class="form-control" name="mytext[]"></div><button  class="remove_field">Remove</button></div></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('.remove').remove(); x--;
    })
});
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการค่าใช้จ่าย</a></li>
			<li><a href="#">สินค้าสำหรับขายต่อ</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">รายการซื้อสินค้า</h3>
  </div>
  <div class="panel-body">
<?php
	$date = date("Y-m-d");
?>
  <p><b>รายการซื้อเข้าประจำวันที่ : </b><?php echo "$date"; ?></p>
  	<form>
    <div class="input_fields_wrap" >
    	<div class="col-md-1" style='margin-bottom:20px'>ประเภท </div>
	    <div class="col-md-2" style='margin-bottom:20px'><input type="text" class='form-control' name="mytext[]"></div>
	    <div class="col-md-1" style='margin-bottom:20px'>ชื่อสินค้า</div>
	    <div class="col-md-2" style='margin-bottom:20px'><input type="text" class='form-control' name="mytext[]"></div>
	    <div class="col-md-1" style='margin-bottom:20px'>จำนวน</div>
	    <div class="col-md-1" style='margin-bottom:20px'><input type="text" class='form-control' name="mytext[]"></div>
	    <div class="col-md-1" style='margin-bottom:20px'>ราคา(หน่วย)</div>
	    <div class="col-md-2" style='margin-bottom:20px'><input type="text" class='form-control' name="mytext[]"></div>
	    <button class="add_field_button" style='margin-bottom:20px'>Add </button>
	</div>
	<p align='right'><button class='btn btn-sm btn-success'>เพิ่มรายการซื้อเข้า</button></p>
	</form>
  </div>
</div>

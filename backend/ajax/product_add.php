<?php
	session_start();
	include("../../include/function.php");
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
        $.ajax({
            type: 'POST',
            data: {product_type: document.getElementById('product_type').value},
            url: 'ajax/select_product_size.php?data=size',
            success: function(data) {$('#product_size1').html(data);$('#product_size2').html(data);$('#product_size3').html(data);$('#product_size4').html(data);$('#product_size5').html(data);}
        });
    	return false;
    });

    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
    	$.ajax({
            type: 'POST',
            data: {product_type: ""},
            url: 'ajax/select_product_size.php?data=type',
            success: function(data) {$('#product_type').html(data);}
        });
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(' <div class="remove col-md-12" style="margin-bottom:2px;padding:0px"><div class="col-md-10" style="padding:0"><p><select class="form-control" id="product_size'+x+'"  name="product_size[]"><option value="">--เลือกขนาดสินค้า--</option></select></p></div><button  class="remove_field btn btn-danger" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src="../images/icon/minus.png" width="12px" height="12px" ></button><div class="col-md-12" style="padding:0"></div><div class="col-md-4" style="padding:0;margin-bottom:4px">ราคาบนเว็บ</div><div class="col-md-6" style="padding:2px;;margin-bottom:4px"><input type="text" class="form-control" name="product_price_web[]" style="margin-top:-5px;"></div><div class="col-md-4" style="padding:0;margin-bottom:4px">ราคาในร้าน</div><div class="col-md-6" style="padding:2px;margin-bottom:4px"><input type="text" class="form-control" name="product_price_shop[]" style="margin-top:-5px;"></div></div></div></div></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('.remove').remove(); x--;
    })
});

</script>
<script>
$(document).ready(function() {
 	var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap2"); //Fields wrapper
    var add_button      = $(".add_field_button2"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(' <div class="remove2 col-md-12" style="margin-bottom:2px;padding:0px"><div class="col-md-10" style="padding:0"><input type="file" name="product_image[]"></div><button  class="remove_field2 btn btn-danger" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src="../images/icon/minus.png" width="12px" height="12px" ></button</div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field2", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('.remove2').remove(); x--;
    })
});
</script>
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
		    		<td width="25%"><p><b>ชื่อสินค้า</b></p></td>
		    		<td width="5%"><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td width="70%"><p><input class='form-control' type='text' name='product_name'></p></td>
		    	</tr>
		    	<tr>
		    		<td><p><b>ประเภทสินค้า</b></p></td>
		    		<td><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td>
<?php			$query_type=mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : product_add line 51");
				echo "<p><select class='form-control' id='product_type'  name='product_type'>";
				echo "<option value=''>--เลือกประเภทสินค้า--</option>";
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
<?php			
				echo "<p><select class='form-control' id='product_quality' name='product_quality'>";
		    		echo "<option value=''>--เลือกหมวดหมู่สินค้า--</option>";
		    	echo "</select></p>";
?>			    			
		    		</td>
		    	</tr>
		    	<tr>
		    		<td valign="top"><p><b>ขนาดสินค้า</b></p>&nbsp;&nbsp;เมื่อกดเครื่องหมายบวก ต้องทำการเลือกประเภทและหมวดหมู่ใหม่</td>
		    		<td valign="top"><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td>
		    		<div class="input_fields_wrap" >		
						<div class='col-md-10' style='padding:0'><p><select class='form-control' id='product_size1'  name='product_size[]'>
				    		<option value=''>--เลือกขนาดสินค้า--</option>
				    	</select></p></div>
				    	<button class="add_field_button btn btn-primary" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src='../images/icon/add.png' width="12px" height="12px" ></button>
				    	<div class='col-md-12' style='padding:0'>
							<div class='col-md-4' style='padding:0;margin-bottom:4px'>ราคาบนเว็บ</div>
							<div class='col-md-6' style='padding:2px;;margin-bottom:4px'><input type='text' class='form-control' name='product_price_web[]' style="margin-top:-5px;"></div>
							<div class='col-md-4' style='padding:0;margin-bottom:4px'>ราคาในร้าน</div>
							<div class='col-md-6' style='padding:2px;margin-bottom:4px'><input type='text' class='form-control' name='product_price_shop[]' style="margin-top:-5px;"></div>
						</div>
		    		</div>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td valign="top"><p><b>รายละเอียดสินค้า</b></p></td>
		    		<td valign="top"><p><b>&nbsp;:&nbsp;</b></p></td>
		    		<td><p><textarea class='form-control'  name='product_detail'></textarea></p></td>
		    	</tr>
		    	<tr>
			    	<td valign="top"><p><b>รูปภาพ</b></p></td>
		    		<td valign="top"><p><b>&nbsp;:&nbsp;</b></p></td>
			    	<td><p>
			    		<div class="input_fields_wrap2" >
			    			<div class="col-md-10" style="padding:0">
			    				<input type='file' name='product_image[]'>			    				
			    			</div>
			    			<button class="add_field_button2 btn btn-primary" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src='../images/icon/add.png' width="12px" height="12px" ></button>
			    		</div>
			    	</p></td>
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
			$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name FROM product  LEFT JOIN type ON product.product_type=type.product_type ORDER BY product.product_id DESC LIMIT 0,6")or die("ERROR : backend product_add line 178");
			while(list($product_id,$product_name,$product_type)=mysqli_fetch_row($query_product)){
				$query_images =mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'")or die("ERROR : backend product_add line 180");
				list($product_image)=mysqli_fetch_row($query_images);
				echo "<div class='col-md-6' style='margin-bottom:20px;'>";
					if(empty($product_image)){
						echo "<center><a  data-toggle='modal' data-target='#$product_id' style='cursor:pointer;text-decoration:none'><img src='../images/icon/no-images.jpg' width='100%' height='200px'><br><b>$product_name</b></a></center>";
					}else{
						echo "<center><a  data-toggle='modal' data-target='#$product_id' style='cursor:pointer;text-decoration:none'><img src='../images/$product_type/$product_image' width='100%' height='200px'><br><b>$product_name</b></a></center>";
					}
					echo "<div class='modal fade' id='$product_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
					  echo "<div class='modal-dialog modal-lg' role='document'>";
					    echo "<div class='modal-content'>";
					      echo "<div class='modal-header'>";
					        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
					        echo "<h4 class='modal-title' id='myModalLabel'><b>รายละเอียดข้อมูลสินค้า : </b>&nbsp;&nbsp;$product_name</h4>";
					      echo "</div>";
					      echo "<div class='modal-body'>";
					        $query_product_detail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_detail,quality.quality_name,product.product_stock FROM product LEFT JOIN quality ON product.product_quality = quality.product_quality WHERE product.product_id='$product_id'")or die("ERROR : product_function line 196");
							list($product_detail,$quality_name,$product_stock)=mysqli_fetch_row($query_product_detail);
							echo "<div class='container-fluid'>";
							    echo "<div class='col-md-5'style='margin-top:20px'>";
							    $query_images_detail = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'")or die("ERROR : product_function line 200");
							    $number_image=1;
							    while(list($product_image_detail)=mysqli_fetch_row($query_images_detail)){
							    	if($number_image==1){
							    	echo "<div class='col-md-12'>";
										echo "<img src='../images/$product_type/$product_image_detail' width='100%' height='350' style='border-radius:5px;'>";
									echo "</div>";
									$number_image++;
									}
									echo "<div class='col-md-3' style='padding:5px'>";
										echo "<img src='../images/$product_type/$product_image_detail' width='100%' height='75' style='border-radius:5px;'>";
									echo "</div>";
								}
							    echo "</div>";
							    echo "<div class='col-md-7'style='margin-top:20px'>";
							    	 echo "<table width='100%' >";
							      		echo "<tr>";
							      			echo "<td width='25%'><p><b>ชื่อสินต้า</b></p></td>";
							      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			echo "<td><p>$product_name</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td valign='top'><p><b>รายละเอียดสินค้า</b></p></td>";
							      			echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			$product_detail =(empty($product_detail))?"ไม่มีรายละเอียดของข้อมูลสินค้า":$product_detail;
							      			echo "<td><p>$product_detail</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td><p><b>ประเภทสินค้า</b></p></td>";
							      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			echo "<td><p>$product_type</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td><p><b>หมวดหมู่สินค้า</b></p></td>";
							      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			echo "<td><p>$quality_name</p></td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td valign='top'><p><b>ขนาดสินค้า</b></p></td>";
							      			echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			echo "<td>";
							      			$query_size =mysqli_query($_SESSION['connect_db'],"SELECT size.size_name,product_size.product_amount_keep,product_size.product_amount_shop,product_size.product_amount_web,product_size.product_price_shop,product_size.product_sprice_shop,product_size.product_price_web,product_size.product_sprice_web FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id ='$product_id'");
							      			$number=1;
							      			while(list($size_name,$product_amount_keep,$product_amount_shop,$product_amount_web,$product_price_shop,$product_sprice_shop,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size)){
							      				echo "<div class='col-md-12'><p><b>ขนาดสินที่ $number : </b> $size_name</p></div>";	
							      				echo "<div class='col-md-4' style='font-size:13px;'><p><b>ราคา(Batn)</b></p></div>";
							      				echo "<div class='col-md-6' style='font-size:13px;'><p>$product_price_web</p></div>";
							      				echo "<div class='col-md-4' style='font-size:13px;'><p><b>ราคา(Batn)</b></p></div>";
							      				echo "<div class='col-md-6' style='font-size:13px;'><p>$product_price_shop</p></div>";
							      				$number++;
							      			}
							      			echo "</td>";
							      		echo "</tr>";
							      		echo "<tr>";
							      			echo "<td><p><b>สถานะสินค้า</b></p></td>";
							      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
							      			$stock = (empty($product_stock))?"ไม่พร้อมจำหน่าย":"พร้อมจำหน่าย";
							      			echo "<td><p>$stock</p></td>";
							      		echo "</tr>";
							      	echo "</table>";
							    echo "</div>";
							echo "</div>";
					      echo "</div>";
					  echo "</div>";
					echo "</div>";
					echo "</div>";
				echo "</div>";
			}
?>
		  </div>
		</div>
	</div>
		
</form>
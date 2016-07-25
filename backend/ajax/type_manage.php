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
            $(wrapper).append(' <div class="remove" style="margin-bottom:2px"><div class="col-md-10" style="margin-bottom:2px;padding:0px;"><input type="text" class="form-control" name="unit_name[]"></div><button  class="remove_field btn btn-danger" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src="../images/icon/minus.png" width="12px" height="12px" ></button></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('.remove').remove(); x--;
    })

    
});
<?php	

echo "$(document).ready(function() {";
	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type FROM type")or die("ERROR : backend type_add line 42");
	while(list($product_type)=mysqli_fetch_row($query_type)){
		echo "$('.add_size_$product_type').click(function(){";
			echo "var new_size= document.getElementById('new_size_$product_type').value;";
	    	echo "window.location='ajax/function_size.php?data=insert_size&product_type=$product_type&new_size='+new_size;";
	    echo "});";
	}
echo "});";
/*

    var max_fields2      = 10; //maximum input boxes allowed
    var wrapper2        = $(".input_fields_wrap2"); //Fields wrapper
    var add_button2      = $(".add_field_button2"); //Add button ID
   	var x2 = 1;
    

	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type FROM type")or die("ERROR : backend type_add line 42");
	while (list($product_type)=mysqli_fetch_row($query_type)) {
		echo "$('#x_$product_type').click(function(){";
			echo "x2=document.getElementById('x_$product_type').value;";
		echo "});";
		echo "$('.remove_field2_$product_type"."_"."2').click(function(){";
	       echo " $('.remove2_$product_type"."_"."2').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."3').click(function(){";
	       echo " $('.remove2_$product_type"."_"."3').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."4').click(function(){";
	       echo " $('.remove2_$product_type"."_"."4').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."5').click(function(){";
	       echo " $('.remove2_$product_type"."_"."5').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."6').click(function(){";
	       echo " $('.remove2_$product_type"."_"."6').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."7').click(function(){";
	       echo " $('.remove2_$product_type"."_"."7').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."8').click(function(){";
	       echo " $('.remove2_$product_type"."_"."8').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."9').click(function(){";
	       echo " $('.remove2_$product_type"."_"."9').remove(); x--;";
	    echo "});";
		echo "$('.remove_field2_$product_type"."_"."10').click(function(){";
	       echo " $('.remove2_$product_type"."_"."10').remove(); x--;";
	    echo "});";
	}


    	
   	
    $(add_button2).click(function(e){ //on add input button click
        e.preventDefault();
       	//initlal text box count
        if(x2 < max_fields2){ //max input box allowed
            x2++; //text box increment
            $(wrapper2).append(' <div class="remove2" style="margin-bottom:2px"><div class="col-md-10" style="margin-bottom:2px;padding:0px;"><input type="text" class="form-control" name="unit_name[]"></div><button  class="remove_field2 btn btn-danger" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src="../images/icon/minus.png" width="12px" height="12px" ></button></div>'); //add input box
        }
    });
    
    $(wrapper2).on("click",".remove_field2", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('.remove2').remove(); x--;
    })
});
function hide_remover(){
	$('.remove2').hide();
}
*/
?>
function check_data(){	
	var eng =	/^([a-zA-Z])+$/;	
	if (!(eng.test(document.all.name_eng.value)))
	{
	swal("", "ชื่อประเภทสินค้า(ภาษาอังกฤษ) กรอกได้เฉพาะภาษาอังกฤษเท่านั้น","error");
	document.all.name_eng.select();
	return false;
	}
}
<?php
	$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type FROM type")or die("ERROR : backend type_add line 42");
	while(list($product_type)=mysqli_fetch_row($query_type)){
		echo "function check_data$product_type(){";	
			echo "var eng =	/^([a-zA-Z])+$/;";	
			echo "if (!(eng.test(document.all.name_eng$product_type.value)))";
			echo "{";
			echo "swal('', 'ชื่อประเภทสินค้า(ภาษาอังกฤษ) กรอกได้เฉพาะภาษาอังกฤษเท่านั้น','error');";
			echo "document.all.name_eng$product_type.select();";
			echo "return false;";
			echo "}";
		echo "}";
	}
?>

function delete_type(type_id){
	swal({
	  title: "ลบประเภทสินค้า",
	  text: "รายการที่เกี่ยวข้องจะถูกลบทั้งหมด คุณต้องการลบเลยใช่ไหม",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "ลบประเภทสินค้า",
	  cancelButtonText: "ยกเลิกการลบ",
	  closeOnConfirm: false
	},
	function(){
	  window.location = 'ajax/type_delete.php?delete_type_id='+type_id;
	});
}
function delete_size(ele){
	var size_id= ele.getAttribute("product_size");
	swal({
	  title: "ลบขนาดสินค้า",
	  text: "รายการที่เกี่ยวข้องจะถูกลบทั้งหมด คุณต้องการลบเลยใช่ไหม",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "ลบขนาดสินค้าสินค้า",
	  cancelButtonText: "ยกเลิกการลบ",
	  closeOnConfirm: false
	},
	function(){
	  window.location = 'ajax/function_size.php?data=delete_size&size_id='+size_id;
	});
}
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการสินค้า</a></li>
			<li><a href="#">จัดการประเภทสินค้า</a></li>

		</ol>
	</div>
</div>
<div class='col-md-6' style="margin-top:20px;">
	<form method="post" action="ajax/type_insert.php" onsubmit="return check_data()">
	<div class="panel panel-default">
	  <div class="panel-heading"><h3>ฟอร์มเพิ่มประเภทสินค้า</h3></div>
	  <div class="panel-body">
	    <table width="100%">
	    	<tr>
	    		<td width="50%"><p align='right'><b>ชื่อประเภทสินค้า : &nbsp;&nbsp;</b></p></td>
	    		<td><input class='form-control' type='text' name='type_name' required></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2"><font color='red'> *** </font>กรุณากรอกเป็นภาษาอังกฤษเท่านั้น เพราะใช้สำหรับตั้งชื่อโฟลเดอร์<font color='red'> *** </font></td>
	    	</tr>
	    	<tr>
	    		<td width="50%"><p align='right'><b>ชื่อประเภทสินค้า(ภาษาอังกฤษ) : &nbsp;&nbsp;</b></p></td>
	    		<td><input class='form-control' type='text' id='name_eng' name='type_name_eng' required></td>
	    	</tr>
	    	<tr>
	    		<td width="50%" valign='top'><p align='right'><b>ขนาดประเภทสินค้า : &nbsp;&nbsp;</b></p></td>
	    		<td>
	    			<div class="input_fields_wrap" >
					    <div class="col-md-10" style='margin-bottom:2px;padding:0px;'><input type="text" class='form-control' name="unit_name[]"></div>
					    <button class="add_field_button btn btn-primary" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src='../images/icon/add.png' width="12px" height="12px" ></button>
					</div>
	    		</td>
	    	</tr>
	    </table>
	    <p align="right" style="margin-top:10px;"><input class='btn btn-sm btn-success' type='submit' value="เพิ่มประเภทสินค้า"></p>
	  </div>
	</div>
	</form>
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
				$query_size = mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id ='$product_type'")or die("ERROR : backend type_edit line 103");
				$rows = mysqli_num_rows($query_size);
				echo "<b><button class='btn btn-info btn-sm' type='button' data-toggle='modal' id='x_$product_type' onclick='hide_remover()' value='$rows' data-target='#$product_type'>แก้ไขข้อมูล</button></b>";
				echo "<form method='post' action='ajax/type_update.php' onsubmit=\"return check_data$product_type()\">";
				echo "<div class='modal fade' id='$product_type' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
				  echo "<div class='modal-dialog' role='document'>";
				    echo "<div class='modal-content'>";
				      echo "<div class='modal-header'>";
				        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
				        echo "<h4 class='modal-title' id='myModalLabel'>แก้ไขประเภท$type_name</h4>";
				      echo "</div>";
				      echo "<div class='modal-body'>";
				        echo "<table align='center' width='100%'>";
					    	echo "<tr>";
					    	$query_typeanme = mysqli_query($_SESSION['connect_db'],"SELECT type_name,type_name_eng FROM type WHERE product_type ='$product_type'")or die("ERROR : backend type_edit line 95");
					    	list($type_name,$type_name_eng)=mysqli_fetch_row($query_typeanme);
					    		echo "<td width='35%'><p align='right'><b>ชื่อประเภทสินค้า : &nbsp;&nbsp;</b></p></td>";
					    		echo "<td><input class='form-control' type='text' name='type_name' value='$type_name' required></td>";
					    	echo "</tr>";
					    	echo "<tr>";
					    		echo "<td width='35%'><p align='right'><b>ชื่อประเภทสินค้า(อังกฤษ) : &nbsp;&nbsp;</b></p></td>";
					    		echo "<td><input class='form-control' type='text' name='type_name_eng' id='name_eng$product_type' value='$type_name_eng' required></td>";
					    	echo "</tr>";
					    	echo "<tr>";
					    		echo "<td valign='top'><p align='right'><b>ขนาดประเภทสินค้า : &nbsp;&nbsp;</b></p></td>";
					    		echo "<td>";
					    			echo "<div class='input_fields_wrap2' >";
					    			//$num=1;
					    			if(empty($rows)){
					    				echo "<input type='text' class='form-control' id='new_size_$product_type' name='unit_name' value=''>";
					    			}else{
						    			while(list($product_size,$size_name)=mysqli_fetch_row($query_size)){
						    				/*
						    				if($num==1){
						    					
						    					echo "<div class='col-md-10' style='margin-bottom:2px;padding:0px;'><input type='text' class='form-control' name='unit_name[]' value='$size_name'></div>";
						    					echo "<button class='add_field_button2 btn btn-primary' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/add.png' width='12px' height='12px' ></button>";
						    				}else{
						    					echo "<div class='remove2_$product_type"."_"."$num' style='margin-bottom:2px'><div class='col-md-10' style='margin-bottom:2px;padding:0px;'><input type='text' class='form-control' name='unit_name[]' value='$size_name'></div><button  class='remove_field2_$product_type"."_"."$num btn btn-danger' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/minus.png' width='12px' height='12px' ></button></div>";
						    				}
						    				$num++;
						    				echo "<input type='hidden' name='size_id[]' value='$product_size'>";
						    				*/
						    				echo "<input type='hidden' name='size_id[]' value='$product_size'>";
						    				echo "<div style='margin-bottom:2px'><div class='col-md-10' style='margin-bottom:2px;padding:0px;'><input type='text' class='form-control' id='size_name_new' name='unit_name_have[]' value='$size_name' disabled></div><button type='button' class='btn btn-danger' onclick=\"delete_size(this)\"  product_size='$product_size' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/minus.png' width='12px' height='12px' ></button></div>";
						    			}
						    			if($rows<10){
						    				echo "<tr>";
									    		echo "<td width='35%'><p align='right'><b>เพิ่มขนาด : &nbsp;&nbsp;</b></p></td>";
									    		echo "<td><input type='text' class='form-control' id='new_size_$product_type' name='unit_name' value=''></td>";
									    	echo "</tr>";
						    				//echo "<div style='margin-bottom:2px'><div class='col-md-12' style='margin-bottom:2px;padding:0px;'><input type='text' class='form-control' id='new_size_$product_type' name='unit_name' value=''></div><!--<button type='button' class='btn btn-primary add_size_$product_type' style='padding:0px 3px;width:27px;height:27px;margin-bottom:2px'><img src='../images/icon/add.png' width='12px' height='12px' ></button>--></div>";
						    			}
					    			}
					    			echo "</div>";
					    		echo "</td>";
					    		echo "<input type='hidden' name='type_id' value='$product_type'>";
					    	echo "</tr>";
					    echo "</table>";
				      echo "</div>";
				      echo "<div class='modal-footer'>";
				      	echo "<button type='submit' class='btn btn-primary'>แก้ไขประเภทสินค้า</button>";
				        echo "<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>";
				      echo "</div>";
				    echo "</div>";
				  echo "</div>";
				echo "</div>";
				echo "</form>";
			echo "</div>";
			echo "<div class='col-md-3' style='margin-bottom:20px;'>";
				echo "<b><a onclick=\"delete_type($product_type)\"><button class='btn btn-danger btn-sm' type='button'>ลบข้อมูล</button></a></b>";
			echo "</div>";
		}
?>
	  </div>
	</div>
</div>

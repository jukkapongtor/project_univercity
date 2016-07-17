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
            $(wrapper).append(' <div class="remove" style="margin-bottom:20px"><div class="col-md-2" style="padding-bottom:10px;">ชื่อวัสดุ</div><div class="col-md-4" style="padding-bottom:10px;"><input type="text" class="form-control" name="supply_name[]"></div><div class="col-md-2" style="padding-bottom:10px;">ราคา(หน่วย)</div><div class="col-md-4" style="padding-bottom:10px;"><input type="text" class="form-control" onkeyup="cal'+(x+1)+'()" id="supply_price'+(x+1)+'" name="supply_price[]"></div><div class="col-md-2" style="padding-bottom:10px;">จำนวน</div><div class="col-md-4" style="padding-bottom:10px;"><input type="text" class="form-control" onkeyup="cal'+(x+1)+'()" id="supply_amount'+(x+1)+'" name="supply_amount[]"></div><div class="col-md-2" style="padding-bottom:10px;">หน่วย</div><div class="col-md-4" style="padding-bottom:10px;"><input type="text" class="form-control" name="supply_unit[]"></div><div class="col-md-2" style="padding-bottom:10px;">ราคารวม</div><div class="col-md-8" style="padding-bottom:10px;"><input type="text" class="form-control" id="total_price'+(x+1)+'" disabled></div><button  class="remove_field btn btn-danger" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src="../images/icon/minus.png" width="12px" height="12px" ></button></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('.remove').remove(); x--;
    })
});
</script>
<?php
echo "<script>";
	for($i=1;$i<10;$i++){
		echo "function cal$i(){";
			echo "var pirce = document.getElementById('supply_price$i').value;";
			echo "var amount = document.getElementById('supply_amount$i').value;";
			echo "var sum = pirce * amount;";
			echo "document.getElementById('total_price$i').value=sum;";
		echo "}";
	}

echo "</script>";
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการค่าใช้จ่าย</a></li>
			<li><a href="#">วัสดุสิ้นเปลือง</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>เพิ่มซื้อเข้าวัสดุสิ้นเปลือง</b></h3>
	  </div>
	  <div class="panel-body">
	<?php
		$date = date("Y-m-d");
	?>
	  <p><b>เพิ่มซื้อเข้าวัสดุสิ้นเปลืองประจำวันที่ : </b><?php echo "$date"; ?></p>
	  	<form action="ajax/supplyes_update.php" method="post">
	  		<div class="input_fields_wrap" >
	  			<div class="col-md-2" style="padding-bottom:10px;">ชื่อวัสดุ</div>
	  			<div class="col-md-4" style="padding-bottom:10px;"><input type="text" class='form-control' name="supply_name[]"></div>
	  			<div class="col-md-2" style="padding-bottom:10px;">ราคา(หน่วย)</div>
	  			<div class="col-md-4" style="padding-bottom:10px;"><input type="text" class='form-control' onkeyup="cal1()" id='supply_price1' name="supply_price[]"></div>
	  			<div class="col-md-2" style="padding-bottom:10px;">จำนวน</div>
	  			<div class="col-md-4" style="padding-bottom:10px;"><input type="text" class='form-control' onkeyup="cal1()" id='supply_amount1' name="supply_amount[]"></div>
	  			<div class="col-md-2" style="padding-bottom:10px;">หน่วย</div>
	  			<div class="col-md-4" style="padding-bottom:10px;"><input type="text" class='form-control' name="supply_unit[]"></div>
	  			<div class="col-md-2" style="padding-bottom:10px;">ราคารวม</div>
	  			<div class="col-md-8" style="padding-bottom:10px;"><input type="text" class='form-control' id='total_price1' value="0" disabled></div>
	  			<div class="col-md-2" style="padding-bottom:10px;padding-left:0px"><button class="add_field_button btn btn-primary" style="padding:0px 3px;width:27px;height:27px;margin-bottom:2px"><img src='../images/icon/add.png' width="12px" height="12px" ></button></div>
	  		</div>
		<p align='right'><button class='btn btn-sm btn-success'>เพิ่มรายการซื้อเข้า</button></p>
		</form>
	  </div>
	</div>	
</div>
<div class="col-md-6">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>รายการซื้อเข้าวัสดุสิ้นเปลือง</b></h3>
	  </div>
	  <div class="panel-body">
<?php
		echo "<p>รายการที่ซื้อเข้าวัสดุสิ้นเปลืองย้อนหลัง 3 วัน</p>";
		$date5day = array();
		$query_sup5day =  mysqli_query($_SESSION['connect_db'],"SELECT supply_date FROM buy_supply GROUP BY DATE(supply_date) ORDER BY DATE(supply_date) DESC LIMIT 0,3")or die("ERROR : supply manage line 91");
		while (list($supply_date)=mysqli_fetch_row($query_sup5day)) {
			$supply_date =substr($supply_date, 0,10);
			array_push($date5day, $supply_date);
		}
		foreach ($date5day as $key => $value) {
			echo "<b>รายการที่ซื้อเข้าวัสดุสิ้นเปลืองวันที่ : </b>$value";
			echo "<table class='table table-hover table-striped table-bordered'>";
			echo "<tr><th><center>ลำดับ</th><th><center>ชื่อวัสดุ</th><th><center>ราคา</th><th><center>จำนวน(หน่วย)</th><th><center>ราคาทั้งหมด</th></tr>";
			$query_buysupply = mysqli_query($_SESSION['connect_db'],"SELECT * FROM buy_supply WHERE DATE(supply_date)='$value'")or die("ERROR : supply manage line 89");
			$number=1;
			while(list($buy_id,$supply_name,$supply_amount,$supply_price,$supply_unit,$supply_date)=mysqli_fetch_row($query_buysupply)){
				echo "<tr>";
					echo "<td align='center' width='10%'>$number</td>";
					echo "<td width='25%'>$supply_name</td>";
					echo "<td align='right' width='20%'>".number_format($supply_price,2)." ฿</td>";
					echo "<td width='20%'>$supply_amount $supply_unit</td>";
					$sum = $supply_price * $supply_amount;
					echo "<td align='right'>".number_format($sum,2)." ฿</td>";
					$number++;
				echo "</tr>";
			}
			echo "</table>";
		}
		
?>
	  </div>
	</div>	
</div>

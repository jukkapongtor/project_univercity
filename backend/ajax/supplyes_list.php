<?php
	session_start();
	include("../../include/function.php");
	date_default_timezone_set('Asia/Bangkok');
	connect_db();

?>
<script>
$(document).ready(function() {	
  $("#send_date").click(function(){
  	var year = document.getElementById("select_year").value;
  	var month = document.getElementById("select_month").value;
  	$.post('ajax/function_supply.php?data=select_supply',{year:year,month:month},function(data){
  		$('.list_supply').html(data);
    });
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
			<li><a href="#">รายการค่าใช้จ่าย</a></li>
		</ol>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>เลือกช่วงเวลาในการดูค่าใช้จ่าย</b></h3>
	  </div>
	  <div class="panel-body">
	  	<table width="60%" align="center">
	  		<tr>
	  			<td width="10%"><p><b>เลือกปี : </b></p></td>
	  			<td><p>
	  				<select class="form-control" id='select_year'>
	  				<?php
	  					$query_month=mysqli_query($_SESSION['connect_db'],"SELECT YEAR(supply_date) FROM buy_supply GROUP BY YEAR(supply_date)")or die("ERROR : supplys list line 33");
	  					while(list($year)=mysqli_fetch_row($query_month)){
	  						$selected = ($year==date("Y"))?"selected='selected'":"";
	  						echo "<option value='$year' $selected>$year</option>";
	  					}
	  				?>
	  				</select>
	  			</p></td>
	  			<td width="15%"><p><b>&nbsp;&nbsp;เลือกเดือน : </b></p></td>
	  			<td><p>
	  				<select class="form-control" id='select_month'>
	  				<?php
	  					$query_month=mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : supplys list line 33");
	  					$month ="";
	  					while(list($month_id,$month_name)=mysqli_fetch_row($query_month)){
	  						$selected = ($month_id==date("m"))?"selected='selected'":"";
	  						echo "<option value='$month_id' $selected>$month_name</option>";
	  						if($month_id==date("m")){
	  							$month = $month_name;
	  						}
	  					}
	  				?>
	  				</select>
	  			</p></td>
	  			<td><p><button class="btn btn-sm btn-primary" id='send_date' style="padding:0px 5px;margin-top:10px">ส่งค่า</button></p></td>
	  		</tr>
	  	</table>
	  </div>
	</div>	
</div>
<div class="col-md-12 list_supply">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>รายการค่าใช้จ่ายในเดือน <?php echo "$month ปี ".date("Y");?> </b></h3>
	  </div>
	  <div class="panel-body">
<?php
		$date5day = array();
		$query_sup5day =  mysqli_query($_SESSION['connect_db'],"SELECT  DATE(supply_date),SUM(supply_price*supply_amount) FROM buy_supply WHERE MONTH(supply_date)='".date("m")."' AND YEAR(supply_date)='".date("Y")."' GROUP BY DATE(supply_date) ORDER BY DATE(supply_date) DESC")or die("ERROR : supply manage line 91");
		$rows = mysqli_num_rows($query_sup5day);
        if($rows>0){
		echo "<table class='table table-hover table-striped table-bordered'>";
		echo "<tr><th width='10%'><center>ลำดับ</th><th width='80%'><center>รายการ</th><th width='10%'><center>ราคารวม</th></tr>";
		$number = 1;
		$total =0;
		while (list($supply_date,$sum_price)=mysqli_fetch_row($query_sup5day)) {
			echo "<tr>";
					$day = substr($supply_date, 8,2);
					//$month = substr($supply_date, 6,2);
					$year = substr($supply_date, 0,4);
					echo "<td align='center' width='10%'>$number</td>";
					echo "<td width='25%'><a data-toggle='modal' data-target='#$day' style='text-decoration:none;cursor:pointer'>ค่าใช้จ่ายประจำวันที่ $day $month $year</a>";
?>
							<div class="modal fade" id="<?php echo "$day";?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
							  <div class="modal-dialog" role="document" style='margin-top:100px;'>
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel"><?php echo "ค่าใช้จ่ายประจำวันที่ $day $month $year";?></h4>
							      </div>
							      <div class="modal-body">
<?php
										echo "<table class='table table-hover table-striped table-bordered'>";
											echo "<tr><th><center>ลำดับ</th><th><center>รายการ</th><th><center>ราคา</th><th><center>จำนวน(หน่วย)</th><th><center>ราคาทั้งหมด</th></tr>";
											$query_buysupply = mysqli_query($_SESSION['connect_db'],"SELECT * FROM buy_supply WHERE MONTH(supply_date)='".date("m")."' AND YEAR(supply_date)='".date("Y")."' AND DAY(supply_date)='$day'")or die("ERROR : supply manage line 89");
											$number=1;
											$total_detail=0;
											while(list($buy_id,$supply_name,$supply_amount,$supply_price,$supply_unit,$supply_date)=mysqli_fetch_row($query_buysupply)){
												echo "<tr>";
													echo "<td align='center' width='10%'>$number</td>";
													echo "<td width='25%'>$supply_name</td>";
													echo "<td align='right' width='20%'>".number_format($supply_price,2)." ฿</td>";
													echo "<td width='20%'>$supply_amount $supply_unit</td>";
													$sum = $supply_price * $supply_amount;
													echo "<td align='right'>".number_format($sum,2)." ฿</td>";
													$number++;
													$total_detail+=$sum;
												echo "</tr>";
											}
											echo "<tr><td colspan='4' align='right'>รวมค่าใช้จ่ายทั้งหมด</td><td align='right'>".number_format($total_detail,2)." ฿</td></tr>";
											echo "</table>";
?>
							      </div>
							    </div>
							  </div>
							</div>
<?php
					echo "</td><td align='right'>".number_format($sum_price,2)." ฿</td>";
					$total +=$sum_price;
			echo "</tr>";
			$number++;
		}
		echo "<tr><td colspan='2' align='right'>รวมค่าใช้จ่ายทั้งหมด</td><td align='right'>".number_format($total,2)." ฿</td></tr>";
		echo "</table>";
		}else{
            echo "<center><h3><font color='red'> !!! </font>ไม่พบรายการค่าใช้จ่าย<font color='red'> !!! </font></h3></center>";
        }
?>
	  </div>
	</div>	
</div>

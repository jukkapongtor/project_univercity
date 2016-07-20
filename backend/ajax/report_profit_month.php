<?php
	session_start();
	date_default_timezone_set('Asia/Bangkok');
	include("../../include/function.php");
	connect_db();
?>
<script>
$(document).ready(function(){
	$("#select_date").click(function(){
		var year = document.getElementById("select_year").value;
		var month = document.getElementById("select_month").value;
		$.post('ajax/function_report_profit.php?data=report_profit_day',{year:year,month:month},function(data){
			$('#report_profit_month').html(data);	  		
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
			<li><a href="#">รายงานผลกำไรขาดทุน</a></li>
			<li><a href="#">ผลกำไรขาดทุนรายเดือน</a></li>
		</ol>
	</div>
</div>
<div class='panel panel-info'>
		  <div class='panel-heading'>
		    <h2 class='panel-title'><b>เลือกช่วงเวลาในการดูรายการผลกำไรรายเดือน</b></h2>
		  </div>
		  <div class='panel-body'>
		  	<b><h5>เลือกช่วงเวลา</h5></b>
			<div class="col-md-7">
				<table width="100%">
					<tr>
						<th width="10%">เลือกปี</th><th width="5%">&nbsp;:&nbsp;</th>
						<td>
							<select class='form-control' id='select_year'>
<?php
								$query_orders = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(order_date) FROM orders GROUP BY YEAR(order_date)")or die("ERROR : report  sell product month line 35");
								$query_product_supply = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(supply_date) FROM buy_supply GROUP BY YEAR(supply_date)")or die("ERROR : report  sell product month line 35");
								$select_year = array();
								while (list($year_oreder)=mysqli_fetch_row($query_orders)) {
									array_push($select_year, $year_oreder);
								}
								while (list($year_oreder)=mysqli_fetch_row($query_product_supply)) {
									array_push($select_year, $year_oreder);
								}
								$year = date("Y");
								$select_year = array_unique($select_year);
								sort($select_year);
								foreach ($select_year as  $value) {
									$selected = ($year==$value)?"selected='selected'":"";
									echo "<option value='$value' $selected>$value</option>";
								}
?>
							</select>
						</td>
						<th width="15%">&nbsp;&nbsp;เลือกเดือน</th><th width="5%">&nbsp;:&nbsp;</th>
						<td>
							<select class='form-control' id='select_month'>
<?php
								$query_month = mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : report  sell product month line 47");
								while (list($month_id,$month_name)=mysqli_fetch_row($query_month)) {
									$selected = ($month_id== date("m"))?"selected='selected'":"";
									echo "<option value='$month_id' $selected>$month_name</option>";
								}
?>
							</select>
						</td>
						<td>
							&nbsp;&nbsp;<input type="submit" id='select_date' class="btn btn-sm btn-success" value="ตกลง" style="padding:0px 5px;margin-top:10px;">
						</td>
					</tr>
				</table>
			</div>
		  </div>
		</div>
</div>

<div class="container-fluid">
	<div id="chartContainer" style="height: 300px; width: 100%;">
		<script>
			  	var month = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
			  	<?php
			  		
			  		$month2 = ($year%4==0)?29:28;
			  		$amount_day = array('31',$month2,'31','30','31','30','31','31','30','31','30','31');
			  	?>
			  	var index =parseInt(document.getElementById("select_month").value)-1;
			  	var now_month = month[index];
			    var chart = new CanvasJS.Chart("chartContainer",
			    {
			      title:{
			        text: "รายงานผลกำไรขาดทุนประจำเดือน " +now_month+" ปี "+<?php echo "$year";?>   
			      },
			      animationEnabled: true,
			      axisY: {
			        title: ""
			      },
			      toolTip: {
					shared: true
				  },
			      legend: {
			        verticalAlign: "bottom",
			        horizontalAlign: "center"
			      },
			      theme: "theme1",
			      data: [

			      {        
			        type: "spline",
			        name: 'ยอดการขาย',
			        legendText: "ยอดการขาย",
					showInLegend: true,   
			        dataPoints: [   
			        <?php
			        	for($i=1;$i<=$amount_day[date("m")-1];$i++){
			        		$quer_orders = mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_price) FROM orders WHERE MONTH(order_date)='".date("m")."' AND YEAR(order_date)='$year' AND DAY(order_date)='$i' AND (order_status='3' OR order_status='4')")or die("ERROR report buy month line 96");
			        		list($total_price)=mysqli_fetch_row($quer_orders);
			        		$total_price = (empty($total_price))?0:$total_price;
			        		echo "{y: $total_price,label: 'วันที่ $i'},";
			        		$report_sell[$i]=$total_price;
			        	}
			        ?> 
			            
			        ]
			      },
			      {        
			        type: "spline",
			        name: 'ยอดค่าใช้จ่าย',
			        legendText: "ยอดค่าใช้จ่าย",
					showInLegend: true,   
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=$amount_day[date("m")-1];$i++){
			        		/*$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='".date("m")."' AND YEAR(product_buy_date)='$year' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 96");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);*/

			        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price*supply_amount) FROM buy_supply WHERE MONTH(supply_date)='".date("m")."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 98");
			        		list($supply_price)=mysqli_fetch_row($quer_buy_supply);
			        		//$sum = $supply_price + $product_buy_price;
			        		$supply_price = (empty($supply_price))?0:$supply_price;
			        		echo "{y: $supply_price,label: 'วันที่ $i'},";
			        		$report_buy[$i]=$supply_price;
			        	}
			        ?>   
			        ]
			      },
			      {        
			        type: "spline",
			        name: 'ผลกำไรขาดทุน',
			        legendText: "ผลกำไรขาดทุน",
					showInLegend: true,   
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=$amount_day[date("m")-1];$i++){
			        		$total = $report_sell[$i] - $report_buy[$i];
			        		$total = (empty($total))?0:$total;
			        		echo "{y: $total,label: 'วันที่ $i'},";
			        	}
			        ?>    
			        ]
			      }     
			      ]
			    });

			    chart.render();
		</script>
	</div>

	<div id='report_profit_month'>
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<table class="table table-hover table-striped">
			<thead>
				<tr><th><center>ลำดับ</th><th><center>รายการ</center></th><th><center>ยอดขาย</th><th><center>ยอดซื้อ</th><th><center>ผลกำไรขาดทุน</th></tr>
			</thead>
			<tbody>
			<?php
				for($i=1;$i<=$amount_day[date("m")-1];$i++){
					echo "<tr>";
						echo "<td align='center'>$i</td>";
						echo "<td>";
							echo "<a style='text-decoration: none;cursor:pointer' data-toggle='modal' data-target='#$i'>ผลกำไรขาดทุนประจำวันที่ $i</a></center>";
						echo "</td>";
						echo "<td align='right'>".number_format($report_sell[$i],2)." ฿</td>"; 
						echo "<td align='right'>".number_format($report_buy[$i],2)." ฿</td>"; 
						echo "<td align='right'>".number_format(($report_sell[$i]-$report_buy[$i]),2)." ฿</td>";
						echo "</tr>";
			
				}
			?>
			</tbody>
		</table>
		</div>
	<div class="col-md-2"></div>
	</div>
</div>
<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	date_default_timezone_set('Asia/Bangkok');
?>
<script>
	$(document).ready(function() {
		$("#select_date").click(function(){
			var year = document.getElementById("select_year").value;
			$.post('ajax/function.php?data=report_sell_month',{year:year},function(data){
				if(data=="<center><h3 style='margin-top:50px;'><font color='red'>!!! </font>กรุณาเลือกข้อมูลในการแสดง ก่อนกดปุ่ม \"ตกลง\" <font color='red'> !!! </font></h3></center>"){
					$('#chartContainer').hide();
		  			$('#report_year').html(data);
				}else{
					$('#chartContainer').show();
		  			$('#report_year').html(data);
		  		}
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
			<li><a href="#">รายงานการขายสินค้า</a></li>
			<li><a href="#">รายงานการขายรายปี</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
<div class='panel panel-info'>
		  <div class='panel-heading'>
		    <h2 class='panel-title'><b>เลือกช่วงเวลาในการดูรายการขายรายเดือน</b></h2>
		  </div>
		  <div class='panel-body'>
		  	<b><h5><b>เลือกช่วงเวลา</b></h5></b>
			<div class="col-md-7">
				<p><font color="red">***</font> ระบบจะให้เลือกปีทำหรับปีที่มีการขาย <font color="red">***</font></p>
				<table width="100%">
					<tr>
						<th width="10%">เลือกปี</th><th width="5%">&nbsp;:&nbsp;</th>
						<td>
							<select class='form-control' id='select_year'>
<?php
								$query_year_order = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(order_date) FROM orders GROUP BY YEAR(order_date)")or die("ERROR : report  sell product month line 35");
								while (list($year_oreder)=mysqli_fetch_row($query_year_order)) {
									echo "<option value='$year_oreder'>$year_oreder</option>";
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
<?php
		$month = date("m");
		$year = date("Y");
		$feb = ($year%4==0)?29:28;
		$day =array("01"=>31,"02"=>$feb,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);
	$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : report_sell_day line 185");
	while (list($month_id,$month_name)=mysqli_fetch_row($query_report_month)) {
		$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_date,SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 47");
		list($date,$total_amount,$total_price)=mysqli_fetch_row($query_order_detail);
		$repot_month[]=array("month_name"=>"$month_name","total_price"=>"$total_price");

		$query_order_detail_shop =mysqli_query($_SESSION['connect_db'],"SELECT order_date,SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4')AND type_order='shop'")or die("ERROR : report_sell_day line 47");
		list($date_shop,$total_amount_shop,$total_price_shop)=mysqli_fetch_row($query_order_detail_shop);
		$repot_month_shop[]=array("month_name"=>"$month_name","total_price"=>"$total_price_shop");
	}
	echo "var chart = new CanvasJS.Chart('chartContainer', {";
		echo "title:{"; 
			echo "text: 'รายงานการขายปี $year'  ";             
		echo "},";
		echo "axisY: {";
        echo "title: \"ยอดขาย\"";
      	echo "},";
      	echo "animationEnabled: true,"; 
		echo "data: [   ";           
			echo "{";
				echo "type: 'column',";		
				
				echo "legendText: \"ยอดขายบนเว็บไซต์\",";
				echo "showInLegend: true,";
				echo "dataPoints: [";	

				foreach ($repot_month as $key => $value) {
					$value['total_price'] = (empty($value['total_price']))?0:$value['total_price'];
					echo "{ label: '$value[month_name]',  y: $value[total_price]  },";
				}
				echo "]";
			echo "},";
			echo "{";
				echo "type: 'column',";
				echo "legendText: \"ยอดขายในร้าน\",";
				echo "showInLegend: true,";		
				echo "dataPoints: [";

				foreach ($repot_month_shop as $key => $value) {
					$value['total_price'] = (empty($value['total_price']))?0:$value['total_price'];
					echo "{ label: '$value[month_name]',  y: $value[total_price]  },";
				}
				echo "]";
			echo "}";
			echo "]";
	echo "});";
	echo "chart.render();";
	
?>
	</script>
	</div>
	<div id='report_year'>
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<table class="table table-hover table-striped">
				<thead>
					<tr><th>ลำดับ</th><th><center>รายการ</center></th><th><center>จำนวน(หน้าร้าน)</th><th><center>ยอดขาย(หน้าร้าน)</th><th><center>จำนวน(เว็บไซต์)</th><th><center>ยอดขาย(เว็บไซต์)</th></tr>
				</thead>
				<tbody>
<?php
					$query_name_month =mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : report_sell_day line 185");
					while (list($month_id,$month_name)=mysqli_fetch_row($query_name_month)) {
						echo "<tr>";
							echo "<td><center>$month_id</center></td>";
							echo "<td>รายงานเดือน $month_name</td>";
							$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : function line 222");
							list($total_amount,$total_price)=mysqli_fetch_row($query_report_month);
							$total_amount = (empty($total_amount))?0:$total_amount;
							$total_price = (empty($total_price))?0:$total_price;
							echo "<td align='right'>".number_format($total_amount)."</td>";
							echo "<td align='right'>".number_format($total_price,2)." ฿</td>";
							$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : function line 222");
							list($total_amount,$total_price)=mysqli_fetch_row($query_report_month);
							$total_amount = (empty($total_amount))?0:$total_amount;
							$total_price = (empty($total_price))?0:$total_price;
							echo "<td align='right'>".number_format($total_amount)." </td>";
							echo "<td align='right'>".number_format($total_price,2)." ฿</td>";
						echo "</tr>";
					}
?>
				</tbody>
			</table>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
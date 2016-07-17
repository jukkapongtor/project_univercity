<?php
	session_start();
	date_default_timezone_set('Asia/Bangkok');
	include("../../include/function.php");
	connect_db();

?><div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">รายงานการซื้อสินค้า</a></li>
			<li><a href="#">รายงานการซื้อรายเดือน</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<div class='panel panel-info'>
		  <div class='panel-heading'>
		    <h2 class='panel-title'><b>เลือกช่วงเวลาในการดูรายการซื้อรายเดือน</b></h2>
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
								$query_year_order = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(order_date) FROM orders GROUP BY YEAR(order_date)")or die("ERROR : report  sell product month line 35");
								while (list($year_oreder)=mysqli_fetch_row($query_year_order)) {
									echo "<option value='$year_oreder'>$year_oreder</option>";
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
			  		$year = date("Y");
			  		$month2 = ($year%4==0)?29:28;
			  		$amount_day = array('31','$month2','31','30','31','30','31','31','30','31','30','31');
			  	?>
			  	var index =parseInt(document.getElementById("select_month").value)-1;
			  	var now_month = month[index];
			    var chart = new CanvasJS.Chart("chartContainer",
			    {
			      title:{
			        text: "รายงานการซื้อประจำเดือน " +now_month   
			      },
			      animationEnabled: true,
			      axisY: {
			        title: "ยอดการซื้อ"
			      },
			      legend: {
			        verticalAlign: "bottom",
			        horizontalAlign: "center"
			      },
			      theme: "theme1",
			      data: [

			      {        
			        type: "column",  
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=$amount_day[date("m")-1];$i++){
			        		$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM(product_buy_price) FROM buy_product WHERE MONTH(product_buy_date)='7' AND YEAR(product_buy_date)='2016' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 96");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);
			        		$product_buy_price = (empty($product_buy_price))?0:$product_buy_price;
			        		echo "{y: $product_buy_price,label: '$i'},";
			        	}
			        ?>    
			        ]
			      }   
			      ]
			    });

			    chart.render();
		</script>
	</div>
	<div id='report_month'></div>
</div>
<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'report_profit_day':
?>
		<script>
		  	var month = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
		  	<?php
		  		$year = $_POST['year'];  		
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
			      legend: {
			        verticalAlign: "bottom",
			        horizontalAlign: "center"
			      },
			      theme: "theme1",
			      data: [

			      {        
			        type: "spline",
			        legendText: "ยอดการขาย",
					showInLegend: true,   
			        dataPoints: [   
			        <?php
			        	for($i=1;$i<=$amount_day[$_POST['month']-1];$i++){
			        		$quer_orders = mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_price) FROM orders WHERE MONTH(order_date)='$_POST[month]' AND YEAR(order_date)='$year' AND DAY(order_date)='$i'")or die("ERROR report buy month line 96");
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
			        legendText: "ยอดการซื้อ",
					showInLegend: true,   
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=$amount_day[$_POST['month']-1];$i++){
			        		$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='$_POST[month]' AND YEAR(product_buy_date)='$year' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 96");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);

			        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price) FROM buy_supply WHERE MONTH(supply_date)='$_POST[month]' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i' AND (order_status='3' OR order_status='4')")or die("ERROR report buy month line 98");
			        		list($supply_price)=mysqli_fetch_row($quer_buy_supply);
			        		$sum = $supply_price + $product_buy_price;
			        		$sum = (empty($sum))?0:$sum;
			        		echo "{y: $sum,label: 'วันที่ $i'},";
			        		$report_buy[$i]=$sum;
			        	}
			        ?>   
			        ]
			      },
			      {        
			        type: "spline",
			        legendText: "ผลกำไรขาดทุน",
					showInLegend: true,   
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=$amount_day[$_POST['month']-1];$i++){
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
<?php
	break;
	case 'report_profit_month':
	$year = $_POST['year'];
?>
		<script>
			    var chart = new CanvasJS.Chart("chartContainer",
			    {
			      title:{
			        text: "รายงานผลกำไรขาดทุนประจำปี "+<?php echo "$year";?>   
			      },
			      animationEnabled: true,
			      axisY: {
			        title: ""
			      },
			      legend: {
			        verticalAlign: "bottom",
			        horizontalAlign: "center"
			      },
			      theme: "theme1",
			      data: [

			      {        
			        type: "spline",
			        legendText: "ยอดการขาย",
					showInLegend: true,   
			        dataPoints: [   
			        <?php
			        	$month = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			        	for($i=1;$i<=12;$i++){
			        		$quer_orders = mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_price) FROM orders WHERE MONTH(order_date)='$i' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4')")or die("ERROR report buy month line 96");
			        		list($total_price)=mysqli_fetch_row($quer_orders);
			        		$total_price = (empty($total_price))?0:$total_price;
			        		echo "{y: $total_price,label: '".$month[$i-1]."'},";
			        		$report_sell[$i]=$total_price;
			        	}
			        ?> 
			            
			        ]
			      },
			      {        
			        type: "spline",
			        legendText: "ยอดการซื้อ",
					showInLegend: true,   
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=12;$i++){
			        		$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='$i' AND YEAR(product_buy_date)='$year'")or die("ERROR report buy month line 96");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);

			        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price) FROM buy_supply WHERE MONTH(supply_date)='$i' AND YEAR(supply_date)='$year'")or die("ERROR report buy month line 98");
			        		list($supply_price)=mysqli_fetch_row($quer_buy_supply);
			        		$sum = $supply_price + $product_buy_price;
			        		$sum = (empty($sum))?0:$sum;
			        		echo "{y: $sum,label: '".$month[$i-1]."'},";
			        		$report_buy[$i]=$sum;
			        	}
			        ?>   
			        ]
			      },
			      {        
			        type: "spline",
			        legendText: "ผลกำไรขาดทุน",
					showInLegend: true,   
			        dataPoints: [    
			        <?php
			        	for($i=1;$i<=12;$i++){
			        		$total = $report_sell[$i] - $report_buy[$i];
			        		$total = (empty($total))?0:$total;
			        		echo "{y: $total,label: '".$month[$i-1]."'},";
			        	}
			        ?>    
			        ]
			      }     
			      ]
			    });

			    chart.render();
		</script>
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<table class="table table-hover table-striped">
			<thead>
				<tr><th><center>ลำดับ</th><th><center>รายการ</center></th><th><center>ยอดขาย</th><th><center>ยอดซื้อ</th><th><center>ผลกำไรขาดทุน</th></tr>
			</thead>
			<tbody>
			<?php
				
				for($i=1;$i<=12;$i++){
					echo "<tr>";
						echo "<td align='center'>$i</td>";
						echo "<td>";
							echo "<a style='text-decoration: none;cursor:pointer' data-toggle='modal' data-target='#$i'>ผลกำไรขาดทุนประจำเดือน ".$month[$i-1]."</a></center>";
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
<?php
	break;
}
?>
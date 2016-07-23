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
			var month = document.getElementById("select_month").value;
			$.post('ajax/function.php?data=report_sell_day',{year:year,month:month},function(data){
				$('#report_month').html(data);	  		
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
			<li><a href="#">รายงานการขายรายเดือน</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
<div class='panel panel-info'>
		  <div class='panel-heading'>
		    <h2 class='panel-title'><b>เลือกช่วงเวลาในการดูรายการขายรายเดือน</b></h2>
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
								$select_month = date("m");
								$select_year = date("Y");
								$query_year_order = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(order_date) FROM orders GROUP BY YEAR(order_date)")or die("ERROR : report  sell product month line 35");
								while (list($year_oreder)=mysqli_fetch_row($query_year_order)) {
									$selected = ($select_year==$year_oreder)?"selected='selected'":"";
									echo "<option value='$year_oreder' $selected>$year_oreder</option>";
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
									$selected = ($select_month==$month_id)?"selected='selected'":"";
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
<?php
		$month = $select_month;
		$year = $select_year;
		$feb = ($year%4==0)?29:28;
		$day =array("01"=>31,"02"=>$feb,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);
		for($i=1;$i<=$day[$month];$i++){
			//เก็บค่าไว้ใน array รายวัน บนเว็บไซตื
			$query_report_day =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price) FROM orders WHERE DAY(order_date)='$i' AND MONTH(order_date)='$month' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : function line 222");
			list($total_amount,$total_price)=mysqli_fetch_row($query_report_day);
			$repot_month[]=array("day"=>"$i","total_price"=>"$total_price");
			//เก็บค่าไว้ใน array รายวัน ในร้าน
			$query_report_day_shop =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price) FROM orders WHERE DAY(order_date)='$i' AND MONTH(order_date)='$month' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : function line 222");
			list($total_amount_shop,$total_price_shop)=mysqli_fetch_row($query_report_day_shop);
			$repot_month_shop[]=array("day"=>"$i","total_price"=>"$total_price_shop");
		}
		echo "var chart = new CanvasJS.Chart('chartContainer', {";
			echo "title:{";
				$query_month =  mysqli_query($_SESSION['connect_db'],"SELECT month_name FROM month WHERE month_id='$month'")or die("ERROR : function line 229");
				list($month_name)=mysqli_fetch_row($query_month);
				echo "text: 'รายงานการขายเดือน $month_name ปี $year'  ";             
			echo "},";
			echo "axisY: {";
	        echo "title: \"ยอดขาย\"";
	      	echo "},";
	      	echo "toolTip: {";
				echo "shared: true";
			echo "},";
	      	echo "animationEnabled: true,"; 
			echo "data: [   ";           
			echo "{";
				echo "type: 'column',";		
				echo "name: 'ยอดขายบนเว็บไซต์',";
				echo "legendText: \"ยอดขายบนเว็บไซต์\",";
				echo "showInLegend: true,";
				echo "dataPoints: [";	

				foreach ($repot_month as $key => $value) {
					$value['total_price'] = (empty($value['total_price']))?0:$value['total_price'];
					echo "{ label: 'วันที่ $value[day]',  y: $value[total_price]  },";
				}
				echo "]";
			echo "},";
			echo "{";
				echo "type: 'column',";
				echo "name: 'ยอดขายในร้าน',";
				echo "legendText: \"ยอดขายในร้าน\",";
				echo "showInLegend: true,";		
				echo "dataPoints: [";

				foreach ($repot_month_shop as $key => $value) {
					$value['total_price'] = (empty($value['total_price']))?0:$value['total_price'];
					echo "{ label: 'วันที่ $value[day]',  y: $value[total_price]  },";
				}
				echo "]";
			echo "}";
			echo "]";
		echo "});";
		echo "chart.render();";
?>
		</script>
	</div>
	<div id='report_month'>
<?php
		
		echo "<br>";
?>
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<table class="table table-hover table-striped">
				<thead>
					<tr><th>ลำดับ</th><th>รายการ</th><th>จำนวน(หน้าร้าน)</th><th>ยอดขาย(หน้าร้าน)</th><th>จำนวน(เว็บไซต์)</th><th>ยอดขาย(เว็บไซต์)</th></tr>
				</thead>
				<tbody>
<?php
				for($i=1;$i<=$day[$month];$i++){
					$query_report_day =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price),type_order FROM orders WHERE DAY(order_date)='$i' AND MONTH(order_date)='$month' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4')")or die("ERROR : function line 222");
					list($total_amount,$total_price_order,$type_order)=mysqli_fetch_row($query_report_day);
					echo "<tr>";
						echo "<td align='center'>$i</td>";
						echo "<td>";
?>
							<a data-toggle="modal" data-target="<?php echo "#day_$i";?>" style='text-decoration:none;cursor:pointer'><?php echo "ยอดขายประจำวันที่ $i" ?></a>
							<div class="modal fade" id="<?php echo "day_$i";?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <!--แสดง modal แสดงรายละเอียดรายวัน-->
							  <div class="modal-dialog  modal-lg" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel"><?php echo "ยอดขายประจำวันที่ $i $month_name $year" ?></h4>
							      </div>
							      <div class="modal-body">
<?php
									echo "<p align='right'><a href='../print/print_income.php?day=$i&month=$month&year=$year' target='_blank'><button class='btn btn-sm btn-info' style='padding:0px 5px'><span class='glyphicon glyphicon-print' aria-hidden='true'></span>&nbsp;ปริ้นรายได้</button></a></p>";
//--------------------------แสดงรายะเอียดข้อมูลขายรายวันสำรหับ  ขายบนเว็บไซต์
									$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE DAY(order_date)='$i' AND MONTH(order_date)='$month' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 247");
									$rows = mysqli_num_rows($query_order);
									if($rows>0){
										$num=0;
										$order_detail =array();
										while (list($order_id)=mysqli_fetch_row($query_order)) {
											$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name,product_size.product_price_web FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN product ON product_size.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 47");


											while (list($amount,$product_name,$size_name,$product_price_web)=mysqli_fetch_row($query_order_detail)) {
												$check_dubble=0;
												foreach ($order_detail as $key => $value) {
													if($value['name']=="$product_name" AND $value['size']=="$size_name"){
														$order_detail[$key]['amount']=$value['amount']+$amount;
														$order_detail[$key]['price']=$value['price']+$product_price_web;
														$check_dubble=1;
													}
												}
												if($check_dubble==0){
													$order_detail[$num]=array("name"=>"$product_name","size"=>"$size_name","amount"=>"$amount","price"=>"$product_price_web");
												}
												$num++;
											}
										}
?>		
										<div class="panel panel-success">
										  <div class="panel-heading"><?php echo "<h4>รายละเอียดยอดขายบนเว็บไซต์</h4>" ?></div>
										  <div class="panel-body">
<?php
											echo "<table class='table table-hover table-striped'>";
												echo "<tr>";
													echo "<th><p>ชื่อสินค้า</p></th>";
													echo "<th><p>ขนาดสินค้า</p></th>";
													echo "<th><p>จำนวน</p></th>";
													echo "<th><p>ราคา</p></th>";
													echo "<th><p>รวมราคา</p></th>";
												echo "</tr>";
											$total_price=0;
											foreach ($order_detail as $key => $value) {
												echo "<tr>";
													echo "<td><p>$value[name]</p></td>";
													echo "<td><p>$value[size]</p></td>";
													echo "<td><p>$value[amount]</p></td>";
													echo "<td align='right'><p>".number_format($value['price'],2)." ฿</p></td>";
													echo "<td align='right'><p>".number_format(($value['amount']*$value['price']),2)." ฿</p></td>";
													$total_price +=($value['amount']*$value['price']);
												echo "</tr>";
											}
												echo "<tr>";
													echo "<td colspan='4'><p align='right'>รวมราคาทั้งหมด</p></td>";
													echo "<td align='right'><p>".number_format($total_price,2)." ฿</p></td>";
												echo "</tr>";
											echo "</table>";
?>
										  </div>
										</div>
<?php
										
									}else{
										echo "<div class='panel panel-success'>";
										  echo "<div class='panel-heading'><h4>รายละเอียดยอดขายบนเว็บไซต์</h4></div>";
										  echo "<div class='panel-body'>";
											echo "<center><h4><font color='red'> !!! </font>ไม่พบข้อมูลการขายสินค้า<font color='red'> !!! </font></h4></center>";
										  echo "</div>";
										echo "</div>";
									}
//--------------------------แสดงรายะเอียดข้อมูลขายรายวันสำรหับ  ขายในร้าน
									$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE DAY(order_date)='$i' AND MONTH(order_date)='$month' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : report_sell_day line 247");
									$rows = mysqli_num_rows($query_order);
									if($rows>0){
										$num=0;
										$order_detail =array();
										while (list($order_id)=mysqli_fetch_row($query_order)) {
											$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name,product_size.product_price_shop FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN product ON product_size.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 47");


											while (list($amount,$product_name,$size_name,$product_price_shop)=mysqli_fetch_row($query_order_detail)) {
												$check_dubble=0;
												foreach ($order_detail as $key => $value) {
													if($value['name']=="$product_name" AND $value['size']=="$size_name"){
														$order_detail[$key]['amount']=$value['amount']+$amount;
														$order_detail[$key]['price']=$product_price_shop;
														$check_dubble=1;
													}
												}
												if($check_dubble==0){
													$order_detail[$num]=array("name"=>"$product_name","size"=>"$size_name","amount"=>"$amount","price"=>"$product_price_shop");
												}
												$num++;
											}
										}
?>		
										<div class="panel panel-success">
										  <div class="panel-heading"><?php echo "<h4>รายละเอียดยอดขายในร้าน</h4>" ?></div>
										  <div class="panel-body">
<?php
											echo "<table class='table table-hover table-striped'>";
												echo "<tr>";
													echo "<th><p>ชื่อสินค้า</p></th>";
													echo "<th><p>ขนาดสินค้า</p></th>";
													echo "<th><p>จำนวน</p></th>";
													echo "<th><p>ราคา</p></th>";
													echo "<th><p>รวมราคา</p></th>";
												echo "</tr>";
											$total_price=0;
											foreach ($order_detail as $key => $value) {
												echo "<tr>";
													echo "<td><p>$value[name]</p></td>";
													echo "<td><p>$value[size]</p></td>";
													echo "<td><p>$value[amount]</p></td>";
													echo "<td align='right'><p>".number_format($value['price'],2)." ฿</p></td>";
													echo "<td align='right'><p>".number_format(($value['amount']*$value['price']),2)." ฿</p></td>";
													$total_price +=($value['amount']*$value['price']);
												echo "</tr>";
											}
												echo "<tr>";
													echo "<td colspan='4'><p align='right'>รวมราคาทั้งหมด</p></td>";
													echo "<td align='right'><p>".number_format($total_price,2)." ฿</p></td>";
												echo "</tr>";
											echo "</table>";
?>
										  </div>
										</div>
<?php
										
									}else{
										echo "<div class='panel panel-success'>";
										  echo "<div class='panel-heading'><h4>รายละเอียดยอดขายในร้าน</h4></div>";
										  echo "<div class='panel-body'>";
											echo "<center><h4><font color='red'> !!! </font>ไม่พบข้อมูลการขายสินค้า<font color='red'> !!! </font></h4></center>";
										  echo "</div>";
										echo "</div>";
									}
?>

							      </div>
							    </div>
							  </div>
							</div> <!-- ปิดการใช้งาน modal แสดงรายละเอียดรายวัน -->
<?php
						echo "</td>";
						if($type_order=="web"){
							echo "<td align='right'>0</td>";
							echo "<td align='right'>0 ฿</td>";
							$total_amount =(empty($total_amount))?0:$total_amount;
							echo "<td align='right'>".number_format($total_amount)."</td>";
							$total_price_order =(empty($total_price_order))?0:$total_price_order;
							echo "<td align='right'>".number_format($total_price_order,2)." ฿</td>";
						}else{
							$total_amount =(empty($total_amount))?0:$total_amount;
							echo "<td align='right'>".number_format($total_amount)."</td>";
							$total_price_order =(empty($total_price_order))?0:$total_price_order;
							echo "<td align='right'>".number_format($total_price_order,2)." ฿</td>";
							echo "<td align='right'>0</td>";
							echo "<td align='right'>0 ฿</td>";	
						}
						
					echo "</tr>";
				}
?>				
				</tbody>
			</table>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
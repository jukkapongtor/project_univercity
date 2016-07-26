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
								$month = date("m");
								$year = date("Y");
								$query_year_order = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(order_date) FROM orders GROUP BY YEAR(order_date)")or die("ERROR : report  sell product month line 35");
								while (list($year_oreder)=mysqli_fetch_row($query_year_order)) {
									$selected = ($year ==$year_oreder)?"selected='selected'":"";
									echo "<option value='$year_oreder' $selected>$year_oreder</option>";
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
		
		$feb = ($year%4==0)?29:28;
		$day =array("01"=>31,"02"=>$feb,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);
	$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : report_sell_day line 185");
	while (list($month_id,$month_name)=mysqli_fetch_row($query_report_month)) {
		$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_date,SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 80");
		list($date,$total_amount,$total_price)=mysqli_fetch_row($query_order_detail);
		$repot_month[]=array("month_name"=>"$month_name","total_price"=>"$total_price");

		$query_order_detail_shop =mysqli_query($_SESSION['connect_db'],"SELECT order_date,SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4')AND type_order='shop'")or die("ERROR : report_sell_day line 84");
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
					echo "{ label: '$value[month_name]',  y: $value[total_price]  },";
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
							echo "<td>";
								echo "<a data-toggle='modal' data-target='#month_$month_id' style='text-decoration:none;cursor:pointer'>รายงานเดือน $month_name</a>";
?>
<div class="modal fade" id="<?php echo "month_$month_id";?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <!--แสดง modal แสดงรายละเอียดรายวัน-->
							  <div class="modal-dialog  modal-lg" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel"><?php echo "ยอดขายประจำเดือน $month_name ปี $year" ?></h4>
							      </div>
							      <div class="modal-body">
<?php
							echo "<p align='right'><a href='../print/print_income.php?month=$month_id&year=$year' target='_blank'><button class='btn btn-sm btn-info' style='padding:0px 5px'><span class='glyphicon glyphicon-print' aria-hidden='true'></span>&nbsp;ปริ้นรายได้</button></a></p>";
//--------------------------แสดงรายะเอียดข้อมูลขายรายวันสำรหับ  ขายบนเว็บไซต์
									$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 247");
									$rows = mysqli_num_rows($query_order);
									$total_amount_web=0;
									$total_price_web=0;
									if($rows>0){
										$num=0;
										$order_detail =array();
										while (list($order_id)=mysqli_fetch_row($query_order)) {
											$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name,order_detail.price FROM order_detail LEFT JOIN size ON order_detail.size_id = size.product_size LEFT JOIN product ON order_detail.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 166");


											while (list($amount,$product_name,$size_name,$product_price_web)=mysqli_fetch_row($query_order_detail)) {
												$check_dubble=0;
												foreach ($order_detail as $key => $value) {
													if($value['name']=="$product_name" AND $value['size']=="$size_name" AND $value['price']=="$product_price_web"){
														$order_detail[$key]['amount']=$value['amount']+$amount;
														$order_detail[$key]['price']=$value['price']+$product_price_web;
														$check_dubble=1;
													}
												}
												if($check_dubble==0){
													$order_detail[$num]=array("name"=>"$product_name","size"=>"$size_name","amount"=>"$amount","price"=>"$product_price_web");
												}
												$num++;
												$total_amount_web+=$amount;
											}
										}
?>		
										<div class="panel panel-success">
										  <div class="panel-heading"><?php echo "<h4>รายละเอียดยอดขายบนเว็บไซต์</h4>" ?></div>
										  <div class="panel-body">
<?php
											echo "<table class='table table-hover table-striped'>";
												echo "<tr>";
													echo "<th><p align='center'>ชื่อสินค้า</p></th>";
													echo "<th><p align='center'>ขนาดสินค้า</p></th>";
													echo "<th><p align='center'>จำนวน</p></th>";
													echo "<th><p align='center'>ราคา</p></th>";
													echo "<th><p align='center'>รวมราคา</p></th>";
												echo "</tr>";
											$total_price_web=0;
											foreach ($order_detail as $key => $value) {
												echo "<tr>";
													echo "<td><p>$value[name]</p></td>";
													echo "<td><p>$value[size]</p></td>";
													echo "<td><p>$value[amount]</p></td>";
													echo "<td align='right'><p>".number_format($value['price'],2)." ฿</p></td>";
													echo "<td align='right'><p>".number_format(($value['amount']*$value['price']),2)." ฿</p></td>";
													$total_price_web +=($value['amount']*$value['price']);
												echo "</tr>";
											}
												echo "<tr>";
													echo "<td colspan='4'><p align='right'>รวมราคาทั้งหมด</p></td>";
													echo "<td align='right'><p>".number_format($total_price_web,2)." ฿</p></td>";
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
									$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$year' AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : report_sell_day line 247");
									$rows = mysqli_num_rows($query_order);
									$total_amount_shop=0;
									$total_price_shop=0;
									if($rows>0){
										$num=0;
										$order_detail =array();
										while (list($order_id)=mysqli_fetch_row($query_order)) {
											$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name,order_detail.price FROM order_detail LEFT JOIN size ON order_detail.size_id = size.product_size LEFT JOIN product ON order_detail.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 233");


											while (list($amount,$product_name,$size_name,$product_price_shop)=mysqli_fetch_row($query_order_detail)) {
												$check_dubble=0;
												foreach ($order_detail as $key => $value) {
													if($value['name']=="$product_name" AND $value['size']=="$size_name" AND $value['price']=="$product_price_shop"){
														$order_detail[$key]['amount']=$value['amount']+$amount;
														$order_detail[$key]['price']=$product_price_shop;
														$check_dubble=1;
													}
												}
												if($check_dubble==0){
													$order_detail[$num]=array("name"=>"$product_name","size"=>"$size_name","amount"=>"$amount","price"=>"$product_price_shop");
												}
												$num++;
												$total_amount_shop+=$amount;
											}
										}
?>		
										<div class="panel panel-success">
										  <div class="panel-heading"><?php echo "<h4>รายละเอียดยอดขายในร้าน</h4>" ?></div>
										  <div class="panel-body">
<?php
											echo "<table class='table table-hover table-striped'>";
												echo "<tr>";
													echo "<th><p align='center'>ชื่อสินค้า</p></th>";
													echo "<th><p align='center'>ขนาดสินค้า</p></th>";
													echo "<th><p align='center'>จำนวน</p></th>";
													echo "<th><p align='center'>ราคา</p></th>";
													echo "<th><p align='center'>รวมราคา</p></th>";
												echo "</tr>";
											$total_price_shop=0;
											foreach ($order_detail as $key => $value) {
												echo "<tr>";
													echo "<td><p>$value[name]</p></td>";
													echo "<td><p>$value[size]</p></td>";
													echo "<td><p>$value[amount]</p></td>";
													echo "<td align='right'><p>".number_format($value['price'],2)." ฿</p></td>";
													echo "<td align='right'><p>".number_format(($value['amount']*$value['price']),2)." ฿</p></td>";
													$total_price_shop +=($value['amount']*$value['price']);
												echo "</tr>";
											}
												echo "<tr>";
													echo "<td colspan='4'><p align='right'>รวมราคาทั้งหมด</p></td>";
													echo "<td><p align='right'>".number_format($total_price_shop,2)." ฿</p></td>";
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
							$total_amount_shop =(empty($total_amount_shop))?0:$total_amount_shop;
							echo "<td align='right'>".number_format($total_amount_shop,2)."</td>";
							$total_price_shop =(empty($total_price_shop))?0:$total_price_shop;
							echo "<td align='right'>".number_format($total_price_shop,2)." ฿</td>";
							$total_amount_web =(empty($total_amount_web))?0:$total_amount_web;
							echo "<td align='right'>".number_format($total_amount_web)."</td>";
							$total_price_web =(empty($total_price_web))?0:$total_price_web;
							echo "<td align='right'>".number_format($total_price_web,2)." ฿</td>";
						echo "</tr>";
					}
?>
				</tbody>
			</table>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
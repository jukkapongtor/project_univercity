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
		$.post('ajax/function_report_buy.php?data=report_buy_day',{year:year,month:month},function(data){
			$('#report_buy_month').html(data);	  		
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
			<li><a href="#">รายงานการซื้อสินค้า</a></li>
			<li><a href="#">รายงานการซื้อรายเดือน</a></li>
		</ol>
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
								$query_product_buy = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(product_buy_date) FROM buy_product GROUP BY YEAR(product_buy_date)")or die("ERROR : report  sell product month line 35");
								$query_product_supply = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(supply_date) FROM buy_supply GROUP BY YEAR(supply_date)")or die("ERROR : report  sell product month line 35");
								$select_year = array();
								while (list($year_oreder)=mysqli_fetch_row($query_product_buy)) {
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
			        text: "รายงานการซื้อประจำเดือน " +now_month+" ปี "+<?php echo "$year";?>   
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
			        		$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='".date("m")."' AND YEAR(product_buy_date)='$year' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 96");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);

			        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price) FROM buy_supply WHERE MONTH(supply_date)='".date("m")."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 98");
			        		list($supply_price)=mysqli_fetch_row($quer_buy_supply);
			        		$sum = $supply_price + $product_buy_price;
			        		$sum = (empty($sum))?0:$sum;
			        		echo "{y: $sum,label: '$i'},";
			        	}
			        ?>    
			        ]
			      }   
			      ]
			    });

			    chart.render();
		</script>
	</div>
	<div id='report_buy_month'>
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<table class="table table-hover table-striped">
			<thead>
				<tr><th><center>ลำดับ</th><th><center>รายการ</center></th><th><center>ยอดขาย(เว็บไซต์)</th></tr>
			</thead>
			<tbody>
			<?php
				for($i=1;$i<=$amount_day[date("m")-1];$i++){
					$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='".date("m")."' AND YEAR(product_buy_date)='$year' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 146");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);

			        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price) FROM buy_supply WHERE MONTH(supply_date)='".date("m")."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 149");
			        		list($supply_price)=mysqli_fetch_row($quer_buy_supply);
			        		$sum = $supply_price + $product_buy_price;
			        		$sum = (empty($sum))?0:$sum;
					echo "<tr>";
						echo "<td align='center'>$i</td>";
						echo "<td>";
							echo "<a style='text-decoration: none;cursor:pointer' data-toggle='modal' data-target='#$i'>ยอดการซื้อของประจำวันที่ $i</a></center>";
?>
							<!-- Modal -->
							<div class="modal fade" id="<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog modal-lg" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel"><?php echo "ยอดการซื้อของประจำวันที่ $i";?></h4>
							      </div>
							      <div class="modal-body">
<?php
									
?>
							      	<div class="panel panel-default">
									  <div class="panel-heading">รายการซื้อเข้าสินค้า</div>
									  <div class="panel-body">
<?php
										$query_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,buy_product.product_amount_keep,buy_product.product_amount_shop,buy_product.product_amount_web,buy_product.product_buy_price FROM buy_product LEFT JOIN product ON buy_product.product_id = product.product_id LEFT JOIN product_size ON buy_product.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size WHERE YEAR(buy_product.product_buy_date)='$year' AND MONTH(buy_product.product_buy_date)='".date("m")."' AND DAY(buy_product.product_buy_date) = '$i'")or die("ERROR report buy month line 168");
										$row = mysqli_num_rows($query_buy_product);
										if(empty($row)){
											echo "<h4 align='center'><font color='red'> !!! </font>ไม่พบรายการซื้อสินค้า<font color='red'> !!! </font></h4>";
										}else{
											$num=1;
											$total_price = 0;
?>
										<table class="table">
											<tr><th><center>ลำดับ</center></th><th><center>ชื่อสินค้า</center></th><th><center>ขนาดสินค้า</center></th><th><center>ราคาที่ซื้อ(หน่วย)</center></th><th><center>จำนวนที่ซื้อ(ชิ้น)</center></th><th><center>รวมราคา</center></th></tr>
<?php
											while(list($product_name,$size_name,$product_amount_keep,$product_amount_shop,$product_amount_web,$product_buy_price)=mysqli_fetch_row($query_buy_product)){
												echo "<tr><td align='center'>$num</td><td>$product_name</td><td>$size_name</td><td align='right'>".number_format($product_buy_price,2)." ฿</td>";
												$amount =($product_amount_keep+$product_amount_shop+$product_amount_web);
												$sum_detail = $amount * $product_buy_price;
												$total_price+=$sum_detail;
												echo "<td align='right'>$amount</td><td align='right'>".number_format($sum_detail,2)." ฿</td></tr>";
												$num++;
											}
?>	
											<tr><td align="right" colspan="5">รวมเป็นจำนวนเงินทั้งหมด</td><td align="right"><?php echo number_format($total_price,2)." ฿";?></td></tr>
										</table>
<?php
										}
?>
									  </div>
									</div>
									<div class="panel panel-default">
									  <div class="panel-heading">รายการซื้อเข้าวัสดุสิ้นเปลือง</div>
									  <div class="panel-body">
<?php
										$query_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT * FROM buy_supply WHERE MONTH(supply_date)='".date("m")."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 168");
										$row = mysqli_num_rows($query_buy_supply);
										if(empty($row)){
											echo "<h4 align='center'><font color='red'> !!! </font>ไม่พบรายการซื้อสินค้า<font color='red'> !!! </font></h4>";
										}else{
											$num=1;
											$total_price = 0;
											echo "<table class='table'>";
											echo "<tr><th><center>ลำดับ</center></th><th><center>ชื่อวัสดุ</center></th><th><center>จำนวนที่ซื้อ(ชิ้น)</center></th><th><center>หน่วยวัสดุ</center></th><th><center>ราคาที่ซื้อ(หน่วย)</center></th><th><center>รวมราคา</center></th></tr>";
											while(list($buy_id,$supply_name,$supply_amount,$supply_price,$supply_unit,$supply_date)=mysqli_fetch_row($query_buy_supply)){
												echo "<tr><td>$num</td><td>$supply_name</td><td align='right'>$supply_amount</td><td>$supply_unit</td><td align='right'>".number_format(($supply_price/$supply_amount),2)." ฿</td><td align='right'>".number_format($supply_price,2)." ฿</td></tr>";
												$num++;
												$total_price +=$supply_price;
											}
											echo "<tr><td align='right' colspan='5'>รวมเป็นจำนวนเงินทั้งหมด</td><td align='right'>".number_format($total_price,2)." ฿</td></tr>";
											echo "</table>";
										}
?>
									  </div>
									</div>
							      </div>
							    </div>
							  </div>
							</div>
<?php
						echo "</td>"; 
						echo "<td align='right'>".number_format($sum,2)." ฿</td>";
						echo "</tr>";
			
				}
			?>
			</tbody>
		</table>
		</div>
	<div class="col-md-3"></div>
	</div>
</div>
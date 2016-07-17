<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'report_buy_day':
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
		        	for($i=1;$i<=$amount_day[($_POST['month'])-1];$i++){
		        		$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='".$_POST['month']."' AND YEAR(product_buy_date)='$year' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 96");
		        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);
		        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price) FROM buy_supply WHERE MONTH(supply_date)='".$_POST['month']."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 98");
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
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<table class="table table-hover table-striped">
			<thead>
				<tr><th><center>ลำดับ</th><th><center>รายการ</center></th><th><center>ยอดขาย(เว็บไซต์)</th></tr>
			</thead>
			<tbody>
			<?php
				for($i=1;$i<=$amount_day[($_POST['month'])-1];$i++){
					$quer_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT SUM((product_buy_price*product_amount_keep)+(product_buy_price*product_amount_shop)+(product_buy_price*product_amount_web)) FROM buy_product WHERE MONTH(product_buy_date)='".$_POST['month']."' AND YEAR(product_buy_date)='$year' AND DAY(product_buy_date)='$i'")or die("ERROR report buy month line 123");
			        		list($product_buy_price)=mysqli_fetch_row($quer_buy_product);

			        		$quer_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT SUM(supply_price) FROM buy_supply WHERE MONTH(supply_date)='".$_POST['month']."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 126");
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
										$query_buy_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,buy_product.product_amount_keep,buy_product.product_amount_shop,buy_product.product_amount_web,buy_product.product_buy_price FROM buy_product LEFT JOIN product ON buy_product.product_id = product.product_id LEFT JOIN product_size ON buy_product.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size WHERE YEAR(buy_product.product_buy_date)='$year' AND MONTH(buy_product.product_buy_date)='".$_POST['month']."' AND DAY(buy_product.product_buy_date) = '$i'")or die("ERROR report buy month line 168");
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
										$query_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT * FROM buy_supply WHERE MONTH(supply_date)='".$_POST['month']."' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$i'")or die("ERROR report buy month line 168");
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
<?php
	break;
}
?>
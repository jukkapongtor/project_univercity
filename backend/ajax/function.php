<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'switch_onoff_buywebsite':
		mysqli_query($_SESSION['connect_db'],"UPDATE web_page SET sellproduct_status ='$_POST[switch_onoff_buywebsite]' WHERE web_page_id='1'"); 
	break;
	case 'switch_onoff_openweb':
		mysqli_query($_SESSION['connect_db'],"UPDATE web_page SET open_web ='$_POST[switch_onoff_openweb]' WHERE web_page_id='1'"); 
	break;
	case 'product_list':
	echo "<script>";
	echo "$(document).ready(function() {";
		$query_product =mysqli_query($_SESSION['connect_db'],"SELECT product_id FROM product")or die("ERROR : backend buy product line 33");
		while(list($product_id)=mysqli_fetch_row($query_product)){
			echo "$('#select_$product_id').click(function() {";
				echo "$.post('ajax/function.php?data=product_detail',{product_id:document.getElementById('product_$product_id').value},function(data){";
					echo "$('#product_detail').html(data);";
            	echo "});";
			echo "});";
		}
	echo "});";
	echo "</script>";
		$query_product=mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,quality.quality_name,type.type_name,type.type_name_eng FROM product  LEFT JOIN quality ON product.product_quality = quality.product_quality LEFT JOIN type ON product.product_type = type.product_type  WHERE product.product_quality='$_POST[product_quality]'");
		$row =mysqli_num_rows($query_product);
		echo "<div class='container-fluid' style='margin-top:30px;padding:0px;'>";
		if($row<=0){
			echo "<div class='col-md-12'><p><b>ไม่พบรายการสินค้า</b></p></div>";
		}else{
			echo "<p><b>รายการสินค้าแบ่งตามประเภทและหมวดหมู่</b></p>";
			while (list($product_id,$product_name,$quality_name,$type_name,$type_name_eng)=mysqli_fetch_row($query_product)) {
				echo "<div class='col-md-4' style='margin-bottom:40px;pading:5px;'>";
					echo "<input type='hidden' id='product_$product_id' value='$product_id'>";
					$query_image=mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
					list($product_image)=mysqli_fetch_row($query_image);
					echo "<a id='select_$product_id' style='cursor:pointer'><p align='center'><img src='../images/$type_name_eng/$product_image' width='90%' height='180px' ></p>";
					$str=explode(" ",$product_name,2);
					echo "<p align='center'><b>$str[0]</b></p></a>";
				echo "</div>";
			}
			
		}
		echo "</div>";
	break;
	case 'product_detail':
		$query_product_detail =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product_image.product_image,type.type_name,type.type_name_eng FROM product LEFT JOIN product_image ON product.product_id = product_image.product_id LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id='$_POST[product_id]'")or die("ERROR : backend functopn line 44");
		list($product_id,$product_name,$product_image,$type_name,$type_name_eng)=mysqli_fetch_row($query_product_detail);
?>
		<div class="panel panel-default">
		  <div class="panel-heading">ต้นทุนสินค้า<?php echo "$product_name";?></div>
		  <div class="panel-body">
		    <div class="container-fluid" style='padding:0px'>
		    	<div class='col-md-12' style='padding:0px'>
		    		<p align="center"><img src="<?php echo "../images/$type_name_eng/$product_image" ?>" width='60%' height='300'></p>
		    		<form action="ajax/buy_insert.php" method="post">
		    		<input type="hidden" name="product_id" value="<?php echo "$product_id";?>">
		    		<input type="hidden" name="but_date" value="<?php echo "$product_id";?>">
		    		<table width="100%">
		    			<tr>
		    				<th width="25%"><p>ชื่อสินค้า</p></th>
		    				<th width="5%"><p>&nbsp;:&nbsp;</p></th>
		    				<td><p><?php echo "$product_name"; ?></p></td>
		    			</tr>
		    			<tr>
		    				<th valign="top"><p>จำนวนต้นทุนสินค้า</p></th>
		    				<th valign="top" width="5%"><p>&nbsp;:&nbsp;</p></th>
		    				<td>
		    					<table width="100%">
<?php
								$query_size = mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,size.size_name FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id='$_POST[product_id]'")or die("ERROR : backend functopn line 66");
								while (list($product_size_id,$size_name)=mysqli_fetch_row($query_size)) {
?>							
									<input type="hidden" name='product_size_id[]' value="<?php echo $product_size_id ?>">
									<tr>
										<td colspan="4"><p><b>ขนาดสินค้า <?php echo $size_name ?></b></p></td>
									</tr>
									<tr>
										<td><p>ราคา(หน่วย) ที่ซื้อเข้า</p></td>
										<td><p><input class="form-control" type="text" name='buy_price[]'></p></td>
									</tr>
									<tr>
										<td><p>จำนวนสินค้าบนเว็บ</p></td>
										<td><p><input class="form-control" type="text" name='amount_web[]'></p></td>
									</tr>
									<tr>
										<td><p>จำนวนสินค้าในร้าน</p></td>
										<td><p><input class="form-control" type="text" name='amount_shop[]'></p></td>
									</tr>
									<tr>
										<td><p>จำนวนสินค้าที่ไม่ขาย</p></td>
										<td><p><input class="form-control" type="text" name='amount_keep[]'></p></td>
									</tr>
									
<?php
								}		
?>
		    					</table>
		    				</td>
		    			</tr>
		    		</table>
		    		<p align="right"><input class='btn btn-sm btn-success' type="submit" value="บันทึกราคาต้นทุน"></p>
		    		</form>
		    	</div>
		    </div>
		  </div>
		</div>
		
<?php
	break;
	case 'select_order':
		$day = substr($_POST['date'],0,2);
		$month = substr($_POST['date'],3,2);
		$year = substr($_POST['date'],6,4);
		$date_select="$year-$month-$day";
		$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id,total_amount,total_price FROM orders WHERE DATE(order_date)='$date_select' AND (order_status='3' OR order_status='4') ")or die("ERROR : report_sell_day line 47");
		$rows = mysqli_num_rows($query_order);
		if($rows<=0){
			echo "<p><b>ไม่พบรายการขาย</p>";
		}else{
?>
		<table class="table">
			<tr><th>ลำดับ</th><th>ลำดับ</th><th>จำนวน</th><th>ราคา</th></tr>
<?php
			$num=1;
			while (list($order_id,$total_amount,$total_price)=mysqli_fetch_row($query_order)) {
				echo "<tr>";
					echo "<td>$num</td>";
					echo "<td>$order_id</td>";
					echo "<td>$total_amount</td>";
					echo "<td>$total_price</td>";
				echo "</tr>";
				$num++;
			}
?>
		</table>
	<script>
<?php
	$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE DATE(order_date)='$date_select' AND (order_status='3' OR order_status='4') ")or die("ERROR : report_sell_day line 47");
	$rows = mysqli_num_rows($query_order);
	if($rows>0){
		$num=0;

		$order_detail =array();
		while (list($order_id)=mysqli_fetch_row($query_order)) {
			$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN product ON product_size.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 47");
			while (list($amount,$product_name,$size_name)=mysqli_fetch_row($query_order_detail)) {
				$check_dubble=0;
				foreach ($order_detail as $key => $value) {
					if($value['name']=="$product_name ($size_name)"){
						$order_detail[$key]['amount']=$value['amount']+$amount;
						$check_dubble=1;
					}
				}
				if($check_dubble==0){
					$order_detail[$num]=array("name"=>"$product_name ($size_name)","amount"=>"$amount");
				}
				$num++;
			}
		}
	echo "var chart = new CanvasJS.Chart('chartContainer', {";
		echo "title:{"; 
			echo "text: 'รายงานการขายวันที่ $_POST[date]'  ";             
		echo "},"; 
		echo "data: [   ";           
		echo "{";
			echo "type: 'column',";		
			echo "dataPoints: [";

			foreach ($order_detail as $key => $value) {
				echo "{ label: '$value[name]',  y: $value[amount]  },";
			}
			echo "]";
		echo "}";
		echo "]";
	echo "});";
	echo "chart.render();";
	}
?>
	</script>
<?php
	}

	break;
//-----------------------แสดงกราฟขายรายปี
	case 'report_sell_month':

		if(!empty($_POST['year'])){
?>
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
							        <h4 class="modal-title" id="myModalLabel"><?php echo "ยอดขายประจำเดือน $month_name ปี $_POST[year]" ?></h4>
							      </div>
							      <div class="modal-body">
<?php
									echo "<p align='right'><a href='../print/print_income.php?&month=$month_id&year=$_POST[year]' target='_blank'><button class='btn btn-sm btn-info' style='padding:0px 5px'><span class='glyphicon glyphicon-print' aria-hidden='true'></span>&nbsp;ปริ้นรายได้</button></a></p>";
//--------------------------แสดงรายะเอียดข้อมูลขายรายวันสำรหับ  ขายบนเว็บไซต์
									$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$_POST[year]' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 247");
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
													echo "<th><p align='center'>ชื่อสินค้า</p></th>";
													echo "<th><p align='center'>ขนาดสินค้า</p></th>";
													echo "<th><p align='center'>จำนวน</p></th>";
													echo "<th><p align='center'>ราคา</p></th>";
													echo "<th><p align='center'>รวมราคา</p></th>";
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
									$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$_POST[year]' AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : report_sell_day line 247");
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
													echo "<th><p align='center'>ชื่อสินค้า</p></th>";
													echo "<th><p align='center'>ขนาดสินค้า</p></th>";
													echo "<th><p align='center'>จำนวน</p></th>";
													echo "<th><p align='center'>ราคา</p></th>";
													echo "<th><p align='center'>รวมราคา</p></th>";
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
													echo "<td><p align='right'>".number_format($total_price,2)." ฿</p></td>";
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
							$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$_POST[year]' AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : function line 222");
							list($total_amount,$total_price)=mysqli_fetch_row($query_report_month);
							$total_amount = (empty($total_amount))?0:$total_amount;
							$total_price = (empty($total_price))?0:$total_price;
							echo "<td align='right'>".number_format($total_amount)."</td>";
							echo "<td align='right'>".number_format($total_price,2)." ฿</td>";
							$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$_POST[year]' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : function line 222");
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
	<script>
<?php
	$query_report_month =mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : report_sell_day line 185");
	while (list($month_id,$month_name)=mysqli_fetch_row($query_report_month)) {
		$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_date,SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$_POST[year]' AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 47");
		list($date,$total_amount,$total_price)=mysqli_fetch_row($query_order_detail);
		$repot_month[]=array("month_name"=>"$month_name","total_price"=>"$total_price");

		$query_order_detail_shop =mysqli_query($_SESSION['connect_db'],"SELECT order_date,SUM(total_amount),SUM(total_price) FROM orders WHERE MONTH(order_date)='$month_id' AND YEAR(order_date)='$_POST[year]' AND (order_status='3' OR order_status='4')AND type_order='shop'")or die("ERROR : report_sell_day line 47");
		list($date_shop,$total_amount_shop,$total_price_shop)=mysqli_fetch_row($query_order_detail_shop);
		$repot_month_shop[]=array("month_name"=>"$month_name","total_price"=>"$total_price_shop");
	}
	echo "var chart = new CanvasJS.Chart('chartContainer', {";
		echo "title:{"; 
			echo "text: 'รายงานการขายปี $_POST[year]'  ";             
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
<?php
		}else{
			echo "<center><h3 style='margin-top:50px;'><font color='red'>!!! </font>กรุณาเลือกข้อมูลในการแสดง ก่อนกดปุ่ม \"ตกลง\" <font color='red'> !!! </font></h3></center>";
		}
	break;
//------------------------------แสดงงกราฟรายเดือน
	case 'report_sell_day':
		$month = $_POST['month'];
		$year = $_POST['year'];

		if(!empty($month)&&!empty($year)){
		$feb = ($year%4==0)?29:28;
		$day =array(1=>31,2=>$feb,3=>31,4=>30,5=>31,6=>30,7=>31,8=>31,9=>30,10=>31,11=>30,12=>31);
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
					$query_month =  mysqli_query($_SESSION['connect_db'],"SELECT month_name FROM month WHERE month_id='$month'")or die("ERROR : function line 229");
					list($month_name)=mysqli_fetch_row($query_month);
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
							echo "<td align='right'>0  ฿</td>";
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
							echo "<td align='right'>0  ฿</td>";	
						}
						
					echo "</tr>";
				}
?>				
				</tbody>
			</table>
		</div>
		<div class="col-md-1"></div>
		<script>
<?php
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
<?php
		}else{
			echo "<center><h3 style='margin-top:50px;'><font color='red'>!!! </font>กรุณาเลือกวันที่ในการแสดงข้อมูล ก่อนกดปุ่ม \"ตกลง\"<font color='red'> !!! </font></h3></center>";
		}
	break;
//--------------------------------------จบการแสดงกราฟรายเดือน
	/*
	case 'select_size':
		$query_product_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type FROM product WHERE product_id='$_POST[product]'")or die("ERROR backend function line 399");
		list($product_type)=mysqli_fetch_row($query_product_type);
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_size,size_name FROM size WHERE type_id='$product_type'")or die("ERROR backend function line 401");
		while (list($product_size,$size_name)=mysqli_fetch_row($query_type)) {
			echo "<option value='$product_size'>$size_name</option>";
		}
	break;
	*/

	case 'order_detail_shop':
?>
		<div class="panel panel-primary">
		  <div class="panel-heading">
		  	<h1 class="panel-title" style="font-size:18px">รายละเอียดการขายสินค้ารหัส <?php echo "$_POST[order_id]";?></h1>
		  </div>
		  <div class="panel-body">
<?php
			$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_date,order_username FROM orders WHERE order_id='$_POST[order_id]'")or die("ERROR : backend function line 418");
			list($order_date,$order_username )=mysqli_fetch_row($query_order);
			echo "<p><b>วันที่ขาย : </b> $order_date</p>";
			echo "<p><b>ผู้ขายสินค้า : </b> $order_username</p>";
			echo "<table class='table table-hover table-striped' style='font-size:13px'>";      
				$total_price=0;
				$query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,size.size_name,product_size.product_price_shop,order_detail.amount,type.type_name,type.type_name_eng FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN product ON product.product_id = product_size.product_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN type ON product.product_type = type.product_type WHERE order_detail.order_id = '$_POST[order_id]'")or die("ERROR : order function line 111");
				while(list($product_id,$product_name,$size_name,$product_price_shop,$total_amount,$type_name,$type_name_eng)=mysqli_fetch_row($query_orderdetail)){
			     		echo "<tr>";
			     			$query_image = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id = '$product_id'")or die("ERROR : cart function line 16");
							list($product_image)=mysqli_fetch_row($query_image);
							$path = (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
							echo "<td><img src='../images/$path' width='100' height='130'></td>";
			     			echo "<td>";
			     				echo "<p>$product_name ($size_name)</p>";
			     				echo "<p><b>จำนวนสินค้า :</b> $total_amount</p>";
			     				echo "<p><b>ราคาต่อชิ้น :</b> ".number_format($product_price_shop,2)."</p>";
			     				$sum=$product_price_shop*$total_amount;
			     				$total_price+=$sum;
			     				echo "<p><b>รวมราคา :</b> ".number_format($sum,2)."</p>";
			     			echo "</td>";
			     			/*
			     			echo "<td>$size_name</td>";
			    			echo "<td>$product_price_shop</td>";
			     			echo "<td>$total_amount</td>";
			     			$sum=$product_price_shop*$total_amount;
			     			$total_price+=$sum;
			     			echo "<td>".number_format($sum)."</td>";
			     			*/
			    		echo "</tr>";
				}
				echo "<tr><td colspan='2' align='right'><b>รวมยอดเงินทั้งหมด</b> ".number_format($total_price,2)."</td></tr>";
			echo "</tbody></table>";
?>
		  </div>
		</div>
<?php 
	break;
	case 'profile':

	$edit_em = mysqli_query($_SESSION['connect_db'], "SELECT employee_id, employee_img, titlename, name_thai, surname_thai, name_eng, surname_eng, id_card, phone_number, email, birth_date, blood_group, personnel_nationality, personnel_race, religious, mate_status, mate_name, address_hrt, village_no_hrt, village_hrt, alley_hrt, road_hrt, province_hrt, districts_hrt, subdistrict_hrt, zipcode_hrt, phone_hrt, address_number, village_no, village, alley, road, province, districts, subdistrict, zipcode, phone, titlename_er, name_er, phone_er, status_er FROM employee WHERE employee_id='$_POST[employee_id]' ") or die("ERROR : employee_fromupdate line 30");

         list($employee_id, $employee_img, $titlename, $name_thai, $surname_thai, $name_eng, $surname_eng, $id_card, $phone_number, $email, $birth_date, $blood_group, $personnel_nationality, $personnel_race, $religious, $mate_status, $mate_name, $address_hrt, $village_no_hrt, $village_hrt, $alley_hrt, $road_hrt, $province_hrt, $districts_hrt, $subdistrict_hrt, $zipcode_hrt, $phone_hrt, $address_number, $village_no, $village, $alley, $road, $province, $districts, $subdistrict, $zipcode, $phone, $titlename_er, $name_er, $phone_er, $status_er)=mysqli_fetch_row($edit_em)
?>
        <div class="panel panel-info" style="width:100% " >
            <div class="panel-heading">
            
                <h3 class="panel-title">ประวัติส่วนตัว</h3>
            </div>
            <div class="panel-body">
         <!--______________________________________________________________________________-->  
                 
                <div class="col-md-12" style="margin-top:20px;">
                    <table align="center" width="100%">  
                        <tr>
                            <td width="50%" align="right" style="padding:10px;">ชื่อ-นามสกุล : </td>
                            <td style="padding:10px;" >
                                <?php echo "$titlename$name_thai  $surname_thai"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="padding:10px;">ชื่อ-นามสกุล(อังกฤษ) : </td>
                            <td style="padding:10px;" >
                                <?php echo "$name_eng $surname_eng"; ?>
                            </td>
                        </tr> 
            <!--______________________________________________________________________________-->  
                        <tr>
                            <td align="right" style="padding:10px;">รหัสบัตรประชาชน : </td>
                            <td style="padding:10px;">
                                <?php echo "$id_card"; ?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="right" style="padding:10px;">เบอร์โทรศัพท์ : </td>
                            <td style="padding:10px;">
                               <?php echo "$phone_number"; ?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="right" style="padding:10px;">อีเมล์ : </td>
                            <td style="padding:10px;">
                                <?php echo "$email"; ?>
                            </td>
                        </tr> 
         <!--______________________________________________________________________________-->
                    </table>
                </div>
        

<!--______________________________________________-->
    
    <div class="col-md-12">
        <hr style="border-width: 2px;" >
            <table align="center" width="100%">
                <tr>
                    <td width="50%" align="right" style="padding:10px;">วันเกิด : </td>
                    <td style="padding: 10px;">
                        <?php echo "$birth_date"; ?>
                    </td>
                </tr>
                <tr>                
                    <td align="right" style="padding: 10px;">หมู่โลหิต :</td>
                    <td style="padding: 10px;">
                        <?php echo "$blood_group";?>
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">สัญชาติ :</td>
                    <td style="padding: 10px;">
                        <?php echo "$personnel_nationality";?>
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">เชื้อชาติ :</td>
                    <td style="padding: 10px;">
                       <?php echo "$personnel_race"; ?>                        
                    </td>
                </tr>

                <tr>
                    <td align="right" style="padding: 10px">ศาสนา :</td>
                    <td style="padding: 10px;">
                        <?php echo "$religious";?>     
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">สถานะภาพ :</td>
                    <td style="padding: 10px;">
                       <?php echo "$mate_status ";?>     
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">ชื่อคู่สมรส :</td>
                    <td style="padding: 10px;">
                        <?php echo "$mate_name"; ?>
                    </td>
                </tr>
            </table>
    </div>


        <div class="col-md-12">
            <hr style="border-width: 2px;" >
                <table width="100%">
                    <tr>
                        <td width="50%" align="right" style="padding:10px;" >บ้านเลขที่(ตามทะเบียนบ้าน) :</td>
                        <td width="50%" style="padding:10px;">
                            <?php echo "$address_hrt";?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >หมู่(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village_no_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >ชื่อหมู่บ้าน(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >ชื่อซอย(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                           <?php echo "$alley_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >ถนน(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$road_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >จังหวัด(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            
<?php
                        $query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces WHERE PROVINCE_ID='$province_hrt'")or die("ERROR : employee detail line 190");
                        list($province_id,$province_name)=mysqli_fetch_row($query_provinces);
                                echo "$province_name";
                                $isset_province = $province_id;
                            
                        
?>   
                        </td>
                    </tr>
                    <tr>                    
                        <td align="right" style="padding:10px;" >เขต/อำเภอ(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
<?php
                   
                        $query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$districts_hrt'")or die("ERROR :employee detail line 206");
                        list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict);
                                echo "$amphure_name";
                                $isset_district = $amphure_id;
?>   
                        </td>
                    </tr>

                    <tr>
                        <td align="right" style="padding:10px;" >แขวง/ตำบล(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            
<?php
                        $query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district' AND DISTRICT_CODE='$subdistrict_hrt'")or die("ERROR : employee detail line 219");
                        list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict);
                            echo "$disrtict_name";      
?>
                        </td>
                    </tr>

                    <tr>

                        <td align="right" style="padding:10px;">รหัสไปรษณีย์(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$zipcode_hrt"; ?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" style="padding:10px;">เบอร์โทรศัพท์(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$phone_hrt"; ?>
                        </td>
                    </tr>
                </table>
            </div>

        <div class="col-md-12">  
            <hr style="border-width: 2px;" >
               <table width="100%">
                    <tr>
                        <td align="right" width="50%" style="padding:10px;" >บ้านเลขที่(ใช้ติดต่อ) :</td>
                        <td width="50%" style="padding:10px;">
                            <?php echo "$address_number"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >หมู่(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village_no"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >ชื่อหมู่บ้าน(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >ชื่อซอย(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                           <?php echo "$alley"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >ถนน(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                           <?php echo "$road"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >จังหวัด(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
<?php
                      $query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces WHERE PROVINCE_ID='$province'")or die("ERROR : employee detail line 190");
                        list($province_id,$province_name)=mysqli_fetch_row($query_provinces);
                                echo "$province_name";
                                $isset_province = $province_id;
?>   
                        </td>
                    </tr>
                    <tr>    
                        <td  align="right" style="padding:10px;" >เขต/อำเภอ(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
<?php
                     $query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$districts'")or die("ERROR :employee detail line 206");
                        list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict);
                                echo "$amphure_name";
                                $isset_district = $amphure_id;
?>   
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >แขวง/ตำบล(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                           
 <?php
                     $query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district' AND DISTRICT_CODE='$subdistrict'")or die("ERROR : employee detail line 219");
                        list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict);
                            echo "$disrtict_name";      
?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;">รหัสไปรษณีย์(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$zipcode"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;">เบอร์โทรศัพท์(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$phone"; ?>
                        </td>
                    </tr>
                </table>
        </div>
            

         <!--________________________________________________________-->
        <div class="col-md-12">
            <hr style="border-width: 2px;" >
                <table width="100%">
                    <tr>
                        <td width="50%" align="right" style="padding:10px;">ชื่อ-นามสกุล(ติดต่อฉุกเฉิน) : </td>
                        <td width="50%" style="padding:10px;" >
                            <?php echo "$titlename_er$name_er"; ?> 
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding: 10px;">เบอร์โทรศัพท์(ติดต่อฉุกเฉิน) :</td>
                        <td style="padding: 10px;">
                           <?php echo "$phone_er"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding: 10px;">สถานะ(ติดต่อฉุกเฉิน) :</td>
                        <td style="padding: 10px;"> 
                            <?php echo "$status_er"; ?>
                        </td>
                    </tr>

                </table>
        </div>
</div>
</div> <!--panal--> 
<?php


	break;

	default: break;


}

?>

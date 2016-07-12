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
		$query_product=mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product_image.product_image,quality.quality_name,type.type_name FROM product LEFT JOIN product_image ON product.product_id = product_image.product_id LEFT JOIN quality ON product.product_quality = quality.product_quality LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_quality='$_POST[product_quality]'");
		$row =mysqli_num_rows($query_product);
		echo "<div class='container-fluid' style='margin-top:30px;padding:0px;'>";
		if($row<=0){
			echo "<div class='col-md-12'><p><b>ไม่พบรายการสินค้า</b></p></div>";
		}else{
			echo "<p><b>รายการสินค้าแบ่งตามประเภทและหมวดหมู่</b></p>";
			while (list($product_id,$product_name,$product_image,$quality_name,$type_name)=mysqli_fetch_row($query_product)) {
				echo "<div class='col-md-4' style='margin-bottom:40px;pading:5px;'>";
					echo "<input type='hidden' id='product_$product_id' value='$product_id'>";
					echo "<a id='select_$product_id' style='cursor:pointer'><p align='center'><img src='../images/$type_name/$product_image' width='90%' height='180px' ></p>";
					echo "<p align='center'><b>$product_name</b></p></a>";
				echo "</div>";
			}
			
		}
		echo "</div>";
	break;
	case 'product_detail':
		$query_product_detail =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product_image.product_image,type.type_name FROM product LEFT JOIN product_image ON product.product_id = product_image.product_id LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id='$_POST[product_id]'")or die("ERROR : backend functopn line 44");
		list($product_id,$product_name,$product_image,$type_name)=mysqli_fetch_row($query_product_detail);
?>
		<div class="panel panel-default">
		  <div class="panel-heading">ซื้อเข้าสินค้า<?php echo "$product_name";?></div>
		  <div class="panel-body">
		    <div class="container-fluid" style='padding:0px'>
		    	<div class='col-md-12' style='padding:0px'>
		    		<p align="center"><img src="<?php echo "../images/$type_name/$product_image" ?>" width='60%' height='300'></p>
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
		    				<th valign="top"><p>จำนวนที่ซื้อเข้า</p></th>
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
		    		<p align="right"><input class='btn btn-sm btn-success' type="submit" value="บันทึกการซื้อเข้า"></p>
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
	
	default: break;
}

?>

<?php
	session_start();
	include("../../include/function.php");
	connect_db();

?>
<head>

<script>
$(document).ready(function() {	
  $(function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange:"c-30:c+0"
    });
  });
  $("#datepicker").change(function(){
  	document.getElementById("report_sell_day").innerHTML=document.getElementById("datepicker").value;
  	$.post('ajax/function.php?data=select_order',{date:innerHTML=document.getElementById("datepicker").value},function(data){
  		$('#list_order').html(data);
  		if(data=="<p><b>ไม่พบรายการขาย</p>"){
  			document.getElementById("chartContainer").innerHTML="";
  		}

    });
  });
});
</script>
<script type="text/javascript">


<?php
	$date_select = date("Y-m-d");
	$date = date("d-m-Y");
	$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE DATE(order_date)='$date_select' AND (order_status='3' OR order_status='4') ")or die("ERROR : report_sell_day line 47");
	$rows = mysqli_num_rows($query_order);
	if($rows>0){
		while (list($order_id)=mysqli_fetch_row($query_order)) {
			$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN product ON product_size.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id ASC")or die("ERROR : report_sell_day line 47");
			while (list($amount,$product_name,$size_name)=mysqli_fetch_row($query_order_detail)) {
				$order_detail[]=array("name"=>"$product_name ($size_name)","amount"=>"$amount");
			}
		}
	echo "var chart = new CanvasJS.Chart('chartContainer', {";
		echo "title:{"; 
			echo "text: 'รายงานการขายวันที่ $date'  ";             
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
</head>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">รายงานการขายสินค้า</a></li>
			<li><a href="#">รายงานการขายรายวัน</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
	<h4><b>เลือกวันที่ที่ต้องการดูรายการขาย</b></h4>
	<p><b>เลือกวันที่ : </b><input type='text' id="datepicker"></p>
	<div class="col-md-6" style="padding:0px;margin-top:10px;">
<?php
	$date = date("d-m-Y");
	$date_select = date("Y-m-d");
?>
	<p><b>รายงานการขายวันที่ : </b><font id='report_sell_day'><?php echo "$date";?></font></p>
<?php
	$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id,total_amount,total_price FROM orders WHERE DATE(order_date)='$date_select' AND (order_status='3' OR order_status='4') ")or die("ERROR : report_sell_day line 47");
	$rows = mysqli_num_rows($query_order);
	echo "<div id='list_order'>";
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
<?php
	}
	echo "</div>";	
?>	
	</div>
	<div class="col-md-6"  style='margin-top:10px;'>
		<div id="chartContainer" style="height: 300px; width: 100%;"></div>
	</div>
</div>
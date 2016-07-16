
<?php

	session_start();
	include("../../include/function.php");
	connect_db();
?>
<script>
$(document).ready(function() {
<?php
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_status='$_POST[order_status]' AND type_order='web'")or die("ERROR : order function line 21");
	$row = mysqli_num_rows($query_order);
	if($row!=0){
		while(list($order_id)=mysqli_fetch_row($query_order)){
			echo "$('#select_order_$order_id').click(function(){";
				echo "var order_id ='$order_id';";
				echo "$.post('ajax/order_detail.php',{order_id:order_id},function(data){";
					echo "$('#order_detail').html(data);";
	            echo "});";   
			echo "});";
		}
	}
?>
});
</script>
<?php
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_status='$_POST[order_status]' AND type_order='web'")or die("ERROR : select order line 7");
	$number=1;
	echo "<table class='table table-striped table-hover'>";
	echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสซื้อสินค้า</th><th align='center'>วันที่สั่งซื้อ</th><th align='center'>สถานะการซื้อสินค้า</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th align='center'>ผู้ชื้อ</th></tr>";
	while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
		echo "<tr>";
			echo "<td>$number</td>";
			echo "<input type='hidden' id='order_id' value='$order_id'>";
			echo "<td><a id='select_order_$order_id' style='text-decoration:none;cursor:pointer'>$order_id</a></td>";
			echo "<td>".substr($order_date,0,10)."</td>";
			echo "<td>$order_date_limit</td>";
			//echo "<td>$total_amount</td>";
			//echo "<td>$total_price</td>";
			echo "<td>$order_username</td>";		
		echo "</tr>";
		$number++;
	}
	echo "</table>";
?>
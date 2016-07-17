<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<script>
$(document).ready(function() {
<?php
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_status='1'")or die("ERROR : order function line 21");
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
	$query_order_status = mysqli_query($_SESSION['connect_db'],"SELECT * FROM status")or die("ERROR : backend manage order line 29");
	while(list($status_id,$status_name)=mysqli_fetch_row($query_order_status)){
		echo "$('#oreder_status_$status_id').click(function(){";
			echo "var status = document.getElementById('oreder_status_$status_id').value;";
			echo "$.post('ajax/select_order.php',{order_status:status},function(data){";
				echo "$('#show_order').html(data);";
            echo "});";
		echo "});";
	}
?>
});
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการข้อมูลผู้ใช้งาน</a></li>
			<li><a href="#">ดูรายการขายบนเว็บไซต์</a></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class='col-md-6'>
<?php
		
		echo "<div class='panel panel-info'>";
		  echo "<div class='panel-heading'>";
		    echo "<h3 class='panel-title'>เลือกดูรายการขายสินค้าที่ต้องการ</h3>";
		  echo "</div>";
		  echo "<div class='panel-body'>";
			  $query_order_status = mysqli_query($_SESSION['connect_db'],"SELECT * FROM status")or die("ERROR : backend manage order line 29");
			  while(list($status_id,$status_name)=mysqli_fetch_row($query_order_status)){
			    echo "<div class='col-md-6'>";
			    	$checked = ($status_id==1)?"checked='checked'":"";
			    	echo "<input type='radio' id='oreder_status_$status_id' name='oreder_status' value='$status_id' $checked>&nbsp;$status_name";
			    echo "</div>";
			  }
		  echo "</div>";
		echo "</div>";
		
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_status='1' AND type_order='web' ")or die("ERROR : order function line 21");
		$row = mysqli_num_rows($query_order);
		echo "<div id='show_order'>";
		if(empty($row)){
			echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ไม่พบรายการขายสินค้า</b></h1></center>";
		}else{
			echo "<center><h4 style='background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สถานะการขายสินค้า</b></h4></center>";
			
			echo "<table class='table table-striped table-hover'>";
				echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสซื้อสินค้า</th><th align='center'>วันที่สั่งซื้อ</th><th align='center'>สถานะการซื้อสินค้า</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th align='center'>ผู้ชื้อ</th></tr>";
			$number=1;
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
			
		}
		echo "</div>";
?>
	</div>
	<div class='col-md-6' id='order_detail'>
		
	</div>
</div>


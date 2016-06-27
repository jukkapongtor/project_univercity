<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<script>
	$("#select_order").click(function(){
		alert(document.getElementById('select_order').innerHTML);
			$.ajax({
                type: 'POST',
                data: {order_id: document.getElementById('select_order').innerHTML},
                url: 'ajax/order_detail.php',
                success: function(data) {$('#order_detail').html(data);}
            });
          
        
	});
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการข้อมูลผู้ใช้งาน</a></li>
			<li><a href="#">ดูรายการขาย</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
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
			  echo "<div class='col-md-6'>";
			  	echo "<input type='radio' name='oreder_status' value='0' checked='checked'>&nbsp;สถานะทั้งหมด";
			  echo "</div>";
			  while(list($status_id,$status_name)=mysqli_fetch_row($query_order_status)){
			    echo "<div class='col-md-6'>";
			    	echo "<input type='radio' name='oreder_status' value='$status_id'>&nbsp;$status_name";
			    echo "</div>";
			  }
		  echo "</div>";
		echo "</div>";
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders ")or die("ERROR : order function line 21");
		$row = mysqli_num_rows($query_order);
		if(empty($row)){
			echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ไม่พบรายการขายสินค้า</b></h1></center>";
		}else{
			echo "<center><h4 style='background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สถานะการซื้อของสินค้า</b></h4></center>";
			echo "<table class='table table-striped table-hover'>";
				echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสซื้อสินค้า</th><th align='center'>เวลาในการชำระเงิน</th><th align='center'>สถานะการซื้อสินค้า</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th align='center'>ผู้ชื้อ</th></tr>";
			$number=1;
			$color=array("background:#dddddd;border:1px solid #bbb","background:#428bca;border:1px solid #256faf","background:#f0ad4e;border:1px solid #dfa451","background:#5bc0de;border:1px solid #2987a3","background:#5cb85c;border:1px solid #3c963c","background:#d9534f;border:1px solid #b53834");
			while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
				echo "<tr>";
					echo "<td>$number</td>";
					echo "<input type='hidden' id='order_id' value='$order_id'>";
					echo "<td><a id='select_order' style='text-decoration:none;cursor:pointer'>$order_id</a></td>";
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
?>
	</div>
	<div class='col-md-6' id='order_detail'>
		
	</div>
</div>


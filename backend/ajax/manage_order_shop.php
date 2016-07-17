<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<script>
function order_detail_shop(ele) {
		var order_id = ele.getAttribute("order_id");
		$.post('ajax/function.php?data=order_detail_shop',{order_id:order_id},function(data){
			$('#order_detail').html(data);
        });
}
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการข้อมูลผู้ใช้งาน</a></li>
			<li><a href="#">ดูรายการขายในร้าน</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-6">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		  	<h1 class="panel-title" style="font-size:18px">รายการขายสินค้าในร้าน</h1>
		  </div>
		  <div class="panel-body">
<?php
			$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_Status='4' AND type_order='shop' ORDER BY order_id DESC")or die("ERROR : order function line 21");
			$row = mysqli_num_rows($query_order);
			if(empty($row)){
				echo "<center><h4>ไม่เคยมีการขายสินค้า</h4></center>";
			}else{
				echo "<table class='table table-striped table-hover font20' style='font-size:12px'>";
					echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสขาย</th><th align='center'>วันที่ขาย</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th>จำนวน</th><th>ราคา</th></tr>";
				$number=1;

				$color=array("background:#dddddd;border:1px solid #bbb","background:#428bca;border:1px solid #256faf","background:#f0ad4e;border:1px solid #dfa451","background:#5bc0de;border:1px solid #2987a3","background:#5cb85c;border:1px solid #3c963c","background:#d9534f;border:1px solid #b53834");
				$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_status='4' AND type_order='shop'")or die("ERROR : order function line 21");
				$all_row = mysqli_num_rows($query_order);

				$total_page = ceil($all_row/10);
				if(empty($_GET['page'])){
					$page=1;
					$start_row=0;
				}
				else{
					$page=$_GET['page'];
					$start_row=($page-1)*10;
				}
				for($a=1;$a<$page;$a++){
				  	$number+=10;
				}
				$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_Status='4' AND type_order='shop' ORDER BY order_id DESC LIMIT $start_row,10")or die("ERROR : order function line 21");
				while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
					echo "<tr>";
						echo "<td align='center'>$number</td>";
						echo "<td><a onclick='order_detail_shop(this)' order_id='$order_id' style='text-decoration: none;cursor:pointer'>$order_id</td>";
						echo "<td>".substr($order_date,0,10)."</td>";
						echo "<td>$total_amount</td>";
						echo "<td>$total_price</td>";
						
					echo "</tr>";
					$number++;
				}
				echo "</table>";
				if($total_page>1){
				echo "<div class='col-md-12'>";
					echo "<center><nav><ul class='pagination'>";
					  echo "<li><a href='index.php?module=orders&action=list_order&page=1'>หน้าแรก</a></li>";
					  $preview = ($page-1);
					  $preview = ($preview<1)?1:$preview;
					  echo "<li><a href='index.php?module=orders&action=list_order&page=$preview'><<</a></li>";
				for($i=1;$i<=$total_page;$i++){
						$active = ($page==$i)?"active":"";
					  echo "<li class='$active'><a href='index.phpmodule=orders&action=list_order&page=$i'>$i</a></li>";
				}	
					  $next = ($page+1);
					  $next = ($next>$total_page)?$total_page:$next;
					  echo "<li><a href='index.php?module=orders&action=list_order&page=$next'>>></a></li>";
					  echo "<li><a href='index.php?module=orders&action=list_order&page=$total_page'>หน้าสุดท้าย</a></li>";
					echo "</ul></nav></center>";
				echo "</div>";
				}
			}
?>	    
	  	</div>
	</div>
	</div>
	<div class="col-md-6" id='order_detail'>

	</div>
	
</div>

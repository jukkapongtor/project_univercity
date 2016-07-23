<?php
function order_insert(){

		$total_price = 0;
		$total_amount  = 0;
		foreach ($_SESSION['cart_id'] as $key => $value) {
			$query_price = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_price_shop,product_amount_shop FROM product_size WHERE product_size_id='$key'")or die("ERROR : order function line 5");
			list($product_id,$product_price_shop,$product_amount_shop)=mysqli_fetch_row($query_price);
			$remain = $product_amount_shop - $value['amount'];
			if($remain<0){
				echo "<script>swal({title:'',text: 'ขออภัยสินค้าถูกซื้อไปก่อนหน้านี่แล้ว กรุณาลดจำนวนสินค้า หรือเลือกสินค้าชิ้นใหม่',type:'warning',showCancelButton: false,confirmButtonColor: '#f39729',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=cart&action=show_cart&';})</script>";
			}else{
				mysqli_query($_SESSION['connect_db'],"UPDATE product_size SET product_amount_shop='$remain' WHERE product_size_id='$key'")or die("ERROR : order function line 36");
			}
			$total_price+=($product_price_shop*$value['amount']);
			$total_amount +=$value['amount'];
		}
		if($total_amount!=0){
			$date_order = date("Y-m-d H:i:s");
			$sql_insert_order = "INSERT INTO orders VALUES('','$_SESSION[login_name]','$date_order','00:00:00','4','$total_amount','$total_price','','','shop')";
			mysqli_query($_SESSION['connect_db'],$sql_insert_order)or die("ERROR : order function line 14");
			$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders ORDER BY order_id DESC")or die("ERROR : order function line 15");
			list($order_id) = mysqli_fetch_row($query_order);
			$sql_insert_orderdetail ="INSERT INTO order_detail VALUES";
			$number=1;
			foreach ($_SESSION['cart_id'] as $key => $value) {
				if((!empty($value['amount']))&&$number!=1){
					$sql_insert_orderdetail.=",";
				}
				if($value['amount']!=0){
					$sql_insert_orderdetail.= "('','$order_id','$key','$value[amount]')";
					$number++;
				}
			}
			mysqli_query($_SESSION['connect_db'],$sql_insert_orderdetail)or die("ERROR : order function line 28");
			unset($_SESSION['cart_id']);
			unset($_SESSION['total_amount']);
			echo "<script>swal({title:'',text: 'จบขั้นตอนการขายสินค้า',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php';})</script>";
		}else{
			echo "<script>swal({title:'',text: 'กรุณาเพิ่มจำนวนสินค้าก่อนทำการยืนยันการซื้อ',type:'warning',showCancelButton: false,confirmButtonColor: '#f39729',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=cart&action=show_cart&';})</script>";
		}
	
	
}

function order_list(){
?>
<div class="menu-header">
	<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='#'>รายการขาย</a>  </p>
</div>
<p style="margin:5px"><b>ขายสินค้าโดย : </b><?php echo $_SESSION['login_name'] ?></p>
<hr style="margin:0px"><hr style="margin:2px">
<?php
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]' AND order_Status='4' AND type_order='shop' ORDER BY order_id DESC")or die("ERROR : order function line 21");
	$row = mysqli_num_rows($query_order);
	if(empty($row)){
		echo "<center><h4>ไม่เคยมีการขายสินค้า</h4></center>";
	}else{

		echo "<center><h4 style='background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการการขายสินค้า</b></h4></center>";
		echo "<table class='table table-striped table-hover font20' style='font-size:12px'>";
			echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสขาย</th><th align='center'>วันที่ขาย</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th>จำนวน</th><th>ราคา</th></tr>";
		$number=1;

		$color=array("background:#dddddd;border:1px solid #bbb","background:#428bca;border:1px solid #256faf","background:#f0ad4e;border:1px solid #dfa451","background:#5bc0de;border:1px solid #2987a3","background:#5cb85c;border:1px solid #3c963c","background:#d9534f;border:1px solid #b53834");
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_username='$_SESSION[login_name]' AND order_Status='4' AND type_order='shop'")or die("ERROR : order function line 21");
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
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]' AND order_Status='4' AND type_order='shop' ORDER BY order_id DESC LIMIT $start_row,10")or die("ERROR : order function line 21");
		while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
			echo "<tr>";
				echo "<td align='center'>$number</td>";
				echo "<td><a href='index.php?module=orders&action=order_detail&order_id=$order_id' style='text-decoration: none;'>$order_id</td>";
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
	
}
function order_success(){
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]' AND order_status='4'")or die("ERROR : order function line 218");
	$row = mysqli_num_rows($query_order);
	if($row>0){
		echo "<table class='table table-striped table-hover font20'>";
			echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสซื้อสินค้า</th><th align='center'>เวลาที่ซื้อสินค้า</th><th align='center'>เวลาในการชำระเงิน</th><th align='center'>สถานะการซื้อสินค้า</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th align='center'>ข้อมูล</th></tr>";
		while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){

		}
		echo "</table>";
	}else{
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ลูกค้ายังไม่เคยซื้อสินค้าจากร้านมุมเฟิร์น</b></h1></center>";
	}
}
function order_detail(){
?>
<div class="menu-header">
	<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='index.php?module=orders&action=order_list'>รายการขาย</a> / <a href='#'>รายละเอียดการขาย <?php echo "$_GET[order_id]";?></a></p>
</div>
<p style="margin:5px"><b>รายละเอียดการขายสินค้ารหัส : </b><?php echo $_GET['order_id'] ?></p>
<hr style="margin:0px"><hr style="margin:2px">
<?php
	echo "<table class='table table-hover table-striped' style='font-size:13px'>";      
		$total_price=0;
		$query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,size.size_name,product_size.product_price_shop,order_detail.amount,type.type_name_eng FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN product ON product.product_id = product_size.product_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN type ON product.product_type = type.product_type WHERE order_detail.order_id = '$_GET[order_id]'")or die("ERROR : order function line 111");
		while(list($product_id,$product_name,$size_name,$product_price_shop,$total_amount,$type_name)=mysqli_fetch_row($query_orderdetail)){
	     		echo "<tr>";
	     			$query_image = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id = '$product_id'")or die("ERROR : cart function line 16");
					list($product_image)=mysqli_fetch_row($query_image);
					$path = (empty($product_image))?"icon/no-images.jpg":"$type_name/$product_image";
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
}
?>
<?php
function order_insert(){
	$total_price = 0;
	$total_amount  = 0;
	foreach ($_SESSION['cart_id'] as $key => $value) {
		$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_name,product_price FROM product WHERE product_id='$key'")or die("ERROR : order function line 5");
		list($product_name,$product_price)=mysqli_fetch_row($query_product);
		$total_price+=($product_price*$value);
		$total_amount +=$value;
	}

	$date_order = date("Y-m-d H:i:s");
	$sql_insert_order = "INSERT INTO orders VALUES('','$_SESSION[login_name]','$date_order','24:00:00','1','$total_amount','$total_price','')";
	mysqli_query($_SESSION['connect_db'],$sql_insert_order)or die("ERROR : order function line 14");
	unset($_SESSION['cart_id']);
	unset($_SESSION['total_amount']);
	echo "<script>window.location='index.php?module=users&action=data_users&menu=3'</script>";
}

function order_list(){
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]'")or die("ERROR : order function line 21");
	$row = mysqli_num_rows($query_order);
	if(empty($row)){
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ไม่เคยมีสถานะซื้อสินค้า</b></h1></center>";
	}else{
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สถานะการซื้อของสินค้า</b></h1></center>";
		echo "<table class='table table-striped table-hover font20'>";
			echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสซื้อสินค้า</th><th align='center'>เวลาที่ซื้อสินค้า</th><th align='center'>เวลาในการชำระเงิน</th><th align='center'>สถานะการซื้อสินค้า</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th align='center'>ข้อมูล</th></tr>";
		$number=1;
		$color=array("background:#dddddd;border:1px solid #bbb","background:#428bca;border:1px solid #256faf","background:#f0ad4e;border:1px solid #dfa451","background:#5bc0de;border:1px solid #2987a3","background:#5cb85c;border:1px solid #3c963c","background:#d9534f;border:1px solid #b53834");
		while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
			echo "<tr>";
				echo "<td>$number</td>";
				echo "<td>$order_id</td>";
				echo "<td>".substr($order_date,0,10)."</td>";
				echo "<td>$order_date_limit</td>";
				$quert_status = mysqli_query($_SESSION['connect_db'],"SELECT status_name FROM status WHERE status_id='$order_status'")or die("ERROR : order function line 36");
				list($status_name)=mysqli_fetch_row($quert_status);
				echo "<td><p align='center' class='font20' style='border-radius:3px;padding-top:5px;color:white;$color[$order_status]'>$status_name</p></h4>";
				//echo "<td>$total_amount</td>";
				//echo "<td>$total_price</td>";
				echo "<td>";
					switch ($order_status) {
						case 1: echo "<button class='btn btn-sm btn-info font20' style='padding:2px;width:100%'>ส่งข้อมมูลชำระเงิน</button>"; break;
						case 3:	echo "<button class='btn btn-sm btn-success font20' style='padding:2px;width:100%'>รหัสส่งสินค้า</button>"; break;
					}
				echo "</td>";
			echo "</tr>";
			$number++;
		}
		echo "</table>";
	}
	
}
?>
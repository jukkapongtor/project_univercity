<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>

<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการข้อมูลผู้ใช้งาน</a></li>
			<li><a href="#">ข้อมูลผู้ใช้งาน</a></li>
			<li><a href="#">รายละเอียดผู้ใช้งาน</a></li>

		</ol>
	</div>
</div>
<?php

	$detail = mysqli_query ($_SESSION['connect_db'],"SELECT * FROM users WHERE username='$_GET[username]'") or die ("ERROE : backend file : detail_customer line 27 ");

	list($username,$passwd,$fullname,$lastname,$image,$phone,$email,$type,$house_no,$village_no,$alley,$lane,$road,$sub_district,$district,$province,$postal_code)=mysqli_fetch_row($detail);

	echo "<div style = 'width:100%; background :#16326a	; padding:5px;color:white;border-bottom:solid 3px #325bb0'><img src = '../images/icon/users2.png' width='30px' height='30px'><font size='4'>&nbsp;&nbsp;ข้อมูลผู้ใช้ทั่วไป</font></div>";
	$path = (empty($image))?"icon/no-images.jpg":"user/$image";
	echo"<div style = 'padding-top:30px; float:left; width:30%;'><center><img src = '../images/$path' width='200px' height='300px'></center></div>";
	echo"<div style = 'padding-top:30px; float:right; width:70%;'><font size='4'>";
		echo "<table width='80%'>";
			echo"<tr><td style ='padding:10px;' align=right>ชื่อผู้ใช้ : </td><td>$username</td><td style ='padding:10px;' align=right>ชื่อ-นามสกุล : </td><td> $fullname $lastname</td></tr>";
			echo"<tr><td style ='padding:10px;' align=right>อีเมลล์ : </td><td> $email</td><td style ='padding:10px;' align=right>โทรศัพท์ : </td><td> $phone</td></tr>";
			echo"<tr><td style ='padding:10px;' align=right>บ้านเลขที่ : </td><td> $house_no</td><td style ='padding:10px;' align=right>หมู่ : </td><td> $village_no</td></tr>";
			echo"<tr><td style ='padding:10px;' align=right>ตรอก : </td><td> $alley</td><td style ='padding:10px;' align=right>ซอย : </td><td> $lane</td></tr>";
			echo"<tr><td style ='padding:10px;' align=right>ถนน : </td><td> $road</td><td style ='padding:10px;' align=right>ตำบล : </td><td> $sub_district</td></tr>";
			echo"<tr><td style ='padding:10px;' align=right>อำเภอ : </td><td> $district</td><td style ='padding:10px;' align=right>จังหวัด : </td><td> $province</td></tr>";
			echo"<tr><td style ='padding:10px;' align=right>รหัสไปรษณีย์ : </td><td> $postal_code</td><td style ='padding:10px;' align=right></td><td></td></tr>";
		echo "</table>";
	echo "</font></div>";
	echo "<br style='clear:both'>";


	echo "<div style = 'width:100%; background :#16326a	; padding:5px;color:white;border-bottom:solid 3px #325bb0;margin-top:30px;'>
		<img src = '../images/icon/bag.png' width='30px' height='30px'>
			<font size='4'>&nbsp;&nbsp;ประวัติการสั่งซื้อ</font></div>";

	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT orders.*,transfer.transfer_date FROM orders LEFT JOIN transfer ON orders.order_id = transfer.order_id WHERE order_username='$_GET[username]' AND order_status='4'")or die("ERROR : order function line 218");
	$row = mysqli_num_rows($query_order);
	if($row>0){
		echo "<div class='col-md-2'></div>";
		echo "<div class='col-md-8' style='margin:20px;'>";
		echo "<table class='table table-striped table-hover'>";
			echo "<tr><th><center>ลำดับ</th><th><center>รหัสซื้อสินค้า</th><th><center>เวลาที่ซื้อสินค้า</th><th><center>เวลาในการชำระเงิน</th><!--<th>จำนวนสินค้า</th><th>ราคา</th>--></tr>";
		$num = 1;
		while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id,$address,$type_order,$transfer_date)=mysqli_fetch_row($query_order)){
			echo "<tr>";
				echo "<td align='center'>$num</td>";
				echo "<td ><a data-toggle='modal' data-target='#detail_$order_id' style='cursor:pointer;text-decoration: none;'>$order_id</a>";
					echo "<div class='modal fade' id='detail_$order_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
					  echo "<div class='modal-dialog' role='document'>";
					    echo "<div class='modal-content'>";
					      echo "<div class='modal-header' style='padding-bottom:0px;'>";
					        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
					        echo "<h4 class='modal-title font26' id='myModalLabel'><b>รายละเอียดการซื้อสินค้ารหัส : </b>$order_id</h4>";
					      echo "</div>";
					      echo "<div class='modal-body'>";
					        echo "<table class='table table-hover table-striped font20'>";
					        echo "<thead><tr><th><center>ลำดับ</th><th><center>ชื่อสินค้า</th><th><center>ขนาดสินค้า</th><th><center>ราคา(ชิ้น)</th><th><center>จำนวน</th><th><center>รวมราคา</th></tr></thead><tbody>";
					        $num=1;
					        $total_price=0;
					        $query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,product_size.product_price_web,order_detail.amount FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN product ON product.product_id = product_size.product_id LEFT JOIN size ON product_size.size_id = size.product_size WHERE order_detail.order_id = '$order_id'")or die("ERROR : order function line 111");
					        while(list($product_name,$size_name,$product_price_web,$total_amount)=mysqli_fetch_row($query_orderdetail)){
					     		echo "<tr>";
					     			echo "<td align='center'>$num</td>";
					     			echo "<td>$product_name</td>";
					     			echo "<td>$size_name</td>";
					     			echo "<td align='right'>".number_format($product_price_web,2)." ฿</td>";
					     			echo "<td align='right'>$total_amount</td>";
					     			$sum=$product_price_web*$total_amount;
					     			$total_price+=$sum;
					     			echo "<td align='right'>".number_format($sum,2)." ฿</td>";
					     		echo "</tr>";
					     		$num++;
					        }
					        echo "<tr><td colspan='5' align='right'><b>รวมยอดเงินทั้งหมด</b></td><td align='right'>".number_format($total_price,2)." ฿</td></tr>";
					        echo "</tbody></table>";
					        echo "<p align='right'><button type='button' class='btn btn-danger' data-dismiss='modal' >ปิด</button></p>";
					      echo "</div>";
					    echo "</div>";
					  echo "</div>";
					echo "</div>";
				echo "</td>";
				$order_date = substr($order_date, 0,10);
				echo "<td align='center'>$order_date</td>";
				$transfer_date = substr($transfer_date, 0,10);
				echo "<td align='center'>$transfer_date</td>";
			echo "</tr>";
			$num++;
		}
		echo "</table>";
		echo "</div>";
		echo "<div class='col-md-2'></div>";

	}else{
		echo "<center><h3 style='margin:40px 0px 50px 0px;'><font color='red' > !!! </font><b>ลูกค้ายังไม่เคยซื้อสินค้าจากร้านมุมเฟิร์น</b><font color='red'> !!! </font></h3></center>";
	}
?>

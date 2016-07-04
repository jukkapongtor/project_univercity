<?php
function order_insert(){

	if(empty($_POST['fullname'])||empty($_POST['lastname'])||empty($_POST['phone'])||empty($_POST['house_no'])||empty($_POST['subdistrict'])||empty($_POST['districts'])||empty($_POST['province'])||empty($_POST['zipcode'])){
		echo "<script>alert('กรุณากรอกข้อมูลผู้ใช้ให้ครบถ้วน');window.location='index.php?module=users&action=data_users&menu=2';</script>";
	}else{
		if($_POST['address']=="user"){
			$query_address = mysqli_query($_SESSION['connect_db'],"SELECT provinces.PROVINCE_NAME,amphures.AMPHUR_NAME,districts.DISTRICT_NAME FROM provinces LEFT JOIN amphures ON provinces.PROVINCE_ID = provinces.PROVINCE_ID LEFT JOIN districts ON amphures.AMPHUR_ID=districts.AMPHUR_ID WHERE provinces.PROVINCE_ID='$_POST[province]' AND amphures.AMPHUR_ID='$_POST[districts]' AND districts.DISTRICT_CODE='$_POST[subdistrict]'")or die("ERROR : users function line 312");
			list($province,$district,$subdistrict)=mysqli_fetch_row($query_address);
			$update_users = "UPDATE users SET fullname='$_POST[fullname]',lastname='$_POST[lastname]',phone='$_POST[phone]',house_no='$_POST[house_no]',village_no='$_POST[village_no]',alley='$_POST[alley]',lane='$_POST[lane]',road='$_POST[road]',sub_district='$subdistrict',district='$district',province='$province',postal_code='$_POST[zipcode]' WHERE username='$_SESSION[login_name]'";
			mysqli_query($_SESSION['connect_db'],$update_users)or die("ERROR : order function line 12");
			$village_no =(empty($_POST['village_no']))?"":" หมู่ $_POST[village_no]";
			$alley =(empty($_POST['alley']))?"":" ตรอก $_POST[alley]";
			$lane =(empty($_POST['lane']))?"":" ซอย $_POST[lane]";
			$road =(empty($_POST['road']))?"":" ถนน $_POST[road]";
			$message_address = "ชื่อนามสกุล ".$_POST['fullname'].$_POST['lastname']."<br>บ้านเลขที่ ".$_POST['house_no'].$village_no.$alley.$lane.$road." ตำบล ".$subdistrict."<br>อำเภอ ".$district."จังหวัด ".$province.$_POST['zipcode']."<br>"."เบอร์โทรศัพท์ ".$_POST['phone'];
		}else{
			$query_address = mysqli_query($_SESSION['connect_db'],"SELECT provinces.PROVINCE_NAME,amphures.AMPHUR_NAME,districts.DISTRICT_NAME FROM provinces LEFT JOIN amphures ON provinces.PROVINCE_ID = provinces.PROVINCE_ID LEFT JOIN districts ON amphures.AMPHUR_ID=districts.AMPHUR_ID WHERE provinces.PROVINCE_ID='$_POST[province]' AND amphures.AMPHUR_ID='$_POST[districts]' AND districts.DISTRICT_CODE='$_POST[subdistrict]'")or die("ERROR : users function line 312");
			list($province,$district,$subdistrict)=mysqli_fetch_row($query_address);
			$village_no =(empty($_POST['village_no']))?"":" หมู่ $_POST[village_no]";
			$alley =(empty($_POST['alley']))?"":" ตรอก $_POST[alley]";
			$lane =(empty($_POST['lane']))?"":" ซอย $_POST[lane]";
			$road =(empty($_POST['road']))?"":" ถนน $_POST[road]";
			$message_address = "ชื่อนามสกุล ".$_POST['fullname'].$_POST['lastname']."<br>บ้านเลขที่ ".$_POST['house_no'].$village_no.$alley.$lane.$road." ตำบล ".$subdistrict."<br>อำเภอ ".$district."จังหวัด ".$province.$_POST['zipcode']."<br>"."เบอร์โทรศัพท์ ".$_POST['phone'];
		}

		$total_price = 0;
		$total_amount  = 0;
		foreach ($_SESSION['cart_id'] as $key => $value) {
			$query_price = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_price_web FROM product_size WHERE product_size_id='$key'")or die("ERROR : order function line 5");
			list($product_id,$product_price_web)=mysqli_fetch_row($query_price);
			$total_price+=($product_price_web*$value['amount']);
			$total_amount +=$value['amount'];
		}
		if($total_amount!=0){
			$date_order = date("Y-m-d H:i:s");
			$sql_insert_order = "INSERT INTO orders VALUES('','$_SESSION[login_name]','$date_order','24:00:00','1','$total_amount','$total_price','','$message_address')";
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
			echo "<script>window.location='index.php?module=users&action=data_users&menu=3&order_status=1'</script>";
		}else{
			echo "<script>alert('กรุณาเพิ่มจำนวนสินค้าก่อนทำการยืนยันการซื้อ');window.location='index.php?module=users&action=data_users&menu=2';</script>";
		}
	}
	
}

function order_list(){
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]'")or die("ERROR : order function line 21");
	$row = mysqli_num_rows($query_order);
	echo "<div class='panel panel-warning' style='margin-top:20px;'>";
	  echo "<div class='panel-heading'>";
	    echo "<h3 class='panel-title font26'>วิธีการสั่งซื้อสินค้า</h3>";
	  echo "</div>";
	  echo "<div class='panel-body'>";
	    echo "<p class='font20'><b>การยืนยันหลักฐานการโอนเงิน</b></p>";
	    echo "<p class='font20'><b>การตรวจสอบกระบวนการโอนเงินจากเจ้าของร้าน</b></p>";
	    echo "<p class='font20'><b>การส่งสินค้า</b></p>";
	    echo "<p class='font20'><b>การเกิดกระบวนการผิดพลาด</b></p>";
	  echo "</div>";
	echo "</div>";
	echo "<div class='panel panel-info' style='margin-top:20px;'>";
	  echo "<div class='panel-heading'>";
	    echo "<h3 class='panel-title font26'>ช่องทางการชำระเงิน</h3>";
	  echo "</div>";
	  echo "<div class='panel-body'>";
	    echo "<p class='font20'><b>บัญชีธนาคาร : </b> 5555-2222-3333-1111</p>";
	  echo "</div>";
	echo "</div>";
	if(empty($row)){
		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ไม่เคยมีสถานะซื้อสินค้า</b></h1></center>";
	}else{

		echo "<center><h1 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สถานะการซื้อของสินค้า</b></h1></center>";
		echo "<div class='order-status'>";
			echo "<div class='order-status-center'></div>";
			switch ($_GET['order_status']) {
				case '1': $active_orsta1='order-status-active';$active_orsta2='';$active_orsta3='';$active_orsta5='';break;
				case '2': $active_orsta1='';$active_orsta2='order-status-active';$active_orsta3='';$active_orsta5='';break;
				case '3': $active_orsta1='';$active_orsta2='';$active_orsta3='order-status-active';$active_orsta5='';break;
				case '5': $active_orsta1='';$active_orsta2='';$active_orsta3='';$active_orsta5='order-status-active';break;
			}
            echo "<a href='index.php?module=users&action=data_users&menu=3&order_status=1'><div class='order-status1 $active_orsta1'><center>รอการชำระเงิน</center></div></a>";
            echo "<a href='index.php?module=users&action=data_users&menu=3&order_status=2'><div class='order-status2 $active_orsta2'><center>รอการตรวจสอบ</center></div></a>";
            echo "<a href='index.php?module=users&action=data_users&menu=3&order_status=3'><div class='order-status3 $active_orsta3'><center>กำลังส่งสินค้า</center></div></a>";
            echo "<a href='index.php?module=users&action=data_users&menu=3&order_status=5'><div class='order-status4 $active_orsta5'><center>ล้มเหลว</center></div></a>";
            echo "<div class='order-status-center'></div>";
        echo "</div>";
		echo "<table class='table table-striped table-hover font20'>";
			echo "<tr><th align='center'>ลำดับ</th><th align='center'>รหัสซื้อสินค้า</th><th align='center'>เวลาที่ซื้อสินค้า</th><th align='center'>เวลาในการชำระเงิน</th><th align='center'>สถานะการซื้อสินค้า</th><!--<th align='center'>จำนวนสินค้า</th><th align='center'>ราคา</th>--><th align='center'>ข้อมูล</th></tr>";
		$number=1;
		$color=array("background:#dddddd;border:1px solid #bbb","background:#428bca;border:1px solid #256faf","background:#f0ad4e;border:1px solid #dfa451","background:#5bc0de;border:1px solid #2987a3","background:#5cb85c;border:1px solid #3c963c","background:#d9534f;border:1px solid #b53834");
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]' AND order_status='$_GET[order_status]'")or die("ERROR : order function line 21");
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
						case 1: echo "<button class='btn btn-sm btn-info font20' data-toggle='modal' data-target='#formtranfer_$order_id' style='padding:2px;width:100%' >ส่งข้อมมูลชำระเงิน</button>"; break;
						case 3:	echo "<button class='btn btn-sm btn-success font20' style='padding:2px;width:100%'>รหัสส่งสินค้า</button>"; break;
					}
				echo "<div class='modal fade' id='formtranfer_$order_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
				  echo "<div class='modal-dialog modal-lg' role='document'>";
				    echo "<div class='modal-content'>";
				      echo "<div class='modal-header' style='padding-bottom:0px;'>";
				        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
				        echo "<h4 class='modal-title font26' id='myModalLabel'><b>ฟอร์มการชำระเงินการซื้อสินค้ารหัส : </b>$order_id</h4>";
				      echo "</div>";
				      echo "<div class='modal-body'>";
				        echo "<p class='font20'><b>รายละเอียดการซื้อสินค้ารหัส : </b>$order_id</p>";
				        echo "<table class='table table-hover table-striped font20'>";
				        echo "<thead><tr><th>ลำดับ</th><th>ชื่อสินค้า</th><th>ขนาดสินค้า</th><th>ราคา(ชิ้น)</th><th>จำนวน</th><th>รวมราคา</th></tr></thead><tbody>";
				        $num=1;
				        $total_price=0;
				        $query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,product_size.product_price_web,order_detail.amount FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN product ON product.product_id = product_size.product_id LEFT JOIN size ON product_size.size_id = size.product_size WHERE order_detail.order_id = '$order_id'")or die("ERROR : order function line 111");
				        while(list($product_name,$size_name,$product_price_web,$total_amount)=mysqli_fetch_row($query_orderdetail)){
				     		echo "<tr>";
				     			echo "<td>$num</td>";
				     			echo "<td>$product_name</td>";
				     			echo "<td>$size_name</td>";
				     			echo "<td>$product_price_web</td>";
				     			echo "<td>$total_amount</td>";
				     			$sum=$product_price_web*$total_amount;
				     			$total_price+=$sum;
				     			echo "<td>".number_format($sum)."</td>";
				     		echo "</tr>";
				     		$num++;
				        }
				        echo "<tr><td colspan='5' align='right'><b>รวมยอดเงินทั้งหมด</b></td><td>".number_format($total_price)."</td></tr>";
				        echo "</tbody></table>";
				        echo "<p class='font20'><b>แบบฟอร์มการส่งหลักฐานการโอนเงิน</b></p>";
				     	echo "<form action ='index.php?module=transfer&action=check_transfer' method='post' enctype='multipart/form-data'>";
				     		echo "<input type='hidden' name='order_id' value='$order_id'>";
				     		echo "<div class='col-md-2' style='padding-top:5px;'><b>เลือกไฟล์ : </b></div><div class='col-md-10'><input type='file' name='image_transfer'></div>";
				     	echo "<hr>";
				     	echo "<p align='right'><button type='submit' class='btn btn-primary font20' style='padding:5px;'>ส่งข้อมูลการชำระเงิน</button>";
				        echo "&nbsp;<button type='button' class='btn btn-danger font20' data-dismiss='modal' style='padding:5px;'>ปิด</button></p>";
				        echo "</form>";
				      echo "</div>";
				    echo "</div>";
				  echo "</div>";
				echo "</div>";
				echo "</td>";
				
			echo "</tr>";
			$number++;
		}
		echo "</table>";
	}
	
}
?>
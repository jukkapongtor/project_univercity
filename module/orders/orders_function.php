<?php
function order_insert(){

	if(empty($_POST['fullname'])||empty($_POST['lastname'])||empty($_POST['phone'])||empty($_POST['house_no'])||empty($_POST['subdistrict'])||empty($_POST['districts'])||empty($_POST['province'])||empty($_POST['zipcode'])){
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<script>swal({title:'',text: \"กรุณากรอกข้อมูลผู้ใช้ให้ครบถ้วน\",type:'error',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='index.php?module=users&action=data_users&menu=2';})</script>";
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
			$query_price = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_sprice_web,product_price_web,product_amount_web FROM product_size WHERE product_size_id='$key'")or die("ERROR : order function line 5");
			list($product_id,$product_sprice_web,$product_price_web,$product_amount_web)=mysqli_fetch_row($query_price);
			$price = ($product_sprice_web!=0)?$product_sprice_web:$product_price_web;
			$remain = $product_amount_web - $value['amount'];
			if($remain<0){
				echo "<script>swal({title:'',text: \"ขออภัยสินค้าถูกซื้อไปก่อนหน้านี่แล้ว\",type:'warning',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=users&action=data_users&menu=2';})</script>";
			}else{
				mysqli_query($_SESSION['connect_db'],"UPDATE product_size SET product_amount_web='$remain' WHERE product_size_id='$key'")or die("ERROR : order function line 36");
			}
			$total_price+=($price*$value['amount']);
			$total_amount +=$value['amount'];
		}
		if($total_amount!=0){
			$date_order = date("Y-m-d H:i:s");
			$sql_insert_order = "INSERT INTO orders VALUES('','$_SESSION[login_name]','$date_order','24:00:00','1','$total_amount','$total_price','','$message_address','web')";
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
					$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id,size_id FROM product_size WHERE product_size_id='$key'")or die("ERROR : order function line 5");
					list($product_id,$size_id)=mysqli_fetch_row($query_product);
					$query_price = mysqli_query($_SESSION['connect_db'],"SELECT product_sprice_web,product_price_web FROM product_size WHERE product_size_id='$key'")or die("ERROR : order function line 5");
					list($product_sprice_web,$product_price_web)=mysqli_fetch_row($query_price);
					$price = ($product_sprice_web!=0)?$product_sprice_web:$product_price_web;
					$sql_insert_orderdetail.= "('','$order_id','$product_id','$size_id','$value[amount]','$price')";
					$number++;
				}
			}
			mysqli_query($_SESSION['connect_db'],$sql_insert_orderdetail)or die("ERROR : order function line 28");
			unset($_SESSION['cart_id']);
			unset($_SESSION['total_amount']);
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			echo "<script>swal({title:'',text: \"สั่งซื้อสินค้าเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=users&action=data_users&menu=3&order_status=1';})</script>";
		}else{
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			echo "<script>swal({title:'',text: \"กรุณาเพิ่มจำนวนสินค้าก่อนทำการยืนยันการซื้อ\",type:'error',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=users&action=data_users&menu=2';})</script>";
		}
	}
	
}

function order_list(){
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]'")or die("ERROR : order function line 21");
	$row = mysqli_num_rows($query_order);
	echo "<div class='panel panel-warning' style='margin-top:5px;'>";
	  echo "<div class='panel-heading'>";
	    echo "<h3 class='panel-title'>วิธีการสั่งซื้อสินค้า</h3>";
	  echo "</div>";
	  echo "<div class='panel-body' style='padding:0px'>";
	    echo "<p class='font20'><img src='images/icon/ขั้นตอนสั่งซื้อสินค้า.png' width='100%'></p>";
	  echo "</div>";
	echo "</div>";
	echo "<div class='panel panel-info' style='margin-top:20px;'>";
	  echo "<div class='panel-heading'>";
	    echo "<h3 class='panel-title '>ช่องทางการชำระเงิน</h3>";
	  echo "</div>";
	  echo "<div class='panel-body' style='padding:3px 0px'>";
	    echo "<div class='col-md-6' style='padding:2px'><img src='images/icon/scb.png' width='100%'></div>";
	  echo "</div>";
	echo "</div>";
	if(empty($row)){
		echo "<center><h3 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ลูกค้ายังไม่เคยสั่งซื้อสินค้าจากร้านมุมเฟิร์น</b></h3></center>";
	}else{

		echo "<center><h3 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>สถานะการซื้อของสินค้า</b></h3></center>";
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
        
		
		$number=1;
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_username='$_SESSION[login_name]' AND order_status='$_GET[order_status]'")or die("ERROR : order function line 21");
		$all_row = mysqli_num_rows($query_order);

		$total_page = ceil($all_row/5);
		if(empty($_GET['page'])){
			$page=1;
			$start_row=0;
		}
		else{
			$page=$_GET['page'];
			$start_row=($page-1)*5;
		}
		for($a=1;$a<$page;$a++){
		  	$number+=5;
		}
		if($_GET['order_status']==1){
			echo "<p align='center'><font color='red'> **** </font>กรุณาชำระเงินและแจ้งการโอนเงินภายในระยะเวลา 3 วันหลังทำการสั่งซื้อสินค้า<font color='red'> **** </font></p>";
		}
		echo "<table class='table table-striped table-hover'>";
			echo "<tr><th><center>ลำดับ</th><th><center>รหัสซื้อสินค้า</th><th><center>เวลาที่ซื้อสินค้า</th>";
			if($_GET['order_status']==1){
				echo "<th><center>เวลาในการชำระเงิน</th>";
			}
			echo "<!--<th>เวลาในการชำระเงิน</th><th>สถานะการซื้อสินค้า</th><th>จำนวนสินค้า</th><th>ราคา</th>--><th><center>หมายเหตุ</th></tr>";
		$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]' AND order_status='$_GET[order_status]' LIMIT $start_row,5")or die("ERROR : order function line 21");
		while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
			echo "<tr>";
				echo "<td align='center'>$number</td>";
				echo "<td>";
					echo "<a data-toggle='modal' data-target='#detail_$order_id' style='cursor:pointer;text-decoration: none;'>$order_id</a>";
					echo "<div class='modal fade' id='detail_$order_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
					  echo "<div class='modal-dialog modal-lg' role='document'>";
					    echo "<div class='modal-content'>";
					      echo "<div class='modal-header' style='padding-bottom:0px;'>";
					        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
					        echo "<h4 class='modal-title' id='myModalLabel'><b>รายละเอียดการซื้อสินค้ารหัส : </b>$order_id</h4>";
					      echo "</div>";
					      echo "<div class='modal-body'>";
					      	echo "<div class='table-responsive'>";

					        echo "<table class='table table-hover table-striped font20'>";
					        echo "<thead><tr><th><center>ลำดับ</th><th><center>ชื่อสินค้า</th><th><center>ขนาดสินค้า</th><th><center>ราคา(ชิ้น)</th><th><center>จำนวน</th><th><center>รวมราคา</th></tr></thead><tbody>";
					        $num=1;
					        $total_price=0;
					        $query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,order_detail.price,order_detail.amount FROM order_detail LEFT JOIN product ON order_detail.product_id = product.product_id LEFT JOIN size ON order_detail.size_id = size.product_size WHERE order_detail.order_id = '$order_id'")or die("ERROR : order function line 111");
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
					        echo "</tbody></table></div>";
					        if($order_status!=5){
						        echo "<p align='center'><font color='red'> **** </font>เมื่อโอนเงินเสร็จและได้รับการตรวจสอบจากเจ้าของร้าน จะปรากฎปุ่มปริ้นใบเสร็จ<font color='red'> **** </font></p>";
						        if($order_status==3){
						        	echo "<p align='center'><a href='print/print_bill.php?order_id=$order_id' target='_blank'><button class='btn btn-info'><span class='glyphicon glyphicon-print' aria-hidden='true'></span> ปริ้นใบเสร็จ</button></a></p>";
						        }
						    }else{
						    	echo "<div class='container-fluid' style='margin-bottom:10px;'>";
						    		echo "<h4 align='center' ><font color='red'> **** </font><b>รายละเอียดข้อผิดพลาด</b><font color='red'> **** </font></h4>";
						    		echo "<div class='col-md-2'></div>";
						    		echo "<div class='col-md-4'>";
						    			$query_transfer = mysqli_query($_SESSION['connect_db'],"SELECT transfer_image FROM transfer WHERE order_id='$order_id'")or die("ERROR order function line 175");
						    			list($transfer_image)=mysqli_fetch_row($query_transfer);
						    			$path = (empty($transfer_image))?"icon/no-images.jpg":"transfer/$transfer_image";
						    			echo "<img src ='images/$path' align='center' width='80%' height='300px'>";
						    		echo "</div>";
						    		echo "<div class='col-md-4'>";
						    			echo "<p><b>สาเหตุที่เกิดข้อผิดพลาด</b></p>";
						    			$tracking_id = (empty($tracking_id))?"เจ้าของร้านไม่ได้ระบุสาเหตุ":$tracking_id;
						    			echo "<p>&nbsp;&nbsp;&nbsp;$tracking_id</p>";
						    			echo "<br><br><br><p>&nbsp;&nbsp;&nbsp;หากมีข้อสงสัยกรุณาติดต่อเจ้าของร้าน</p>";
						    			echo "<p>&nbsp;&nbsp;&nbsp;<b>เบอร์โทรศัพท์ : </b>090-893-xxxx</p>";
						    		echo "</div>";
						    		echo "<div class='col-md-2'></div>";
						    	echo "</div>";
						    }
					        echo "<p align='right'><button type='button' class='btn btn-danger' data-dismiss='modal' >ปิด</button></p>";
					      echo "</div>";
					    echo "</div>";
					  echo "</div>";
					echo "</div>";
				echo "</td>";
				echo "<td>".substr($order_date,0,10)."</td>";
				if($_GET['order_status']==1){;
					echo "<td>".date("Y-m-d", strtotime("+3 day", strtotime(substr($order_date,0,10))))."</td>";
				}
				$quert_status = mysqli_query($_SESSION['connect_db'],"SELECT status_name FROM status WHERE status_id='$order_status'")or die("ERROR : order function line 36");
				list($status_name)=mysqli_fetch_row($quert_status);
				//echo "<td><p align='center' class='font20' style='border-radius:3px;padding-top:5px;color:white;$color[$order_status]'>$status_name</p></h4></td>";
				//echo "<td>$total_amount</td>";
				//echo "<td>$total_price</td>";
				echo "<td>";
					switch ($order_status) {
						case 1: echo "<button class='btn btn-sm btn-info font20' data-toggle='modal' data-target='#transfer_$order_id'  style='padding:2px;width:100%' >ส่งข้อมมูลชำระเงิน</button>"; break;
						case 2:	echo "$tracking_id"; break;
						case 3:	echo "$tracking_id"; break;
						case 5:	echo "$tracking_id"; break;
					}
					echo "<div class='modal fade' id='transfer_$order_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
					  echo "<div class='modal-dialog' role='document'>";
					    echo "<div class='modal-content'>";
					      echo "<div class='modal-header' style='padding-bottom:0px;'>";
					        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
					        echo "<h4 class='modal-title font26' id='myModalLabel'><b>ฟอร์มการชำระเงินการซื้อสินค้ารหัส : </b>$order_id</h4>";
					      echo "</div>";
					      echo "<div class='modal-body'>";
					      echo "<div class='container-fluid'>";
					        echo "<p ><b>แบบฟอร์มการส่งหลักฐานการโอนเงินการซื้อสินค้ารหัส : </b>$order_id</p>";
					     	echo "<form action ='index.php?module=transfer&action=check_transfer' method='post' enctype='multipart/form-data'>";
					     		echo "<input type='hidden' name='order_id' value='$order_id'>";
					     		echo "<div class='col-md-4' style='padding:5px; 0px'><b>เลือกไฟล์หลักฐานโอนเงิน : </b></div><div class='col-md-8'><input type='file' name='image_transfer'  multiple onchange=\"document.getElementById('blah_$order_id').src = window.URL.createObjectURL(this.files[0])\"></div>";
					     	echo "<div class='col-md-12'><p align='center'><img src='' id='blah_$order_id' height='350px' width='60%'></p></div>";
					     	echo "<div class='col-md-12'>";
					     		echo "<div class='col-md-5'><p>จำนวนเงินทั้งหมดที่ต้องจ่าย : </p></div>";
					     		echo "<div class='col-md-7'><p>".number_format($total_price,2)." ฿</p></div>";
					     		echo "<div class='col-md-5'><p>จำนวนเงินที่โอน : </p></div>";
					     		echo "<div class='col-md-7'><p><input type='text' class='form-control' id='transfer_price_$order_id' name='transfer_price'></p></div>";
					     		echo "<input type='hidden' id='total_price_$order_id' name='total_price'  value='$total_price'>";
					     		echo "<div class='col-md-5' ><p>วันที่โอน : </p></div>";
					     		echo "<div class='col-md-7' ><p><input type='date' class='form-control' name='day' width='100%' ></p></div>";;
					     		echo "<div class='col-md-3'>เวลา </div>";
					     		echo "<div class='col-md-3'>";
					     			echo "<select class='form-control' name='minute'>";
					     				for($i=0;$i<24;$i++){
					     					$value = ( strlen($i)==1)?"0".$i:$i;
					     					echo "<option value='$i'>$value</option>";
					     				}
					     			echo "</select>";
					     		echo "</div>";
					     		echo "<div class='col-md-1'> : </div>";
					     		echo "<div class='col-md-3'>";
					     			echo "<select class='form-control' name='second'>";
					     				for($i=0;$i<60;$i++){
					     					$value = ( strlen($i)==1)?"0".$i:$i;
					     					echo "<option value='$i'>$value</option>";
					     				}
					     			echo "</select>";
					     		echo "</div>";
					     		echo "<div class='col-md-1'> น. </div>";
					     	echo "</div>";
					     	echo "<div class='col-md-12'><p align='right'><button type='submit' class='btn btn-primary font20 check_order' style='padding:5px;'>ส่งข้อมูลการชำระเงิน</button>";
					        echo "&nbsp;<button type='button' class='btn btn-danger' data-dismiss='modal' >ปิด</button></p></div>";
					        echo "</form>";
					        echo "</div>";
					      echo "</div>";
					    echo "</div>";
					  echo "</div>";
					echo "</div>";
				echo "</td>";
				
			echo "</tr>";
			$number++;
		}
		echo "</table>";

		if($total_page>1){
		echo "<div class='col-md-12'>";
			echo "<center><nav><ul class='pagination'>";
			  echo "<li><a href='index.php?module=users&action=data_users&menu=3&order_status=$_GET[order_status]&page=1'>หน้าแรก</a></li>";
			  $preview = ($page-1);
			  $preview = ($preview<1)?1:$preview;
			  echo "<li><a href='index.php?module=users&action=data_users&menu=3&order_status=$_GET[order_status]&page=$preview'><<</a></li>";
		for($i=1;$i<=$total_page;$i++){
				$active = ($page==$i)?"active":"";
			  echo "<li class='$active'><a href='index.php?module=users&action=data_users&menu=3&order_status=$_GET[order_status]&page=$i'>$i</a></li>";
		}	
			  $next = ($page+1);
			  $next = ($next>$total_page)?$total_page:$next;
			  echo "<li><a href='index.php?module=users&action=data_users&menu=3&order_status=$_GET[order_status]&page=$next'>>></a></li>";
			  echo "<li><a href='index.php?module=users&action=data_users&menu=3&order_status=$_GET[order_status]&page=$total_page'>หน้าสุดท้าย</a></li>";
			echo "</ul></nav></center>";
		echo "</div>";
		}
	}
	/*
	echo "<script>";
		echo "$(document).ready(function() {";
			$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_username='$_SESSION[login_name]' ")or die("ERROR : order function line 21");
			while(list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order)){
				echo "$('.check_order').click(function(){";
					echo "alert('asdasdasd');";
					echo "alert(document.getElementById('transfer_price_$order_id').value);";
					echo "alert(document.getElementById('total_price_$order_id')value);";
				echo "});";
			}
		echo "});";
	echo "</script>";
	*/
}
function order_success(){
;
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT orders.*,transfer.transfer_date FROM orders LEFT JOIN transfer ON orders.order_id = transfer.order_id WHERE order_username='$_SESSION[login_name]' ORDER BY order_status ASC")or die("ERROR : order function line 218");
	$row = mysqli_num_rows($query_order);
	if($row>0){
		echo "<center><h3 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ประวัติการซื้อสินค้าจากร้านมุมเฟิร์น</b></h3></center>";
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-hover font20'>";
			echo "<tr><th><center>ลำดับ</th><th><center>รหัสซื้อสินค้า</th><th><center>เวลาที่ซื้อสินค้า</th><!--<th><center>เวลาในการชำระเงิน</th><th>จำนวนสินค้า</th><th>ราคา</th>--><th><center>สถานะ</th><th><center>หมายเหตุ</th></tr>";
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
					        $number=1;
					        $total_price=0;
					        $query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,order_detail.price,order_detail.amount FROM order_detail LEFT JOIN product ON order_detail.product_id = product.product_id LEFT JOIN size ON order_detail.size_id = size.product_size WHERE order_detail.order_id = '$order_id'")or die("ERROR : order function line 334");
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
					     		$number++;
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
				echo "<td >$order_date</td>";
				$transfer_date = substr($transfer_date, 0,10);
				//echo "<td >$transfer_date</td>";
				switch ($order_status) {
					case '1': $order_status_name ="รอการชำระเงิน"; break;
					case '2': $order_status_name ="รอการตรวจสอบโอนเงิน"; break;
					case '3': $order_status_name ="กำลังส่งสินค้า";break;
					case '4': $order_status_name ="การซื้อเสร็จสิ้น"; break;
					case '5': $order_status_name ="รายการล้มเหลว"; break;
				}
				
				echo "<td>$order_status_name</td>";
				if($order_status==3||$order_status==4){
					echo "<td ><center><a href='print/print_bill.php?order_id=$order_id' target='_blank'><button class='btn btn-info btn-sm'><span class='glyphicon glyphicon-print' aria-hidden='true'></span> ปริ้นใบเสร็จ</button></a></center></td>";	
				}else{
					echo "<td>$tracking_id</td?";
					
				}

				
			echo "</tr>";
			$num++;
		}
		echo "</table>";
		echo "</div>";
	}else{
		echo "<center><h3 style='margin-top:40px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>ลูกค้ายังไม่เคยซื้อสินค้าจากร้านมุมเฟิร์น</b></h3></center>";
	}
}
?>
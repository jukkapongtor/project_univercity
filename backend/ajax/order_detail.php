<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>

<script>
$(document).ready(function() {
<?php
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_status='1' AND type_order='web'")or die("ERROR : order detail line 9");
	while(list($order_id)=mysqli_fetch_row($query_order)){
		echo "$('#change_$order_id').click(function(){";

				echo "var status = document.getElementById('change_oreder_$order_id').value;";
				echo "alert(status+'$order_id');";
				echo "window.location='ajax/change_order.php?order_id=$order_id&status='+status+'';";
				/*
				echo "if(status==5){";

				echo "}else{";

				echo "}";
				*/
		echo "});";
	}
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_status='2' AND type_order='web'")or die("ERROR : order detail line 9");
	while(list($order_id)=mysqli_fetch_row($query_order)){
		echo "$('#transfer_error_$order_id').click(function(){";
			echo "var message_error = document.getElementById('message_error_$order_id').value;";
			echo "var order_id = document.getElementById('order_id_$order_id').value;";
			echo "if(message_error==''){";
				echo "swal('',\"กรุณากรอกข้อความก่อนทำการแจ้งการโอนเงินผิดพลาด\", 'warning');";
			echo "}else{";
				echo "swal({title:'',text: 'ย้ายรหัสการซื้อสินค้า $order_id ไปยังสถานะล้มเหลวแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='ajax/update_order_error.php?order_id='+order_id+'&message_error='+message_error+'';})";
			echo "}";
		echo "});";
		echo "$('#transfer_success_$order_id').click(function(){";
			echo "var order_id = document.getElementById('order_id_$order_id').value;";
			echo "if(swal({title:'',text: 'ยืนยันการโอนเงิน',type:'warning',showCancelButton: true,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',cancelButtonText: 'ยกเลิก',closeOnConfirm: false },function(){window.location='ajax/update_order_sendproduct.php?order_id='+order_id+'';})){";
			echo "}else{";
			echo "}";
		echo "});";
	}
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE order_status='3' AND type_order='web'")or die("ERROR : order detail line 29");
	while(list($order_id)=mysqli_fetch_row($query_order)){
		echo "$('#transfer_tracking_$order_id').click(function(){";
			echo "var order_id = document.getElementById('order_id_$order_id').value;";
			echo "var tracking = document.getElementById('tracking_$order_id').value;";
			echo "swal({title:'',text: 'อัพเดทสถานะการส่งสินค้า เรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='ajax/update_order_tracking_id.php?order_id='+order_id+'&tracking='+tracking+'';})"; 
		echo "});";
		echo "$('#send_success_$order_id').click(function(){";
			echo "var order_id = document.getElementById('order_id_$order_id').value;";
			echo "var change_success = document.getElementById('change_success_$order_id').value;";
			echo "if(change_success==4){";
				echo "swal({title:'',text: 'ย้ายสถานะสินค้าจากกำลังส่งสินค้า ไป จบกระบวนการ เรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='ajax/update_change_success.php?order_id='+order_id+'&change_success='+change_success+'';})"; 
	        echo "}";
		echo "});";
	}
	
?>
});
</script>
<body>
<?php
	$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : "";
	$query_order = mysqli_query($_SESSION['connect_db'],"SELECT * FROM orders WHERE order_id='$order_id' AND type_order='web'")or die("ERROR : backend order detail line 6");
	list($order_id,$order_username,$order_date,$order_date_limit,$order_status,$total_amount,$total_price,$tracking_id)=mysqli_fetch_row($query_order);

	echo "<div class='panel panel-primary'>";
	  echo "<div class='panel-heading'>";
	    echo "<h3 class='panel-title'><b>รายละเอียดการขายสินค้ารหัส : </b>$order_id</h3>";
	  echo "</div>";
	  echo "<div class='panel-body'>";
	    echo "<table width='100%'>";
	    	$query_status = mysqli_query($_SESSION['connect_db'],"SELECT status_id,status_name FROM status WHERE status_id='$order_status'")or die("ERROR : backend order detail line 17");
	    	list($status_id,$status_name)=mysqli_fetch_row($query_status);
	    	echo "<tr><th>สถานะการซื้อ&nbsp;</th><th> : </th><td colspan='2'>&nbsp;$status_name</td></tr>";
	    	echo "<tr><th>ผู้ชื้อสินค้า&nbsp;</th><th> : </th><td>&nbsp;$order_username</td></tr>";
	    	echo "<tr><th>วันที่สั่งซื้อ&nbsp;</th><th> : </th><td>&nbsp;$order_date</td></tr>";
			if($order_status==1){
				echo "<tr><th>เปลี่ยนสถานะ&nbsp;</th><th> : </th>";
					echo "<td>&nbsp;";
						echo "<table width='100%'><tr><td><select class='form-control' id='change_oreder_$order_id' style='margin-top:-15px'>";
							$query_status = mysqli_query($_SESSION['connect_db'],"SELECT status_id,status_name FROM status WHERE status_id != '2'")or die("ERROR : backend order detail line 17");
	    					while(list($status_id,$status_name)=mysqli_fetch_row($query_status)){
	    						echo "<option value='$status_id'>$status_name</option>";
	    					}
						echo "</select><td></div>";
						echo "<td><button type='button' class='btn btn-sm btn-success' id='change_$order_id' style='padding:0px 5px;margin-top:-5px;'>ตกลง</td></tr></table>";
					echo "</td>";
				echo "</tr>";
			}
	    	if($order_status==2){
	    		echo "<tr><th width='30%'>หลักฐานการจ่ายเงิน&nbsp;</th><th> : </th><td>&nbsp;<button type='button' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#show_bill' style='padding:0px 3px;margin-top:10px;'>แสดงหลักฐาน</button></td></tr>";
	    		echo "<div class='modal fade' id='show_bill' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
				  echo "<div class='modal-dialog' role='document'>";
				    echo "<div class='modal-content'>";
				      echo "<div class='modal-header'>";
				        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
				        echo "<h3 class='modal-title' id='myModalLabel'>แสดงหลักฐานการโอนเงิน</h3>";
				      echo "</div>";
				      echo "<div class='modal-body'>";
				        echo "<h5><b>แสดงรูปภาพการโอนเงิน</b></h5>";
				        $query_transfer = mysqli_query($_SESSION['connect_db'],"SELECT transfer_image,transfer_date FROM transfer WHERE order_id='$order_id'")or die("ERROR : backend order detail line 31");
				        list($transfer_image,$transfer_date)=mysqli_fetch_row($query_transfer);
				        echo "<p><b>อัพโหลดหลักฐานการโอนเงินเมื่อ : </b>$transfer_date</p>";
				        echo "<center><img src='../images/transfer/$transfer_image' width='60%'>";
				        echo "<p style='margin-top:20px;''>**หากหลักฐานข้อมูลไม่ถูกต้องกรุณาพืมพ์ความผิดพลาด เพื่อแจ้งแก่ทางลูกค้า**</p>";
				        echo "<textarea id='message_error_$order_id' style='width:80%;'></textarea></center>";
				        echo "<input type='hidden' id='order_id_$order_id' value='$order_id'>";
				        echo "<p align='right' style='margin-top:20px;'><button type='button' id='transfer_success_$order_id' class='btn btn-success'>ยืนยันการโอนเงิน</button>&nbsp;<button type='button' id='transfer_error_$order_id' class='btn btn-danger'>การโอนเงินล้มเหลว</button></a>";
				      echo "</div>";
				    echo "</div>";
				  echo "</div>";
				echo "</div>";
	    	}
	    	if($order_status==3){
	    		echo "<tr><th>แจ้งการส่งสินค้า&nbsp;</th><th> : </th><td><input class='form-control' type='text' id='tracking_$order_id' value='$tracking_id'><input type='hidden' id='order_id_$order_id' value='$order_id'></td><td><input type='button' id='transfer_tracking_$order_id' class='btn btn-sm btn-primary' value='อัพเดทการส่งสินค้า' style='padding:0px 5px; margin-top:8px;'></td></tr>";
	    		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
	    		echo "<tr><td colspan='4'>**เมื่อสินค้าส่งถึงผู้ซื้อแล้วสามารถเปลี่ยนจาก กำลังส่งสินค้า เป็น จบกระบวนการ**</td></tr>";

	    		echo "<tr><th>เปลี่ยนสถานะ&nbsp;</th><th> : </th>";
	    		echo "<td><select class='form-control' id='change_success_$order_id'><option value='3'>กำลังส่งสินค้า</option><option value='4'>จบกระบวนการ</option></select>";
	    		echo "<input type='hidden' id='order_id_$order_id' value='$order_id'></td>";
	    		echo "<td><input type='button' id='send_success_$order_id' value='เสร็จกระบวนการ' class='btn btn-sm btn-success' style='padding:0px 5px; margin-top:8px;'></td></tr>";

	    	}
	    	if($order_status==5){
	    		echo "<tr><th width='25%'>สาเหตุ</th><th> : </th><td>&nbsp;$tracking_id</td></tr>";
	    	}
	    echo "</table>";
	    echo "<table class='table table-hover table-striped' style='margin-top:20px;'>";
		    echo "<thead><tr><th>ลำดับ</th><th>ชื่อสินค้า</th><th>ขนาดสินค้า</th><th>ราคา(ชิ้น)</th><th>จำนวน</th><th>รวมราคา</th></tr></thead><tbody>";
		    $num=1;
		    $total_price=0;
		    $query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,order_detail.price,order_detail.amount FROM order_detail LEFT JOIN product ON order_detail.product_id = product.product_id LEFT JOIN size ON order_detail.size_id = size.product_size WHERE order_detail.order_id = '$order_id'")or die("ERROR : order function line 82");
		    while(list($product_name,$size_name,$product_price_web,$total_amount)=mysqli_fetch_row($query_orderdetail)){
		  		echo "<tr>";
		   			echo "<td align='center'>$num</td>";
				    echo "<td>$product_name</td>";
				    echo "<td>$size_name</td>";
				    echo "<td align='right'>".number_format($product_price_web,2)." ฿</td>";
				    echo "<td>$total_amount</td>";
				    $sum=$product_price_web*$total_amount;
				    $total_price+=$sum;
				    echo "<td><p align='right'>".number_format($sum,2)." ฿</p></td>";
		  		echo "</tr>";
		   		$num++;
		      }
		    echo "<tr><td colspan='5' align='right'><b>รวมยอดเงินทั้งหมด</b></td><td><p align='right'>".number_format($total_price,2)." ฿</p></td></tr>";
		echo "</tbody></table>";
	  echo "</div>";
	echo "</div>";
?>
<body>
<?php
	session_start();
	include("../include/function.php");
	connect_db();
	require_once('../mpdf/mpdf.php');
	ob_start();
?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

<style type="text/css">
<!--
@page rotated { size: landscape; }
.style1 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	font-weight: bold;
}
.style2 {
	font-family: "TH SarabunPSK";
	font-size: 14pt;
	font-weight: bold;
}
.style3 {
	font-family: "TH SarabunPSK";
	font-size: 14pt;
	
}
.style5 {cursor: hand; font-weight: normal; color: #000000;}
.style9 {font-family: Tahoma; font-size: 12px; }
.style11 {font-size: 12px}
.style13 {font-size: 9}
.style16 {font-size: 9; font-weight: bold; }
.style17 {font-size: 12px; font-weight: bold; }
-->

</style>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
</head>
<body>
<p align="center"><img src='../images/icon/logomumfern.png' width="100" height="100"></p>
<h3 align="center"><b>ร้านมุมเฟิร์น</b></h3>
<?php
	$day =(empty($_GET['day']))?"":" AND DAY(order_date)='$_GET[day]'";
	$month =(empty($_GET['month']))?"":" AND MONTH(order_date)='$_GET[month]' ";
	$year =(empty($_GET['year']))?"YEAR(order_date)='".date("Y")."'":" YEAR(order_date)='$_GET[year]'";
	$query_month = mysqli_query($_SESSION['connect_db'],"SELECT month_name FROM month WHERE month_id='$_GET[month]'")or die("ERROR : print expen line 50");
	list($month_name)=mysqli_fetch_row($query_month);
	$select_month = $month_name;
	

?>	
<p align="center">รายได้ประจำวันที่ <?php echo "$_GET[day] $select_month $_GET[year]" ?></p>
<?php
	$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE $year $month $day AND (order_status='3' OR order_status='4') AND type_order='web'")or die("ERROR : report_sell_day line 59");
	$rows = mysqli_num_rows($query_order);
	if($rows>0){
		$num=0;
		$order_detail =array();
		while (list($order_id)=mysqli_fetch_row($query_order)) {
			$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name,product_size.product_price_web FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN product ON product_size.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 47");
			while (list($amount,$product_name,$size_name,$product_price_web)=mysqli_fetch_row($query_order_detail)) {
				$check_dubble=0;
				foreach ($order_detail as $key => $value) {
					if($value['name']=="$product_name" AND $value['size']=="$size_name"){
						$order_detail[$key]['amount']=$value['amount']+$amount;
						$order_detail[$key]['price']=$value['price']+$product_price_web;
						$check_dubble=1;
					}
				}
				if($check_dubble==0){
					$order_detail[$num]=array("name"=>"$product_name","size"=>"$size_name","amount"=>"$amount","price"=>"$product_price_web");
				}
				$num++;
			}	
		}
		echo "<h4><b>รายละเอียดยอดขายบนเว็บไซต์</b></h4>";
		echo "<table width='100%' border='1' cellpadding='10' cellspacing='0'>";
			echo "<tr>";
				echo "<th><p>ชื่อสินค้า</p></th>";
				echo "<th><p>ขนาดสินค้า</p></th>";
				echo "<th><p>จำนวน</p></th>";
				echo "<th><p>ราคา</p></th>";
				echo "<th><p>รวมราคา</p></th>";
			echo "</tr>";
			$total_price=0;
			foreach ($order_detail as $key => $value) {
				echo "<tr>";
					echo "<td><p>$value[name]</p></td>";
					echo "<td><p>$value[size]</p></td>";
					echo "<td><p>$value[amount]</p></td>";
					echo "<td align='right'><p>".number_format($value['price'],2)." ฿</p></td>";
					echo "<td align='right'><p>".number_format(($value['amount']*$value['price']),2)." ฿</p></td>";
					$total_price +=($value['amount']*$value['price']);
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td colspan='4'><p align='right'>รวมราคาทั้งหมด</p></td>";
				echo "<td align='right'><p>".number_format($total_price,2)." ฿</p></td>";
			echo "</tr>";
		echo "</table>";								
	}
	$query_order =mysqli_query($_SESSION['connect_db'],"SELECT order_id FROM orders WHERE $year $month $day AND (order_status='3' OR order_status='4') AND type_order='shop'")or die("ERROR : report_sell_day line 247");
	$rows = mysqli_num_rows($query_order);
	if($rows>0){
		$num=0;
		$order_detail =array();
		while (list($order_id)=mysqli_fetch_row($query_order)) {
			$query_order_detail =mysqli_query($_SESSION['connect_db'],"SELECT order_detail.amount,product.product_name,size.size_name,product_size.product_price_shop FROM order_detail LEFT JOIN product_size ON order_detail.product_size_id = product_size.product_size_id LEFT JOIN size ON product_size.size_id = size.product_size LEFT JOIN product ON product_size.product_id = product.product_id WHERE order_detail.order_id = '$order_id' ORDER BY order_detail.order_id DESC")or die("ERROR : report_sell_day line 47");
			while (list($amount,$product_name,$size_name,$product_price_shop)=mysqli_fetch_row($query_order_detail)) {
				$check_dubble=0;
				foreach ($order_detail as $key => $value) {
					if($value['name']=="$product_name" AND $value['size']=="$size_name"){
						$order_detail[$key]['amount']=$value['amount']+$amount;
						$order_detail[$key]['price']=$product_price_shop;
						$check_dubble=1;
					}
				}
				if($check_dubble==0){
					$order_detail[$num]=array("name"=>"$product_name","size"=>"$size_name","amount"=>"$amount","price"=>"$product_price_shop");
				}
				$num++;
			}
		}
		echo "<h4><b>รายละเอียดยอดขายในร้าน</b></h4>"; 
		echo "<table width='100%' border='1' cellpadding='10' cellspacing='0'>";
			echo "<tr>";
				echo "<th><p>ชื่อสินค้า</p></th>";
				echo "<th><p>ขนาดสินค้า</p></th>";
				echo "<th><p>จำนวน</p></th>";
				echo "<th><p>ราคา</p></th>";
				echo "<th><p>รวมราคา</p></th>";
			echo "</tr>";
			$total_price=0;
			foreach ($order_detail as $key => $value) {
				echo "<tr>";
					echo "<td><p>$value[name]</p></td>";
					echo "<td><p>$value[size]</p></td>";
					echo "<td><p>$value[amount]</p></td>";
					echo "<td align='right'><p>".number_format($value['price'],2)." ฿</p></td>";
					echo "<td align='right'><p>".number_format(($value['amount']*$value['price']),2)." ฿</p></td>";
					$total_price +=($value['amount']*$value['price']);
				echo "</tr>";
			}
			echo "<tr>";
				echo "<td colspan='4'><p align='right'>รวมราคาทั้งหมด</p></td>";
				echo "<td align='right'><p>".number_format($total_price,2)." ฿</p></td>";
			echo "</tr>";
		echo "</table>";		
	}
?>
</body>
</html>
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4', '0', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>     
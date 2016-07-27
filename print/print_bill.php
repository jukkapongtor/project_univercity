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
<p align="center"><img src="../images/icon/logomumfern.png" width="100" height="100"></p>
<p align="center" style="padding:-2px;" font='4'><b>ใบเสร็จร้านมุมเฟิร์น</b></p>
<p align="center" style="padding:-2px;">ตลากคำเที่ยง ล็อค f208-f209 ตำบล ป่าตัน อำเภอเมือง จังหวัดเชียงใหม่ 50300</p>
<p align="center" style="padding:-2px;">เบอร์โทร : 081-8055024   E-mail : veerada@mumfern.com</p>
<br>

<?php
	$query_orders = mysqli_query($_SESSION['connect_db'],"SELECT address FROM orders WHERE order_id='$_GET[order_id]'")or die("ERROR  print bill line 46");
	list($address)=mysqli_fetch_row($query_orders);
	echo $address;
	echo "<table width='100%' border='1' cellspacing='0' cellpadding='5'>";
    echo "<thead><tr><th><center>ลำดับ</th><th><center>ชื่อสินค้า</th><th><center>ขนาดสินค้า</th><th><center>ราคา(ชิ้น)</th><th><center>จำนวน</th><th><center>รวมราคา</th></tr></thead><tbody>";
	$num=1;
	$total_price=0;
	$query_orderdetail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,size.size_name,order_detail.price,order_detail.amount FROM order_detail LEFT JOIN product ON order_detail.product_id = product.product_id LEFT JOIN size ON order_detail.size_id = size.product_size WHERE order_detail.order_id = '$_GET[order_id]'")or die("ERROR  print bill line 51");
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
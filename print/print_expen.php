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
	$day =(empty($_GET['day']))?"":" AND DAY(supply_date)='$_GET[day]'";
	$month =(empty($_GET['month']))?"":" AND MONTH(supply_date)='$_GET[month]' ";
	$year =(empty($_GET['year']))?"YEAR(supply_date)='".date("Y")."'":" YEAR(supply_date)='$_GET[year]'";
	$query_month = mysqli_query($_SESSION['connect_db'],"SELECT month_name FROM month WHERE month_id='$_GET[month]'")or die("ERROR : print expen line 50");
	list($month_name)=mysqli_fetch_row($query_month);
	$select_month = $month_name;
	

?>	
<p align="center">ค่าใช้จ่ายประจำวันที่ <?php echo "$_GET[day] $select_month $_GET[year]" ?></p>

<?php
	$query_buy_supply = mysqli_query($_SESSION['connect_db'],"SELECT * FROM buy_supply WHERE $year $month $day")or die("ERROR report buy month line 168");
	$row = mysqli_num_rows($query_buy_supply);
	if(empty($row)){
		echo "<h4 align='center'><font color='red'> !!! </font>ไม่พบรายการค่าใช้จ่าย<font color='red'> !!! </font></h4>";
	}else{
		$num=1;
		$total_price = 0;
		echo "<table width='100%' cellpadding='10' cellspacing='0' border='1'>";
			echo "<tr><th><center>ลำดับ</center></th><th><center>ชื่อวัสดุ</center></th><th><center>จำนวนที่ซื้อ(ชิ้น)</center></th><th><center>หน่วยวัสดุ</center></th><th><center>ราคาที่ซื้อ(หน่วย)</center></th><th><center>รวมราคา</center></th></tr>";
		while(list($buy_id,$supply_name,$supply_amount,$supply_price,$supply_unit,$supply_date)=mysqli_fetch_row($query_buy_supply)){
			echo "<tr><td align='center'>$num</td><td>$supply_name</td><td align='right'>$supply_amount</td><td>$supply_unit</td><td align='right'>".number_format(($supply_price),2)." ฿</td><td align='right'>".number_format($supply_price*$supply_amount,2)." ฿</td></tr>";
			$total+=$supply_price*$supply_amount;
			$num++;
		}
			echo "<tr><td align='right' colspan='5'>รวมเป็นจำนวนเงินทั้งหมด</td><td align='right'>".number_format($total,2)." ฿</td></tr>";
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
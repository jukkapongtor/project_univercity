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
<?php
echo "<table align='center' border='1' cellspacing='0' width='100%'>";
    for($a=0;$a<7;$a++){
        echo "<tr>";
            $num=0;
            for($b=0;$b<5;$b++){
                echo "<td width='20%'>";
                    echo "<img src="."../backend/ajax/phpqrcode/temp/".basename($_SESSION['filename'][$num])." width='115px'/>";
                    echo "<center><font style='font-size:16px;'>".$_SESSION['product_name'][$num]."</font></center>";
                echo "</td>";
                $num++;
                $num=($num>=count($_SESSION['product_id']))?0:$num;
            }
        echo "</tr>";
    }
    echo "</table>";
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
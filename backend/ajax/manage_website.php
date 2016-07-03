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
			<li><a href="#">จัดการรายการสินค้า</a></li>
			<li><a href="#">แสดงรายการสินค้า</a></li>
			<li><a href="#">แก้ไขสินค้า</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
<?php
		$query_webpage = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status,open_web FROM web_page ")or die("ERROR : backend manage_website line 65");
		list($sellproduct_status,$open_web)=mysqli_fetch_row($query_webpage);
		
		echo "$('#switch_onoff_buywebsite').click(function(){";
		if($sellproduct_status==1){
			echo "$('.on-buywebsite1').hide();";
			echo "$('.off-buywebsite1').hide();";
			echo "$('.on-buywebsite2').show();";
			echo "$('.off-buywebsite2').show();";
			echo "$.post('ajax/function.php?data=switch_onoff_buywebsite',{switch_onoff_buywebsite:2},function(data){";
			echo "});";
			echo "alert('ปืดระบบการขายสินค้าเรียบร้อยแลว');";
			echo "window.location='ajax/manage_website_callback.php';";
		}else{
			echo "$('.on-buywebsite1').show();";
			echo "$('.off-buywebsite1').show();";
			echo "$('.on-buywebsite2').hide();";
			echo "$('.off-buywebsite2').hide();";
			echo "$.post('ajax/function.php?data=switch_onoff_buywebsite',{switch_onoff_buywebsite:1},function(data){";
			echo "});";
			echo "alert('เปืดระบบการขายสินค้าเรียบร้อยแลว');";
			echo "window.location='ajax/manage_website_callback.php';";
		}
		echo "});";

		echo "$('#switch_onoff_openweb').click(function(){";
		if($open_web==1){
			echo "$('.on-buywebsite3').hide();";
			echo "$('.off-buywebsite3').hide();";
			echo "$('.on-buywebsite4').show();";
			echo "$('.off-buywebsite4').show();";
			echo "$.post('ajax/function.php?data=switch_onoff_openweb',{switch_onoff_openweb:2},function(data){";
			echo "});";
			echo "alert('ปิดการแจ้งเตือนการปรับปรุงเว็บไซต์ เรียบร้อยแล้ว');";
			echo "window.location='ajax/manage_website_callback.php';";
		}else{
			echo "$('.on-buywebsite3').show();";
			echo "$('.off-buywebsite3').show();";
			echo "$('.on-buywebsite4').hide();";
			echo "$('.off-buywebsite4').hide();";
			echo "$.post('ajax/function.php?data=switch_onoff_openweb',{switch_onoff_openweb:1},function(data){";
			echo "});";
			echo "alert('เปิดการแจ้งเตือนการปรับปรุงเว็บไซต์ เรียบร้อยแล้ว');";
			echo "window.location='ajax/manage_website_callback.php';";
		}
		echo "});";
?>
	});
	
</script>
<div class="container-fluid">
	<div class='col-md-6'>
		<center>
		<form action="">
			<table style="font-size:20px">
			<tr>
				<td colspan="3"><input type="file" name="logo_image"></td>
			</tr>
			<tr>
				<td style ="padding:10px;">ชื่อร้านภาษาอังกฤษ</td>
				<td style ="padding:10px;">:</td>
				<td style ="padding:10px;"><input type="text" name="nameshop_Eng" class="text_name"></td>
			</tr>
			<tr>
				<td style ="padding:10px;">ชื่อร้านภาษาไทย</td>
				<td style ="padding:10px;">:</td>
				<td style ="padding:10px;"><input type="text" name="nameshop_thai"  class="text_name"></td>
			</tr>
			<tr>
				<td style ="padding:10px;">ชื่อร้านภาษาไทย</td>
				<td style ="padding:10px;">:</td>
				<td style ="padding:10px;"><textarea></textarea></td>
			</tr>
			
			</table>
		</form>
		</center>
	</div>
	<div class='col-md-6'>
		<div class="container-fluid">
		<div class="col-md-6">
			<p align="center">เว็บไซต์พร้อมขายของ</p>
			<a href='#ajax/manage_website.php' id="switch_onoff_buywebsite"><div class='on-off-buywebsite'>
<?php
			$query_webpage = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : backend manage_website line 65");
			list($sellproduct_status)=mysqli_fetch_row($query_webpage);
			$hidden_onbuywebsite =($sellproduct_status==1)?"":"style='display:none'";
			$hidden_offbuywebsite =($sellproduct_status==2)?"":"style='display:none'";
			echo "<div class='on-buywebsite1' $hidden_onbuywebsite>";
				echo "<b>ON</b>";
			echo "</div>";
			echo "<div class='off-buywebsite1' $hidden_onbuywebsite>";
				echo "<b>OFF</b>";
			echo "</div>";
			echo "<div class='on-buywebsite2' $hidden_offbuywebsite>";
				echo "<b>ON</b>";
			echo "</div>";
			echo "<div class='off-buywebsite2' $hidden_offbuywebsite>";
				echo "<b>OFF</b>";
			echo "</div>";
?>
			</div></a>
		</div>
		<div class="col-md-6">
			<p align="center">แจ้งเตือนการปรับปรุงเว็บไซต์</p>
			<a href='#ajax/manage_website.php' id="switch_onoff_openweb"><div class='on-off-buywebsite'>
<?php
			$query_webpage = mysqli_query($_SESSION['connect_db'],"SELECT open_web FROM web_page")or die("ERROR : backend manage_website line 65");
			list($open_web)=mysqli_fetch_row($query_webpage);
			$hidden_onopenweb =($open_web==1)?"":"style='display:none'";
			$hidden_offopenweb =($open_web==2)?"":"style='display:none'";
			echo "<div class='on-buywebsite3' $hidden_onopenweb>";
				echo "<b>ON</b>";
			echo "</div>";
			echo "<div class='off-buywebsite3' $hidden_onopenweb>";
				echo "<b>OFF</b>";
			echo "</div>";
			echo "<div class='on-buywebsite4' $hidden_offopenweb>";
				echo "<b>ON</b>";
			echo "</div>";
			echo "<div class='off-buywebsite4' $hidden_offopenweb>";
				echo "<b>OFF</b>";
			echo "</div>";
?>
			</div></a>
		</div>
		</div>
		<br style="clear:both">
	</div>
</div>

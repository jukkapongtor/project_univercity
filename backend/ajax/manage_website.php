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
		
		</div>
		<br style="clear:both">
	</div>
</div>

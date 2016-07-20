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
			<li><a href="#">จัดการเว็บไซต์</a></li>
			<li><a href="#">จัดการหน้าแรกเว็บไซต์</a></li>
		</ol>
	</div>
</div>

<div class="container-fluid" style="padding:0px;">
	<div class='col-md-6'>
<?php
		$query_webpage = mysqli_query($_SESSION['connect_db'],"SELECT * FROM web_page WHERE web_page_id='1'")or die("ERROR manage website line 24");
		list($web_page_id,$logo,$nameshop,$header_detail_shop,$detail_shop,$image_content2,$header_content2,$content2,$image_content3,$header_content3,$content3,$sellproduct_status,$open_web)=mysqli_fetch_row($query_webpage);
?>
		<form action="ajax/update_webpage.php" method="post" enctype="multipart/form-data">
			<table width="100%" cellpadding="10">
			
			<tr>
				<td colspan="3">
<?php
					$image1 = (!empty($logo))?"src='../images/icon/$logo'":"";
?>
					<p align="center"><img <?php echo $image1 ;?> id='blah' width="100" height="100" ></p>
				</td>
			</tr>
			<tr>
				<td  width="30%" ><p><b>เลือกภาพโลโก้ร้าน</b></p></td>
				<td ><p><b>:&nbsp;</b></p></td>
				<td ><p><input type="file" name="logo_image" multiple onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"></p></td>
			</tr>
			<tr>
				<td  width="25%" style="padding:5px;"><p><b>ชื่อร้าน</b></p></td>
				<td ><p><b>:&nbsp;</b></p></td>
				<td ><input type="text" class="form-control" name="name_shop" value="<?php echo "$nameshop";?>"></td>
			</tr>
			<tr>
				<td style="padding:5px;"><p><b>หัวข้อเนื้อหาส่วที่1</b></p></td>
				<td ><p><b>:</b></p></td>
				<td ><input type="text" class="form-control" name="head_content1" value="<?php echo "$header_detail_shop";?>"></td>
			</tr>
			<tr>
				<td valign="top" style="padding:5px;"><p><b>เนื้อหาส่วนที่1</b></p></td>
				<td valign="top" ><p><b>:&nbsp;</b></p></td>
				<td ><textarea class="form-control" name='content1'><?php echo "$detail_shop";?></textarea></td>
			</tr>
			<tr>
				<td colspan="3">
<?php
					$image2 = (!empty($image_content2))?"src='../images/webpage/$image_content2'":"";
?>
					<p align="center"><img id='blah2' <?php echo $image2 ;?> width="100" height="100" ></p>
				</td>
			</tr>
			<tr>
				<td ><p><b>เลือกภาพเนื้อหาส่วนที่2</b></p></td>
				<td ><p><b>:&nbsp;</b></p></td>
				<td ><p><input type="file" name="image_content2" multiple onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])"></p></td>
			</tr>
			<tr>
				<td style="padding:5px;"><p><b>หัวข้อเนื้อหาส่วที่2</b></p></td>
				<td ><p><b>:&nbsp;</b></p></td>
				<td ><input type="text" class="form-control" name="head_content2" value="<?php echo "$header_content2";?>"></td>
			</tr>
			<tr>
				<td valign="top" style="padding:5px;"><p><b>เนื้อหาส่วนที่2</b></p></td>
				<td valign="top" ><p><b>:&nbsp;</b></p></td>
				<td ><textarea class="form-control" name="content2"><?php echo "$content2";?></textarea></td>
			</tr>
			<tr>
				<td colspan="3">
<?php
					$image3 = (!empty($image_content3))?"src='../images/webpage/$image_content3'":"";
?>
					<p align="center"><img id='blah3' <?php echo $image3 ;?> width="100" height="100" ></p>
				</td>
				</td>
			</tr>
			<tr>
				<td ><p><b>เลือกภาพเนื้อหาส่วนที่3</b></p></td>
				<td ><p><b>:&nbsp;</b></p></td>
				<td ><p><input type="file" name="image_content3" multiple onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])"></p></td>
			</tr>
			<tr>
				<td style="padding:5px;"><p><b>หัวข้อเนื้อหาส่วที่3</b></p></td>
				<td ><p><b>:&nbsp;</b></p></td>
				<td ><input type="text" class="form-control" name="head_content3" value="<?php echo "$header_content3";?>"></td>
			</tr>
			<tr>
				<td valign="top" style="padding:5px;"><p><b>เนื้อหาส่วนที่3</b></p></td>
				<td valign="top" ><p><b>:&nbsp;</b></p></td>
				<td ><textarea class="form-control" name="content3"><?php echo "$content3";?></textarea></td>
			</tr>
			<tr >
				<td valign="top" style="padding:5px;"><p><b>เนื้อหาส่วนท้าย</b></p></td>
				<td valign="top" ><p><b>:&nbsp;</b></p></td>
				<td style="padding-top:5px;"><textarea class="form-control" name="content_footer"></textarea></td>
			</tr>
			</table>
			<p align="center" style="margin-top:10px"><button class='btn btn-sm btn-success' type='submit'>ยืนยันการแก้ไข</button></p>
		</form>
	</div>
	<div class='col-md-6'>
		<div class="container-fluid">
			<img src='../images/background/ex_index.jpg' width="100%">
		</div>
	</div>
</div>

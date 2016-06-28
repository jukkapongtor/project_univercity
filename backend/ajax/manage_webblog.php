<?php
	session_start();
	echo "<meta charset='utf8'>";
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
			<li><a href="#">จัดการบทความ</a></li>

		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>

<button class="btn btn-primary" type="submit" data-toggle="modal"  data-target="#addblog"> <img src="../images/icon/add.png" width="26px" ></button>



<div class="modal fade" id="addblog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">สร้างบทความ</h4>
      </div>
      <form action="ajax/insert_webblog.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body"  >
      	<div class="container-fluid" >
      			<div class="col-md-12">
      			<!--____________________________________________-->
      				<div class="col-md-6">
					    <table>
					      	<tr>
					      		<td style="padding:10px;" align="right" ><p>หัวเรื่อง : </p></td>
					       		<td><input type="text" class="form-control" name="title_blog" ></td>
					    	</tr>
					    	<tr>
      							<td style="padding:10px;" align="right" ><p>รูปตัวอย่าง : </p></td>
      							<td><input type="file" name="featured_image"></td>
      						</tr>
      					</table> 		
		      		</div>

      			<!--____________________________________________-->
						
		      		<div class="col-md-6">
		      			<table width="100%">
		      				<tr>
		      					<td><p>ตัวอย่างข้อความ</p></td>
		      				</tr>
		      				<tr>
		      					<td>
		      						<textarea class="form-control" name="review_detail" style="width:100%;"></textarea>
		      					</td>
		      					
		      				</tr> 
		      			</table>
					</div>				
      			<!--____________________________________________-->
     			<div class="col-md-12">
      				<input type="radio" name="typeblog" value="บทความ"> บทความ
      				<input type="radio" name="typeblog" value="ข่าวสาร"> ข่าวสาร
      			</div>
      			<div class="col-md-12">
      				<textarea class="form-control" name="detail" style="width:100%; height: 350px; " ></textarea>
      			</div>	
     		</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="blog-body" >
<table class="table table-hover " style="margin-top:10px; ">
	<thead>
	<tr><th>รูปหน้าปก</th>
		<th>ชื่อบทความ</th>
		<th>ประเภท</th>
		<th>วันเดือนปี</th>
		<th>คนเข้าชม</th>
		<th>คะแนน</th>
		<th align="center">จัดการ</th>
	</tr>
	</thead>
<?php
	
	$query_blog = mysqli_query($_SESSION['connect_db'], "SELECT id_blog,title_blog,featured_image,rating_blog,visitor,type_blog,blog_date FROM webblog") or die("ERROR : manage webblog line 88");

	while (list($blog_id,$title_blog,$featured_image,$rating_blog,$visitor,$type_blog,$blog_date )=mysqli_fetch_row($query_blog)){

		echo "<tbody><tr><th><img src = '../images/webblog/$featured_image' width='35px' height=35px'></th>";
		echo "<td>$title_blog</td>";
		echo "<td>$type_blog</td>";
		echo "<td>$blog_date</td>";
		echo "<td>$visitor</td>";
		echo "<td>$rating_blog</td>";
		echo "<td><button class='btn btn-success btn-edit' data-toggle='modal' data-target='#editblog_$blog_id'>แก้ไข</button>";
?>
<div class="modal fade" id="editblog_<?php echo "$blog_id";?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">สร้างบทความ</h4>
      </div>
      <form action="ajax/insert_webblog.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body"  >
      <?php
      $edit_blog = mysqli_query($_SESSION['connect_db'], "SELECT id_blog,title_blog,featured_image,review_detail,detail,type_blog FROM webblog WHERE id_blog='$blog_id' ") or die("ERROR : manage webblog line 123");

      list($idblog,$titleblog,$featuredimage,$reviewdetail,$detail,$typeblog)=mysqli_fetch_row($edit_blog)
      ?>
      	<div class="container-fluid" >
      			<div class="col-md-12">
      			<!--____________________________________________-->
      				<div class="col-md-6">
					    <table>
					      	<tr>
					      		<td style="padding:10px;" align="right" ><p>หัวเรื่อง : </p></td>
					       		<td><input type="text" class="form-control" name="title_blog" value="<?php echo "$titleblog"; ?>" ></td>
					    	</tr>
					    	<tr>
      							<td style="padding:10px;" align="right" ><p>รูปตัวอย่าง : </p></td>
      							<td><input type="file" name="featured_image"></td>
      						</tr>
      					</table> 		
		      		</div>

      			<!--____________________________________________-->
						
		      		<div class="col-md-6">
		      			<table width="100%">
		      				<tr>
		      					<td><p>ตัวอย่างข้อความ</p></td>
		      				</tr>
		      				<tr>
		      					<td>
		      						<textarea class="form-control" name="review_detail" style="width:100%;">
									<?php echo "$reviewdetail"; ?>
		      						</textarea>
		      					</td>
		      					
		      				</tr> 
		      			</table>
					</div>				
      			<!--____________________________________________-->
     			<div class="col-md-12">
     			<?php
     				if ($typeblog=="บทความ") {

     					$chk1 = "checked='checked'" ;
     					$chk2="";
     				}else if ($typeblog=="ข่าวสาร") {
     					
     					$chk2 = "checked='checked'" ;
     					$chk1 = "";
     				}else{
     					$chk1="";
     					$chk2="";
     				}
     			?>
      				<input type="radio" name="typeblog" value="บทความ" <?php echo "$chk1"; ?>> บทความ
      				<input type="radio" name="typeblog" value="ข่าวสาร" <?php echo "$chk2"; ?> > ข่าวสาร
      			</div>
      			<div class="col-md-12">
      				<textarea class="form-control" name="detail" style="width:100%; height: 350px; " ><?php echo "$detail"; ?></textarea>
      			</div>	
     		</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php

		echo "<a href='ajax/webblog_delete.php?id_blog=$blog_id' onclick='return confirm(\"คุณต้องการลบบทความ--$title_blog-- ใช่หรือไม่\")'>
			<button class='btn btn-danger btn-de'>ลบ</button></a></td>";
		
		echo "</tr></tbody>";

		
	}




?>
</table>
</div>
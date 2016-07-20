<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
 
?>
<head>
	<title>เพิ่มบทความ</title>
	<meta charset="utf-8">
  
</head>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการเว็บไซต์</a></li>
			<li><a href="#">จัดการบทความ</a></li>
			<li><a href="#">แก้ไขบทความ</a></li>
		</ol>
	</div>
</div>
<?php
   $edit_blog = mysqli_query($_SESSION['connect_db'], "SELECT id_blog,title_blog,featured_image,review_detail,detail,type_blog FROM webblog WHERE id_blog='$_GET[id_blog]' ") or die("ERROR : webblog_from_up line 29");

      list($idblog,$titleblog,$featuredimage,$reviewdetail,$detail,$typeblog)=mysqli_fetch_row($edit_blog)

?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">แก้ไขบทความ<?php echo "\"$titleblog\""; ?></h3>
  </div>
  <div class="panel-body">
    
      	<div class="container-fluid" >
      	<form action="ajax/webblog_update.php" method="POST" enctype="multipart/form-data">
    	<input type="hidden" name="blog" value="<?php echo "$idblog"; ?>" >
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
      							<td><input type='file' name='webblog_image'></td>
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

		      						<textarea class="form-control" name="review_detail" style="width:100%;"><?php echo "$reviewdetail"; ?></textarea>
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
      			
		
      			<div class="col-md-12" style="margin-top: 10px">

      				<textarea class="form-control text-editor"  id="edit"   name="detail" style="width: 100%;" ><?php echo "$detail";?></textarea>
      			</div>	
     		
		
		
    		<div class="col-md-12"  align="right" style="margin-top: 10px;" >
       			 <button type="button" class="btn btn-default" >ยกเลิก</button>
       			 <button type="submit" class="btn btn-primary">แก้ไข</button>
      		</div>
      </form>
  </div>
</div>


   
 


</body>
</html>
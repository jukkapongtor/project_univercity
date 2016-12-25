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
			<li><a href="#">เพิ่มบทความ</a></li>

		</ol>
	</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">สร้างบทความ</h3>
  </div>
  <div class="panel-body">
    <form action="ajax/insert_webblog.php" method="POST" enctype="multipart/form-data">
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
      			
		
      			<div class="col-md-12" style="margin-top: 10px">

      				<textarea class="form-control text-editor"  id="edit"   name="detail" style="width: 100%;" ><p>hello</p></textarea>
      			</div>	
     		
		
		
    		<div class="col-md-12"  align="right" style="margin-top: 10px;" >
       			 <button type="button" class="btn btn-default" >Close</button>
       			 <button type="submit" class="btn btn-primary">Save</button>
      		</div>
      </form>
  </div>
</div>


   
 


</body>
</html>
<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
?>
<head>


</head>
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

<a href="ajax/webblog_frominsert_id.php"><button class="btn btn-primary" type="submit"> <img src="../images/icon/add.png" width="26px" ></button></a>




     

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
		echo "<td><a href = 'ajax/webblog_from_update_id.php?id_blog=$blog_id'><button class='btn btn-success btn-edit'>แก้ไข</button></a>";
		echo "<a href='ajax/webblog_delete.php?id_blog=$blog_id' onclick='return confirm(\"คุณต้องการลบบทความ--$title_blog-- ใช่หรือไม่\")'>
			<button class='btn btn-danger btn-de'>ลบ</button></a></td>";
		
		echo "</tr></tbody>";

		
	}




?>
</table>
</div>

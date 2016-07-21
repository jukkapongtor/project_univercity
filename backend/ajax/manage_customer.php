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
			<li><a href="#">จัดการข้อมูลผู้ใช้งาน</a></li>
			<li><a href="#">ข้อมูลผู้ใช้งาน</a></li>

		</ol>
	</div>
</div>
<?php

	$query_user = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,image,email,type FROM users WHERE type=3 " ) or die ("ERROE : backend file : mannage_costomer line 6 ");

	$number = 1;
	//echo "<h2 style='margin-top:30px; background : #C1CDC1'  >จัดการลูกค้า</h2>";
	echo "<table class='table table-hover' style='margin-top:40px;' ><tr class='success'><th height ='10px' >";
		echo "<center>ลำดับ</center></th><th><center>รูปภาพ</center></th><th><center>user</center></th><th><center>อีเมลล์</center></th><th><center>สถานะ</center></th><th><center>แก้ไข</center></th><th><center>ลบ</center></th><tr>";

	while (list($username,$fullname,$image,$email,$type)=mysqli_fetch_row($query_user)) {

		
		echo "<tr><td width ='20px'><center>$number</center></td>";
		if (empty($image)) {
			$image="<center><img src='../images/icon/no-images.jpg' width='65px' height='65px' ></center>";
		}else{
			$image="<center><img src = '../images/user/$image' width='65px' height='65px' ></center>";
		}
	 	echo "<td>$image</td>";
	 	echo "<td>$username</td>";
	 	echo "<td>$email</td>";
	 	echo "<td>$type</td>
	 		  <td><center><a href ='ajax/detail_customer_id.php?username=$username'>
	 		  	<img src='../images/icon/magnifying-glass .png' width='30px'height='30px'>
	 		  </a></center></td>
	 		 
	 		  <td><center><img src='../images/icon/garbage.png' width='30px'height='30px'></center></td></tr>";


	$number++;
	 } 
	echo "</table>";
?>
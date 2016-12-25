<?php
	session_start();
	include("../../include/function.php");
	connect_db();
	$keywd = (empty($_GET['keywd']))?"":$_GET['keywd'];
?>
<script type="text/javascript">
	
	$(document).ready(function() {
		$("#search_user").click(function(){
        	window.location ='ajax/function_user.php?data=search&keywd='+document.getElementById('keywd').value;
		});
	});
</script>
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
<center><h3  style='margin:20px;'>รายชื่อผู้ใช้งานระบบบนเว็บไซต์</h3></center>
<div class="col-md-2"></div>
<div class="col-md-8">
	<div class="col-md-10">
		<input type='text' class='form-control' id='keywd' placeholder='Search...' value='<?php echo $keywd ?>'  style='height:30px;'>
	</div>
	<div class="col-md-2">
		<button class="btn btn-primary btn-xs" id='search_user'><span class='glyphicon glyphicon-search'></span> ค้นหา </button>
	</div>
</div>
<div class="col-md-2"></div>
<?php
	$query_user = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,image,email,type FROM users WHERE (type='3' OR type='4') AND  username LIKE '%$keywd%' ") or die ("ERROE : backend file : mannage_costomer line 6 ");
	$count_user = mysqli_num_rows($query_user);
	$total_page = ceil($count_user/10);
	if(empty($_GET['page'])){
		$page=1;
		$start_row=0;
	}
	else{
		$page=$_GET['page'];
		$start_row=($page-1)*10;
	}
	$query_user = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,image,email,type FROM users WHERE (type='3' OR type='4') AND username LIKE '%$keywd%' LIMIT $start_row,10 ") or die ("ERROE : backend file : mannage_costomer line 6 ");

	$number = 1;
	//echo "<h2 style='margin-top:30px; background : #C1CDC1'  >จัดการลูกค้า</h2>";
	echo "<table class='table table-hover' ><tr class='success'><th height ='10px' >";
		echo "<center>ลำดับ</center></th><th><center>รูปภาพ</center></th><th><center>user</center></th><th><center>อีเมลล์</center></th></th><th><center>สถานะ</center></th><th><center>ดูข้อมูล</center></th><!--<th><center>ลบ</center></th>--><tr>";

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
	 	$type = ($type==3)?"ผูใช้งานทั่วไป":"ผู้กระทำความผิด";
	 	echo "<td align='center'>$type</td>";
	 	echo "<td><center><a href ='ajax/detail_customer_id.php?username=$username'>
	 		  	<img src='../images/icon/magnifying-glass .png' width='30px'height='30px'>
	 		  </a></center></td>";
	 	//echo "<td><center><img src='../images/icon/garbage.png' width='30px'height='30px'></center></td></tr>";	 
	$number++;
	 } 
	echo "</table>";
	if($total_page>1){
	echo "<div class='col-md-12'>";
		echo "<center><nav><ul class='pagination'>";
		  echo "<li><a href='ajax/function_user.php?data=search&page=1&keywd=$keywd'>หน้าแรก</a></li>";
		  $preview = ($page-1);
		  $preview = ($preview<1)?1:$preview;
		  echo "<li><a href='ajax/function_user.php?data=search&page=$preview&keywd=$keywd'><<</a></li>";
	for($i=1;$i<=$total_page;$i++){
			$active = ($page==$i)?"active":"";
		  echo "<li class='$active'><a href='ajax/function_user.php?data=search&page=$i&keywd=$keywd'>$i</a></li>";
	}	
		  $next = ($page+1);
		  $next = ($next>$total_page)?$total_page:$next;
		  echo "<li><a href='ajax/function_user.php?data=search&page=$next&keywd=$keywd'>>></a></li>";
		  echo "<li><a href='ajax/function_user.php?data=search&page=$total_page&keywd=$keywd'>หน้าสุดท้าย</a></li>";
		echo "</ul></nav></center>";
	echo "</div>";
	}
?>
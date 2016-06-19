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
			<li><a href="#">รายละเอียดผู้ใช้งาน</a></li>

		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<?php

	$detail = mysqli_query ($_SESSION['connect_db'],"SELECT username,fullname,lastname,image,phone,email FROM users WHERE username='$_GET[username]'") or die ("ERROE : backend file : detail_customer line 27 ");

	list($username,$fullname,$lastname,$image,$phone,$email)=mysqli_fetch_row($detail);

	echo "<div style = 'width:100%; background :#FFDAB9; padding:10px;'><img src = '../images/icon/users.png' width='30px' height='30px'><font size='5'>ข้อมูลผู้ใช้ทั่วไป</font></div>";

	echo"<div style = 'padding-top:30px; float:left; width:30%;'><center><img src = '../images/user/$image' width='200px' height='200px'></center></div>";
	echo"<div style = 'padding-top:30px; float:right; width:70%;'><font size='4'><table><tr><td style ='padding:10px;' align=right>ชื่อผู้ใช้ : </td><td>$username</td></tr>";

	echo"<tr><td style ='padding:10px;' align=right>ชื่อ-นามสกุล : </td><td> $fullname $lastname</td></tr>";
	echo"<tr><td style ='padding:10px;' align=right>อีเมลล์ : </td><td> $email</td></tr>";
	echo"<tr><td style ='padding:10px;' align=right>โทรศัพท์ : </td><td> $phone</td></tr>";
	echo "</table></font></div>";
	echo "<br style='clear:both'>";


echo "<div style = 'width:100%; background :#FFDAB9; padding:10px; margin-top:20px;'>
		<img src = '../images/icon/bag.png' width='30px' height='30px'>
			<font size='5'>ประวัติการสั่งซื้อ</font></div>";
?>

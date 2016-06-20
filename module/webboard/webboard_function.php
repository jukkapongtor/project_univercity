<?php
function webboard(){
	if(!empty($_SESSION['login_name'])){
		echo "<a href='index.php?module=webboard&action=form_webboard'><p class='font20' align='right' style='margin:10px 10px 0px 0px;'><button>เพิ่มกระทู้</button></p></a>";
	}
	echo "<div class='panel panel-default weboard-showrecommend'>";
	  echo "<div class='panel-heading' style='padding-bottom:0px;'><b><p class='font20'>รายการสนทนาที่แนะนำ</p></b></div>";
	  echo "<div class='panel-body'>";
		echo "<div>";
		  echo "<!-- Nav tabs -->";
		  echo "<ul class='nav nav-tabs' role='tablist'>";
		    echo "<li role='presentation' class='active font20'><a href='#webboard_recommend' aria-controls='webboard_recommend' role='tab' data-toggle='tab'>กระทู้แนะนำ</a></li>";
		    echo "<li role='presentation'><a href='#webboard_interesting' class='font20' aria-controls='webboard_interesting' role='tab' data-toggle='tab'>กระทู้ที่น่าสนใจ</a></li>";
		  echo "</ul>";
		  echo "<!-- Tab panes -->";
		  echo "<div class='tab-content'>";
		    echo "<div role='tabpanel' class='tab-pane active' id='webboard_recommend'>";
		    	echo "<p></p><p class='font20'>กระทู้แนะนำจะเป็นการนำกรทู้ที่มีการถูกใจมากที่สุด 4 อันดับนำมาแสดง</p>";
		    	echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
			  		echo "<thead>";
			  		echo "<tr style='font-size:24px;'>
			  			<th><center>ลำดับ</center></th>
			  			<th><center>ชื่อกระทู้</center></th>
			  			<th><center>ผู้โพสต์</center></th>
			  			<th><center>เข้าชม</center></th>
			  			<th><center>ตอบ</center></th>
			  			<th><center>วัน/เวลา ที่โพสต์</center></th>
			  		</tr>";
			  		echo "</thead>";
			  		echo "<tbody>";
			  		$number=1;
				  	$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webboard ORDER BY webboard_like DESC LIMIT 0,4")or die("ERROR : webboard function line 34");
				  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$like,$visitor)=mysqli_fetch_row($query_webboard)){
				  		echo "<tr>
				  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
				  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id'>$webboard_header</a></p></td>
				  			<td class='col-md-2'><p align='center' class='font20'>$username</p></td>
				  			<td class='col-md-1'><p align='center' class='font20'>$visitor</p></td>
				  			<td class='col-md-1'><p align='center' class='font20'>ตอบ</p></td>
				  			<td class='col-md-3'><p align='center' class='font20'>$webboard_date</p></td>
				  		</tr>";
				  		$number++;
				  	}
			  	echo "</tbody></table>";
		    echo "</div>";
		    echo "<div role='tabpanel' class='tab-pane' id='webboard_interesting'>";
		    	echo "<p></p><p class='font20'>กระทู้น่าสนใจะเป็นการนำกรทู้ที่มีการเข้าดูมากที่สุด 4 อันดับนำมาแสดง</p>";
		    	echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
			  		echo "<thead>";
			  		echo "<tr style='font-size:24px;'>
			  			<th><center>ลำดับ</center></th>
			  			<th><center>ชื่อกระทู้</center></th>
			  			<th><center>ผู้โพสต์</center></th>
			  			<th><center>เข้าชม</center></th>
			  			<th><center>ตอบ</center></th>
			  			<th><center>วัน/เวลา ที่โพสต์</center></th>
			  		</tr>";
			  		echo "</thead>";
			  		echo "<tbody>";
			  		$number=1;
				  	$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webboard ORDER BY visitor DESC LIMIT 0,4")or die("ERROR : webboard function line 34");
				  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$like,$visitor)=mysqli_fetch_row($query_webboard)){
				  		echo "<tr>
				  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
				  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id'>$webboard_header</a></p></td>
				  			<td class='col-md-2'><p align='center' class='font20'>$username</p></td>
				  			<td class='col-md-1'><p align='center' class='font20'>$visitor</p></td>
				  			<td class='col-md-1'><p align='center' class='font20'>ตอบ</p></td>
				  			<td class='col-md-3'><p align='center' class='font20'>$webboard_date</p></td>
				  		</tr>";
				  		$number++;
				  	}
			  	echo "</tbody></table>";
		    echo "</div>";
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	echo "</div>";
	echo "<div class='panel panel-default weboard-showrecommend'>";
	  echo "<div class='panel-heading' style='padding-bottom:0px;'><b><p class='font20'>รายการกระทู้ทั้งหมด</p></b></div>";
	  echo "<div class='panel-body'>";
	  	echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
	  		echo "<thead>";
	  		echo "<tr style='font-size:24px;'>
	  			<th><center>ลำดับ</center></th>
	  			<th><center>ชื่อกระทู้</center></th>
	  			<th><center>ผู้โพสต์</center></th>
	  			<th><center>เข้าชม</center></th>
	  			<th><center>ตอบ</center></th>
	  			<th><center>วัน/เวลา ที่โพสต์</center></th>
	  		</tr>";
	  		echo "</thead>";
	  		echo "<tbody>";
	  		$number=1;
		  	$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webboard ORDER BY webboard_date DESC")or die("ERROR : webboard function line 34");
		  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$like,$visitor)=mysqli_fetch_row($query_webboard)){
		  		echo "<tr>
		  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
		  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id'>$webboard_header</a></p></td>
		  			<td class='col-md-2'><p align='center' class='font20'>$username</p></td>
		  			<td class='col-md-1'><p align='center' class='font20'>$visitor</p></td>
		  			<td class='col-md-1'><p align='center' class='font20'>ตอบ</p></td>
		  			<td class='col-md-3'><p align='center' class='font20'>$webboard_date</p></td>
		  		</tr>";
		  		$number++;
		  	}
	  	echo "</tbody></table>";
	  echo "</div>";
	echo "</div>";
}
function form_webboard(){
	echo "<div class='panel panel-default weboard-showrecommend'>";
	  echo "<div class='panel-heading' style='padding-bottom:0px;'><b><p class='font20'>เพิ่มกระทู้</p></b></div>";
	  echo "<div class='panel-body'>";
	  	echo "<form method='post' action='index.php?module=webboard&action=add_webboard'><div>";
	  		echo "<div class='col-md-2'><b><p class='font20'>หัวข้อกระทู้ : </p></b></div>";
	  		echo "<div class='col-md-10'><p class='font20'><input type='text' class='form-control' name='webboard_header' ></p></div>";
	  		echo "<div class='col-md-12' style='border-top:2px #ddd solid;margin-top:10px;padding-top:10px;'><b><p class='font20'>รายละเอียดของกระทู้ : </p></b></div>";
	  		echo "<div class='col-md-12'>";
	  			echo "<p class='font20'><button id='message_bold'>B</button>";
	  			echo "&nbsp;<button id='message_bold'>I</button>";
	  			echo "&nbsp;<button id='message_bold'>U</button></p>";
	  		echo "</div>";
	  		echo "<div class='col-md-12'><p class='font20'><textarea class='form-control' id='webboard_message' name='webboard_detail' style='height:150px;'></textarea></p></div>";
	  		echo "<div class='col-md-6'><p ><button type='submit' class='btn btn-success font20' >ตั้งกระทู้</button></p></div>";
	  		echo "<div class='col-md-6'>";
	  			echo "<table align='right'>";
	  				$query_user = mysqli_query($_SESSION['connect_db'],"SELECT image FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : webboard function line 47");
	  				list($image)=mysqli_fetch_row($query_user);
	  				echo "<tr><td rowspan='2' valign='top' ><img src='images/user/$image' width='45' height='45'></td><td ><b class='font20'>&nbsp;ตั้งกระทู้โดย : </b></td></tr>";
	  				echo "<tr><td ><p class='font20' style='margin-top:-5px'>&nbsp;$_SESSION[login_name]</p></td></tr>";
	  			echo "</table>";
	  		echo "</div>";
	  	echo "</div></form>";
	  echo "</div>";
	echo "</div>";
}
function add_webboard(){
	if(empty($_POST['webboard_header'])||empty($_POST['webboard_detail'])){
		echo "<script>alert('กรุณากรอกข้อมูลให้ครบก่อนทำการเพิ่มกระทู้');window.location='index.php?module=webboard&action=form_webboard'</script>";
	}else{
		$datetime= date("Y-m-d H:i:s");
		mysqli_query($_SESSION['connect_db'],"INSERT INTO webboard VALUES('','$_POST[webboard_header]','$_POST[webboard_detail]','$_SESSION[login_name]','$datetime','0','0')")or die("ERROR : webboard function line 58");
		echo "<script>alert('เพิ่มกระทู้เรียบร้อยแล้ว');window.location='index.php?module=webboard&action=webboard'</script>";
	}
	
}
function webboard_detail(){

}

?>

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
				  	$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT webboard.* FROM webboard LEFT JOIN like_status ON webboard_id = like_name_id WHERE like_status.like_name='webboard' GROUP BY webboard.webboard_id ORDER BY COUNT(like_status.like_id) DESC LIMIT 0,4")or die("ERROR : webboard function line 32");
				  	$row = mysqli_num_rows($query_webboard);
				  	if($row>0){
					  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
					  		echo "<tr>
					  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
					  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
					  			<td class='col-md-2'><p align='center' class='font20'>$username</p></td>
					  			<td class='col-md-1'><p align='center' class='font20'>$visitor</p></td>
					  			<td class='col-md-1'><p align='center' class='font20'>ตอบ</p></td>
					  			<td class='col-md-3'><p align='center' class='font20'>$webboard_date</p></td>
					  		</tr>";
					  		$number++;
					  	}
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
				  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
				  		echo "<tr>
				  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
				  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
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
		  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
		  		echo "<tr>
		  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
		  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
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
	  				$image = (empty($image))?"<img src='images/icon/no-images.jpg' width='45' height='45'>":"<img src='images/user/$image' width='45' height='45'>";
	  				echo "<tr><td rowspan='2' valign='top' >$image</td><td ><b class='font20'>&nbsp;ตั้งกระทู้โดย : </b></td></tr>";
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
	$query_visitor = mysqli_query($_SESSION['connect_db'],"SELECT visitor FROM webboard WHERE webboard_id='$_GET[webboard_id]'")or die("ERROR : webboard function line 151");
	list($visitor)=mysqli_fetch_row($query_visitor);
	$visitor++;
	mysqli_query($_SESSION['connect_db'],"UPDATE webboard SET visitor='$visitor' WHERE webboard_id='$_GET[webboard_id]' ")or die("ERROR : webboard function line 152");
	echo "<div class='col-md-12' style='padding:20px;'>";
		echo "<div class='col-md-12 blog_webboard'>";
			$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT webboard.*,COUNT(like_status.like_id) FROM webboard LEFT JOIN like_status ON webboard.webboard_id = like_status.like_name_id WHERE webboard.webboard_id='$_GET[webboard_id]' AND like_status.like_name='webboard'  ")or die("ERROR : webboard function line 151");
			list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor,$like)=mysqli_fetch_row($query_webboard);
			echo "<p class='font26'><b>ชื่อกระทู้ : </b> $webboard_header</p>";
			echo "<p class='font26'><b>รายระเอียดข้อมูล : </b></p>";
			echo "<p class='font20'>$webboard_detail</p>";
			echo "<hr>";
			if(!empty($_SESSION['login_name'])){
				$query_like = mysqli_query($_SESSION['connect_db'],"SELECT like_id FROM like_status WHERE like_name='webboard' AND username='$_SESSION[login_name]' AND like_name_id='$_GET[webboard_id]'")or die("ERROR : webboard function line 168");
	            $row = mysqli_num_rows($query_like);
	            $row = empty($row)?0:$row;
				echo "<input type='hidden' id='like_webboard' value='$row'>";
			}
			echo "<div class='col-md-2' style='padding-top:20px;'><p class='font20'><b><a id='plus_like' style='text-decoration: none;cursor:pointer'>Like</a> : </b><font id='like_status'>$like</font></p></div>";
			echo "<div class='col-md-8' style='border-left:1px solid #bbb;padding-left:10px;'><p class='font20'>";
				echo "<table>";
	  				$query_user = mysqli_query($_SESSION['connect_db'],"SELECT image FROM users WHERE username='$username'")or die("ERROR : webboard function line 47");
	  				list($image)=mysqli_fetch_row($query_user);
	  				echo "<tr><td rowspan='2' valign='top' ><img src='images/user/$image' width='45' height='45'></td><td ><b class='font20'>&nbsp;$username</b></td></tr>";
	  				echo "<tr><td ><p class='font20' style='margin-top:-5px'>&nbsp;$webboard_date</p></td></tr>";
	  			echo "</table>";
			echo "</div>";
			echo "<div class='col-md-2'><p class='font20'><b>จำนวนผู้เข้าชม : </b>$visitor</p></div>";
		echo "</div>";
		$query_subwebboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM subwebboard WHERE webboard_id ='$webboard_id'")or die("ERROR subwebboard function line 174");
		$subwebboard_row = mysqli_num_rows($query_subwebboard);
		if($subwebboard_row>0){
		echo "<div class='col-md-12' style='margin-top:20px;'><p class='font20' ><b>ความคิดเห็น</b></p><hr style='margin-top:-10px;'></div>";
			$subwebboard_comment =1;
			while (list($subwebboard_id,$webboard_id,$subwebboard_detail,$username,$subwebboard_date)=mysqli_fetch_row($query_subwebboard)) {
			echo "<div class='col-md-12 blog_webboard'>";
				echo "<p><b class='font20'>ความเห็นที่ $subwebboard_comment</b></p>";
				echo "<p class='font20'>$subwebboard_detail</p>";
				echo "<div class='col-md-12'><a href='' id='comment_subwebboard$subwebboard_id' style='text-decoration: none;'><p class='font20' align='right'> ตอบกลับ</p></a></div>";
				echo "<hr>";
				echo "<div class='col-md-2' style='padding-top:20px;'><p class='font20'><b>Like : </b></p></div>";
				echo "<div class='col-md-10' style='border-left:1px solid #bbb;padding-left:10px;'><p class='font20'>";
					echo "<table>";
		  				$query_user = mysqli_query($_SESSION['connect_db'],"SELECT image FROM users WHERE username='$username'")or die("ERROR : webboard function line 47");
		  				list($image)=mysqli_fetch_row($query_user);
		  				$image = (empty($image))?"<img src='images/icon/no-images.jpg' width='45' height='45'>":"<img src='images/user/$image' width='45' height='45'>";
		  				echo "<tr><td rowspan='2' valign='top' >$image</td><td ><b class='font20'>&nbsp;$username</b></td></tr>";
		  				echo "<tr><td ><p class='font20' style='margin-top:-5px'>&nbsp;$subwebboard_date</p></td></tr>";
		  			echo "</table>";
				echo "</div>";
			echo "</div>";
			$subwebboard_comment++;
			}
		}
		echo "<div class='col-md-12' style='margin-top:20px;'><p class='font20' ><b>แสดงความเห็น</b></p><hr style='margin-top:-10px;'></div>";
		echo "<div class='col-md-12 blog_webboard'>";
			echo "<form method='post' action='index.php?module=webboard&action=insert_subwebboard'><div>";
				echo "<input type='hidden' name='webboard_id' value='$_GET[webboard_id]'>";
		  		echo "<div class='col-md-12'><b><p class='font20'>ตอบกลับกระทู้ : </p></b></div>";
		  		if(empty($_SESSION['login_name'])){
		  			echo "<div class='col-md-12'><p class='font20'>*****หากต้องการตอบกระทู้หรือตั้งกระทู้ กรุณาล็อดอินเข้าใช้งานระบบก่อน*****</p></div>";
		  			$disabled = "disabled";
		  			$button_type ="button";
		  		}else{
		  			$disabled = "";
		  			$button_type ="submit";
		  		}
		  		echo "<div class='col-md-12'><p class='font20'><textarea class='form-control' id='subwebboard_message' name='subwebboard_message' style='height:150px;' $disabled></textarea></p></div>";
		  		echo "<div class='col-md-6'><p ><button type='$button_type' class='btn btn-success font20' >ตอบกลับ</button></p></div>";
		  		echo "<div class='col-md-6'>";
		  		if(!empty($_SESSION['login_name'])){
		  			echo "<table align='right'>";
		  				$query_user = mysqli_query($_SESSION['connect_db'],"SELECT image FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : webboard function line 47");
		  				list($image)=mysqli_fetch_row($query_user);
		  				$image = (empty($image))?"<img src='images/icon/no-images.jpg' width='45' height='45'>":"<img src='images/user/$image' width='45' height='45'>";
		  				echo "<tr><td rowspan='2' valign='top' >$image</td><td ><b class='font20'>&nbsp;ตอบกลับโดย : </b></td></tr>";
		  				echo "<tr><td ><p class='font20' style='margin-top:-5px'>&nbsp;$_SESSION[login_name]</p></td></tr>";
		  			echo "</table>";
		  		}
		  		echo "</div>";
		  	echo "</div></form>";
		echo "</div>";
		
	echo "</div>";
}
function insert_subwebboard(){
	if(empty($_POST['subwebboard_message'])){
		echo "<script>alert('กรุณาพิมพ์ข้อความก่อนทำการตอบกระทู้');window.location='index.php?module=webboard&action=webboard_detail&webboard_id=$_POST[webboard_id]'</script>";
	}else{
		$subwebboard_datetime = date("Y-m-d H:i:s");
		mysqli_query($_SESSION['connect_db'],"INSERT INTO subwebboard VALUES('','$_POST[webboard_id]','$_POST[subwebboard_message]','$_SESSION[login_name]','$subwebboard_datetime','0')")or die("ERROR : insert_subwebboard line 209");
		echo "<script>window.location='index.php?module=webboard&action=webboard_detail&webboard_id=$_POST[webboard_id]'</script>";
	}

}
?>
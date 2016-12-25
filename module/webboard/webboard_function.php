
<?php
function webboard(){
	if(!empty($_SESSION['login_name'])){
		echo "<div class='panel panel-success weboard-showrecommend'>";
		  echo "<div class='panel-heading'><p><b>เพิ่มกระทู้</b></p></div>";
		  echo "<div class='panel-body'>";
		    echo "<p style='margin-left:20px;'>สำหรับสมาชิกสามารถกด <a href='index.php?module=webboard&action=form_webboard'><button class='btn btn-sm btn-success'>เพิ่มกระทู้</button></a> ได้  เพื่อใช้ในการถามคำถามหรือแลกเปลี่ยนข้อมูล</p>";
		  echo "</div>";
		echo "</div>";
	}
	echo "<div class='panel panel-primary weboard-showrecommend'>";
	  echo "<div class='panel-heading' style='padding-bottom:0px;'><b><p>รายการกระทู้ที่แนะนำ</p></b></div>";
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
		    	$number=1;
				$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT webboard.* FROM webboard LEFT JOIN like_status ON webboard_id = like_name_id WHERE like_status.like_name='webboard' GROUP BY webboard.webboard_id ORDER BY COUNT(like_status.like_id) DESC LIMIT 0,4")or die("ERROR : webboard function line 32");
				$row = mysqli_num_rows($query_webboard);
				if($row>0){
		    	echo "<p></p><p class='font20'>กระทู้แนะนำจะเป็นการนำกรทู้ที่มีการถูกใจมากที่สุด 4 อันดับนำมาแสดง</p>";
		    	echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
			  		echo "<thead>";
			  		echo "<tr>
			  			<th><center>ลำดับ</center></th>
			  			<th><center>ชื่อกระทู้</center></th>
			  			<th class='hidden-xs'><center>ผู้โพสต์</center></th>
			  			<th class='hidden-xs'><center>เข้าชม</center></th>
			  			<th class='hidden-xs'><center>ตอบ</center></th>
			  			<th class='hidden-xs'><center>วัน/เวลา ที่โพสต์</center></th>
			  		</tr>";
			  		echo "</thead>";
			  		echo "<tbody>";
			  		
					  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
					  		$query_subwebboard = mysqli_query($_SESSION['connect_db'],"SELECT subwebboard_id FROM subwebboard WHERE webboard_id='$webboard_id'")or die("ERROR : webboard line 37");
					  		$cnt_subwebboard = mysqli_num_rows($query_subwebboard);
					  		echo "<tr>
					  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
					  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
					  			<td class='col-md-2 hidden-xs'><p align='center' class='font20'>$username</p></td>
					  			<td class='col-md-1 hidden-xs'><p align='center' class='font20'>$visitor</p></td>
					  			<td class='col-md-1 hidden-xs'><p align='center' class='font20'>$cnt_subwebboard</p></td>
					  			<td class='col-md-3 hidden-xs'><p align='center' class='font20'>$webboard_date</p></td>
					  		</tr>";
					  		$number++;
					  	}
				  	
			  	echo "</tbody></table>";
			  }else{
			  	echo "<h4 align='center' style='margin:60px 0px 40px 0px;'><b>ขออภัย!!! ยังไม่มีการเพิ่มกระทู้</b></h4>";
			  }
		    echo "</div>";
		    echo "<div role='tabpanel' class='tab-pane' id='webboard_interesting'>";
		    	$number=1;
				$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webboard ORDER BY visitor DESC LIMIT 0,4")or die("ERROR : webboard function line 34");
				$row = mysqli_num_rows($query_webboard);
				if($row>0){
		    	echo "<p></p><p class='font20'>กระทู้น่าสนใจะเป็นการนำกรทู้ที่มีการเข้าดูมากที่สุด 4 อันดับนำมาแสดง</p>";
		    	echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
			  		echo "<thead>";
			  		echo "<tr>
			  			<th><center>ลำดับ</center></th>
			  			<th><center>ชื่อกระทู้</center></th>
			  			<th class='hidden-xs'><center>ผู้โพสต์</center></th>
			  			<th class='hidden-xs'><center>เข้าชม</center></th>
			  			<th class='hidden-xs'><center>ตอบ</center></th>
			  			<th class='hidden-xs'><center>วัน/เวลา ที่โพสต์</center></th>
			  		</tr>";
			  		echo "</thead>";
			  		echo "<tbody>";
			  		
				  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
				  		$query_subwebboard = mysqli_query($_SESSION['connect_db'],"SELECT subwebboard_id FROM subwebboard WHERE webboard_id='$webboard_id'")or die("ERROR : webboard line 37");
					  	$cnt_subwebboard = mysqli_num_rows($query_subwebboard);
				  		echo "<tr>
				  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
				  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
				  			<td class='col-md-2 hidden-xs'><p align='center' class='font20'>$username</p></td>
				  			<td class='col-md-1 hidden-xs'><p align='center' class='font20'>$visitor</p></td>
				  			<td class='col-md-1 hidden-xs'><p align='center' class='font20'>$cnt_subwebboard</p></td>
				  			<td class='col-md-3 hidden-xs'><p align='center' class='font20'>$webboard_date</p></td>
				  		</tr>";
				  		$number++;
				  	}
			  	echo "</tbody></table>";
			  	}else{
			  		echo "<h4 align='center' style='margin:60px 0px 40px 0px;'><b>ขออภัย!!! ยังไม่มีการเพิ่มกระทู้</b></h4>";
			  	}
		    echo "</div>";
		  echo "</div>";
		echo "</div>";
	  echo "</div>";
	echo "</div>";
	echo "<div class='panel panel-primary weboard-showrecommend'>";
	  echo "<div class='panel-heading' style='padding-bottom:0px;'><b><p class='font20'>รายการกระทู้ทั้งหมด</p></b></div>";
	  echo "<div class='panel-body'>";
	  	$number=1;
		$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webboard ORDER BY webboard_date DESC")or die("ERROR : webboard function line 34");
		$row = mysqli_num_rows($query_webboard);
		if($row>0){
	  	echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
	  		echo "<thead>";
	  		echo "<tr>
	  			<th><center>ลำดับ</center></th>
	  			<th><center>ชื่อกระทู้</center></th>
	  			<th class='hidden-xs'><center>ผู้โพสต์</center></th>
	  			<th class='hidden-xs'><center>เข้าชม</center></th>
	  			<th class='hidden-xs'><center>ตอบ</center></th>
	  			<th class='hidden-xs'><center>วัน/เวลา ที่โพสต์</center></th>
	  		</tr>";
	  		echo "</thead>";
	  		echo "<tbody>";
	  		
		  	while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
		  		$query_subwebboard = mysqli_query($_SESSION['connect_db'],"SELECT subwebboard_id FROM subwebboard WHERE webboard_id='$webboard_id'")or die("ERROR : webboard line 37");
				$cnt_subwebboard = mysqli_num_rows($query_subwebboard);
		  		echo "<tr>
		  			<td class='col-md-1'><p align='center' class='font20'>$number</p></td>
		  			<td class='col-md-4'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
		  			<td class='col-md-2 hidden-xs'><p align='center' class='font20'>$username</p></td>
		  			<td class='col-md-1 hidden-xs'><p align='center' class='font20'>$visitor</p></td>
		  			<td class='col-md-1 hidden-xs'><p align='center' class='font20'>$cnt_subwebboard</p></td>
		  			<td class='col-md-3 hidden-xs'><p align='center' class='font20'>$webboard_date</p></td>
		  		</tr>";
		  		$number++;
		  	}
	  	echo "</tbody></table>";
	  	}else{
			echo "<h4 align='center' style='margin:60px 0px 50px 0px;'><b>ขออภัย!!! ยังไม่มีการเพิ่มกระทู้</b></h4>";
		}
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
	  			//echo "<p class='font20'><button id='message_bold'>B</button>";
	  			//echo "&nbsp;<button id='message_bold'>I</button>";
	  			//echo "&nbsp;<button id='message_bold'>U</button></p>";
	  		echo "</div>";
	  		echo "<div class='col-md-12'><p class='font20'><textarea class='form-control' id='webboard_message' name='webboard_detail' style='height:240px;'></textarea></p></div>";
	  		echo "<div class='col-md-6 col-xs-6'><p ><button type='submit' class='btn btn-success font20' >ตั้งกระทู้</button></p></div>";
	  		echo "<div class='col-md-6 col-xs-6'>";
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
		echo "<script>swal({title:'',text: \"กรุณากรอกข้อมูลให้ครบก่อนทำการเพิ่มกระทู้\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=webboard&action=form_webboard';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	}else{
		$datetime= date("Y-m-d H:i:s");
		mysqli_query($_SESSION['connect_db'],"INSERT INTO webboard VALUES('','$_POST[webboard_header]','$_POST[webboard_detail]','$_SESSION[login_name]','$datetime','0')")or die("ERROR : webboard function line 154");
		echo "<script>swal({title:'',text: \"เพิ่มกระทู้เรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=webboard&action=webboard';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	}
	
}
function webboard_detail(){

	echo "<script>";
	    echo "$(document).ready(function() {";
	            echo "$('#plus_like').click(function(){";
	            if(!empty($_SESSION['login_name'])){
	                echo "var amount_like = parseInt(document.getElementById('like_status').innerHTML);";
	                echo "var rows = parseInt(document.getElementById('like_webboard').value);";
	                echo "if(rows == 0){";
	                    echo "amount_like++;";
	                    echo "$.post('module/index.php?data=plus_like',{webboard_id:$_GET[webboard_id]},function(data){";
	                    echo "});";
	                    echo "document.getElementById('like_status').innerHTML =amount_like;";
	                    echo "document.getElementById('like_webboard').value=1;";
	                    echo "document.getElementById('plus_like').innerHTML='Unlike';";
	                echo "}else{";
	                    echo "amount_like--;";
	                    echo "$.post('module/index.php?data=lower_like',{webboard_id:$_GET[webboard_id]},function(data){";
	                    echo "});";
	                    echo "document.getElementById('like_status').innerHTML =amount_like;";
	                    echo "document.getElementById('like_webboard').value=0;";
	                    echo "document.getElementById('plus_like').innerHTML='Like';";
	                echo "}";
	            }else{
	                echo "swal('', 'สามารถกดถูกใจได้เฉพาะสมาชิกเท่านั้น', 'warning');";
	            }
	            echo "});";
	    echo "});";
/*
	echo "function subwebboard(ele){";
		if(!empty($_SESSION['login_name'])){
	                echo "var amount_like = parseInt(ele.getAttribute('like_substatus'));";
	                echo "var rows = parseInt(ele.getAttribute('like_subwebboard'));";
	                echo "var subwebboard_id = ele.getAttribute('subwebboard_id');";
	                echo "if(isNAaN(ele.getAttribute('like_substatus'))){";
	                echo "amount_like='0';";
	                echo "alert(asdadsadasdasd);";
	                echo "}";
	                echo "alert(amount_like);";
					echo "alert(rows);";
					echo "alert(subwebboard_id);";
	                echo "if(rows == 0){";
	                    echo "amount_like++;";
	                    echo "$.post('module/index.php?data=plus_like',{subwebboard_id:'subwebboard_id'},function(data){";
	                    echo "});";
	                    echo "document.getElementById('like_substatus').innerHTML =amount_like;";
	                    echo "document.getElementById('like_subwebboard').value=1;";
	                    echo "document.getElementById('plus_like').innerHTML='Unlike';";
	                echo "}else{";
	                    echo "amount_like--;";
	                    echo "$.post('module/index.php?data=lower_like',{subwebboard_id:'subwebboard_id'},function(data){";
	                    echo "});";
	                    echo "document.getElementById('like_substatus').innerHTML =amount_like;";
	                    echo "document.getElementById('like_subwebboard').value=0;";
	                    echo "document.getElementById('plus_like').innerHTML='Like';";
	                echo "}";
	            }else{
	                echo "swal('', 'สามารถกดถูกใจได้เฉพาะสมาชิกเท่านั้น', 'warning');";
	            }
	echo "}";
			//alert(ele.getAttribute('like_subwebboard'));
			//alert(ele.getAttribute('subwebboard_id'));
			//alert(ele.getAttribute('like_substatus'));
*/
	echo "</script>";
?>
	<script>
		$(document).ready(function() {
			$("#edit_webboard").click(function(){
				var webboard_id = document.getElementById("webboard_id").value;
				$.post('module/index.php?data=edit_webboard',{webboard_id:webboard_id},function(data){
	            	$("#webboard_detail").html(data);
	            });
			});
		});
		function delete_webboard(webboard_id){
		    swal({
		      title: "ลบกรทู้",
		      text: "คุณต้องการลบกระทู้เลยใช่ไหม",
		      type: "warning",
		      showCancelButton: true,
		      confirmButtonColor: "#DD6B55",
		      confirmButtonText: "ลบกรทู้",
		      cancelButtonText: "ยกเลิกการลบ",
		      closeOnConfirm: false
		    },
		    function(){
		      window.location = 'index.php?module=webboard&action=delete_webboard&webboard_id='+webboard_id;
		    });
		}
	</script>
<?php



	$query_visitor = mysqli_query($_SESSION['connect_db'],"SELECT visitor FROM webboard WHERE webboard_id='$_GET[webboard_id]'")or die("ERROR : webboard function line 151");
	list($visitor)=mysqli_fetch_row($query_visitor);
	$visitor++;
	mysqli_query($_SESSION['connect_db'],"UPDATE webboard SET visitor='$visitor' WHERE webboard_id='$_GET[webboard_id]' ")or die("ERROR : webboard function line 152");
	echo "<div class='col-md-12' style='padding:20px;'>";
		echo "<div class='col-md-12 blog_webboard'>";
			$query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT webboard.*,COUNT(like_status.like_id) FROM webboard LEFT JOIN like_status ON webboard.webboard_id = like_status.like_name_id WHERE webboard.webboard_id='$_GET[webboard_id]' AND like_status.like_name='webboard'  ")or die("ERROR : webboard function line 151");
			list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor,$like)=mysqli_fetch_row($query_webboard);
			echo "<input type='hidden' id='webboard_id' value='$webboard_id'>";
			if(!empty($_SESSION['login_name'])&&($username==$_SESSION['login_name'])){
				echo "<p class='font20' align='right'><button id='edit_webboard' class='btn btn-sm btn-primary'>แก้ไขข้อความ</button>&nbsp;&nbsp;<button onclick='delete_webboard($webboard_id)' class='btn btn-sm btn-danger'>ลบกระทู้</button></p>";
			}
			echo "<p class='font26'><b>ชื่อกระทู้ : </b> $webboard_header</p>";
			echo "<p class='font26'><b>รายละเอียดข้อมูล : </b></p>";
			echo "<p class='font20' id='webboard_detail'>$webboard_detail</p>";

			echo "<hr>";
			$like_message = "Like";
			if(!empty($_SESSION['login_name'])){
				$query_like = mysqli_query($_SESSION['connect_db'],"SELECT like_id FROM like_status WHERE like_name='webboard' AND username='$_SESSION[login_name]' AND like_name_id='$_GET[webboard_id]'")or die("ERROR : webboard function line 168");
	            $row = mysqli_num_rows($query_like);
	            $row = empty($row)?0:$row;
				echo "<input type='hidden' id='like_webboard' value='$row'>";
				$like_message = empty($row)?"Like":"Unlike";
			}
			echo "<div class='col-md-2' style='padding-top:20px;'><p class='font20'><b><a id='plus_like' style='text-decoration: none;cursor:pointer'>$like_message</a> : </b><font id='like_status'>$like</font></p></div>";
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
				echo "<hr>";
				/*
				$query_sublike = mysqli_query($_SESSION['connect_db'],"SELECT like_name_id FROM like_Status WHERE like_name='subwebboard' AND like_name_id='$subwebboard_id'")or die("ERROR subwebboard function line 230");
				$sublike = mysqli_num_rows($query_sublike);
				$sublike = (empty($sublike))?"0":"$sublike";
				$sublike_message = "Like";
				if(!empty($_SESSION['login_name'])){
					$query_likesub = mysqli_query($_SESSION['connect_db'],"SELECT like_id FROM like_status WHERE like_name='subwebboard' AND username='$_SESSION[login_name]' AND like_name_id='$subwebboard_id'")or die("ERROR : webboard function line 168");
		            $cnt_user_sublike = mysqli_num_rows($query_likesub);
		            $cnt_user_sublike = empty($cnt_user_sublike)?0:$cnt_user_sublike;
					$sublike_message = empty($cnt_user_sublike)?"Like":"Unlike";
				}

				echo "<div class='col-md-2' style='padding-top:20px;'><p class='font20'><b><a onclick='subwebboard(this)' id='plus_sublike' like_subwebboard='$cnt_user_sublike' subwebboard_id='$subwebboard_id' style='text-decoration: none;cursor:pointer'>$sublike_message</a> : <font id='like_substatus'>$sublike</font></b></p></div>";
				*/
				// อันเก่า echo "<div class='col-md-10' style='border-left:1px solid #bbb;padding-left:10px;'><p class='font20'>";
				echo "<div class='col-md-10' style='padding-left:10px;'><p class='font20'>";
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
		  		echo "<div class='container-fluid' style='padding:0px'>";
		  		echo "<div class='col-md-12'><b><p class='font20'>ตอบกลับกระทู้ : </p></b></div>";
		  		if(empty($_SESSION['login_name'])){
		  			echo "<div class='col-md-12'><p class='font20'>*****หากต้องการตอบกระทู้หรือตั้งกระทู้ กรุณาล็อดอินเข้าใช้งานระบบก่อน*****</p></div>";
		  			$disabled = "disabled";
		  			$button_type ="button";
		  		}else{
		  			$disabled = "";
		  			$button_type ="submit";
		  		}
		  		echo "<div class='col-md-12'><p class='font20'><textarea id='subwebboard_message' name='subwebboard_message' style='height:150px;width:100%' $disabled></textarea></p></div>";
		  		echo "<div class='col-md-6 col-xs-4'><p ><button type='$button_type' class='btn btn-success font20' >ตอบกลับ</button></p></div>";
		  		echo "<div class='col-md-6 col-xs-8'>";
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
		  		echo "</div>";
		  	echo "</div></form>";
		echo "</div>";
		
	echo "</div>";
}
function update_webboard(){
	mysqli_query($_SESSION['connect_db'],"UPDATE webboard SET webboard_detail='$_POST[webboard_detail]' WHERE webboard_id='$_POST[webboard_id]'")or die("ERROR : webboard line 349");
		echo "<script>swal({title:'',text: \"แก้ไขกระทู้เรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=webboard&action=webboard_detail&webboard_id=$_POST[webboard_id]';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}
function insert_subwebboard(){
	if(empty($_POST['subwebboard_message'])){
		echo "<script>swal({title:'',text: \"กรุณาพิมพ์ข้อความก่อนทำการตอบกระทู้\",type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=webboard&action=webboard_detail&webboard_id=$_POST[webboard_id]';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	}else{
		$subwebboard_datetime = date("Y-m-d H:i:s");
		mysqli_query($_SESSION['connect_db'],"INSERT INTO subwebboard VALUES('','$_POST[webboard_id]','$_POST[subwebboard_message]','$_SESSION[login_name]','$subwebboard_datetime')")or die("ERROR : webboard line 359");
		echo "<script>swal({title:'',text: \"แสดงความคิดเห็นเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=webboard&action=webboard_detail&webboard_id=$_POST[webboard_id]';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	}
}
function delete_webboard(){
	mysqli_query($_SESSION['connect_db'],"DELETE FROM webboard WHERE webboard_id='$_GET[webboard_id]'")or die("ERROR : webboard line 349");
		echo "<script>swal({title:'',text: \"ลบกระทู้รหัส $_GET[webboard_id] เรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=webboard&action=webboard';})</script>";
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}

?>
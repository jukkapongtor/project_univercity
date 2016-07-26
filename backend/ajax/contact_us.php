<?php
session_start();
include("../../include/function.php");
connect_db();
?>
<script>
	$(document).ready(function() {
<?php
		$query_contact = mysqli_query($_SESSION['connect_db'],"SELECT contact_id FROM contactus ")or die("ERROR : backend manage_website line 65");
		while(list($contact_id)=mysqli_fetch_row($query_contact)){
			echo "$('#contact_id_$contact_id').click(function(){";
				echo "$('#background_read_$contact_id').css({'background':'white'});";
				echo "$.post('ajax/function_contact.php?data=read',{contact_id:'$contact_id'},function(data){";
				echo "});";
			echo "});";
		}
?>
	});
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a style="text-decoration:none">หน้าหลัก</a></li>
			<li><a style="text-decoration:none">ข้อความ</a></li>
		</ol>
	</div>
</div>
<div class="container-fluid">
<center><h3 style='margin-top:0px;background:#16326a;color:white;padding-top:8px;border-bottom:4px solid #325bb0'><b>รายการข้อความจากผู้ใช้</b></h3></center>
	<div class="panel panel-primary" style="margin-top:20px;">
	  <div class="panel-heading">ข้อความจากผู้ใช้</div>
	  <div class="panel-body">
	    <table class="table ">
			<thead><tr><th><center>ลำดับ</center></th><th><center>ข้อความ</center></th><th><center>ผู้ส่ง</center></th><th><center>เวลาที่ส่ง</center></th></tr></thead><tbody>
<?php
		$query_contact = mysqli_query($_SESSION['connect_db'],"SELECT contact_id,contact_username,contact_email,contact_massage,type_user,contact_date,visitor FROM contactus ")or die("ERROR : backend manage_website line 65");
		$num = 1;
		while(list($contact_id,$contact_username,$contact_email,$contact_massage,$type_user,$contact_date,$visitor)=mysqli_fetch_row($query_contact)){
			$visi = ($visitor==1)?"background:#ddd":"";
			echo "<tr id='background_read_$contact_id' style='$visi'>";
				echo "<td align='center' width='10%'>$num</td>";
				//echo "<td>$product_id</td>";
				$length = strlen($contact_massage);
	
				if($length>80){
					$text = substr_replace($contact_massage,'...',80);
				}else{
					$text=$contact_massage;
				}
				echo "<td><a id='contact_id_$contact_id' data-toggle='modal' data-target='#$contact_id' style='text-decoration:none;cursor:pointer'>".$text."</a></td>";
?>
					<div class="modal fade" id="<?php echo $contact_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel">รายละเอียดข้อความจาก <?php echo "$contact_username เมื่อวันที่ $contact_date"?></h4>
					      </div>
					      <div class="modal-body">
					        <?php
					        	echo "<p><b>ข้อความจากผู้ใช้ </b>$contact_username</p>";
					        	echo "<p><b>อีเมล์ </b>$contact_email</p>";
					        	echo "<p><b>เมื่อวันที่ </b>$contact_date</p>";
					        	echo "<p><b>รายละเอียด</b></p>";
					        	echo "<p style='margin-left:30px;'>$contact_massage</p>";
					        ?>
					      </div>
					    </div>
					  </div>
					</div>
<?php
				echo "<td width='10%'>$contact_username</td>";
				echo "<td width='20%'>$contact_date</td>";
				//echo "<td align='center'><button class='btn btn-sm btn-success' style='padding:0px 10px;'>เพิ่มจำนวน</button></td>";
			echo "</tr>";
			$num++;
		}
?>
		</tbody></table>

	  </div>
	</div>
</div>
</body>
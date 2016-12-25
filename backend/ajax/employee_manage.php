<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	date_default_timezone_set('Asia/Bangkok');
	connect_db();
?>
<head>
	<title></title>
	<link rel="stylesheet" href="css/table.css">
<script>
function delete_product(employee_id){
    swal({
      title: "ลบพนักงาน",
      text: "คุณต้องการลบพนักงานใช่หรือไหม",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "ลบพนักงาน",
      cancelButtonText: "ยกเลิกการลบ",
      closeOnConfirm: false
    },
    function(){
      window.location = 'ajax/employee_delete.php?employee_id='+employee_id;
    });
}
</script> 
</head>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#ajax/employee_manage.php">จัดการข้อมูลพนักงาน</a></li>
			<li><a href="#ajax/employee_manage.php">ข้อมูลพนักงาน</a></li>

		</ol>
	</div>
</div>

<body>
	<a href="ajax/employee_form_id.php"><button class="btn btn-primary" type="submit"> <img src="../images/icon/add.png" width="26px" ></button></a>
	<center><div class="datagrid" style="width: 100%;" >
	<table>
		<thead>
			<tr>
				<th><center>ภาพพนักงาน</center></th>
				<th><center>ชื่อพนักงาน</center></th>
				<th><center>นามสกุลพนักงาน</center></th>
				<th><center>เบอร์โทรศัพท์</center></th>
				<th><center>รายละเอียด</center></th>
				<th><center>จัดการ</center></th>
			</tr>
		</thead>

<?php 
				
		$query_em = mysqli_query($_SESSION['connect_db'],"SELECT employee_id, employee_img, name_thai, surname_thai, phone_number FROM employee")or die("ERROR : employee_manage line 40");
		while (list($employee_id, $employee_img, $name_thai, $surname_thai, $phone_number)=mysqli_fetch_row($query_em)) {

		if (empty($employee_img)) {
			$image="<center><img src='../images/icon/no-images.jpg' width='65px' height='65px' ></center>";
		}else{
			$image="<center><img src = '../images/employee/$employee_img' width='65px' height='65px' ></center>";
		}

		echo "<tbody><tr>";
		echo "<center><td valign='middle'>$image</td></center>";
		echo "<td valign='middle'><center>$name_thai</center></td>";
		echo "<td valign='middle'><center>$surname_thai</center></td>";
		echo "<td valign='middle'><center>$phone_number</center></td>";
		echo "<td valign='middle'><a href = 'ajax/employee_detail_id.php?employee_id=$employee_id'><center><img src='../images/icon/magnifying-glass .png' width='30px'height='30px'></center></a></td>";
		echo "<td valign='middle'><center><a href = 'ajax/employee_fromupdate_id.php?employee_id=$employee_id'><button class='btn btn-success'>แก้ไข</button></a>";
		echo "&nbsp;&nbsp;<a onclick='delete_product($employee_id)'><button class='btn btn-danger'>ลบ</button></a></center></td>";
		
		echo "</tr></tbody>";

			
		}


 ?>



	</table>
	</div></center>
</body>
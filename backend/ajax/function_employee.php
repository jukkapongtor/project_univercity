<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'salary':
	$employee_id = $_POST['employee_id'];
	$edit_em = mysqli_query($_SESSION['connect_db'], "SELECT titlename, name_thai, surname_thai FROM employee WHERE employee_id='$employee_id' ") or die("ERROR : employee_fromupdate line 30");
    list($titlename, $name_thai, $surname_thai)=mysqli_fetch_row($edit_em);
?>
	<div class="panel panel-info" style="width:100% " >
        <div class="panel-heading">
           	<input type="hidden" id="employee_id" value="<?php echo "$employee_id"; ?>" >
            <h3 class="panel-title">เงินเดือน <?php echo "$titlename$name_thai $surname_thai"; ?></h3>
        </div>
            <div class="panel-body">

            <p>SALARY</p>

            </div>
	</div>

<?php
	break;
	case 'timework':
	$employee_id = $_POST['employee_id'];
	$edit_em = mysqli_query($_SESSION['connect_db'], "SELECT titlename, name_thai, surname_thai FROM employee WHERE employee_id='$employee_id' ") or die("ERROR : employee_fromupdate line 30");
    list($titlename, $name_thai, $surname_thai)=mysqli_fetch_row($edit_em);
?>
	<div class="panel panel-info" style="width:100% " >
        <div class="panel-heading">
           	<input type="hidden" id="employee_id" value="<?php echo "$employee_id"; ?>" >
            <h3 class="panel-title">เวลาเข้างานของ <?php echo "$titlename$name_thai $surname_thai"; ?></h3>
        </div>
            <div class="panel-body">
            	<p style="font-size:16px"><b>วันที่ทำงาน : </b><?php echo date("d-m-Y");?></p>
            	<form action="ajax/working.php" method='post'>
            	<p style="margin-top:10px;"><b>ลงเวลาทำงาน : </b>
            		<input type='hidden' name='employee_id' value="<?php echo $employee_id;?>" >
            		<button class='btn btn-sm btn-success' name='btn_work' value="workin"  style="padding:0px 5px;margin-top:-2px;">ลงเวลาเข้า</button>
            	&nbsp;&nbsp;&nbsp;<b>ลงเวลาออกงาน : </b>
            		<button class='btn btn-sm btn-danger' name='btn_work' value="workout" style="padding:0px 5px;margin-top:-2px;">ลงเวลาออก</button>
            	</p>
                <p><font color="red"> *** </font>กรณีลางาน<font color="red"> *** </font></p>
                <p><textarea name='stop_work' class="form-control"></textarea></p>
                <p align="right"><button class="btn btn-xs btn-info" name='btn_work' value="btn_stopwork" style="padding:0px 5px;margin-top:-2px;">ลางาน</button></p>
            	</form>
            	<p ><b>เวลาในทำงานวันนี้</b></p>
            	<table class="table">
            		<tr>
            			<th><center>เวลาเข้าทำงาน</th><th><center>เวลาออกงาน</th><th><center>หมายเหตุ</th>
            		</tr>
<?php
					$query_working = mysqli_query($_SESSION['connect_db'],"SELECT working_in,working_out,note FROM working WHERE employee_id ='$employee_id' AND DAY(working_in)='".date("d")."' AND MONTH(working_in)='".date("m")."' AND YEAR(working_in)='".date("Y")."'")or die("ERROR function employee line 45");
					$rows = mysqli_num_rows($query_working);
					if($rows > 0){
						list($working_in,$working_out,$note)=mysqli_fetch_row($query_working);
						echo "<tr><td align='center'>$working_in</td><td align='center'>$working_out</td><td>$note</td></tr>";
					}else{
						echo "<tr><td align='center'>0000-00-00 00:00:00</td><td align='center'>0000-00-00 00:00:00</td><td>-</td></tr>";
					}
?>
            	</table>
            	<p ><b>เวลาในทำงานย้อนหลัง 7 วัน</b></p>
            	<table class="table">
            		<tr>
            			<th><center>เวลาเข้าทำงาน</th><th><center>เวลาออกงาน</th><th><center>หมายเหตุ</th>
<?php
					$query_working = mysqli_query($_SESSION['connect_db'],"SELECT working_in,working_out,note FROM working WHERE employee_id ='$employee_id' ORDER BY working_in DESC LIMIT 0,7");
					$rows = mysqli_num_rows($query_working);
					if($rows > 0){
						while(list($working_in,$working_out,$note)=mysqli_fetch_row($query_working)){
							echo "<tr><td align='center'>$working_in</td><td align='center'>$working_out</td><td>$note</td></tr>";
						}
					}else{
						echo "<tr><td align='center'>0000-00-00 00:00:00</td><td align='center'>0000-00-00 00:00:00</td><td>-</td></tr>";
					}
?>
            		</tr>
            	</table>
            </div>
	</div>

<?php
	break;
}
?>
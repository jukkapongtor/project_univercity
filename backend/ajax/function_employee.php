<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'salary':
	$employee_id = $_POST['employee_id'];
	$edit_em = mysqli_query($_SESSION['connect_db'], "SELECT titlename, name_thai, surname_thai FROM employee WHERE employee_id='$employee_id' ") or die("ERROR : backend salary function line 9");
    list($titlename, $name_thai, $surname_thai)=mysqli_fetch_row($edit_em);
?>
    <div class="panel panel-info" style="width:100% " >
        <div class="panel-heading">
            <h3 class="panel-title">กำหนดเงินเดือนให้พนักงาน(รายวัน)</h3>
        </div>
            <div class="panel-body">
            <form action='ajax/salary_start.php' method="post">
            <table>
                <tr>
                    <input type="hidden" name="employee_id" value="<?php echo "$employee_id"; ?>" >
                    <td><p><b>กำหนดเงินรายวัน : &nbsp;&nbsp;</b></p></td>
                <?php
                    $query_start_salary = mysqli_query($_SESSION['connect_db'],"SELECT salary_price FROM start_salary ORDER BY salary_id DESC ")or die("backend salary function line 23");
                    list($salary_price)=mysqli_fetch_row($query_start_salary);
                ?>
                    <td><p><input type="text" class='form-control' name='salarybyday' value="<?php  echo "$salary_price";?>" required></p></td>
                    <td><p>&nbsp;&nbsp;<input type="submit" class='btn btn-sm btn-success'  value='ตกลง' style='padding:0px 5px;margin-top:10px;'></p></td>
                </tr>
            </table>
            </form>
            </div>
    </div>
	<div class="panel panel-info" style="width:100% " >
        <div class="panel-heading">
            <h3 class="panel-title">เงินเดือน <?php echo "$titlename$name_thai $surname_thai"; ?></h3>
        </div>
            <div class="panel-body">
            <?php
                $query_working = mysqli_query($_SESSION['connect_db'],"SELECT SUM(salary) FROM working WHERE employee_id ='$employee_id' AND MONTH(working_in)='".(date("m")-1)."'")or die("ERROR function employee line 39");
                list($last_salary)=mysqli_fetch_row($query_working);
                $last_salary = empty($last_salary)?0:$last_salary;
            ?>
            <p>เงินเดือนเมื่อเดือนที่แล้ว : <?php echo $last_salary?> บาท</p>
            <?php
                $query_working = mysqli_query($_SESSION['connect_db'],"SELECT working_id,working_in,working_out,salary,TIMEDIFF(working_out,working_in) FROM working WHERE employee_id ='$employee_id' AND MONTH(working_in)='".date("m")."'")or die("ERROR function employee line 45");
                $rows = mysqli_num_rows($query_working);
                if($rows > 0){
                echo "<form action='ajax/salary_update.php' method='post'>";
                    echo "<input type='hidden' name='employee_id' value='$employee_id' >";
                    echo "<input type='hidden' name='month' value='".date("m")."' >";
                    echo "<table class='table'>";
                        echo "<tr><th><center>เวลาเข้าทำงาน</th><th><center>เวลาออกงาน</th><th><center>เวลาในการทำงาน</th><th><center>กำหนดเงิน</th></tr>";
                    $total_Salary = 0;
                    while(list($working_id,$working_in,$working_out,$salary,$date_diff)=mysqli_fetch_row($query_working)){
                        $date_diff = ($working_out!="0000-00-00 00:00:00")?$date_diff:0;
                        echo "<input type='hidden' name='working_id[]' value='$working_id' ";
                        echo "<tr><td align='center'>$working_in</td><td align='center'>$working_out</td><td align='center'>$date_diff</td><td><input class='form-control input-sm' type='text' name='salary[]' value='$salary'></td></tr>";
                        $total_Salary +=$salary;
                    }
                        echo "<tr><td align='right' colspan='3'>รวมเงินเดือน</td><td align='right'>".number_format($total_Salary)." ฿</td></tr>";
                    echo "</table>";
                }
                echo "<p><font color='red'>*** </font>กรณีที่มีการแก้ไขเงินเดือนพนักงาน<font color='red'> ***</font></p>";
                echo "<input type='submit' class='btn btn-sm btn-info' value='แก้ไขข้อมูลเงินเดือน'>";
                echo "</form>"
            ?>

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
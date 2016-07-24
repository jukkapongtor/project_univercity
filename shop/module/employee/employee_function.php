<?php
function show_worktime(){
?>
<div class="menu-header">
	<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='#'>ดูเวลาทำงาน</a>  </p>
</div>
<hr style="margin-top:0px;"><hr style="margin-top:-18px;">
<?php
$query_user = mysqli_query($_SESSION['connect_db'],"SELECT employee_id FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : shop employee line 9");
list($employee_id)=mysqli_fetch_row($query_user);
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
            	<p ><b>เวลาในทำงานวันนี้</b></p>
            	<div class='table-responsive'> 
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
            	</div>
            	<p ><b>เวลาในทำงานย้อนหลัง 7 วัน</b></p>
            	<div class='table-responsive'>
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
            	</center>
            </div>
	</div>

<?php
}
function show_salary(){
?>
<div class="menu-header">
	<p style="margin:0px;"><a href='index.php'>หน้าหลัก</a> / <a href='#'>ดูเงินเดือน</a>  </p>
</div>
<?php
	$query_user = mysqli_query($_SESSION['connect_db'],"SELECT employee_id FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : shop employee line 9");
	list($employee_id)=mysqli_fetch_row($query_user);

	$query_working = mysqli_query($_SESSION['connect_db'],"SELECT SUM(salary) FROM working WHERE employee_id ='$employee_id' AND MONTH(working_in)='".(date("m")-1)."'");
    list($last_salary)=mysqli_fetch_row($query_working);
    $last_salary = empty($last_salary)?0:$last_salary;
    echo "<p style='margin:20px;'><b>เงินเดือนเมื่อเดือนที่แล้ว : </b>$last_salary บาท</p>";
	
	$query_working = mysqli_query($_SESSION['connect_db'],"SELECT working_id,working_in,working_out,salary,TIMEDIFF(working_out,working_in) FROM working WHERE employee_id ='$employee_id' AND MONTH(working_in)='".date("m")."'");
    $rows = mysqli_num_rows($query_working);
   	if($rows > 0){
        echo "<input type='hidden' name='employee_id' value='$employee_id' >";
        echo "<input type='hidden' name='month' value='".date("m")."' >";
        echo "<div class='table-responsive'>";
        echo "<table class='table'>";
            echo "<tr><th><center>เวลาเข้าทำงาน</th><th><center>เวลาออกงาน</th><th><center>เวลาในการทำงาน</th><th><center>กำหนดเงิน</th></tr>";
            $total_Salary = 0;
            while(list($working_id,$working_in,$working_out,$salary,$date_diff)=mysqli_fetch_row($query_working)){
                $date_diff = ($working_out!="0000-00-00 00:00:00")?$date_diff:0;
                echo "<input type='hidden' name='working_id[]' value='$working_id' ";
                echo "<tr><td align='center'>$working_in</td><td align='center'>$working_out</td><td align='center'>$date_diff</td><td align='right'>$salary  ฿</td></tr>";
                $total_Salary +=$salary;
            }
            echo "<tr><td align='right' colspan='3'>รวมเงินเดือน</td><td align='right'>".number_format($total_Salary)." ฿</td></tr>";
        echo "</table>";
        echo "</div>";
    }
}
?>
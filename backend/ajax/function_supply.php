<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'select_supply':

    $year=$_POST['year'];
    $query_month=mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : supplys list line 33");

    while(list($month_id,$month_name)=mysqli_fetch_row($query_month)){
        if($month_id==$_POST['month']){
            $month = $month_name;
        }
    }
?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><b>รายการค่าใช้จ่ายในเดือน <?php echo "$month ปี $year";?> </b></h3>
      </div>
      <div class="panel-body">
<?php
        $date5day = array();
        $query_sup5day =  mysqli_query($_SESSION['connect_db'],"SELECT  DATE(supply_date),SUM(supply_price*supply_amount) FROM buy_supply WHERE MONTH(supply_date)='$_POST[month]' AND YEAR(supply_date)=' $year' GROUP BY DATE(supply_date) ORDER BY DATE(supply_date) DESC")or die("ERROR : supply manage line 91");
        $rows = mysqli_num_rows($query_sup5day);
        if($rows>0){
        echo "<table class='table table-hover table-striped table-bordered'>";
        echo "<tr><th width='10%'><center>ลำดับ</th><th width='80%'><center>รายการ</th><th width='10%'><center>ราคารวม</th></tr>";
        $number = 1;
        $total =0;

        while (list($supply_date,$sum_price)=mysqli_fetch_row($query_sup5day)) {
            echo "<tr>";
                    $day = substr($supply_date, 8,2);
                    //$month = substr($supply_date, 6,2);
                    $year = substr($supply_date, 0,4);
                    echo "<td align='center' width='10%'>$number</td>";
                    echo "<td width='25%'><a data-toggle='modal' data-target='#$day' style='text-decoration:none;cursor:pointer'>ค่าใช้จ่ายประจำวันที่ $day $month $year</a>";
?>
                            <div class="modal fade" id="<?php echo "$day";?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                              <div class="modal-dialog" role="document" style='margin-top:100px;'>
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo "ค่าใช้จ่ายประจำวันที่ $day $month $year";?></h4>
                                  </div>
                                  <div class="modal-body">
<?php
                                        echo "<table class='table table-hover table-striped table-bordered'>";
                                            echo "<tr><th><center>ลำดับ</th><th><center>รายการ</th><th><center>ราคา</th><th><center>จำนวน(หน่วย)</th><th><center>ราคาทั้งหมด</th></tr>";
                                            $query_buysupply = mysqli_query($_SESSION['connect_db'],"SELECT * FROM buy_supply WHERE MONTH(supply_date)='$_POST[month]' AND YEAR(supply_date)='$year' AND DAY(supply_date)='$day'")or die("ERROR : supply manage line 89");
                                            $number=1;
                                            $total_detail=0;
                                            while(list($buy_id,$supply_name,$supply_amount,$supply_price,$supply_unit,$supply_date)=mysqli_fetch_row($query_buysupply)){
                                                echo "<tr>";
                                                    echo "<td align='center' width='10%'>$number</td>";
                                                    echo "<td width='25%'>$supply_name</td>";
                                                    echo "<td align='right' width='20%'>".number_format($supply_price,2)." ฿</td>";
                                                    echo "<td width='20%'>$supply_amount $supply_unit</td>";
                                                    $sum = $supply_price * $supply_amount;
                                                    echo "<td align='right'>".number_format($sum,2)." ฿</td>";
                                                    $number++;
                                                    $total_detail+=$sum;
                                                echo "</tr>";
                                            }
                                            echo "<tr><td colspan='4' align='right'>รวมค่าใช้จ่ายทั้งหมด</td><td align='right'>".number_format($total_detail,2)." ฿</td></tr>";
                                            echo "</table>";
?>
                                  </div>
                                </div>
                              </div>
                            </div>
<?php
                    echo "</td><td align='right'>".number_format($sum_price,2)." ฿</td>";
                    $total +=$sum_price;
            echo "</tr>";
            $number++;
        }
        echo "<tr><td colspan='2' align='right'>รวมค่าใช้จ่ายทั้งหมด</td><td align='right'>".number_format($total,2)." ฿</td></tr>";
        echo "</table>";
        }else{
            echo "<center><h3><font color='red'> !!! </font>ไม่พบรายการค่าใช้จ่าย<font color='red'> !!! </font></h3></center>";
        }
?>
      </div>
    </div>  
<?php
	break;
}
?>
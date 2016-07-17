<?php
	session_start();
	include("../../include/function.php");
	connect_db();

?>
<script>
	$(document).ready(function() {
		$("#select_date").click(function(){
			var year = document.getElementById("select_year").value;
			$.post('ajax/function.php?data=report_sell_month',{year:year},function(data){
				if(data=="<center><h3 style='margin-top:50px;'><font color='red'>!!! </font>กรุณาเลือกข้อมูลในการแสดง ก่อนกดปุ่ม \"ตกลง\" <font color='red'> !!! </font></h3></center>"){
					$('#chartContainer').hide();
		  			$('#report_year').html(data);
				}else{
					$('#chartContainer').show();
		  			$('#report_year').html(data);
		  		}
		    });
		});
		
	});

</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">รายงานการขายสินค้า</a></li>
			<li><a href="#">รายงานการขายรายปี</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<div class="container-fluid">
<div class='panel panel-info'>
		  <div class='panel-heading'>
		    <h2 class='panel-title'><b>เลือกช่วงเวลาในการดูรายการขายรายเดือน</b></h2>
		  </div>
		  <div class='panel-body'>
		  	<b><h5><b>เลือกช่วงเวลา</b></h5></b>
			<div class="col-md-7">
				<p><font color="red">***</font> ระบบจะให้เลือกปีทำหรับปีที่มีการขาย <font color="red">***</font></p>
				<table width="100%">
					<tr>
						<th width="10%">เลือกปี</th><th width="5%">&nbsp;:&nbsp;</th>
						<td>
							<select class='form-control' id='select_year'>
								<option value="0">--เลือกปี--</option>
<?php
								$query_year_order = mysqli_query($_SESSION['connect_db'],"SELECT YEAR(order_date) FROM orders GROUP BY YEAR(order_date)")or die("ERROR : report  sell product month line 35");
								while (list($year_oreder)=mysqli_fetch_row($query_year_order)) {
									echo "<option value='$year_oreder'>$year_oreder</option>";
								}
?>
							</select>
						</td>
						<td>
							&nbsp;&nbsp;<input type="submit" id='select_date' class="btn btn-sm btn-success" value="ตกลง" style="padding:0px 5px;margin-top:10px;">
						</td>
					</tr>
				</table>
			</div>
		  </div>
		</div>
</div>

<div class="container-fluid">
	<div id="chartContainer" style="height: 300px; width: 100%;"></div>
	<div id='report_year'></div>
</div>
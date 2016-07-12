<?php
	session_start();
	include("../../include/function.php");
	connect_db();

?>
<script>
	$(document).ready(function() {
		$("#select_date").click(function(){
			var year = document.getElementById("select_year").value;
			var month = document.getElementById("select_month").value;
			$.post('ajax/function.php?data=report_sell_day',{year:year,month:month},function(data){
		  		$('#report_month').html(data);

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
			<li><a href="#">รายงานการขายรายเดือน</a></li>
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
		  	<b><h5>เลือกช่วงเวลา</h5></b>
			<div class="col-md-7">
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
						<th width="15%">&nbsp;&nbsp;เลือกเดือน</th><th width="5%">&nbsp;:&nbsp;</th>
						<td>
							<select class='form-control' id='select_month'>
								<option value="0">--เลือกเดือน--</option>
<?php
								$query_month = mysqli_query($_SESSION['connect_db'],"SELECT month_id,month_name FROM month")or die("ERROR : report  sell product month line 47");
								while (list($month_id,$month_name)=mysqli_fetch_row($query_month)) {
									echo "<option value='$month_id'>$month_name</option>";
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
	<div id='report_month'></div>
</div>
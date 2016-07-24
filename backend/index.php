<?php
	session_start();

	include("../include/function.php");
	connect_db();
	date_default_timezone_set('Asia/Bangkok');
	if(!empty($_SESSION['login_name'])&&$_SESSION['login_type']==1){
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>MUMFERN SHOP</title>
		<meta name="description" content="description">
		<meta name="author" content="DevOOPS">
		<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="images/icon/logomumfern.png" />
			<link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
			<link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
			<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
			<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
			<link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
			<link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
			<link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">
			<link href="plugins/select2/select2.css" rel="stylesheet">
			<link href="plugins/justified-gallery/justifiedGallery.css" rel="stylesheet">
			<link href="css/style_v2.css" rel="stylesheet">
			<link href="css/style_v3.css" rel="stylesheet">
			<link href="plugins/chartist/chartist.min.css" rel="stylesheet">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/froala_editor.css">
			<link rel="stylesheet" href="css/froala_style.css">
			<link rel="stylesheet" href="css/plugins/code_view.css">
			<link rel="stylesheet" href="css/plugins/colors.css">
			<link rel="stylesheet" href="css/plugins/emoticons.css">
			<link rel="stylesheet" href="css/plugins/image_manager.css">
			<link rel="stylesheet" href="css/plugins/image.css">
			<link rel="stylesheet" href="css/plugins/line_breaker.css">
			<link rel="stylesheet" href="css/plugins/table.css">
			<link rel="stylesheet" href="css/plugins/char_counter.css">
			<link rel="stylesheet" href="css/plugins/video.css">
			<link rel="stylesheet" href="css/codemirror.min.css">
			<link rel="stylesheet" type="text/css" href="../sweetalert/sweetalert.css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
		
	</head>

<body>

<!--Start Header-->
<div id="screensaver">
	<canvas id="canvas"></canvas>
	<i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
	<div class="devoops-modal">
		<div class="devoops-modal-header">
			<div class="modal-header-name">
				<span>Basic table</span>
			</div>
			<div class="box-icons">
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="devoops-modal-inner">
		</div>
		<div class="devoops-modal-bottom">
		</div>
	</div>
</div>
<header class="navbar">
	<div class="container-fluid expanded-panel">
		<div class="row">
			<div id="logo" class="col-xs-12 col-sm-2">
				<a href="index.php"><img src='../images/icon/logomumfern.png' width="50" height="50" style="margin-top:-3px;">&nbsp;MUMFERN SHOP</a>
			</div>
			<div id="top-panel" class="col-xs-12 col-sm-10">
				<div class="row">
					<div class="col-xs-8 col-sm-4">
						<!--<div id="search">
							<input type="text" placeholder="search"/>
							<i class="fa fa-search"></i>
						</div>-->
					</div>
					<div class="col-xs-4 col-sm-8 top-panel-right">
						<!--<a href="#" class="about hidden-xs">about</a>-->
						<ul class="nav navbar-nav pull-right panel-menu">
						<!--
							<li class="hidden-xs">
								<a href="index.php" class="modal-link">
									<i class="fa fa-bell"></i>
									<span class="badge">7</span>
								</a>
							</li>
							<li class="hidden-xs">
								<a class="ajax-link" href="ajax/calendar.html">
									<i class="fa fa-calendar"></i>
									<span class="badge">7</span>
								</a>
							</li>
							<li class="hidden-xs">
								<a href="ajax/page_messages.html" class="ajax-link">
									<i class="fa fa-envelope"></i>
									<span class="badge">7</span>
								</a>
							</li>
						-->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
									<i class="fa fa-angle-down pull-right" style='float:right;'></i>
<?php
								$query_user_login = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,lastname,image FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : backend index line 98");
								list($username,$fullname,$lastname,$image)=mysqli_fetch_row($query_user_login);
									echo "<div class='user-mini pull-right' style='float:right;'>";
										echo "<span class='welcome hidden-xs'>$username</span>";
										echo "<span class='hidden-xs'>$fullname $lastname</span>";
									echo "</div>";
									echo "<div class='avatar' style='float:right;'>";
										echo "<img src='../images/user/$image' class='img-circle' alt='avatar' />";
									echo "</div>";
?>
								</a>
								<ul class="dropdown-menu" style="background:#444">
									<li>
										<a href="#">
											<i class="fa fa-user"></i>
											<span>ข้อมูลส่วนตัว</span>
										</a>
									</li>
<!--
									<li>
										<a href="ajax/page_messages.html" class="ajax-link">
											<i class="fa fa-envelope"></i>
											<span>Messages</span>
										</a>
									</li>
									<li>
										<a href="ajax/gallery_simple.html" class="ajax-link">
											<i class="fa fa-picture-o"></i>
											<span>Albums</span>
										</a>
									</li>
									<li>
										<a href="ajax/calendar.html" class="ajax-link">
											<i class="fa fa-tasks"></i>
											<span>Tasks</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-cog"></i>
											<span>Settings</span>
										</a>
									</li>
-->
									<li>
										<a href="../include/index.php?action=logout">
											<i class="fa fa-power-off"></i>
											<span>Logout</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
	<div class="row">
		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<ul class="nav main-menu">
				<li>
					<a href="ajax/dashboard.php" class="ajax-link">
						<i class="fa fa-dashboard"></i>
						<span class="hidden-xs">หน้าแดชบอร์ด</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/website-design.png" width="16px" ></i>
						 <span >จัดการเว็บไซต์</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/manage_website.php">จัดการหน้าเว็บไซต์</a></li>
						<li><a class="ajax-link" href="ajax/manage_slideshow.php">จัดการสไลด์</a></li>
						<li><a class="ajax-link" href="ajax/manage_webblog.php">จัดการบทความ</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/box-closed.png" width="16px" ></i>
						 <span >จัดการสินค้า</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/type_manage.php">จัดการประเภทสินค้า</a></li>
						<li><a class="ajax-link" href="ajax/quality_manage.php">จัดการหมวดหมู่สินค้า</a></li>
						<li><a class="ajax-link" href="ajax/product_add.php">เพิ่มรายการสินค้า</a></li>
						<li><a class="ajax-link" href="ajax/product_list.php">แก้ไขรายการสินค้า</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/shopping.png" width="16px" ></i>
						 <span >จัดการคลังสินค้า</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/buy_product.php">เพิ่มสินค้า</a></li>
						<li><a class="ajax-link" href="ajax/stock_list.php">รายการคลังสินค้า</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/shopping.png" width="16px" ></i>
						 <span >จัดการค่าใช้จ่าย</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/supplyes_manage.php">เพิ่มค่าใช้จ่าย</a></li>
						<li><a class="ajax-link" href="ajax/supplyes_list.php">รายการค่าใช้จ่าย</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/income.png" width="16px" ></i>
						 <span >จัดการรายได้</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/manage_order.php">ดูรายการขายบนเว็บไซต์</a></li>
						<li><a class="ajax-link" href="ajax/manage_order_shop.php">ดูรายการขายในร้าน</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/money.png" width="16px" ></i>
						 <span >รายงานการขายสินค้า</span>
					</a>
					<ul class="dropdown-menu">
						<!--<li><a class="ajax-link" href="ajax/report_sell_day.php">รายงานการขายรายวัน</a></li>-->
						<li><a class="ajax-link" href="ajax/report_sell_month.php">รายงานการขายรายเดือน</a></li>
						<li><a class="ajax-link" href="ajax/report_sell_year.php">รายงานการขายรายปี</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/delivery.png" width="16px" ></i>
						 <span >รายงานค่าใช้จ่าย</span>
					</a>
					<ul class="dropdown-menu">
						<!--<li><a class="ajax-link" href="ajax/report_buy_day.php">รายงานการซื้อรายวัน</a></li>-->
						<li><a class="ajax-link" href="ajax/report_buy_month.php">รายงานค่าใช้จ่ายรายเดือน</a></li>
						<li><a class="ajax-link" href="ajax/report_buy_year.php">รายงานค่าใช้จ่ายรายปี</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/progress-report.png" width="16px" ></i>
						 <span >รายงานผลกำไรขาดทุน</span>
					</a>
					<ul class="dropdown-menu">
						<!--<li><a class="ajax-link" href="ajax/report_buy_day.php">รายงานการซื้อรายวัน</a></li>-->
						<li><a class="ajax-link" href="ajax/report_profit_month.php">ผลกำไรขาดทุนรายเดือน</a></li>
						<li><a class="ajax-link" href="ajax/report_profit_year.php">ผลกำไรขาดทุนรายปี</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/qr-code.png" width="16px" ></i>
						 <span >จัดการคิวอาร์โค้ด</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/phpqrcode/">พิมพ์คิวอาร์โค้ด</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/users-silhouette.png" width="16px" ></i>
						 <span >จัดการข้อมูลผู้ใช้งาน</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/manage_customer.php">ดูข้อมูลผู้ใช้งาน</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i><img src="../images/icon/employee.png" width="16px" ></i>
						 <span >จัดการข้อมูลพนักงาน</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/employee_manage.php">ข้อมูลพนักงาน</a></li>
					</ul>
				</li>
<!--
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs">Charts</span>
					</a>
	
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/charts_xcharts.html">xCharts</a></li>
						<li><a class="ajax-link" href="ajax/charts_flot.html">Flot Charts</a></li>
						<li><a class="ajax-link" href="ajax/charts_google.html">Google Charts</a></li>
						<li><a class="ajax-link" href="ajax/charts_morris.html">Morris Charts</a></li>
						<li><a class="ajax-link" href="ajax/charts_amcharts.html">AmCharts</a></li>
						<li><a class="ajax-link" href="ajax/charts_chartist.html">Chartist</a></li>
						<li><a class="ajax-link" href="ajax/charts_coindesk.html">CoinDesk realtime</a></li>
					</ul>
				</li>
									
		

				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-table"></i>
						 <span >Tables</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/tables_simple.html">Simple Tables</a></li>
						<li><a class="ajax-link" href="ajax/tables_datatables.html">Data Tables</a></li>
						<li><a class="ajax-link" href="ajax/tables_beauty.html">Beauty Tables</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-pencil-square-o"></i>
						 <span class="hidden-xs">Forms</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/forms_elements.html">Elements</a></li>
						<li><a class="ajax-link" href="ajax/forms_layouts.html">Layouts</a></li>
						<li><a class="ajax-link" href="ajax/forms_file_uploader.html">File Uploader</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-desktop"></i>
						 <span class="hidden-xs">UI Elements</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/ui_grid.html">Grid</a></li>
						<li><a class="ajax-link" href="ajax/ui_buttons.html">Buttons</a></li>
						<li><a class="ajax-link" href="ajax/ui_progressbars.html">Progress Bars</a></li>
						<li><a class="ajax-link" href="ajax/ui_jquery-ui.html">Jquery UI</a></li>
						<li><a class="ajax-link" href="ajax/ui_icons.html">Icons</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-list"></i>
						 <span class="hidden-xs">Pages</span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="ajax/page_login.html">Login</a></li>
						<li><a href="ajax/page_register.html">Register</a></li>
						<li><a id="locked-screen" class="submenu" href="ajax/page_locked.html">Locked Screen</a></li>
						<li><a class="ajax-link" href="ajax/page_contacts.html">Contacts</a></li>
						<li><a class="ajax-link" href="ajax/page_feed.html">Feed</a></li>
						<li><a class="ajax-link add-full" href="ajax/page_messages.html">Messages</a></li>
						<li><a class="ajax-link" href="ajax/page_pricing.html">Pricing</a></li>
						<li><a class="ajax-link" href="ajax/page_product.html">Product</a></li>
						<li><a class="ajax-link" href="ajax/page_invoice.html">Invoice</a></li>
						<li><a class="ajax-link" href="ajax/page_search.html">Search Results</a></li>
						<li><a class="ajax-link" href="ajax/page_404.html">Error 404</a></li>
						<li><a href="ajax/page_500.html">Error 500</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-map-marker"></i>
						<span class="hidden-xs">Maps</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/maps.html">OpenStreetMap</a></li>
						<li><a class="ajax-link" href="ajax/map_fullscreen.html">Fullscreen map</a></li>
						<li><a class="ajax-link" href="ajax/map_leaflet.html">Leaflet</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-picture-o"></i>
						 <span class="hidden-xs">Gallery</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/gallery_simple.html">Simple Gallery</a></li>
						<li><a class="ajax-link" href="ajax/gallery_flickr.html">Flickr Gallery</a></li>
					</ul>
				</li>
				<li>
					 <a class="ajax-link" href="ajax/typography.html">
						 <i class="fa fa-font"></i>
						 <span class="hidden-xs">Typography</span>
					</a>
				</li>
				 <li>
					<a class="ajax-link" href="ajax/calendar.html">
						 <i class="fa fa-calendar"></i>
						 <span class="hidden-xs">Calendar</span>
					</a>
				 </li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-picture-o"></i>
						 <span class="hidden-xs">Multilevel menu</span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">First level menu</a></li>
						<li><a href="#">First level menu</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-plus-square"></i>
								<span class="hidden-xs">Second level menu group</span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Second level menu</a></li>
								<li><a href="#">Second level menu</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle">
										<i class="fa fa-plus-square"></i>
										<span class="hidden-xs">Three level menu group</span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="#">Three level menu</a></li>
										<li><a href="#">Three level menu</a></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle">
												<i class="fa fa-plus-square"></i>
												<span class="hidden-xs">Four level menu group</span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="#">Four level menu</a></li>
												<li><a href="#">Four level menu</a></li>
												<li class="dropdown">
													<a href="#" class="dropdown-toggle">
														<i class="fa fa-plus-square"></i>
														<span class="hidden-xs">Five level menu group</span>
													</a>
													<ul class="dropdown-menu">
														<li><a href="#">Five level menu</a></li>
														<li><a href="#">Five level menu</a></li>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle">
																<i class="fa fa-plus-square"></i>
																<span class="hidden-xs">Six level menu group</span>
															</a>
															<ul class="dropdown-menu">
																<li><a href="#">Six level menu</a></li>
																<li><a href="#">Six level menu</a></li>
															</ul>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										<li><a href="#">Three level menu</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
-->
			</ul>
		</div>
		<!--Start Content-->
		<div id="content" class="col-xs-12 col-sm-10">
			<div id="about">
				<div class="about-inner">
					<h4 class="page-header">Open-source admin theme for you</h4>
					<p>DevOOPS team</p>
					<p>Homepage - <a href="http://devoops.me" target="_blank">http://devoops.me</a></p>
					<p>Email - <a href="mailto:devoopsme@gmail.com">devoopsme@gmail.com</a></p>
					<p>Twitter - <a href="http://twitter.com/devoopsme" target="_blank">http://twitter.com/devoopsme</a></p>
					<p>Donate - BTC 123Ci1ZFK5V7gyLsyVU36yPNWSB5TDqKn3</p>
				</div>
			</div>
			<div class="preloader">
				<img src="img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
			</div>
			<div id="ajax-content"></div>

		</div>
		<!--End Content-->
	</div>
</div>
<!--End Container-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/justified-gallery/jquery.justifiedGallery.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="plugins/tinymce/jquery.tinymce.min.js"></script>
<!-- All functions for this theme + document.ready processing -->
<script src="js/devoops.js"></script>
<script src="../canvas/canvasjs.min.js"></script>
<?php
	}else{
		echo "<meta charset='utf-8'><script>alert('คุณไม่ได้รับสิทธื์ในการใช้งานระบบในส่วนนี้');window.location='../';</script>";
	}

?>

  <script type="text/javascript" src="js/codemirror.min.js"></script>
  <script type="text/javascript" src="js/xml.min.js"></script>
  <script type="text/javascript" src="js/froala_editor.min.js"></script>
  <script type="text/javascript" src="js/plugins/align.min.js"></script>
  <script type="text/javascript" src="js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="js/plugins/image.min.js"></script>
  <script type="text/javascript" src="js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="js/plugins/link.min.js"></script>
  <script type="text/javascript" src="js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="js/plugins/table.min.js"></script>
  <script type="text/javascript" src="js/plugins/video.min.js"></script>
  <script type="text/javascript" src="js/plugins/url.min.js"></script>
  <script type="text/javascript" src="js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="js/plugins/char_counter.min.js"></script>
  <script type="text/javascript" src="js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="js/plugins/save.min.js"></script>
  <script src="../sweetalert/sweetalert.min.js"></script> 
  <script>
    $(function(){
      $('#edit').froalaEditor({
         toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'emoticons', 'paragraphFormat', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink', 'insertImage', 'insertTable', 'insertFile', 'undo', 'redo', 'html'],

        enter: $.FroalaEditor.ENTER_P,
        height: 400
      })
    });
  </script>
</body>

</html>


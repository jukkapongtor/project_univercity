<?php
function list_webblog(){
	echo "<div class='container-fluid' style='padding:0px;'>";
		echo "<div class='header-webblog'>";
			echo "<b>ข่าวสาร & บทความ</b>";
		echo "</div>";
		echo "<div class='col-md-12 underline'  style='margin-bottom:20px;'>";
			echo "<div class='col-md-4'></div>";
			echo "<div class='col-md-4'>";
				switch ($_GET['webblog_menu']) {
					case '1': $webblog_menu1='menu-webblog-active';$webblog_menu2='';$webblog_menu3=''; break;
					case '2': $webblog_menu1='';$webblog_menu2='menu-webblog-active';$webblog_menu3='';break;
					case '3': $webblog_menu1='';$webblog_menu2='';$webblog_menu3='menu-webblog-active';break;
					default: $webblog_menu1='menu-webblog-active';$webblog_menu2='';$webblog_menu3=''; break;
				}
                echo "<a href='index.php?module=webblog&action=list_webblog&webblog_menu=1'><div class='col-md-5 menu-webblog $webblog_menu1'><center><b>แสดงทั้งหมด</center></div></a>";
                echo "<a href='index.php?module=webblog&action=list_webblog&webblog_menu=2'><div class='col-md-3 menu-webblog $webblog_menu2'><center>ข่าวสาร</center></div></a>";
                echo "<a href='index.php?module=webblog&action=list_webblog&webblog_menu=3'><div class='col-md-4 menu-webblog $webblog_menu3' ><center>บทความ</b></center></div></a>";
			echo "</div>";
			echo "<div class='col-md-4'></div>";
		echo "</div>";
		switch ($_GET['webblog_menu']) {
			case '1': $query_webblog = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webblog")or die("ERROR : webblog function line 23"); break;
			case '2': $query_webblog = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webblog WHERE type_blog='ข่าวสาร'")or die("ERROR : webblog function line 24"); break;
			case '3': $query_webblog = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webblog WHERE type_blog='บทความ'")or die("ERROR : webblog function line 25"); break;
		}
		while(list($id_clog,$title_blog,$featured_image,$review_detail,$detail,$rating_blog,$visitor,$type_blog,$blog_date)=mysqli_fetch_row($query_webblog)){
		echo "<div class='col-md-12' style='margin-bottom:20px;'>";
			echo "<div class='col-md-4'>";
				if(empty($featured_image)){
					echo "<div class='webbolg-none-image' >$title_blog</div>";
				}else{
					echo "<img src='images/webblog/$featured_image' width='100%' height='250px;'>";
				}
			echo "</div>";
			echo "<div class='col-md-8'>";
				echo "<div class='header-webblog-content'>";
					echo "<b>$title_blog</b>";
				echo "</div>";
				echo "<div class='content-webblog'>$review_detail</div>";
				echo "<div class='read-more'></div>";
			echo "</div>";	
		echo "</div>";
		}
		
	echo "</div>";
}
?>
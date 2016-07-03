<?php
session_start();
include("../../include/function.php");
connect_db();
switch ($_GET['data']) {
	case 'switch_onoff_buywebsite':
		mysqli_query($_SESSION['connect_db'],"UPDATE web_page SET sellproduct_status ='$_POST[switch_onoff_buywebsite]' WHERE web_page_id='1'"); 
	break;
	case 'switch_onoff_openweb':
		mysqli_query($_SESSION['connect_db'],"UPDATE web_page SET open_web ='$_POST[switch_onoff_openweb]' WHERE web_page_id='1'"); 
	break;
	default: break;
}

?>
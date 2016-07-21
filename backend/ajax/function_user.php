<?php
session_start();
include("../../include/function.php");
connect_db();
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'search':
		$_GET['page'] = (empty($_GET['page']))?1:$_GET['page'];
		echo "<script>window.location='../#ajax/manage_customer.php?keywd=$_GET[keywd]&page=$_GET[page]'</script>";
	break;
}
?>
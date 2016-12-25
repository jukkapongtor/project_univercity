<?php
session_start();
include("../../include/function.php");
connect_db();
?>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
date_default_timezone_set('Asia/Bangkok');
switch ($_GET['data']) {
	case 'read':
       mysqli_query($_SESSION['connect_db'],"UPDATE contactus SET visitor='0' WHERE contact_id='$_POST[contact_id]'")or die("ERROR : backend contant funtion line 17");
	break;
}
?>
</body>
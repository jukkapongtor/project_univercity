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
	case 'min_amount':
       echo "<script>window.location='../#ajax/min_amount.php'</script>";
	break;
  case 'contact_us':
       echo "<script>window.location='../#ajax/contact_us.php'</script>";
  break;
    
}
?>
</body>
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
	case 'delete_size':
       $query_size = mysqli_query($_SESSION['connect_db'],"SELECT size_name FROM size WHERE product_size='$_GET[size_id]'")or die("ERROR : backend function size line 16");
       list($size_name)=mysqli_fetch_row($query_size);
       $query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_name FROM product WHERE product_id='$_GET[product_id]'")or die("ERROR : backend function size line 16");
       list($product_name)=mysqli_fetch_row($query_product);
       mysqli_query($_SESSION['connect_db'],"DELETE FROM product_size WHERE size_id='$_GET[size_id]' AND product_id = '$_GET[product_id]'")or die("ERROR : backend function size line 19");
       echo "<script>swal({title:'',text: 'ลบขนาด$size_name ของ $product_name เรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/product_list.php';})</script>";
	break;
    
}
?>
</body>
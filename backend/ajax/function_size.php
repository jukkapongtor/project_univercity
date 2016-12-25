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
       mysqli_query($_SESSION['connect_db'],"DELETE FROM size WHERE product_size='$_GET[size_id]'")or die("ERROR : backend function size line 18");
       mysqli_query($_SESSION['connect_db'],"DELETE FROM product_size WHERE size_id='$_GET[size_id]'")or die("ERROR : backend function size line 19");
       echo "<script>swal({title:'',text: 'ลบรายการที่เกี่ยวข้องกับขนาด$size_name เรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
	break;
    case 'insert_size':
        if(!empty($_GET['new_size'])){
            $query_size = mysqli_query($_SESSION['connect_db'],"SELECT size_name FROM size WHERE type_id='$_GET[product_type]' AND size_name='$_GET[new_size]'")or die("ERROR : backend function size line 16");
            $row = mysqli_num_rows($query_size);
            //echo "SELECT size_name FROM size WHERE type_id='$_GET[product_type]' AND size_name='$_GET[new_size]'";
            if($row>0){
                echo "<script>swal({title:'',text: 'ขนาดสินค้านี้มีในประเภทสินค้าแล้ว กรุณาเพิ่มขนาดสินค้าชนิดอื่น',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
            }else{
                mysqli_query($_SESSION['connect_db'],"INSERT INTO size VALUES('','$_GET[new_size]','$_GET[product_type]')")or die("ERROR : backend function size line 31");
                echo "<script>swal({title:'',text: 'เพิ่มขนาด $_GET[new_size] ในประเภทสินค้าเรียบร้อยแล้ว',type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
            }
            
        }else{
             echo "<script>swal({title:'',text: 'กรุณากรอกขนาดสินค้าก่อนทำการเพิ่มขนาด',type:'error',showCancelButton: false,confirmButtonColor: '#f27474',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/type_manage.php';})</script>";
        }
    break;
}
?>
</body>
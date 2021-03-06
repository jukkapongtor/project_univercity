<?php
    session_start();
    echo "<meta charset='utf-8'>";
    date_default_timezone_set('Asia/Bangkok');
	include("../include/function.php");
    include("include/function.php");
	connect_db();
    include("module/product/product_function.php");
    include("module/cart/cart_function.php");
    include("module/orders/orders_function.php");
    include("module/employee/employee_function.php");
    $module=empty($_GET['module'])?"":$_GET['module'];
    $action=empty($_GET['action'])?"":$_GET['action'];
    
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MUMFERN SHOP</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="keywords" content="ขายเฟิร์น,ขายต้นไม้,เฟิร์น,ต้นไม้,ขายเฟิร์น จังหวัดเชียงใหม่,ขายเฟิร์น รับส่งทั่วประเทศ,ร้านขายเฟิร์น,มุมเฟิร์น ขายส่งเฟิร์น,ขายเฟิร์น ตลาดคำเที่ยง,ขายต้นไม้ ตลาดคำเที่ยง">
 <link rel="shortcut icon" href="../images/icon/logomumfern.png" />
 <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
 <link rel="stylesheet" type="text/css" href="../js/jquery-ui.css">
 <link rel="stylesheet" type="text/css" href="css/mystyle.css">
 <link rel="stylesheet" type="text/css" href="../sweetalert/sweetalert.css">
 <script src="../js/jquery-1.11.3.min.js"></script>
 <script src="../js/jquery-ui.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script src="../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<div class='container-fluid' style='paddig:0px;background:#eee;'>
<div class="col-md-2 hidden-xs"></div>
<div class="col-md-8 col-xs-12" style="background:#fff;padding:0px;">
<?php
    if(!empty($_SESSION['login_name'])&&($_SESSION['login_type']==2||$_SESSION['login_type']==1)){

    $quality_webpage = mysqli_query($_SESSION['connect_db'],"SELECT logo,nameshop FROM web_page WHERE web_page_id='1'")or die("ERROR : index line 260");
    list($logo,$nameshop)=mysqli_fetch_row($quality_webpage);
?>
    <div class='header-top'></div>
    <div class="header">
<?php
        echo "<img src='../images/icon/$logo' width='50px' height='50px' style='margin:5px'><b>$nameshop</b>";
?>
    </div>
    <div class="main">

<?php
        if(!empty($module)){
            get_module_shop($module,$action);
        }else{
?>
    <div class="container-fluid" style="padding:0px;">
    <div class='col-md-6' style="padding:0px;">
<?php
            echo "<div class='user'>";
                echo "<div class='user-image'>";
                    $query_user = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,lastname,image FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : index line 116");
                    list($username,$user_fullname,$user_lastname,$user_image)=mysqli_fetch_row($query_user);
                    if(empty($user_image)){
                        echo "<img src='../images/user/user.png' width='50' height='50' style='border-radius:50px;margin:5px;'>";
                    }else{
                        echo "<img src='../images/employee/$user_image' width='50' height='50' style='border-radius:50px;margin:5px'>";
                    }
                echo "</div>";
                echo "<div class='user-data'>";
                    echo "<b>ชื่อผู้ใช้งาน : </b>";
                    echo "$user_fullname $user_lastname<br>";
                    echo "<b>สถานะ : </b>";
                    $type_user = array(1=>"เจ้าของร้าน",2=>"พนักงาน",3=>"ผู้ใช้งานทั่วไป");
                    echo $type_user[$_SESSION['login_type']]."<br>";
                echo "</div>";
            echo "</div>";
        
?>
    </div>
    <div class='col-md-6'>
        <p align='right' style="margin-right:10px;margin-top:10px;">
<?php
            if($_SESSION['login_type']==1){
                echo "<a href='../backend/index.php?action=logout'><button class='btn btn-sm btn-primary' type='button'>ส่วนการจัดการ</button></a>&nbsp;";
            }
?>  
            <a href='../include/index.php?action=logout'><button class="btn btn-sm btn-danger" type='button'>ออกระบบ</button></a>
        </p>
    </div>
    </div>
        <hr>
        <div class="container-fluid" style='padding:0px'>
            <div class="col-xs-6 col-md-3 col-sm-3">
                <center>
                    <a href='index.php?module=product&action=list_product' style="text-decoration: none;"><div class="menu-images" >
                        <img src='../images/icon/clipboard.png' width="100" height="100" style="margin:6px;"> 
                    </div>
                    <p>รายการสินค้า</p></a>
                </center>
            </div>
            <div class="col-xs-6 col-md-3 col-sm-3">
                <center>
<?php
                if(!empty($_SESSION['total_amount'])){
                    echo "<p style='position:absolute;padding:5px;right:20;background:#133572;border-radius:20px;color:white;font-size:16px'><b>&nbsp;&nbsp;$_SESSION[total_amount]&nbsp;&nbsp;</b></p>";
                }
?>
                    <div class="menu-images" >
                        <a href='index.php?module=cart&action=show_cart' style="text-decoration: none;"><img src='../images/icon/cart.png' width="100" height="100" style="margin:6px;">
                    </div>
                    <p>ตะกร้าสินค้า</p></a> 
                </center>
            </div>
            <div class="col-xs-6 col-md-3 col-sm-3">
                <center>
                    <a href='index.php?module=orders&action=order_list' style="text-decoration: none;"><div class="menu-images">
                        <img src='../images/icon/cashbox.png' width="100" height="100" style="margin:6px;"> 
                    </div>
                    <p>รายการขายสินค้า</p></a>
                </center>
            </div>
<?php
        if($_SESSION['login_type']==2){
?>
            <div class="col-xs-6 col-md-3 col-sm-3">
                <center>
                    <a href='index.php?module=employee&action=show_worktime' style="text-decoration: none;"><div class="menu-images">
                        <img src='../images/icon/clock.png' width="100" height="100" style="margin:6px;"> 
                    </div>
                    <p>ดูเวลาทำงาน</p></a>
                </center>
            </div>
<?php  
        }
?>
<?php
        if($_SESSION['login_type']==2){
?>
            <div class="col-xs-6 col-md-3 col-sm-3">
                <center>
                    <a href='index.php?module=employee&action=show_salary' style="text-decoration: none;"><div class="menu-images" >
                        <img src='../images/icon/notes.png' width="100" height="100" style="margin:6px;"> 
                    </div>
                    <p>ดูเงินเดือน</p></a>
                </center>
            </div>
<?php  
        }
?>
        </div>
<?php
        }
?>
    <div class="col-md-12 hidden-xs" style="margin-bottom:10px;"><br><br><br><br><br><br><br><br><br></div>
    </div>
</div>
<div class="col-md-2"></div>

</div>
</body>
</html>
<?php
    }else{
?>
        <script>swal({title: 'ไม่สามารถใช้งานระบบ',text: 'คุณไม่ได้รับอณุญาติให้ใช้งานระบบ ระบบจะพาคุณกลับไปยังหน้าแรก',   type: 'warning', 
            showCancelButton: false,
            confirmButtonColor: '#ffb32f',
            confirmButtonText: 'ยันยัน',
            closeOnConfirm: false 
            }, 
            function(){ window.location='../' });
        </script>
<?php
    }
?>
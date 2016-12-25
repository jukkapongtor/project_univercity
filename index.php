<?php
    session_start();
	include("include/function.php");
    include("module/product/product_function.php");
    include("module/webboard/webboard_function.php");
    include("module/users/users_function.php");
    include("module/cart/cart_function.php");
    include("module/orders/orders_function.php");
    include("module/transfer/transfer_function.php");
    include("module/webblog/webblog_function.php");
    include("module/contact/contact_function.php");
	connect_db();
	$module=empty($_GET['module'])?"":$_GET['module'];
    $action=empty($_GET['action'])?"":$_GET['action'];
    date_default_timezone_set('Asia/Bangkok');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MUMFERN SHOP</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="keywords" content="ขายเฟิร์น,ขายต้นไม้,เฟิร์น,ต้นไม้,ขายเฟิร์น จังหวัดเชียงใหม่,ขายเฟิร์น รับส่งทั่วประเทศ,ร้านขายเฟิร์น,มุมเฟิร์น ขายส่งเฟิร์น,ขายเฟิร์น ตลาดคำเที่ยง,ขายต้นไม้ ตลาดคำเที่ยง">
 <link rel="shortcut icon" href="images/icon/logomumfern.png" />
 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="css/mystyle.css">
 <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
 <link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
 <link rel="stylesheet" type="text/css" href="sweetalert/sweetalert.css">
 <link href="plugins/chartist/chartist.min.css" rel="stylesheet">

<link rel="stylesheet" href="backend/css/froala_editor.css">
<link rel="stylesheet" href="backend/css/froala_style.css">
 <link rel="stylesheet" href="backend/css/plugins/code_view.css">
<link rel="stylesheet" href="backend/css/plugins/colors.css">
<link rel="stylesheet" href="backend/css/plugins/emoticons.css">
<link rel="stylesheet" href="backend/css/plugins/image_manager.css">
<link rel="stylesheet" href="backend/css/plugins/image.css">
<link rel="stylesheet" href="backend/css/plugins/line_breaker.css">
<link rel="stylesheet" href="backend/css/plugins/table.css">
<link rel="stylesheet" href="backend/css/plugins/char_counter.css">
<link rel="stylesheet" href="backend/css/plugins/video.css">
<link rel="stylesheet" href="backend/css/codemirror.min.css">
<link href="css/froala_style.min.css" rel="stylesheet" type="text/css" />

 <script src="js/jquery-1.11.3.min.js"></script>
 <script src="js/jquery-ui.js"></script>
 <script src="js/bootstrap.min.js"></script>
 <script src="sweetalert/sweetalert.min.js"></script> 
 <script>
    $(function(){
        $(".header-function-user").mouseenter(function(){
            $("#header-user").hide();
            $("#header-user-hover").show();
        });
        $(".header-function-user").mouseleave(function(){
            $("#header-user").show();
            $("#header-user-hover").hide();
        });
        $(".product-recommend-sale").click(function(){
            $(".product-recommend-sale").css({"background":"#248a32","border-bottom":"2px solid #1c5d25","color":"white" });
            $(".product-recommend-new").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recommend-best").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recom-sale-content").show();
            $(".product-recom-new-content").hide();
            $(".product-recom-best-content").hide();
        });
        $(".product-recommend-new").click(function(){
            $(".product-recommend-new").css({"background":"#248a32","border-bottom":"2px solid #1c5d25","color":"white" });
            $(".product-recommend-sale").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recommend-best").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recom-new-content").show();
            $(".product-recom-sale-content").hide();
            $(".product-recom-best-content").hide();
        });
        $(".product-recommend-best").click(function(){
            $(".product-recommend-best").css({"background":"#248a32","border-bottom":"2px solid #1c5d25","color":"white" });
            $(".product-recommend-new").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recommend-sale").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recom-best-content").show();
            $(".product-recom-new-content").hide();
            $(".product-recom-sale-content").hide();
        });
<?php
        if(!empty($_GET['menu'])){
            $query_cate = mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality WHERE quality_type='$_GET[menu]'")or die("ERROR : inedex line 60");
            $count_cate = mysqli_num_rows($query_cate);
            for($i=1;$i<=$count_cate;$i++){
                echo "$('.select-cate-product_$i').mouseenter(function(){";
                    echo "$('.select-cate-product_$i').css({'width':'100','height':'100','border':'solid 5px #42b752'});";
                echo "});";
                echo "$('.select-cate-product_$i').mouseleave(function(){";
                    echo "$('.select-cate-product_$i').css({'width':'100','height':'100','border':'0px'});";
                echo "});";
            }
        }
        

 ?> 

    });
    $(document).ready(function() {
        $('#select_provinces').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $(this).val()},
                url: 'module/index.php?data=provinces',
                success: function(data) {$('#select_districts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_provinces:"null",select_districts:"null"},
                url: 'module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_districts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $('#select_provinces').val(),select_districts: $(this).val()},
                url: 'module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_subdistricts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_districts: $(this).val()},
                url: 'module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
            $("#message_bold").click(function(){
                var message = document.getElementById('webboard_message').value;
                document.getElementById('webboard_message').value= message+"<b></b>";
            });

            $("#button-close-web").click(function(){
                $("#close-web").hide();
                $("#button-close-web").hide();
                $("#image-close-web").hide();
                $.post('module/index.php?data=close_web',{close_web:1},function(data){
                });
            });
        $(".contactuser-content1").click(function(){
            $(".contactuser-content1").hide();
            $(".contactuser").animate({"margin-bottom":"0px"},300);
            $(".contactuser-content2").show();
        }); 
         $(".contactuser-content2").click(function(){
            $(".contactuser-content2").hide();
            $(".contactuser").animate({"margin-bottom":"-285px"},300);
            $(".contactuser-content1").show();
        });    
        $(".cart_user_empty").click(function(){
            swal("", "ตะกร้าสินค้าสามารถใช้ได้เฉพาะสมาชิกเท่านั้น", "warning");
        });
    });
 </script>
</head>
<body>
<?php include_once("analyticstracking.php");

 ?>
<!-- Button trigger modal -->

<div class="display_com">
<?php
    $quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT * FROM web_page WHERE web_page_id='1'")or die("ERROR : index line 260");
    list($web_page_id,$logo,$nameshop,$header_detail_shop,$detail_shop,$image_content2,$header_content2,$content2,$image_content3,$header_content3,$content3,$sellproduct_status,$open_web)=mysqli_fetch_row($quality_sellstatus);
    if($open_web==1){
        if(empty($_SESSION['web_close'])){
            echo "<div id='close-web'></div>";
        }      
    }
?>
    <div class='header-top'></div>
    <div class="header">
        <a href='index.php' style='text-decoration: none;'><div class="header-logo hidden-xs">
<?php
            echo "<div class='header-logo-img'><img src='images/icon/$logo' width='100%' height='100%'></div>";
            echo "<font color='#1c5d25' size='4'><p style='margin-top:20px;' class='hidden-xs'><b>$nameshop</b></p></font>";
?>
        </div></a>
        <div class="header-menu">
<?php
            switch ($module) {
                case 'product': $active_menu1="";$active_menu2="header-menu-active";$active_menu3="";$active_menu4=""; break;
                case 'webblog': $active_menu1="";$active_menu2="";$active_menu3="header-menu-active";$active_menu4=""; break;
                case 'webboard': $active_menu1="";$active_menu2="";$active_menu3="";$active_menu4="header-menu-active"; break;
                default: $active_menu1="header-menu-active";$active_menu2="";$active_menu3="";$active_menu4=""; break;
            }

            echo "<a href='index.php'><div class='header-menu-home $active_menu1'><center>หน้าหลัก</center></div></a>";
            echo "<a href='index.php?module=product&action=list_product&menu=1&cate=1'><div class='header-menu-product $active_menu2'><center><div class='hidden-xs'>รายการสินค้า</div><div class='hidden-md hidden-sm hidden-lg'>รายการ</div></center></div></a>";
            echo "<a href='index.php?module=webblog&action=list_webblog&webblog_menu=1'><div class='header-menu-webblog $active_menu3'><center>ข่าวสาร</center></div></a>";
            echo "<a href='index.php?module=webboard&action=webboard'><div class='header-menu-webboard $active_menu4'><center>เว็บบอร์ด </center></div></a>";
?>
        </div>
        <div class="header-function">
<?php
        $quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : index line 260");
        list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
        if($sellstatus==1){
        if((!empty($_SESSION['login_name'])&&$_SESSION['login_type']==3)||empty($_SESSION['login_name'])){
            if(!empty($_SESSION['login_name'])){
                echo "<a href='index.php?module=users&action=data_users&menu=2'><div class='header-function-cart'>";
            }else{
                echo "<a style='cursor:pointer'><div class='header-function-cart cart_user_empty'>";
            }
                $_SESSION['total_amount'] = (empty($_SESSION['total_amount']))?"0":$_SESSION['total_amount'];
                $hidden = (empty($_SESSION['total_amount']))?"display:none":"";
                echo "<b><p id='total_amountincart' style='$hidden'>$_SESSION[total_amount]</p></b>";
?>
                <img src="images/icon/cart-of-ecommerce.png" class="img_cart">
            </div></a>
<?php
        }
        }
            

            if(empty($_SESSION['login_name'])){
                echo "<div class='header-function-user'>";
                    echo "<a href='include/'><img src='images/user/user.png' id='header-user' class='img_user'>";
                    echo "<img src='images/user/user-hover.png' id='header-user-hover' class='img_user' style='display:none'></a>";
                echo "</div>";
            }else{
                $query_user = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,lastname,image FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : index line 116");
                list($username,$user_fullname,$user_lastname,$user_image)=mysqli_fetch_row($query_user);
                echo "<div class='header-function-user' style='width:auto;padding:5px;'>";
                    echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>";
                    if(empty($user_image)){
                        echo "<img src='images/user/user.png'   class='img_user_login' style='float:left;border-radius:50px;'>";
                    }else{
                        echo "<img src='images/user/$user_image'   class='img_user_login' style='float:left;border-radius:50px;'>";
                    }
                    
                    echo "</a><ul class='dropdown-menu dropdown-menu-right' style='cursor:default'>";
                        echo "<li><p style='margin-left:10px;'><b>ชื่อผู้ใช้งาน :</b> $username</p></li>";
                        echo "<li><div>
                        <div style='float:left'>";
                        if(empty($user_image)){
                            echo "<a href='index.php?module=users&action=data_users' style='text-decoration: none;'><img src='images/user/user.png'   width='70' height='70' style='margin-left:10px;'></a>";
                        }else{
                            echo "<a href='index.php?module=users&action=data_users' style='text-decoration: none;'><img src='images/user/$user_image'   width='70' height='70' style='margin-left:10px;'></a>";
                        }
                        echo "</div>
                        <div style='float:left'>";
                        if(!empty($user_fullname)&&!empty($user_lastname)){
                            echo "<p style='margin-right:10px;'>&nbsp;$user_fullname $user_lastname</p>";
                        }
                    if($_SESSION['login_type']==1){
                        echo "<a href='backend/' style='text-decoration: none;'><p style='margin-top:-10px;margin-right:10px;'>&nbsp;จัดการข้อมูลหลังร้าน</p></a>";
                    }
                    if($_SESSION['login_type']==2){
                        echo "<a href='shop/' style='text-decoration: none;'><p style='margin-top:-10px;margin-right:10px;'>&nbsp;ขายสินค้าในร้าน</p></a>";
                    }
                    if($_SESSION['login_type']==3){
                        echo "<a href='index.php?module=users&action=data_users&menu=1' style='text-decoration: none;'><p style='margin-top:-5px;margin-right:10px;'>&nbsp;ข้อมูลส่วนตัว</p></a>";
                        echo "<a href='index.php?module=users&action=data_users&menu=3&order_status=1' style='text-decoration: none;'><p style='margin-top:-5px;margin-right:10px;'>&nbsp;สถานะการซื้อสินค้า</p></a>";
                        echo "<a href='index.php?module=users&action=data_users&menu=4' style='text-decoration: none;'><p style='margin-top:-5px;margin-right:10px;'>&nbsp;ประวัติการซื้อสินค้า</p></a>";
                    }
                        echo "</div>
                        </div><br class='clear'></li>";
                        echo "<li role='separator' class='divider'></li>";
                        echo "<li><p align='right' style='margin-right:10px;'><a href='include/index.php?action=logout'><button class='btn btn-sm btn-warning'><font size='2'>ออกจากระบบ</font></button></a></p></li>";
                    echo "</ul>";
                echo "</div>";
            }
                

            

?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="container-fluid content_allwebsite"> 
    
        <div class="col-md-2 col-xs-0"></div>
        <div class="col-md-8 col-xs-12 content_website">
<?php
        if($open_web==1){
            if(empty($_SESSION['web_close'])){   
                echo "<div id='button-close-web'><img src='images/icon/close.png' width='19' height='19'></div>";
                echo "<img src ='images/background/close-web.png' id='image-close-web'>";
            }
        }
        if(!empty($module)){
            get_module($module,$action);
        }else{
?>
            <div id="carousel-example-generic" class="carousel slide " data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators" style="z-index:1">
<?php
                $query_slide=mysqli_query($_SESSION['connect_db'],"SELECT * FROM slide ")or die("ERROR : backend slide line 29");;
                $row=mysqli_num_rows($query_slide);
                for($i=0;$i<$row;$i++){
                    $active = ($i==0)?"class='active'":"";
                    echo "<li data-target='#carousel-example-generic' data-slide-to='$i' $active></li>";
                }
?>
              </ol>
              <!-- Wrapper for slides -->
              <div class="carousel-inner home-slide" role="listbox">
<?php
                $number=0;
                while(list($slide_id,$slide_image,$header_slide,$slide_detail)=mysqli_fetch_row($query_slide)){
                    $active= ($number==0)?"active":"";
                    echo "<div class='item $active home-slide'>";
                      $header_slide = (!empty($header_slide))?$header_slide:"";
                      $path =(empty($slide_image))?"icon/no-images.jpg":"slide/$slide_image";
                      echo "<img src='images/$path' style='width:100%;height:100%' alt='...'>";
                      echo "<div class='carousel-caption'>";
                        echo "<h4 style='font-size:36px;'>$header_slide</h4><p>$slide_detail</p>";
                      echo "</div>";
                    echo "</div>";
                    $number++;
                }
?>
              </div>

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
            <br>
<?php           
            echo "<center><h3><b>$nameshop</b></h3></center>";
            echo "<center><h4 style='margin-top:10px'><b>$header_detail_shop</b></h4></center>";
            echo "<div width='100%' class='font-content'  style='padding:0px 30px;'><p><center>$detail_shop</center></p></div>";
            echo "<br>";
            echo "<div class='clear'></div>";

            $quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 64");
            list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
            
?>            
            <div class="product-recommend">
<?php
            if($sellstatus==1){
?>
                <div class='product-recommend-center'></div>
                <div class="product-recommend-new"><center>สินค้ามาใหม่</center></div>
                <div class="product-recommend-sale"><center>สินค้าลดราคา</center></div>
                <div class="product-recommend-best"><center>สินค้าขายดี</center></div>
                <div class='product-recommend-center'></div>
<?php
            }else{
                echo "<font size='5'><b>&nbsp;รายการสินค้ามาใหม่</b></font>";
            }
?>
            </div>

            <div class="product-recom-new-content">
<?php
            $query_recom_new =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type ORDER BY product.product_id DESC LIMIT 0,6 ");
            while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_new)){
                echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><div class='col-md-4 col-xs-4' style='padding-top:10px;'>";
                    echo "<div class='div-recom'>";
                        $str=explode(" ",$product_name,2);
                        echo "<b><p align='center' class='div-recom-content'>$str[0]</p></b>";
                    echo "</div>";
                $query_image= mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
                list($product_image)=mysqli_fetch_row($query_image);
                $path= (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
                    echo "<img src='images/icon/new.png' class='img_product_recom' style='position: absolute;z-index:2'><img src='images/$path' class='img_product_recom' style='position: relative;'><br>";
                echo "</div></a>";
            }
?>
            </div>
<?php
            if($sellstatus==1){

?>
            <div class="product-recom-sale-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type LEFT JOIN product_size ON product.product_id = product_size.product_id WHERE product_size.product_sprice_web !=0 GROUP BY product_name ORDER BY RAND() LIMIT 6");
            while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_sale)){
                echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><div class='col-md-4 col-xs-4' style='padding-top:10px;'>";
                    echo "<div class='div-recom'>";
                        $str=explode(" ",$product_name,2);
                        echo "<b><p align='center' class='div-recom-content'>$str[0]</p></b>";
                    echo "</div>";
                $query_image= mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
                list($product_image)=mysqli_fetch_row($query_image);
                $path= (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
                    echo "<img src='images/icon/sale.png' class='img_product_recom' style='position: absolute;z-index:2'><img src='images/$path' class='img_product_recom' style='position: relative;'><br>";
                echo "</div></a>";
            }
?>
            </div>

<?php
            }
?>
            <div class="product-recom-best-content">
<?php
            $query_recom_best =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng,order_detail.product_id FROM product LEFT JOIN type ON product.product_type =type.product_type LEFT JOIN order_detail ON order_detail.product_id = product.product_id GROUP BY  order_detail.product_id ORDER BY COUNT(order_detail.product_id) DESC  LIMIT 0,6 ");
            while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_best)){
                echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><div class='col-md-4 col-xs-4' style='padding-top:10px;'>";
                    echo "<div class='div-recom'>";
                        $str=explode(" ",$product_name,2);
                        echo "<b><p align='center' class='div-recom-content'>$str[0]</p></b>";
                    echo "</div>";
                $query_image= mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
                list($product_image)=mysqli_fetch_row($query_image);
                $path= (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
                    echo "<img src='images/icon/best seller.png' class='img_product_recom' style='position: absolute;z-index:2'><img src='images/$path' class='img_product_recom' style='position: relative;'><br>";
                echo "</div></a>";
            }
?>
            </div>
            
            <div class="container-fluid padding0">
                <div class="col-md-12 padding0" style="margin-top:20px;">
                    <font size='5'><b>&nbsp;ข่าวสาร</b></font>
                    <div  class="container-fluid padding0" style="border-bottom:solid 2px #ddd"></div>
                    <div class="container-fluid">
                    <table class="table table-hover" style="margin-top:5px;">
                        <thead>
                            <tr>
                                <th><center>รายการข่าวสาร</center></th>
                                <th><center>วันที่</center></th>
                            </tr>
                        </thead>
                        <tbody>
<?php
                        $query_webblog = mysqli_query($_SESSION['connect_db'],"SELECT id_blog,title_blog,blog_date FROM webblog ORDER BY blog_date DESC LIMIT 0,4")or die("ERROR index line 444");
                        $line_table = 0;
                        while(list($id_blog,$title_blog,$blog_date)=mysqli_fetch_row($query_webblog)){
                            $line_success = (($line_table%2)==0)?"class='success'":"";
                            echo "<tr $line_success>";
                                echo "<td class='col-md-10'><a href='index.php?module=webblog&action=webblog_detail&webblog_id=$id_blog'><p>$title_blog</p></td>";
                                $blog_date = substr($blog_date,0,10);
                                echo "<td class='col-md-2'><p align='center'>$blog_date</p></td>";
                            echo "</tr>";
                            $line_table++;
                        }
?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <div class="container-fluid padding0">
                <div class="col-md-12 padding0" style="margin-top:20px;">
                    <font size='5'><b>&nbsp;เว็บบอร์ด</b></font>
                    <div  class="container-fluid padding0" style="border-bottom:solid 2px #ddd"></div>
<?php
        echo "<div class='container-fluid' style='margin-top:5px;'>";
          echo "<!-- Nav tabs -->";
          echo "<ul class='nav nav-tabs' role='tablist'>";
            echo "<li role='presentation' class='active font20'><a href='#webboard_recommend' aria-controls='webboard_recommend' role='tab' data-toggle='tab'>กระทู้แนะนำ</a></li>";
            echo "<li role='presentation'><a href='#webboard_interesting' class='font20' aria-controls='webboard_interesting' role='tab' data-toggle='tab'>กระทู้ที่น่าสนใจ</a></li>";
          echo "</ul>";
          echo "<!-- Tab panes -->";
          echo "<div class='tab-content'>";
            echo "<div role='tabpanel' class='tab-pane active' id='webboard_recommend'>";
                $number=1;
                $query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT webboard.* FROM webboard LEFT JOIN like_status ON webboard_id = like_name_id WHERE like_status.like_name='webboard' GROUP BY webboard.webboard_id ORDER BY COUNT(like_status.like_id),like_status.like_id DESC LIMIT 0,3")or die("ERROR : webboard function line 32");
                $row = mysqli_num_rows($query_webboard);
                if($row>0){
                echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
                    echo "<thead>";
                    echo "<tr>
                        <th><center>ชื่อกระทู้</center></th>
                        <th class='hidden-xs'><center>ผู้โพสต์</center></th>
                        <th class='hidden-xs'><center>เข้าชม</center></th>
                        <th class='hidden-xs'><center>ตอบ</center></th>
                        <th><center>วันที่โพสต์</center></th>
                    </tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    
                        while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
                            $query_subwebboard = mysqli_query($_SESSION['connect_db'],"SELECT subwebboard_id FROM subwebboard WHERE webboard_id='$webboard_id'")or die("ERROR : webboard line 37");
                            $cnt_subwebboard = mysqli_num_rows($query_subwebboard);
                            $webboard_date = substr($webboard_date, 0,10);
                            echo "<tr>
                                <td class='col-md-6'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
                                <td class='col-md-2 hidden-xs'><p align='center' class='font20'>$username</p></td>
                                <td class='col-md-1 hidden-xs'><p align='center' class='font20'>$visitor</p></td>
                                <td class='col-md-1 hidden-xs'><p align='center' class='font20'>$cnt_subwebboard</p></td>
                                <td class='col-md-2'><p align='center' class='font20'>$webboard_date</p></td>
                            </tr>";
                            $number++;
                        }
                    
                echo "</tbody></table>";
                }else{
                    echo "<h4 align='center' style='margin-top:40px;'><b>ขออภัย!!! ยังไม่มีการเพิ่มกระทู้</b></h4>";
                }
            echo "</div>";
            echo "<div role='tabpanel' class='tab-pane' id='webboard_interesting'>";
                $number=1;
                $query_webboard = mysqli_query($_SESSION['connect_db'],"SELECT * FROM webboard ORDER BY visitor DESC LIMIT 0,3")or die("ERROR : webboard function line 34");
                $row = mysqli_num_rows($query_webboard);
                if($row>0){
                echo "<table class='table table-hover table-striped' style='margin-top:10px;'>";
                    echo "<thead>";
                    echo "<tr>
                        <th><center>ชื่อกระทู้</center></th>
                        <th class='hidden-xs'><center>ผู้โพสต์</center></th>
                        <th class='hidden-xs'><center>เข้าชม</center></th>
                        <th class='hidden-xs'><center>ตอบ</center></th>
                        <th><center>วันที่โพสต์</center></th>
                    </tr>";
                    echo "</thead>";
                    echo "<tbody>";
                   
                    while(list($webboard_id,$webboard_header,$webboard_detail,$username,$webboard_date,$visitor)=mysqli_fetch_row($query_webboard)){
                        $query_subwebboard = mysqli_query($_SESSION['connect_db'],"SELECT subwebboard_id FROM subwebboard WHERE webboard_id='$webboard_id'")or die("ERROR : webboard line 37");
                        $cnt_subwebboard = mysqli_num_rows($query_subwebboard);
                        $webboard_date = substr($webboard_date, 0,10);
                        echo "<tr>
                            <td class='col-md-6'><p class='font20'><a href='index.php?module=webboard&action=webboard_detail&webboard_id=$webboard_id' style='text-decoration: none;'>$webboard_header</a></p></td>
                            <td class='col-md-2 hidden-xs'><p align='center' class='font20'>$username</p></td>
                            <td class='col-md-1 hidden-xs'><p align='center' class='font20'>$visitor</p></td>
                            <td class='col-md-1 hidden-xs'><p align='center' class='font20'>$cnt_subwebboard</p></td>
                            <td class='col-md-2'><p align='center' class='font20'>$webboard_date</p></td>
                        </tr>";
                        $number++;
                    }
                echo "</tbody></table>";
                }else{
                    echo "<h4 align='center' style='margin-top:40px;'><b>ขออภัย!!! ยังไม่มีการเพิ่มกระทู้</b></h4>";
                }
            echo "</div>";
          echo "</div>";
        echo "</div>";
?>
                </div>
            </div>

            <div class="container-fluid" style="margin:10px;">
            <div class="col-md-12 con1" style="padding-top:10px;margin-top:20px;">
                <div class="col-md-6 col-xs-5" style="margin-top:10px;">
<?php
                    echo "<img src='images/webpage/$image_content2' class='img_show_content'>";
?>
                    
                </div>
                <div class="col-md-6 col-xs-7">
<?php
                    echo "<p class='content1'><b>$header_content2</b></p>";
                    echo "<p class='content1'>$content2</p>";
?>
                </div>
            </div>
            
            <div class="col-md-12 con2" style="margin-top:20px;">
                <div class="col-md-6 col-xs-7">
<?php
                    echo "<p class='content2'><b>$header_content3</b></p>";
                    echo "<p class='content2'>$content3</p>";
?>
                </div>
                <div class="col-md-6 col-xs-5">
<?php
                    echo "<img align='right' src='images/webpage/$image_content3' class='img_show_content'>";
?>
                </div>
            </div>
            </div>

<?php
        }
?>      
        </div>
        <div class="col-md-2 col-xs-0"></div>
    </div>
    <div class="footer" >
        <div class="container-fluid">
                <p style='color:white;margin-top:5px;'><b>ที่อยู่ร้านมุมเฟิร์น</b></p>
                <p style='color:white'>ตลากคำเที่ยง ล็อค f208-f209 ตำบล ป่าตัน อำเภอเมือง จังหวัดเชียงใหม่ 50300</p>
                <p style='color:white'>เบอร์โทร : 081-8055024 &nbsp;&nbsp;E-mail : veerada@mumfern.com</p>
        </div>
    </div>
<?php
    if(empty($_SESSION['login_type'])||($_SESSION['login_type']!=1&&$_SESSION['login_type']!=2)){
        if(!empty($_SESSION['login_type'])){  
            $query_user = mysqli_query($_SESSION['connect_db'],"SELECT email FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR index line 476");
            list($email)=mysqli_fetch_row($query_user);

        }
        $username = (empty($_SESSION['login_name']))?"":$_SESSION['login_name'];
        $email =(empty($email))?"":$email;
        $disabled = (empty($_SESSION['login_name']))?"":"disabled";
?>
    <div class="contactuser">
        <center><h4 class="contactuser-content1"><b>ติดต่อเจ้าของร้าน</b></h4><h4 class="contactuser-content2"><b>ติดต่อเจ้าของร้าน</b></h4></center>
        <div class='container-fluid'>
            <form action="index.php?module=contact&action=insert_contact" method="post">
                <p><input type='text' class='form-control input-sm' name='username' value="<?php echo "$username";?>"  placeholder="Username...." <?php echo "$disabled";?>  required></p>
                <p><input type='text' class='form-control input-sm' name='email' value="<?php echo "$email";?>" placeholder="E-mail...." <?php echo "$disabled";?>  required></p>
                <p><textarea class='form-control ' style='height:120px' name='message' placeholder="Message...."></textarea></p>
                <p align="right"><button class="btn btn-sm btn-warning">Send</button></p>
            </form>
        </div>
    </div>
<?php
    }
?>
</div>
<div class="display_mobile">
    
</div>

</body>
</html>
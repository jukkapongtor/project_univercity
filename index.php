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
 <meta name="keywords" content="ขายเฟิร์น,ขายต้นไม้,เฟิร์น,ต้นไม้,ขายเฟิร์น จังหวัดเชียงใหม่,ขายเฟิร์น รับส่งทั่วประเทศ,ร้านขายเฟิร์น,มุมเฟิร์น ขายส่งเฟิร์น,ขายเฟิร์น ตลาดคำเที่ยง,ขายต้นไม้ ตลาดคำเที่ยง"
 <link rel="shortcut icon" href="images/icon/logomumfern.png" />
 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="css/mystyle.css">
 <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
 <link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
 <link rel="stylesheet" type="text/css" href="sweetalert/sweetalert.css">
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
            $(".product-recommend-sale").css({"background":"#248a32","border-bottom":"1px solid #1c5d25","color":"white" });
            $(".product-recommend-new").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recommend-best").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recom-sale-content").show();
            $(".product-recom-new-content").hide();
            $(".product-recom-best-content").hide();
        });
        $(".product-recommend-new").click(function(){
            $(".product-recommend-new").css({"background":"#248a32","border-bottom":"1px solid #1c5d25","color":"white" });
            $(".product-recommend-sale").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recommend-best").css({"background":"white","border-bottom":"0px","color":"#1c5d25" });
            $(".product-recom-new-content").show();
            $(".product-recom-sale-content").hide();
            $(".product-recom-best-content").hide();
        });
        $(".product-recommend-best").click(function(){
            $(".product-recommend-best").css({"background":"#248a32","border-bottom":"1px solid #1c5d25","color":"white" });
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

    });
 </script>
<?php

?>

 
 
</head>
<body>
<?php include_once("analyticstracking.php") ?>
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
        if(!empty($_SESSION['login_name'])&&$_SESSION['login_type']==3){
            echo "<a href='index.php?module=users&action=data_users&menu=2'><div class='header-function-cart'>";
        }else{
            echo "<a href='' ><div class='header-function-cart'>";
        }
                $_SESSION['total_amount'] = (empty($_SESSION['total_amount']))?"0":$_SESSION['total_amount'];
                $hidden = (empty($_SESSION['total_amount']))?"display:none":"";
                echo "<b><p id='total_amountincart' style='$hidden'>$_SESSION[total_amount]</p></b>";
?>
                <img src="images/icon/cart-of-ecommerce.png" class="img_cart">
            </div></a>
<?php
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
                        echo "<a href='backend/' style='text-decoration: none;'><p style='margin-top:-10px;font-size:21px;margin-right:10px;'>&nbsp;จัดการข้อมูลหลังร้าน</p></a>";
                    }
                    if($_SESSION['login_type']==2){
                        echo "<a href='shop/' style='text-decoration: none;'><p style='margin-top:-10px;font-size:21px;margin-right:10px;'>&nbsp;ขายสินค้าในร้าน</p></a>";
                    }
                    if($_SESSION['login_type']==3){
                        echo "<a href='index.php?module=users&action=data_users&menu=1' style='text-decoration: none;'><p style='margin-top:-10px;margin-right:10px;'>&nbsp;ข้อมูลผู้ใช้งาน</p></a>";
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
            if($sellstatus==1){
?>            
            <div class="product-recommend">
                <div class='product-recommend-center'></div>
                <!--<div class="product-recommend-sale"><center>สินค้าลดราคา</center></div>-->
                <div class="product-recommend-new"><center>สินค้ามาใหม่</center></div>
                <div class="product-recommend-best"><center>สินค้าขายดี</center></div>
                <div class='product-recommend-center'></div>
            </div>
<?php
            }
/*
?>
            <div class="product-recom-sale-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type LIMIT 0,6 ");
            while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_sale)){
                echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><div class='col-md-4 col-xs-6' style='padding-top:10px;'>";
                    echo "<div class='div-recom'>";
                        $str=explode(" ",$product_name,2);
                        echo "<b><p align='center' class='div-recom-content'>$str[0]</p></b>";
                    echo "</div>";
                $query_image= mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
                list($product_image)=mysqli_fetch_row($query_image);
                $path= (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
                    echo "<img src='images/$path' class='img_product_recom'><br>";
                echo "</div></a>";
            }
?>
            </div>
*/
?>
            <div class="product-recom-new-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type LIMIT 6,6 ");
            while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_sale)){
                echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><div class='col-md-4 col-xs-6' style='padding-top:10px;'>";
                    echo "<div class='div-recom'>";
                        $str=explode(" ",$product_name,2);
                        echo "<b><p align='center' class='div-recom-content'>$str[0]</p></b>";
                    echo "</div>";
                $query_image= mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
                list($product_image)=mysqli_fetch_row($query_image);
                $path= (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
                    echo "<img src='images/$path' class='img_product_recom'><br>";
                echo "</div></a>";
            }
?>
            </div>
            <div class="product-recom-best-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type =type.product_type LIMIT 12,6 ");
            while(list($product_id,$product_name,$type_name_eng)=mysqli_fetch_row($query_recom_sale)){
                echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><div class='col-md-4 col-xs-6' style='padding-top:10px;'>";
                    echo "<div class='div-recom'>";
                        $str=explode(" ",$product_name,2);
                        echo "<b><p align='center' class='div-recom-content'>$str[0]</p></b>";
                    echo "</div>";
                $query_image= mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
                list($product_image)=mysqli_fetch_row($query_image);
                $path= (empty($product_image))?"icon/no-images.jpg":"$type_name_eng/$product_image";
                    echo "<img src='images/$path' class='img_product_recom'><br>";
                echo "</div></a>";
            }
?>
            </div>
            <div class="container-fluid" style="margin:10px;"></div>
            <div class="col-md-12 con1" >
                <div class="col-md-6 col-xs-5">
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
            
            <div class="col-md-12 con2" style="margin:10px;">
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
                <p><input type='text' class='form-control input-sm' name='username' value="<?php echo "$username";?>"  placeholder="Username...." <?php echo "$disabled";?>></p>
                <p><input type='text' class='form-control input-sm' name='email' value="<?php echo "$email";?>" placeholder="E-mail...." <?php echo "$disabled";?>></p>
                <p><textarea class='form-control' style='height:120px' name='message' placeholder="Message...."></textarea></p>
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
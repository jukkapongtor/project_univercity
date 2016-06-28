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
	connect_db();
	$module=empty($_GET['module'])?"":$_GET['module'];
    $action=empty($_GET['action'])?"":$_GET['action'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MUMFERN SHOP</title>
 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="css/mystyle.css">
 <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
 <link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
 <script src="js/jquery-1.11.3.min.js"></script>
 <script src="js/jquery-ui.js"></script>
 <script src="js/bootstrap.min.js"></script>
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
                    echo "$('.select-cate-product_$i').css({'width':'95','height':'95','border':'solid 5px #42b752'});";
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

        $('#push_indetail').click(function() {
            var product_indetail = document.getElementById('product_amountindetail').value;
            product_indetail++;
            document.getElementById('product_amountindetail').value=product_indetail;
        });
        $('#lower_indetail').click(function() {
            var product_indetail = document.getElementById('product_amountindetail').value;
            if(product_indetail>1){
                product_indetail--;
                document.getElementById('product_amountindetail').value=product_indetail;
            }
            
        });
<?php
        
        echo "$('#add2cart').click(function() {";
            if(empty($_SESSION['login_name'])){
                echo "alert('การซื้อสินค้าทำได้เฉพาะสมาชิกเท่านั้น');";
            }else{
                echo "stop=0;";
                echo "var product_id = document.getElementById('product_id').value;";
                if(!empty($_SESSION['cart_id'])){
                    foreach ($_SESSION['cart_id'] as $key => $value) {
                        echo "if('$key'==product_id){";
                            echo "alert('สินค้าชิ้นนี้ถูกเพิ่มในตะกร้าสินค้าเรียบร้อยแล้ว');";
                            echo "stop=1;";
                        echo "}";
                    }
                }
                echo "if(stop==0){";
                echo "var product_indetail = parseInt(document.getElementById('product_amountindetail').value);";
                echo "var amount_incart = parseInt(document.getElementById('total_amountincart').innerHTML);";
                echo "if(isNaN(amount_incart)){";
                   echo " amount_incart =0;";
                echo "}";
                echo "total = product_indetail +amount_incart;";
                echo "$('#total_amountincart').show();";
                echo "document.getElementById('total_amountincart').innerHTML =total;";
                echo "$.post('module/index.php?data=addproduct_cart',{product_id:product_id,amount:product_indetail},function(data){";
                echo "});";
                echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:total},function(data){";
                echo "});";
                echo "alert('เพิ่มสินค้าลงในตะกร้าแล้ว');";
                echo "window.location='index.php?module=product&action=product_detail&product_id="."'+product_id+'"."';";
                echo "}";
            }
        echo "});";
        if(!empty($_SESSION['cart_id'])){
            foreach ($_SESSION['cart_id'] as $key => $value) {
                $query_price_product = mysqli_query($_SESSION['connect_db'],"SELECT product_price_web FROM product WHERE product_id='$key'")or die("ERROR index line 174");
                list($product_price_web)=mysqli_fetch_row($query_price_product);
                echo "$('#push_incart_$key').click(function() {";
                    echo "var product_incart = document.getElementById('product_amountincart_$key').value;";
                    echo "var total_incart = parseInt(document.getElementById('total_incart').innerHTML);";
                    echo "var amount_incart = parseInt(document.getElementById('total_amountincart').innerHTML);";
                    echo "product_incart++;";
                    echo "document.getElementById('product_amountincart_$key').value=product_incart;";
                    echo "var sum = product_incart * $product_price_web;";
                    echo "var total = $product_price_web + total_incart;";
                    echo "amount_incart++;";
                    echo "document.getElementById('sum_incart_$key').innerHTML =sum;";
                    echo "document.getElementById('total_incart').innerHTML =total;";
                    echo "document.getElementById('total_amountincart').innerHTML=amount_incart;";
                    echo "$.post('module/index.php?data=addproduct_cart',{product_id:'$key',amount:product_incart},function(data){";
                    echo "});";
                    echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:amount_incart},function(data){";
                    echo "});";
                echo "});";
                echo "$('#lower_incart_$key').click(function() {";
                    echo "var product_incart = document.getElementById('product_amountincart_$key').value;";
                    echo "var total_incart = parseInt(document.getElementById('total_incart').innerHTML);";
                    echo "var amount_incart = parseInt(document.getElementById('total_amountincart').innerHTML);";
                    echo "if(product_incart>0){";
                        echo "product_incart--;";
                        echo "document.getElementById('product_amountincart_$key').value=product_incart;";
                        echo "var sum = product_incart * $product_price_web;";
                        echo "var total = total_incart - $product_price_web ;";
                        echo "amount_incart--;";
                        echo "document.getElementById('sum_incart_$key').innerHTML =sum;";
                        echo "document.getElementById('total_incart').innerHTML =total;";
                        echo "document.getElementById('total_amountincart').innerHTML=amount_incart;";
                        echo "$.post('module/index.php?data=addproduct_cart',{product_id:'$key',amount:product_incart},function(data){";
                        echo "});";
                        echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:amount_incart},function(data){";
                        echo "});";
                    echo "}";
                echo "});";
            }
        }
        
?>
            $("#message_bold").click(function(){
                var message = document.getElementById('webboard_message').value;
                document.getElementById('webboard_message').value= message+"<b></b>";
            });
        });
 </script>
<?php
echo "<script>";
    echo "$(document).ready(function() {";
            echo "$('#plus_like').click(function(){";
            if(!empty($_SESSION['login_name'])){
                echo "var amount_like = parseInt(document.getElementById('like_status').innerHTML);";
                echo "var rows = parseInt(document.getElementById('like_webboard').value);";
                echo "if(rows == 0){";
                    echo "amount_like++;";
                    echo "$.post('module/index.php?data=plus_like',{webboard_id:$_GET[webboard_id]},function(data){";
                    echo "});";
                    echo "document.getElementById('like_status').innerHTML =amount_like;";
                    echo "document.getElementById('like_webboard').value=1;";
                echo "}else{";
                    echo "amount_like--;";
                    echo "$.post('module/index.php?data=lower_like',{webboard_id:$_GET[webboard_id]},function(data){";
                    echo "});";
                    echo "document.getElementById('like_status').innerHTML =amount_like;";
                    echo "document.getElementById('like_webboard').value=0;";
                echo "}";
            }else{
                echo "alert('ขออภัย ระบบกดถูกใจสามารถทำได้เพียงสมาชิกเท่านั้น');";
            }
            echo "});";
    echo "});";
echo "</script>";
?>

 
 
</head>
<body>
<!-- Button trigger modal -->

<div class="display_com">
    <div class="header">
        <a href='index.php' style='text-decoration: none;'><div class="header-logo">
            <div class="header-logo-img"><img src="images/icon/logomumfern.png" width="100%" height="100%"></div>
            <font color="#1c5d25" size="5"><p style="margin-top:16px;"><b>MUMFERN SHOP</b></p></font>
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
            echo "<a href='index.php?module=product&action=list_product&menu=1&cate=1'><div class='header-menu-product $active_menu2'><center>รายการสินค้า</center></div></a>";
            echo "<a href='index.php?module=webblog&action=list_webblog&webblog_menu=1'><div class='header-menu-webblog $active_menu3'><center>ข่าวสาร</center></div></a>";
            echo "<a href='index.php?module=webboard&action=webboard'><div class='header-menu-webboard $active_menu4'><center>เว็บบอร์ด </center></div></a>";
?>
        </div>
        <div class="header-function">
<?php
        $quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : index line 260");
        list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
        if($sellstatus==1){
        if(!empty($_SESSION['login_name'])){
            echo "<a href='index.php?module=users&action=data_users&menu=2'><div class='header-function-cart'>";
        }else{
            echo "<a href='' ><div class='header-function-cart'>";
        }
                $_SESSION['total_amount'] = (empty($_SESSION['total_amount']))?"0":$_SESSION['total_amount'];
                $hidden = (empty($_SESSION['total_amount']))?"display:none":"";
                echo "<b><p id='total_amountincart' style='$hidden'>$_SESSION[total_amount]</p></b>";
?>
                <img src="images/icon/cart-of-ecommerce.png" width="40" height="40">
            </div></a>
<?php
        }
            

            if(empty($_SESSION['login_name'])){
                echo "<div class='header-function-user'>";
                    echo "<a href='include/'><img src='images/user/user.png' id='header-user' width='40' height='40'>";
                    echo "<img src='images/user/user-hover.png' id='header-user-hover' width='40' height='40' style='display:none'></a>";
                echo "</div>";
            }else{
                $query_user = mysqli_query($_SESSION['connect_db'],"SELECT username,fullname,lastname,image FROM users WHERE username='$_SESSION[login_name]'")or die("ERROR : index line 116");
                list($username,$user_fullname,$user_lastname,$user_image)=mysqli_fetch_row($query_user);
                echo "<div class='header-function-user' style='width:auto;padding:5px;'>";
                    echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>";
                    if(empty($user_image)){
                        echo "<img src='images/user/user.png'   width='50' height='50' style='float:left;border-radius:50px;'>";
                    }else{
                        echo "<img src='images/user/$user_image'   width='50' height='50' style='float:left;border-radius:50px;'>";
                    }
                    
                    echo "</a><ul class='dropdown-menu dropdown-menu-right' style='cursor:default'>";
                        echo "<li><p style='margin-left:10px;font-size:20px;'><b>ชื่อผู้ใช้งาน :</b> $username</p></li>";
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
                            echo "<p style='margin-right:10px;font-size:23px;'>&nbsp;$user_fullname $user_lastname</p>";
                        }
                    if($_SESSION['login_type']==1){
                        echo "<a href='backend/' style='text-decoration: none;'><p style='margin-top:-10px;font-size:21px;margin-right:10px;'>&nbsp;จัดการข้อมูลหลังร้าน</p></a>";
                    }
                    if($_SESSION['login_type']!=1){
                        echo "<a href='index.php?module=users&action=data_users&menu=1' style='text-decoration: none;'><p style='margin-top:-10px;font-size:21px;margin-right:10px;'>&nbsp;ข้อมูลผู้ใช้งาน</p></a>";
                    }
                        echo "</div>
                        </div><br class='clear'></li>";
                        echo "<li role='separator' class='divider'></li>";
                        echo "<li><p align='right' style='margin-right:10px;'><a href='include/index.php?action=logout'><button class='btn btn-sm btn-default'><font size='4'>ออกจากระบบ</font></button></a></p></li>";
                    echo "</ul>";
                echo "</div>";
            }
                

            

?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="container-fluid"> 
        <div class="col-md-2"></div>
        <div class="col-md-8" style="background:#fff;padding:60px 0px 10px 0px;">
<?php
        if(!empty($module)){
            get_module($module,$action);
        }else{
?>
            <div id="carousel-example-generic" class="carousel slide " data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol>
              <!-- Wrapper for slides -->
              <div class="carousel-inner home-slide" role="listbox">
                <div class="item active home-slide ">
                  <img src="images/fern/20150818_182251_001.jpg" style="width:100%;height:100%" alt="...">
                  <div class="carousel-caption">
                    ...
                  </div>
                </div>
                <div class="item home-slide ">
                  <img src="images/fern/20150819_074210.jpg." style="width:100%;height:100%" alt="...">
                  <div class="carousel-caption">
                    ...
                  </div>
                </div>
                <div class="item home-slide ">
                  <img src="images/fern/20150819_074317.jpg" style="width:100%;height:100%" alt="...">
                  <div class="carousel-caption">
                    ...
                  </div>
                </div>
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
            <center><h1><b>MUMFERN SHOP</b></h1></center>
            <center><h2  class='marginun20'><b>ร้าน มุมเฟิร์น</b></h2></center>
            <p><center><font size='5'>ร้านมุมเฟิร์น เป็นร้านค้าขายต้นไม้ประเภทเฟิร์น เราจะขายสินค้าประเภทเฟิร์นเป็นหลัก ซึ่งมีหลายประเภท</font></center></p>
            <p  class='marginun20'><center><font size='5' >และร้านเรายังนำกระถางมาขายซึ่งมีหลากหลายรูปแบบให้เลือก ให้เหมาะสมกับเฟิร์นที่ทางร้านขาย</font></center></p>
            <br>
            <div class="clear"></div>
<?php
            $quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 64");
            list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
            if($sellstatus==1){
?>            
            <div class="product-recommend">
                <div class='product-recommend-center'></div>
                <div class="product-recommend-sale"><center>สินค้าลดราคา</center></div>
                <div class="product-recommend-new"><center>สินค้ามาใหม่</center></div>
                <div class="product-recommend-best"><center>สินค้าขายดี</center></div>
                <div class='product-recommend-center'></div>
            </div>
<?php
            }
?>
            <div class="product-recom-sale-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_price_web,product_type,product_image FROM product LIMIT 0,6 ");
            while(list($product_id,$product_name,$product_price_web,$product_type,$product_image)=mysqli_fetch_row($query_recom_sale)){
                echo "<div class='col-md-4' style='padding-top:10px;'>";
                    $folder= ($product_type=="1")?"fern":"pots";
                    echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><img src='images/$folder/$product_image' width='100%' height='300px'><br>";
                    echo "<p><center><font size='5'>$product_name</font></center></p></a>";
                    if($sellstatus==1){
                    echo "<p class='marginun20'><center><font size='4'>$product_price_web</font></center></p>";
                    }
                echo "</div>";
            }
?>
            </div>
            <div class="product-recom-new-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_price_web,product_type,product_image FROM product LIMIT 6,6 ");
            while(list($product_id,$product_name,$product_price_web,$product_type,$product_image)=mysqli_fetch_row($query_recom_sale)){
                echo "<div class='col-md-4' style='padding-top:10px;'>";
                    $folder= ($product_type=="1")?"fern":"pots";
                    echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><img src='images/$folder/$product_image' width='100%' height='300px'><br>";
                    echo "<p><center><font size='5'>$product_name</font></center></p></a>";
                    if($sellstatus==1){
                    echo "<p class='marginun20'><center><font size='4'>$product_price_web</font></center></p>";
                    }
                echo "</div>";
            }
?>
            </div>
            <div class="product-recom-best-content">
<?php
            $query_recom_sale =mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_price_web,product_type,product_image FROM product LIMIT 12,6 ");
            while(list($product_id,$product_name,$product_price_web,$product_type,$product_image)=mysqli_fetch_row($query_recom_sale)){
                echo "<div class='col-md-4' style='padding-top:10px;'>";
                    $folder= ($product_type=="1")?"fern":"pots";
                    echo "<a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><img src='images/$folder/$product_image' width='100%' height='300px'><br>";
                    echo "<p><center><font size='5'>$product_name</font></center></p></a>";
                    if($sellstatus==1){
                    echo "<p class='marginun20'><center><font size='4'>$product_price_web</font></center></p>";
                    }
                echo "</div>";
            }
?>
            </div>
<?php
        }
?>      
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="footer" >
        <div class="container-fluid">
                <p align="right" class="font26" style='color:white'><b>ที่อยู่ร้านมุมเฟิร์น</b></p>
                <p align="right" class="font20" style='color:white'>ตลากคำเที่ยง ล็อค f208-f209 ตำบล ป่าตัน อำเภอเมือง จังหวัดเชียงใหม่ 50300</p>
                <p align="right" class="font20" style='color:white'>เบอร์โทร : 081-8055024 &nbsp;&nbsp;E-mail : veerada@mumfern.com</p>
        </div>
    </div>
</div>
<div class="display_mobile">
    
</div>

</body>
</html>
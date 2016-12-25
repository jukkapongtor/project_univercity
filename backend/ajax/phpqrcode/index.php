<?php
    session_start();
    include("../../../include/function.php");
    connect_db();
    $_GET['amount']=(empty($_GET['amount']))?1:$_GET['amount'];
?>
<script>
    $(document).ready(function() {
<?php
/*
    for($i=1;$i<=$_GET['amount'];$i++){
        echo "$('#select_product'+$i).change(function(){";
            echo "var product = document.getElementById('select_product'+$i).value;";
            echo "$.post('ajax/function.php?data=select_size',{product:product},function(data){";
                echo "$('#select_size'+$i).html(data);";
            echo "});";
        echo "});"; 
    }
*/
?>
    });
    function  select_qrcode(number_qrcode){
        var amount_qrcode = number_qrcode.value;
        window.location='ajax/phpqrcode/qrcode_id.php?amount_qrcode='+amount_qrcode;
    }         

</script>
<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <a href="#" class="show-sidebar">
            <i class="fa fa-bars"></i>
        </a>
        <ol class="breadcrumb pull-left">
            <li><a href="#">จัดการคิวอาร์โค้ด</a></li>
            <li><a href="#">พิมพ์คิวอาร์โค้ด</a></li>
        </ol>
    </div>
</div>
<p style='background:#16326a;color:white;padding:5px;border-bottom:2px solid #325bb0;font-size:16px'><b>ไม่พบรายการขายสินค้า</b></p>

<div class="col-md-12" style="border-bottom:1px solid #ddd">
    <p><b>เลือกจำนวนคิวอาร์โค้ด</b></p>
    <div class="col-md-1"></div>
    <div class="col-md-2">
<?php
    switch ($_GET['amount']) {
        case '1': $checked1="checked='checked'";$checked2="";$checked3="";$checked4="";$checked5=""; break;
        case '2': $checked1="";$checked2="checked='checked'";$checked3="";$checked4="";$checked5=""; break;
        case '3': $checked1="";$checked2="";$checked3="checked='checked'";$checked4="";$checked5=""; break;
        case '4': $checked1="";$checked2="";$checked3="";$checked4="checked='checked'";$checked5=""; break;
        case '5': $checked1="";$checked2="";$checked3="";$checked4="";$checked5="checked='checked'"; break;

    }
?>
        <p align="center"><input type='radio' name='select_qrcode' onclick="select_qrcode(this)" value="1" <?php echo "$checked1";?>>&nbsp;จำนวน 1 สินค้า</p>
        <p><img src='../images/qrcode/select_qrcode1.jpg'></p>
    </div>
    <div class="col-md-2">
        <p align="center"><input type='radio' name='select_qrcode' onclick="select_qrcode(this)" value="2" <?php echo "$checked2";?>>&nbsp;จำนวน 2 สินค้า</p>
        <p><img src='../images/qrcode/select_qrcode2.jpg'></p>
    </div>
    <div class="col-md-2">
        <p align="center"><input type='radio' name='select_qrcode' onclick="select_qrcode(this)" value="3" <?php echo "$checked3";?>>&nbsp;จำนวน 3 สินค้า</p>
        <p><img src='../images/qrcode/select_qrcode3.jpg'></p>
    </div>
    <div class="col-md-2">
        <p align="center"><input type='radio' name='select_qrcode' onclick="select_qrcode(this)" value="4" <?php echo "$checked4";?>>&nbsp;จำนวน 4 สินค้า</p>
        <p><img src='../images/qrcode/select_qrcode4.jpg'></p>
    </div>
    <div class="col-md-2">
        <p align="center"><input type='radio' name='select_qrcode' onclick="select_qrcode(this)" value="5" <?php echo "$checked5";?>>&nbsp;จำนวน 5 สินค้า</p>
        <p><img src='../images/qrcode/select_qrcode5.jpg'></p>
    </div>
    <div class="col-md-1" ></div>

</div>
<div class="col-md-12" style="border-bottom:1px solid #ddd">
    <p><b>เลือกรูปภาพ</b></p>
    <div class="col-md-2"></div>
    <div class="col-md-8" >
        <form action="ajax/phpqrcode/qrcode_id.php" method="post">
<?php
        echo "<input type='hidden' name='amount_qrcode' value='$_GET[amount]'>";
        for($i=1;$i<=$_GET['amount'];$i++){

           echo "<div class='col-md-12'><div class='col-md-2'></div><div class='col-md-3' style='padding:0px'><p>เลือกสินค้าที่ $i </p></div><div class='col-md-5'>";
            echo "<p><select name='product_id[]' id='select_product$i' class='form-control'>";
                echo "<option value='0'>--เลือกสินค้า--</option>";

                $query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name FROM product");
                while(list($product_id,$product_name)=mysqli_fetch_row($query_product)){
                    echo "<option value='$product_id'>$product_name</option>";
                }

            echo "</select></p></div><div class='col-md-2'></div></div>";
/*
            echo "<div class='col-md-3'>เลือกขนาด</div><div class='col-md-4'>";
            echo "<select name='product_size[]' id='select_size$i' class='form-control' >";
                echo "<option value='0'>--เลือกขนาด--</option>";
            echo "</select></div></div>"; 
*/
        }
?>
        <div class='col-md-12'><p align="right"><input class="btn btn-sm btn-success" type="submit" value="GENERATE"></p></div>
        </form>
    </div>
    <div class="col-md-2" ></div>

</div>

<?php    
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
    include "qrlib.php"; 
    echo "<p align='center' style='font-size:20px;margin-top:10px;border-bottom:solid 1px #ddd'><b>QR Code</b></p>";
    if(!empty($_SESSION['product_id'])){
    for($i=0;$i<count($_SESSION['product_id']);$i++){
        $_REQUEST['data'] = $_SESSION['product_id'][$i];
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'ajax/phpqrcode/temp/';

       
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename[$i] = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
 

    $matrixPointSize = 4;



    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename[$i] = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename[$i], $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename[$i], $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }


    //echo "$PNG_WEB_DIR";
    //echo '<img src="'.'ajax/phpqrcode/temp/'.basename('ajax/phpqrcode/temp/test'.md5('ews'.'|'.'L'.'|'.'4').'.png').'" width="40px" /><hr/><img src="'.'ajax/phpqrcode/temp/'.basename('ajax/phpqrcode/temp/test'.md5('jukkapong'.'|'.'L'.'|'.'4').'.png').'" width="40px" /><hr/><img src="'.'ajax/phpqrcode/temp/'.basename('ajax/phpqrcode/temp/test'.md5('asdasd'.'|'.'L'.'|'.'4').'.png').'" width="40px" /><hr/>';   
    //display generated file
    } 
    echo "<div class='col-md-12'><table align='center' width='70%'>";
    echo "<tr><td colspan='5' align='right'><a href='../print/print_qrcode.php' target='_blank'><input type='button' class='btn btn-sm btn-primary' value='พิมพ์คิวอาร์โค้ด'></a></td></tr>";
    for($a=0;$a<7;$a++){
        echo "<tr>";
            $num=0;
            for($b=0;$b<5;$b++){
                echo "<td width='20%'>";
                    $_SESSION['filename'][$num]=$filename[$num];
                    echo "<img src=".$PNG_WEB_DIR.basename($filename[$num])." width='100%'/>";
                    echo "<center>".$_SESSION['product_name'][$num]."</center>";
                echo "</td>";
                $num++;
                $num=($num>=count($_SESSION['product_id']))?0:$num;
            }
        echo "</tr>";
    }
    echo "</table></div>";
    
    /*
    //config form
    echo '<form action="ajax/phpqrcode/test.php" method="post">
        Data:&nbsp;<input name="data[]" value="wqwqwqwwqw" />
        <input name="data[]" value="asdasdasasdasd" />&nbsp;

        Size:&nbsp;<select name="size">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '</select>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';
        
    // benchmark
    QRtools::timeBenchmark(); 
    */   
    }

    
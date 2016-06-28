<?php
function list_product(){
	echo "<div class='container-fluid well padding0' style='margin-top:5px;'>";
		echo "<div class='col-md-3 padding0' >";
			echo "<div class='list-group' style='margin-bottom:0px;'>";
		$query_type=mysqli_query($_SESSION['connect_db'],"SELECT type.product_type,type.type_name,quality.product_quality FROM type LEFT JOIN quality ON type.product_type = quality.quality_type GROUP BY type.type_name ORDER BY type.product_type ASC")or die("ERROR : product_function line 6");
		while(list($product_type,$type_name,$product_quality)=mysqli_fetch_row($query_type)){
			$active = ($product_type==$_GET['menu'])?"active":"";
			echo "<a href='index.php?module=product&action=list_product&menu=$product_type&cate=$product_quality' class='list-group-item list-group-item-success $active'><font style='font-size:18px'><b>รายการสินค้าประเภท$type_name</b></font></a>";
		} 
			echo "</div>";
		echo "</div>";
		echo "<div class='col-md-9' style='padding-top:10px;padding-right:0px'>";
		$query_cate = mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name FROM quality WHERE quality_type='$_GET[menu]'")or die("ERROR : product_function line 14");
		$number=1;
		$num_cate = mysqli_num_rows($query_cate);
		if(!empty($num_cate)){
		while (list($product_quality,$quality_name)=mysqli_fetch_row($query_cate)) {
			echo "<div class='col-md-3'>";
			if($product_quality==$_GET['cate']){
				echo "<center><img src='images/icon/no-images.jpg' width='95' height='95' style='border-radius:100px;border:5px solid #248a32;' >";
			}else{
				echo "<center><a href='index.php?module=product&action=list_product&menu=$_GET[menu]&cate=$product_quality' ><img src='images/icon/no-images.jpg' class='select-cate-product_$number' style='width: 100px;height: 100px;border-radius: 100px;'></a>";
			}
				echo "<p style='font-size:25px;margin-top:5px'>$quality_name</p></center>";
			$number++;
			echo "</div>";
		}
		}else{
			echo "<div class='col-md-12' style='padding-top:30px;'>";
				echo "<center><h3><b>สินค้ายังไม่ถูกเพิ่มหมวดหมู่</b></h3></center>";
			echo "</div>";
		}
		echo "</div>";
	echo "</div>";
	echo "<div class='container-fluid'>";
	$query_type =  mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE product_type='$_GET[menu]'")or die("ERROR : product_function line 37");
	list($type_product) = mysqli_fetch_row($query_type);
	$query_cate = mysqli_query($_SESSION['connect_db'],"SELECT quality_name FROM quality WHERE quality_type='$_GET[menu]' AND product_quality='$_GET[cate]'")or die("ERROR : product_function line 39");
	list($cate_name)=mysqli_fetch_row($query_cate);
	echo "<h3><b>รายการสินค้า / ร้านการสินค้าประเภท$type_product / หมวดหมู่$cate_name</b></h3>";
	$quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 42");
    list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_price_web,product_type,product_image FROM product WHERE product_type='$_GET[menu]' AND product_quality='$_GET[cate]'")or die("ERROR : product_function line 44");
	while (list($product_id,$product_name,$product_price_web,$product_type,$product_image)=mysqli_fetch_row($query_product)) {
		echo "<div class='col-md-3' style='margin-top:20px'>";
			$folder = ($product_type==1)?"fern":"pots";
			echo "<center><a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><img src='images/$folder/$product_image' width='100%' height='300'><p><font style='font-size:20px'>$product_name</font></p></a>";
			if($sellstatus==1){
			echo "<p class='marginun20'><font size='3'>$product_price_web</font></p> ";
			}
		echo "</div>";
	}
	echo "</div>";
}

function product_detail(){
	
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,product.product_price_web,product.product_detail,type.type_name,quality.quality_name,size.size_name,product.product_stock,product.product_image FROM product INNER JOIN type ON product.product_type = type.product_type INNER JOIN quality ON product.product_quality = quality.product_quality INNER JOIN size ON product.product_size = size.product_size WHERE product.product_id='$_GET[product_id]'")or die("ERROR : product_function line 47");
	list($product_id,$product_name,$product_price_web,$product_detail,$product_type,$product_quality,$product_size,$product_stock,$product_image)=mysqli_fetch_row($query_product);
		echo "<center><h4 style='margin-top:30px;font-size:45px'><b>$product_name</b></h4></center>";
		echo "<div class='container-fluid'><div class='col-md-5'style='margin-top:20px'>";
			$file = ($product_type=="เฟิร์น")?"fern":"pots";
			echo "<img src='images/$file/$product_image' width='100%' height='500' style='border-radius:5px;'>";
		echo "</div>";
		echo "<div class='col-md-7' style='margin-top:20px'>";
			$product_detail =(empty($product_detail))?"ไม่มีรายละเอียดของข้อมูลสินค้า":$product_detail;
			echo "<p style='font-size:25px'><b>รายละเอียดสินค้า :</b><br>&nbsp;&nbsp;&nbsp;&nbsp;$product_detail</p>";
			$quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 64");
	        list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
	        if($sellstatus==1){
				echo "<p style='font-size:25px'><b>ราคาสินค้า : </b> $product_price_web &nbsp;<b>บาท/(Bath)</b></p>";
			}
			echo "<p style='font-size:25px'><b>ประเภทสินค้า : </b> $product_type</p>";
			echo "<p style='font-size:25px'><b>หมวดหมู่สินค้า : </b> $product_quality</p>";
			echo "<p style='font-size:25px'><b>ขนาดสินค้า : </b> $product_size</p>";
			echo "<p style='font-size:25px'><b>สถานะสินค้า : </b> $product_stock</p>";
			echo "<div class='row'>";
			if($sellstatus==1){
			  echo "<div class='col-lg-3'></div>";
			  echo "<div class='col-lg-4'>";
			    echo "<div class='input-group'>";
			      echo "<span class='input-group-btn'>";
			        echo "<button class='btn btn-default' id='lower_indetail' type='button'>ลบ</button>";
			      echo "</span>";
			      echo "<input type='text' class='form-control' id='product_amountindetail' value='1'>";
			      echo "<span class='input-group-btn'>";
			        echo "<button class='btn btn-default' id='push_indetail' type='button'>บวก</button>";
			      echo "</span>";
			    echo "</div>";
			  echo "</div>";
			  echo "<div class='col-lg-2'>";
			    echo "<input type='hidden' id='product_id' value='$product_id'>";
			  	echo "<p align='center'><a id='add2cart'><button type='button' class='btn btn-default btn-sm'><font style='font-size:15px'><b>หยิบสินค้า</b></font></button></a></p>";
			  echo "</div>";
			 echo "</div>";
			}	
		echo "</div></div>";


	echo "<br class='clear'><div class='underline'></div>";
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id,product_name,product_price_web,product_type,product_image FROM product ORDER BY RAND() LIMIT 4")or die("ERROR : product_function line 65");
	while (list($product_id,$product_name,$product_price_web,$product_type,$product_image)=mysqli_fetch_row($query_product)) {
		echo "<div class='col-md-3' style='margin-top:20px'>";
			$file = ($product_type==1)?"fern":"pots";
			echo "<center><a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'><img src='images/$file/$product_image' width='100%' height='200px'>";
			echo "<p style='font-size:25px;'>$product_name</p></a>";
			echo "<p style='font-size:20px;margin-top:-15px;'>$product_price_web</p></center>";
		echo "</div>";
	}
}

?>
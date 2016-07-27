<?php
	session_start();
	date_default_timezone_set('Asia/Bangkok');
	include("../../include/function.php");
	connect_db();

?>

<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการโปรโมชั่น</a></li>
			<li><a href="#">เพิ่มสินค้าลดราคา</a></li>

		</ol>
	</div>
</div>
<div class="container-fluid" style="border-bottom:1px solid #ddd;margin-bottom:20px;">
	<form action="ajax/function_pomotion_sale.php" method="get"  >
	<input type='hidden' name='data' value="pomotion_sale_add_search">
	<div class="col-md-1"></div>
	<div class="col-md-6">
		<h4>ค้นหาข้อมูลสินค้า</h4>
		<div class="col-md-10" style="margin-top:20px;padding:0px;" >
<?php
		$keywords = (empty($_GET['keywords']))?"":$_GET['keywords'];
		$getproduct_type=(empty($_GET['product_type']))?"":$_GET['product_type'];
		$getproduct_quality=(empty($_GET['product_quality']))?"":$_GET['product_quality'];
		$sql_type = (empty($_GET['product_type']))?"":"AND type.product_type='$_GET[product_type]'";
		$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,type.type_name FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_name LIKE '%$keywords%' $sql_type")or die("ERROR : backend product list line 61");
		$count_product = mysqli_num_rows($query_product);
		$total_page = ceil($count_product/10);
		if(empty($_GET['page'])){
			$page=1;
			$start_row=0;
		}
		else{
			$page=$_GET['page'];
			$start_row=($page-1)*10;
		}	
		    echo "<input type='text' class='form-control' name='keywords' placeholder='Search...' value='$keywords'  style='height:30px;'>";
?>		
		</div>
		<div class="col-md-2" style="margin-top:20px;">
		    <button type="submit" class="btn btn-default btn-sm" style='height:30px;padding:2px 10px;'>Search</button>
		</div>
	</div>
	<div class="col-md-4">

		<h4>เลือกประเภทสินค้าในการค้นหา</h4>
<?php
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type")or die("ERROR : backend product list line 39");
		
		$chk = (empty($_GET['product_type']))?"checked='checked'":"";
			echo "<div class='col-md-6' ><p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='product_type' value='' $chk>&nbsp;ไม่เลือกประเภท</p></div>";
		while (list($product_type,$type_name)=mysqli_fetch_row($query_type)) {
			$chk = ($getproduct_type==$product_type)?"checked='checked'":"";
			echo "<div class='col-md-6' ><p>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='product_type' value='$product_type' $chk>&nbsp;$type_name</p></div>";
		}
?>
		<div class="col-md-1"></div>
	</div>
	</form>
</div>
<div class="container-fluid">
<?php
	
	if(empty($count_product)){
		echo "<center><h3 style='margin-top:30px;'><font color='red'> !!! </font>ไม่พบรายการสินค้า<font color='red'> !!! </font></h3></center>";
	}else{
		$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name,type.type_name_eng,product.product_type FROM product LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN quality ON product.product_quality = quality.product_quality  WHERE product.product_name LIKE '%$keywords%' $sql_type ORDER BY product.product_id DESC  LIMIT $start_row,10")or die("ERROR : backend product list line 87");
		$number =0;
		while(list($product_id,$product_name,$type_name,$type_name_eng,$type_id)=mysqli_fetch_row($query_product)){

			if(($number%5)==0){
				echo "<div class='col-md-1' style='margin-bottom:20px; height:300px;'></div>";
			}
			echo "<div class='col-md-2' style='margin-bottom:20px; height:300px;'>";
				$query_productimg = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'")or die("ERROR : backend product list line 113");
				list($product_image)=mysqli_fetch_row($query_productimg);
				echo "<a data-toggle='modal' data-target='#$product_id' style='text-decoration:none;cursor:pointer'><center><p><img src='../images/$type_name_eng/$product_image' width='100%' height='200px' style='border-radius:5px;'></p>";
				$str=explode(" ",$product_name,2);
				echo "<p>$str[0]</p></a></center>";
					echo "<div class='modal fade' id='$product_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
					  echo "<div class='modal-dialog' role='document'>";
					    echo "<div class='modal-content'>";
					      echo "<div class='modal-header'>";
					        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
					        echo "<h4 class='modal-title' id='myModalLabel'>ลดราค้าสิินค้า $product_name</h4>";
					      echo "</div>";
					      echo "<div class='modal-body'>";
					      $query_size = mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,size.size_name,product_size.product_price_web,product_size.product_price_shop,product_size.product_sprice_web,product_size.product_sprice_shop FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id='$product_id'")or die("ERROR : backend pomotion sale line 95");
					      echo "<form action='ajax/function_pomotion_sale.php?data=update_pomotion' method='post'>";
					      echo "<table width='80%' align='center'>";
					      $rows = mysqli_num_rows($query_size); 
					      if($rows > 0){
						      while(list($product_size_id,$size_name,$product_price_web,$product_price_shop,$product_sprice_web,$product_sprice_shop)=mysqli_fetch_row($query_size)){
						      	echo "<input type='hidden' name='product_size_id[]' value='$product_size_id'>";
						      	echo "<tr><td colspan='4'><p><b>ขนาดสินค้า : </b>$size_name</p></td></tr>";
						      	echo "<tr>";
						      		echo "<td><p><b>ราคาบนเว็บไซต์ : </b></p></td>";
						      		echo "<td><p>".number_format($product_price_web,2)." ฿</p></td>";
						      		echo "<td><p><b>ลดราคา : </b></p></td>";
						      		echo "<td width='20%'><p><input type='text' class='form-control' name='sprice_web[]' value='$product_sprice_web'></p></td>";
						      	echo "</tr>";
						      	echo "<tr>";
						      		echo "<td><p><b>ราคาในร้าน : </b></p></td>";
						      		echo "<td><p>".number_format($product_price_shop,2)." ฿</p></td>";
						      		echo "<td><p><b>ลดราคา : </b></p></td>";
						      		echo "<td><p><input type='text' class='form-control' name='sprice_shop[]' value='$product_sprice_shop'></p></td>";
						      	echo "</tr>";
						      }
						      echo "<tr><td colspan='4'><p align='right'><button class='btn btn-sm btn-primary'>เพิ่มโปรโมชั่น</button></p></td></tr>";
						      echo "</table>";
						      echo "</form>";
					  	  }else{
					  	  	echo "<p align='center'>ไม่พบขนาดสินค้า</p>";
					  	  	echo "<p align='center'>กรุณาเพิ่มขนาดสินค้าก่อนทำการลดราคาสินค้า</p>";
					  	  }
					      echo "</div>";//ปิด modal
					    echo "</div>";
					  echo "</div>";
					echo "</div>";
			echo "</div>";
			$number++;
			
			if(($number%5)==0){
				echo "<div class='col-md-1' style='margin-bottom:20px; height:300px;'></div>";
				$number=0;
			}
		}
		if($total_page>1){
		echo "<div class='col-md-12'>";
			echo "<center><nav><ul class='pagination'>";
			  echo "<li><a href='ajax/function_pomotion_sale.php?data=pomotion_sale_add_page&page=1&keywords=$keywords&product_type=$getproduct_type'>หน้าแรก</a></li>";
			  $preview = ($page-1);
			  $preview = ($preview<1)?1:$preview;
			  echo "<li><a href='ajax/function_pomotion_sale.php?data=pomotion_sale_add_page&page=$preview&keywords=$keywords&product_type=$getproduct_type'><<</a></li>";
		for($i=1;$i<=$total_page;$i++){
				$active = ($page==$i)?"active":"";
			  echo "<li class='$active'><a href='ajax/function_pomotion_sale.php?data=pomotion_sale_add_page&page=$i&keywords=$keywords&product_type=$getproduct_type'>$i</a></li>";
		}	
			  $next = ($page+1);
			  $next = ($next>$total_page)?$total_page:$next;
			  echo "<li><a href='ajax/function_pomotion_sale.php?data=pomotion_sale_add_page&page=$next&keywords=$keywords&product_type=$getproduct_type'>>></a></li>";
			  echo "<li><a href='ajax/function_pomotion_sale.php?data=pomotion_sale_add_page&page=$total_page&keywords=$keywords&product_type=$getproduct_type'>หน้าสุดท้าย</a></li>";
			echo "</ul></nav></center>";
		echo "</div>";
		}
	}

?>
</div>
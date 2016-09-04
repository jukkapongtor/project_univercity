<?php
function list_product(){
?>
	<form method="get" style="margin-top:10px;">
		<input type="hidden" name='module' value="product">
		<input type="hidden" name='action' value="list_product">
		<input type="hidden" name='menu' value="<?php echo $_GET['menu']; ?>">
		<input type="hidden" name='cate' value="<?php echo $_GET['cate']; ?>">
		<div class="container-fluid">
			<div class="col-md-7"></div>
			<div class="col-md-5">
				<div class="col-md-4" style="padding-top:5px;"><b>ค้นหาสินค้า</b></div>
				<div class="col-md-6 padding0"><input type="text" name='keywd' class='form-control input-sm' pattern='[a-zA-Z0-9ก-๙]{0,}' title="กรอกข้อความได้เฉพาะ a-z A-Z ก-๙"></div>
				<div class="col-md-2"><button class="btn btn-sm"><b><span class='glyphicon glyphicon-search'></span> ค้นหา</b></button></div>			
			</div>
		</div>
	</form>

<script type="text/javascript">
/*
  var str = '\'';
  if ( checkStr( str ) )
 { 
    alert( 'มีอักขระพิเศษในข้อความ' ); 
 }
*/
 function checkStr (val) {
  var str = '<>&'; //ตัวอักษรที่ไม่ต้องการให้มี
  if (val.indexOf("'")!= -1) return true //เครื่องหมาย '
  if (val.indexOf('"')!= -1) return true //เครื่องหมาย "
  for (i = 0; i < str.length; i++) {
    if (val.indexOf(str.charAt(i))!= -1) return true
  }
  return false
  }
</script>
<?php
	echo "<div class='container-fluid well padding0' style='margin-top:5px;padding-top:10px;'>";
		echo "<div class='col-md-3' style='padding' >";
?>			<div class='hidden-sm hidden-md hidden-lg'>
				<nav class="navbar navbar-default" >
				  <div class="container-fluid" style='padding:10px;margin:0px;'>
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand">เลือกประเภทสินค้า</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
				      <ul class="nav navbar-nav" style='padding:10px;width:100%;margin:0px;'>
<?php
						$query_type=mysqli_query($_SESSION['connect_db'],"SELECT type.product_type,type.type_name,quality.product_quality FROM type LEFT JOIN quality ON type.product_type = quality.quality_type GROUP BY type.type_name ORDER BY type.product_type ASC")or die("ERROR : product_function line 6");
						while(list($product_type,$type_name,$product_quality)=mysqli_fetch_row($query_type)){
							$active = ($product_type==$_GET['menu'])?"active":"";
							echo "<a href='index.php?module=product&action=list_product&menu=$product_type&cate=$product_quality' class='list-group-item list-group-item-success $active'><font ><b>สินค้าประเภท$type_name</b></font></a>";
						}
?>
				      </ul>
				    </div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>
			</div>
			<div class='hidden-xs' style='width:100%'>
				<ul class="list-group">
<?php
						$query_type=mysqli_query($_SESSION['connect_db'],"SELECT type.product_type,type.type_name,quality.product_quality FROM type LEFT JOIN quality ON type.product_type = quality.quality_type GROUP BY type.type_name ORDER BY type.product_type ASC")or die("ERROR : product_function line 6");
						while(list($product_type,$type_name,$product_quality)=mysqli_fetch_row($query_type)){
							$active = ($product_type==$_GET['menu'])?"active":"";
							echo "<a href='index.php?module=product&action=list_product&menu=$product_type&cate=$product_quality' class='list-group-item list-group-item-success $active'><font ><b>สินค้าประเภท$type_name</b></font></a>";
						}
?>
				</ul>
			</div>
<?php
		echo "</div>";
		echo "<div class='col-md-9' style='padding:0px'>";

			echo "<div class='container-fluid'>";
				echo "<center><h4 style='background:#3c763d;padding:10px;margin-top:5px;color:white'><b>หมวดหมู่สินค้า</b></h4></center>";
			echo "</div>";
		

		$query_cate = mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name,quality_image FROM quality WHERE quality_type='$_GET[menu]'")or die("ERROR : product_function line 14");
		$number=1;
		$num_cate = mysqli_num_rows($query_cate);
		if(!empty($num_cate)){
		while (list($product_quality,$quality_name,$quality_image)=mysqli_fetch_row($query_cate)) {
			echo "<div class='col-md-3 col-xs-4'>";
			if($product_quality==$_GET['cate']){
				$quality_img = (empty($quality_image))?"no-images.jpg":$quality_image;
				echo "<center><img src='images/icon/$quality_img' width='100' height='100' style='border-radius:100px;border:5px solid #248a32;' >";
			}else{
				$quality_img = (empty($quality_image))?"no-images.jpg":$quality_image;
				echo "<center><a href='index.php?module=product&action=list_product&menu=$_GET[menu]&cate=$product_quality' ><img src='images/icon/$quality_img' class='select-cate-product_$number' style='width: 100px;height: 100px;border-radius: 100px;'></a>";
			}
				echo "<p class='font_menu' style='margin-top:5px'>$quality_name</p></center>";
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
	$quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 42");
    list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
	if(!empty($_GET['keywd'])){
		$sql_product = "SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_name LIKE '%$_GET[keywd]%'";
	}else{
		$sql_product = "SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_type='$_GET[menu]' AND product.product_quality='$_GET[cate]' ";
	}
	$query_product = mysqli_query($_SESSION['connect_db'],$sql_product)or die("ERROR : product_function line 44");
	$num_row =mysqli_num_rows($query_product);
	if(!empty($cate_name)){
		if(empty($_GET['keywd'])){
			echo "<h4 class='font_show_type_qulity'><b>รายการสินค้า / ประเภท$type_product / หมวดหมู่$cate_name</b></h4>";
		}else{
			echo "<div class='container-fluid'>";
				echo "<center><h4><b>เจอสินค้าที่ค้นหาทั้งหมด <font color='red'>$num_row</font> รายการ</b></h4></center>";
			echo "</div>";
		}
	}else{
		echo "<br><br><br>";
	}
	if($num_row>0){
		while (list($product_id,$product_name,$product_type)=mysqli_fetch_row($query_product)) {
			
			echo "<div class='col-md-3 col-xs-6' style='margin-top:20px'>";
			$query_image = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
			list($product_image_detail)=mysqli_fetch_row($query_image);
			$path= (empty($product_image_detail))?"icon/no-images.jpg":"$product_type/$product_image_detail";
				$str=explode(" ",$product_name,2);
				echo "<center><a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'>";
				$status_product = check_product($product_id);
				if($status_product!=0){
					switch ($status_product) {
						case '1': echo "<img src='images/icon/new.png' class='img_product_detail' style='position: absolute;z-index:2'>"; break;
						case '2': echo "<img src='images/icon/best seller.png' class='img_product_detail' style='position: absolute;z-index:2'>"; break;
						default: echo "<img src='images/icon/sale.png' class='img_product_detail' style='position: absolute;z-index:2'>"; break;
					}
				}
				
				
				echo "<img src='images/$path' class='img_product_detail' style='position: relative;'>
				<p style='margin-top:5px;'><font class='font-content' >$str[0]</font></p></a>";
			echo "</div>";
		}
	}else{
		echo "<div class='col-md-12' style='margin:40px 0px 50px 0px;'><center><h1 ><b>ไม่พบรายการสินค้า</b></h1></center></div>";
		echo "<div><br><br><br><br><br><br><br><br><br><br><br><br></div>";
	}
	echo "</div>";
}

function product_detail(){
	if(!empty($_SESSION['login_type'])&&(($_SESSION['login_type']==2)||($_SESSION['login_type']==1))){
		echo "<script>window.location='shop/index.php?module=product&action=product_detail&product_id=$_GET[product_id]'</script>";
	}
	
	$quality_sellstatus = mysqli_query($_SESSION['connect_db'],"SELECT sellproduct_status FROM web_page")or die("ERROR : product function line 64");
	list($sellstatus)=mysqli_fetch_row($quality_sellstatus);
	$query_product_detail = mysqli_query($_SESSION['connect_db'],"SELECT product.product_name,product.product_detail,quality.quality_name,product.product_stock,type.type_name,type.type_name_eng FROM product LEFT JOIN quality ON product.product_quality = quality.product_quality LEFT JOIN type ON product.product_type = type.product_type WHERE product.product_id='$_GET[product_id]'")or die("ERROR : product_function line 59");
	list($product_name,$product_detail,$quality_name,$product_stock,$product_type,$type_name_eng)=mysqli_fetch_row($query_product_detail);
	echo "<center><div class='hidden-md hidden-sm hidden-lg' style='margin-top:20px'><h4><b>รายละเอียดสินนค้า$product_name</b></h4></div></center>";
	echo "<div class='container-fluid'>";
		echo "<div class='col-md-12 padding0' >";
			echo "<h4 style='background:#3c763d;color:white;padding:10px;padding-top:15px;'><b>รายการสินค้า / ประเภท$product_type / หมวดหมู่$quality_name / $product_name</b></h4>";
		echo "</div>";
	    echo "<div class='col-md-5'>";
	    $sql_images_detail = "SELECT product_image FROM product_image WHERE product_id='$_GET[product_id]'";
	    $query_images_detail = mysqli_query($_SESSION['connect_db'],$sql_images_detail)or die("ERROR : product_function line 200");
	    $number_image=1;
	    $row_image = mysqli_num_rows($query_images_detail);
	    if(!empty($row_image)){
?>
			<div class='col-md-12'>
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="border:1px solid #eee;border-radius:15px;">
				<!-- Indicators -->
				<ol class="carousel-indicators">
<?php
				for($i=0;$i<$row_image;$i++){
                    $active = ($i==0)?"class='active'":"";
                    echo "<li data-target='#carousel-example-generic' data-slide-to='$i' $active></li>";
                }
?>
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox" style="height:350px;border-radius:15px;">
<?php
			$number=0;
		    while(list($product_image_detail)=mysqli_fetch_row($query_images_detail)){
		    	$path= (empty($product_image_detail))?"icon/no-images.jpg":"$type_name_eng/$product_image_detail";
		    	//if($number_image==1){
		    	//echo "<div class='col-md-12'>";
					//echo "<img src='images/$path' width='100%' height='350' style='border-radius:5px;'>";
				//echo "</div>";
				//$number_image++;
				//}
				$active= ($number==0)?"active":"";
                echo "<div class='item $active' style='height:350px;border-radius:15px;'>";
                	echo "<img src='images/$path' style='width:100%;height:100%;border-radius:15px;' alt='...'>";
                echo "</div>";
                $number++;
				//echo "<div class='col-md-3 col-xs-3' style='padding:5px'>";
					//echo "<img src='images/$path'  class='img_producde_mini' style='border-radius:5px;'>";
				//echo "</div>";
			}

?>
				</div>
				 <!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev" style="border-radius:15px 0px 0px 15px">
				    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next" style="border-radius:0px 15px 15px 0px">
				    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
			</div>
			</div>
<?php
			$query_images_detail = mysqli_query($_SESSION['connect_db'],$sql_images_detail)or die("ERROR : product_function line 200");
			while(list($product_image_detail)=mysqli_fetch_row($query_images_detail)){
				$path= (empty($product_image_detail))?"icon/no-images.jpg":"$type_name_eng/$product_image_detail";
				echo "<div class='col-md-3 col-xs-3' style='padding:5px'>";
					echo "<img src='images/$path'  class='img_producde_mini' style='border-radius:5px;'>";
				echo "</div>";
			}
		}else{
			echo "<div class='col-md-12'>";
				echo "<img src='images/icon/no-images.jpg' width='100%' height='350' style='border-radius:5px;'>";
			echo "</div>";
		}
	    echo "</div>";
	    echo "<div class='col-md-7'style='margin-top:20px'>";
		   	 echo "<table width='100%' class='font-content'>";
	     		echo "<tr>";
	      			echo "<td width='25%'><p><b>ชื่อสินค้า</b></p></td>";
	      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
	      			echo "<td><p>$product_name</p></td>";
	      		echo "</tr>";
	      		echo "<tr>";
	      			echo "<td><p><b>รายละเอียดสินค้า</b></p></td>";
	      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
	      			$product_detail =(empty($product_detail))?"ไม่มีรายละเอียดของข้อมูลสินค้า":$product_detail;
	      			echo "<td><p>$product_detail</p></td>";
	      		echo "</tr>";
	      		echo "<tr>";
	      			echo "<td><p><b>ประเภทสินค้า</b></p></td>";
	      			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
	      			echo "<td><p>$product_type</p></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><p><b>หมวดหมู่สินค้า</b></p></td>";
					echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
					echo "<td><p>$quality_name</p></td>";
				echo "</tr>";
				if($sellstatus==1){
				echo "<tr>";
					echo "<td><p><b>สถานะสินค้า</b></p></td>";
					echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
					if(!empty($product_stock)){
						$check_amount_product =mysqli_query($_SESSION['connect_db'],"SELECT SUM(product_amount_web) FROM product_size  WHERE product_id ='$_GET[product_id]'");
						list($num_check_amount_product) = mysqli_fetch_row($check_amount_product);
						if(empty($num_check_amount_product)){
							mysqli_query($_SESSION['connect_db'],"UPDATE product SET product_stock='0' WHERE product_id ='$_GET[product_id]'");
							$product_stockw=0;
						}
					}
					$stock = (empty($product_stock))?"ไม่พร้อมจำหน่าย":"พร้อมจำหน่าย";
					echo "<td><p>$stock</p></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td valign='top'><p><b>ขนาดสินค้า</b></p></td>";
					echo "<td valign='top'><p><b>&nbsp;:&nbsp;</b></p></td>";
					echo "<td>";
					$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size.product_size_id,product_size.size_id,size.size_name,product_size.product_amount_web,product_size.product_price_web,product_size.product_sprice_web FROM product_size LEFT JOIN size ON product_size.size_id = size.product_size WHERE product_size.product_id ='$_GET[product_id]'");
					$number=1;
					$rows_size = mysqli_num_rows($query_size);
					if($rows_size>0){
					while(list($product_size_id,$size_id,$size_name,$product_amount_web,$product_price_web,$product_sprice_web)=mysqli_fetch_row($query_size)){
						echo "<div class='col-md-12'><p><b>ขนาดสินที่ $number : </b> $size_name</p></div>";
						if(!empty($product_stock)){	
							echo "<div class='col-md-3' ><p><b>จำนวน</b></p></div>";
							$product_amount_web = ($product_amount_web==0)?"สินค้าหมด":$product_amount_web;
							if($product_amount_web!="สินค้าหมด"){
								echo "<div class='col-md-2' <p>$product_amount_web</p></div>";
								if($sellstatus==1){
									echo "<div class='col-md-2' ><p><b>ราคา</b></p></div>";
									if($product_sprice_web!=0){
										echo "<div class='col-md-5' ><p style='text-decoration:line-through;color:red'>$product_price_web ฿</p></div>";
										echo "<div class='col-md-6' ><p align='right'><font color='red'> !!! </font>ราคาพิเศษ<font color='red'> !!! </font></div></p>";
										echo "<div class='col-md-6' ><p>$product_sprice_web ฿</p></div>";
									}else{
										echo "<div class='col-md-5' ><p>$product_price_web ฿</p></div>";
									}
								}
								$number++;
								if($sellstatus==1){
								  echo "<div class='col-lg-2'></div>";
								  echo "<div class='col-lg-6 col-xs-9'>";
								    echo "<div class='input-group'>";
								      echo "<span class='input-group-btn'>";
								        echo "<button class='btn' id='lower_indetail_$product_size_id' type='button' style='padding:6px;background:#aa8383'><img src='images/icon/minus.png' width='20' height='20'></button>";
								      echo "</span>";
								      echo "<input type='text' class='form-control' id='product_amountindetail_$product_size_id' value='0' disabled style='background:#fff;cursor: default;text-align:center'>";
								      echo "<span class='input-group-btn'>";
								        echo "<button class='btn' id='push_indetail_$product_size_id' type='button'style='padding:6px;background:#496a84'><img src='images/icon/add.png' width='20' height='20'></button>";
								      echo "</span>";
								    echo "</div>";
								  echo "</div>";
								  echo "<div class='col-lg-2 col-xs-3' style='padding:0px'>";
								    echo "<input type='hidden' id='product_id' value='$_GET[product_id]'>";
								  	echo "<p align='center'><a id='add2cart_$product_size_id'><button type='button' class='btn btn-default btn-sm' style='font-size:14px;'><span class='glyphicon glyphicon-shopping-cart'></span><b> หยิบสินค้า</b></button></a></p>";
								  echo "</div>";
								 echo "</div>";
								}
							}else{
								echo "<div class='col-md-9' <p>$product_amount_web</p></div>";
							}	
						}
						$number++;
					}
					}else{
						echo "<p>ไม่พบขนาดสินค้า</p>";
					}
					echo "</td>";
				echo "</tr>";
				}
			echo "</table>";
		echo "</div>";
	echo "</div>";

	$query_comment_product = mysqli_query($_SESSION['connect_db'],"SELECT * FROM comment_product WHERE product_id='$_GET[product_id]' ORDER BY comment_date ASC ")or die("ERROR : product line 226");
	$comment_row = mysqli_num_rows($query_comment_product);
	if(!empty($comment_row)){
		echo "<div class='container-fluid' style='border-bottom:2px #ddd solid;margin:30px 0px; width:80%;margin-left:10%;'>";
		$num=1;
		while(list($comment_proid,$username,$product_id,$comment_detail,$comment_date)=mysqli_fetch_row($query_comment_product)){
			echo "<div class='container-fluid padding0'>";
				echo "<div class='col-md-6 padding0'>";
					echo "<h4><b>ความคิดเห็นที่ $num</	b></h4>";
				echo "</div>";
				echo "<div class='col-md-6 padding0'>";
					echo "<p align='right'>";
					if(!empty($_SESSION['login_name'])&&$_SESSION['login_name']==$username){
						echo "<img src='images/icon/draw.png' width='20' height='20' onclick='edit_comment($comment_proid)' style='cursor:pointer;'>&nbsp;&nbsp;";
						echo "<img src='images/icon/can.png' width='20' height='20' onclick='delete_comment($comment_proid)' style='cursor:pointer;'>";
?>
						<script>
							function delete_comment(comment_proid){
								swal({
									title: "ลบความคิดเห็น",
									text: "คุณต้องการลบความคิดเห็นใช่หรือไม่?",
									type: "warning",
									showCancelButton: true,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "ลบข้อความ",
									closeOnConfirm: false,
									cancelButtonText: "ยกเลิก" },function(){
										$.post('index.php?module=product&action=delete_comment',{comment_proid:comment_proid},function(data){
                						});
										location.reload();
									});
							}
							function edit_comment(comment_proid){
								$.post('module/index.php?data=edit_comment',{comment_proid:comment_proid},function(data){
									$('#edit_content_comment_'+comment_proid).html(data);
                				});
							}	
						</script>
<?php
					}
					echo "</p>";
				echo "</div>";
			echo "</div>";
			echo "<div id='edit_content_comment_$comment_proid'>".nl2br($comment_detail)."</div>";
			$query_user = mysqli_query($_SESSION['connect_db'],"SELECT image FROM users WHERE username='$username'")or die("ERROR : 
				product line 215");
			list($image)=mysqli_fetch_row($query_user);
			echo "<table>";
				echo "<tr>";
					echo "<td rowspan='2' valign='middle'><img src='images/user/$image' width='45' height='45' style='border-radius:45px;border:2px #ddd solid;margin-top:-10px;'></td>";
					echo "<td><p>&nbsp;&nbsp;<b>ผู้แสดงความคิดเห็น<b></p></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><p>&nbsp;&nbsp;$username</p></td>";
				echo "</tr>";
			echo "</table>";
			if($num!=$comment_row){
				echo "<div class='container-fluid' style='border-bottom:2px #ddd solid;margin:10px 0px 0px 0x;  width:80%;margin-left:10%;'></div>";	
			}
			$num++;
		}
		echo "</div>";
	}
?>
	<div class="container-fluid" style='border-bottom:2px #ddd solid;margin:30px; width:90%;margin-left:5%;'> 
		<h4><b>แสดงความคิดเห็น</b></h4>
	</div>
	<div class="container-fluid"> 
		<div class='row'>
		<div class='col-md-2'></div>
		<div class='col-md-8'>
			<div class="col-md-12">
			<form action='index.php?module=product&action=comment_product' method="post">
<?php
				$disabled = (empty($_SESSION['login_name']))?"disabled":"";

				echo "<p><textarea class='form-control' name='comment_product' style='height:100px;' placeholder='Comment...' required $disabled>";
					if(empty($_SESSION['login_name'])){
						echo "สามารถแสดงความคิดเห็นสินค้าได้เฉพาะสมาชิกเท่านั้น";
					}
				echo "</textarea></p>";

					$user =(!empty($_SESSION['login_name']))?$_SESSION['login_name']:"";
?>
				<input type="hidden" name='username' value="<?php echo "$user";?>">
				<input type="hidden" name='product_id' value="<?php echo "$_GET[product_id]" ;?>">
				<p><input type='text' class="form-control" value="<?php echo "$user";?>" placeholder="Username..." required disabled></p>
<?php
				if(!empty($_SESSION['login_name'])){
					echo "<p align='right'><button class='btn btn-sm btn-primary'>แสดงความเห็น</button></p>";
				}else{
					echo "<p align='right'><button type='button' class='btn btn-sm btn-primary' onclick='check_comment()' $disabled>แสดงความเห็น</button></p>";
				}
				
?>
			</form>
			</div>
		</div>
		<div class='col-md-2'></div>
		</div>
	</div>
<?php

	echo "<br class='clear'><div class='underline'></div>";
	echo "<div class='col-md-12'><h4><b>รายการสินค้าที่เกี่ยวข้อง(ประเภทเดียวกัน)</b></h4></div>";
	$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product.product_id,product.product_name,type.type_name_eng FROM product LEFT JOIN type ON product.product_type = type.product_type WHERE type.type_name='$product_type' ORDER BY RAND() LIMIT 4")or die("ERROR : product_function line 65");
	while (list($product_id,$product_name,$product_type)=mysqli_fetch_row($query_product)) {
		echo "<div class='col-md-3 col-xs-4 rand_img_product'>";
			$query_image = mysqli_query($_SESSION['connect_db'],"SELECT product_image FROM product_image WHERE product_id='$product_id'");
			list($product_image_detail)=mysqli_fetch_row($query_image);
			$path= (empty($product_image_detail))?"icon/no-images.jpg":"$product_type/$product_image_detail";
			echo "<center><a href='index.php?module=product&action=product_detail&product_id=$product_id' style='text-decoration: none;'>";

			$status_product = check_product($product_id);
			if($status_product!=0){
				switch ($status_product) {
					case '1': echo "<img src='images/icon/new.png' class='ran_img_product' style='position: absolute;z-index:2'>"; break;
					case '2': echo "<img src='images/icon/best seller.png' class='ran_img_product' style='position: absolute;z-index:2'>"; break;
					default: echo "<img src='images/icon/sale.png' class='ran_img_product' style='position: absolute;z-index:2'>"; break;
				}
			}
			echo "<img src='images/$path' class='ran_img_product'  style='border-radius:5px;position:relative'>";
			
			$str = explode(" ",$product_name, 2);
			echo "<p class='font-content' style='margin-top:5px'>$str[0]</p></a>";
		echo "</div>";
	}

	echo "<script>";
		echo "$(document).ready(function() {";
			$query_size =mysqli_query($_SESSION['connect_db'],"SELECT product_size_id,size_id,product_amount_web FROM product_size WHERE product_size.product_id ='$_GET[product_id]'");
					$number=1;
			while(list($product_size_id,$size_id,$product_amount_web)=mysqli_fetch_row($query_size)){
			echo "$('#push_indetail_$product_size_id').click(function() {";
	            echo "var product_indetail = document.getElementById('product_amountindetail_$product_size_id').value;";
	            echo "var max_product = $product_amount_web;";
	            echo "product_indetail++;";
	            echo "if(product_indetail<=max_product){";
	            echo "document.getElementById('product_amountindetail_$product_size_id').value=product_indetail;";
	            echo "}";
	        echo "});";
	        echo "$('#lower_indetail_$product_size_id').click(function() {";
	            echo "var product_indetail = document.getElementById('product_amountindetail_$product_size_id').value;";
	            echo "if(product_indetail>=1){";
	                echo "product_indetail--;";
	                echo "document.getElementById('product_amountindetail_$product_size_id').value=product_indetail;";
	            echo "}";
	        echo "});";
        
	        echo "$('#add2cart_$product_size_id').click(function() {";
	            if(empty($_SESSION['login_name'])){
	            	
	                echo "swal('', 'การซื้อสินค้าทำได้เฉพาะสมาชิกเท่านั้น','error');";
	            }else{
	                echo "stop=0;";
	                echo "var product_id = document.getElementById('product_id').value;";
	                if(!empty($_SESSION['cart_id'])){
	                    foreach ($_SESSION['cart_id'] as $key => $value) {
	                        echo "if('$key'=='$product_size_id'){";
	                            echo "swal('', 'สินค้าชิ้นนี้ถูกเพิ่มในตะกร้าสินค้าเรียบร้อยแล้ว', 'warning');";
	                            echo "stop=1;";
	                        echo "}";
	                    }
	                }
	                echo "if(stop==0){";
	                echo "var product_indetail = parseInt(document.getElementById('product_amountindetail_$product_size_id').value);";
	                echo "var amount_incart = parseInt(document.getElementById('total_amountincart').innerHTML);";
	                echo "if(product_indetail!=0){";
		                echo "if(isNaN(amount_incart)){";
		                   echo " amount_incart =0;";
		                echo "}";
		                echo "total = product_indetail +amount_incart;";
		                echo "$('#total_amountincart').show();";
		                echo "document.getElementById('total_amountincart').innerHTML =total;";
		                echo "$.post('module/index.php?data=addproduct_cart',{product_id:product_id,amount:product_indetail,product_size_id:$product_size_id},function(data){";
		                echo "});";
		                echo "$.post('module/index.php?data=amounttotal_cart',{amounttotal_cart:total},function(data){";
		                echo "});";
						echo "swal({title:'',text: \"เพิ่มสินค้าลงในตะกร้าแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=product&action=product_detail&product_id="."'+product_id+'"."';})";
		                echo "}";
	                echo "}";
	            }
	        echo "});";
			}
		echo "});";
	echo "</script>";
?>
	<script>
		function check_comment(){
			swal('', 'สามารถแสดงความคิดเห็นสินค้าได้เฉพาะสมาชิกเท่านั้น','error');
		}
	</script>
<?php

}
function comment_product(){
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		$date = date("Y-m-d H:i:s");
		$_POST['comment_product'] = str_replace(" ","&nbsp;", $_POST['comment_product']);
		$_POST['comment_detail'] = str_replace("'","&#39;", $_POST['comment_detail']);
		$insert_comment = "INSERT INTO comment_product VALUES('','$_SESSION[login_name]','$_POST[product_id]','$_POST[comment_product]','$date')";
		mysqli_query($_SESSION['connect_db'],$insert_comment)or die("ERROR product funtion line 346");
		echo "<script>swal({title:'',text: \"แสดงความคิดเห็นเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.location='index.php?module=product&action=product_detail&product_id=$_POST[product_id]';})</script>";
	
	
}
function delete_comment(){
	mysqli_query($_SESSION['connect_db'],"DELETE FROM comment_product WHERE comment_proid='$_POST[comment_proid]'")or die("ERROR product funtion line 509");
}
function update_comment(){
	$_POST['comment_detail'] = str_replace(" ","&nbsp;", $_POST['comment_detail']);
	$_POST['comment_detail'] = str_replace("'","&#39;", $_POST['comment_detail']);
	mysqli_query($_SESSION['connect_db'],"UPDATE comment_product SET comment_detail='$_POST[comment_detail]' WHERE comment_proid='$_POST[comment_proid]'")or die("ERROR product funtion line 512");
	echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<script>swal({title:'',text: \"แก้ไขความคิดเห็นเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){window.history.back();})</script>";
}
?>
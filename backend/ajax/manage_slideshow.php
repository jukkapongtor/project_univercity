<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการเว็บไซต์</a></li>
			<li><a href="#">จัดการสไลด์</a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
		</div>
	</div>
</div>
<div class='container-fluid'>
	<h3>ตัวอย่างสไลด์ที่ใช้แสดงบนหน้าเว็บไซต์</h3>
	<div class="container-fluid">
		<div class="col-md-1"></div>
        <div class="col-md-10" style="padding:20px 0px 10px 0px;">
			<div id="carousel-example-generic" class="carousel slide " data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
<?php
				$query_slide=mysqli_query($_SESSION['connect_db'],"SELECT slide.slide_id,product.product_id,product.product_name,type.type_name,product_image.product_image,slide.slide_detail,slide.slide_image FROM slide LEFT JOIN product ON slide.product_id=product.product_id LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN product_image ON product.product_id =product_image.product_id ")or die("ERROR : backend slide line 29");;
				
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
              	while(list($slide_id,$product_id,$product_name,$type_name,$product_image,$slide_detail,$slide_image)=mysqli_fetch_row($query_slide)){
					$active= ($number==0)?"active":"";
					echo "<div class='item $active home-slide'>";
					if(empty($product_id)){
						$folder='slide';
						$image=$slide_image;
					}else{
						$folder = ($type_name=="เฟิร์น")?"fern":$type_name;
						$folder = ($folder=="กระถาง")?"pots":$folder;
						$image = $product_image;
					}
					  $product_name = (!empty($product_name))?$product_name:"";
	                  echo "<img src='../images/$folder/$image' style='width:100%;height:100%' alt='...'>";
	                  echo "<div class='carousel-caption'>";
	                    echo "<h4>$product_name</h4>$slide_detail";
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
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class='container-fluid'>
<?php
		$query_slide=mysqli_query($_SESSION['connect_db'],"SELECT slide.slide_id,product.product_id,product.product_name,type.type_name,product_image.product_image,slide.slide_detail,slide.slide_image FROM slide LEFT JOIN product ON slide.product_id=product.product_id LEFT JOIN type ON product.product_type = type.product_type LEFT JOIN product_image ON product.product_id =product_image.product_id ")or die("ERROR : backend slide line 78");
		echo "<br>";
		$number=1;
		while(list($slide_id,$product_id,$product_name,$type_name,$product_image,$slide_detail,$slide_image)=mysqli_fetch_row($query_slide)){
			echo "<div class='col-md-6' style='margin-top:20px;'>";
				echo "<p align='center'><b>รูปภาพสไลด์ที่ $number</b></p>";
				if(empty($product_id)){
					$folder='slide';
					$image=$slide_image;
				}else{
					$folder = ($type_name=="เฟิร์น")?"fern":$type_name;
					$folder = ($folder=="กระถาง")?"pots":$folder;
					$image = $product_image;
				}
				//$product_name = (!empty($product_name))?$product_name:"";
	            echo "<img src='../images/$folder/$image' style='width:100%;height:230px' alt='...'>";
	            echo "<div class='col-md-12' style='margin-top:10px;'><p><b>เลือกภาพจากสินค้า : </b></p></div>";
	            echo "<div class='col-md-5'><p><b>เลือหภาพจากบนเครื่อง : </b></p></div><div class='col-md-7'><input type='file' name='image_slide'></div>";
	            echo "<div class='col-md-12'><p><b>คำอธิบายภาพ : </b></p>";
	            echo "<p><textarea class='form-control' name='slide_explan' style='width:100%;height:100px;'></textarea></p>";
	            echo "</div>";;
			echo "</div>";
			$number++;
		}
		echo "<div class='col-md-12' style='margin-top:20px'><p align='center'><button class='btn btn-sm btn-success'>เปลี่ยนภาพสไลด์</button></p></div>";
		
?>
    </div>
</div>
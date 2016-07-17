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
	                  echo "<img src='../images/$path' style='width:100%;height:100%' alt='...'>";
	                  echo "<div class='carousel-caption'>";
	                    echo "<h4>$header_slide</h4>$slide_detail";
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
    <h4>การจัดการภาพไลด์</h4>
    <p><b><font color="red">***</font>คำแนะนำ<font color="red">***</font></b></p>
    <ul>
    	<li>ควรเลือกภาพที่มีขนาดความกว้างมากหว่าความสูง</li>
    	<li>ควรเลือกภาพที่มีขนาดน้อยกว่า 1.5 MB</li>
    </ul>
<?php
		$query_slide=mysqli_query($_SESSION['connect_db'],"SELECT * FROM slide")or die("ERROR : backend slide line 69");
		$number=1;
		echo "<form action='ajax/update_slide.php' method='post' enctype='multipart/form-data'>";
		while(list($slide_id,$slide_image,$header_slide,$slide_detail)=mysqli_fetch_row($query_slide)){
			echo "<div class='col-md-12' style='margin-top:20px;'>";
				echo "<p ><b>รูปภาพสไลด์ที่ $number</b></p>";
				$header_slide = (!empty($header_slide))?$header_slide:"";
				$path =(empty($slide_image))?"icon/no-images.jpg":"slide/$slide_image";
	            echo "<div class='col-md-6'><img src='../images/$path' id='blah$number' style='width:100%;height:230px;margin-bottom:20px;' alt='...'></div>";
	            echo "<div class='col-md-6'>";
	            	echo "<table width='100%'>";
	            		echo "<tr>";
	            			echo "<td><p><b>เลือกภาพไลด์ที่ $number</b></p></td>";
	            			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
	            			echo "<td><p><input type='file' name='image_slide[]' multiple onchange=\"document.getElementById('blah$number').src = window.URL.createObjectURL(this.files[0])\"></p></td>";
	            		echo "</tr>"; 
	            		echo "<tr>";
	            			echo "<td><p><b>หัวข้อภาพที่ $number</b></p></td>";
	            			echo "<td><p><b>&nbsp;:&nbsp;</b></p></td>";
	            			echo "<td><p><input type='text' class='form-control' name='header_slide[]' value='$header_slide'></p></td>";
	            		echo "</tr>";
	            		echo "<tr>";
	            			echo "<td colspan='3'<p><b>คำอธิบายภาพที่ $number</b></p></td>";
	            		echo "</tr>";
	            		echo "<tr>";
	            			echo "<td colspan='3'><p><textarea class='form-control' name='slide_detail[]' style='width:100%;height:100px;'>$slide_detail</textarea></p></td>";
	            		echo "</tr>";
	            	echo "</table>";
		        echo "</div>";
			echo "</div>";
			$number++;
		}
		echo "<div class='col-md-12' style='margin-top:20px'><p align='center'><button type='submit' class='btn btn-sm btn-success'>เปลี่ยนภาพสไลด์</button></p></div>";
		echo "</form>";
		
?>
    </div>
</div>
<?php
	session_start();
	include("../../include/function.php");
	connect_db();
?>
<script>
function delete_quality(quality_id){
    swal({
      title: "ลบหมวดหมู่สินค้า",
      text: "รายการที่เกี่ยวข้องจะถูกลบทั้งหมด คุณต้องการลบเลยใช่ไหม",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "ลบหมวดหมู่สินค้า",
      cancelButtonText: "ยกเลิกการลบ",
      closeOnConfirm: false
    },
    function(){
      window.location = 'ajax/quality_delete.php?delete_quality_id='+quality_id;
    });
}  
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">จัดการสินค้า</a></li>
			<li><a href="#">จัดการหมวดหมู่สินค้า</a></li>

		</ol>
	</div>
</div>
<div class='col-md-6' style="margin-top:20px;">
    <form method="post" action="ajax/quality_insert.php" enctype='multipart/form-data'>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>ฟอร์มเพิ่มหมวดหมู่สินค้า</h3></div>
        <div class="panel-body">
            <table width="90%" align="center">
                <tr>
                    <td width="35%"><p align='right'><b>เลือกประเภทสินค้า : </b>&nbsp;&nbsp;</p></td>
<?php
                    $query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type ")or die("ERROR : backend type_add line 30");
?>
                    <td>
                        <select class="form-control" name="product_type">
<?php
                        while(list($product_type,$type_name)=mysqli_fetch_row($query_type)){
                            echo "<option value='$product_type'>$type_name</option>";
                        }
?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"> &nbsp;</td></tr>   
                <tr>    
                    <td><p align='right'><b>ชื่อหมวดหมู่สินค้า : </b>&nbsp;&nbsp;</p></td>
                    <td>
                        <input type="text" class="form-control" name='quality_name' >
                    </td>
                </tr>
                <tr>    
                    <td colspan="2"><p><b>เลือกรูปภาพหมวดหมู่สินค้า</b></p></td>
                </tr>
                <tr>    
                    <td><p align='center'><b><img src='../images/icon/no-images.jpg' id='blah' width='95' height='95' style='border-radius:100px;border:5px solid #eee;' ></td>
                    <td>
                        <input type="file" name='quality_image' multiple onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    </td>
                </tr>
            </table>
            <p align="right"><input class='btn btn-sm btn-success' type='submit' value="เพิ่มหมวดหมู่สินค้า" style="margin-top:20px;"></p>
        </div>
    </div>
    </form>
</div>
<div class='col-md-6' style="margin-top:20px;">
    <div class="panel panel-default">
        <div class="panel-heading"><h3>รายการประเภทสินค้าและหมวดหมู่สินค้า</h3></div>
        <div class="panel-body">
             แสดงประเภทสินค้าและหมวดหมู่สินค้า <br><br>
<?php
            $query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type ORDER BY product_type ASC")or die("ERROR : backend type_add line 42");
            while(list($product_type,$type_name)=mysqli_fetch_row($query_type)){
                echo "<div class='col-md-12'>";
                    echo "<b>$type_name</b>";
                echo "</div>";
                $query_quality = mysqli_query($_SESSION['connect_db'],"SELECT product_quality,quality_name,quality_type FROM quality WHERE quality_type='$product_type'")or die("ERROR : backend quality_add line 70");
                while(list($product_quality,$quality_name,$quality_type)=mysqli_fetch_row($query_quality)){
                    echo "<div class='col-md-4'>";
                        echo "<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$quality_name</b>";
                    echo "</div>";
                $query_quality_number=mysqli_query($_SESSION['connect_db'],"SELECT COUNT(product_id) FROM product WHERE product_quality='$product_quality' AND product_type='$product_type'")or die("ERROR : backend quality_add line 47");
                list($count)=mysqli_fetch_row($query_quality_number);
                    echo "<div class='col-md-4' >";
                        echo "<b><span class='badge'>$count</span></b>";
                    echo "</div>";
                    echo "<div class='col-md-2' >";
                    echo "<b><button class='btn btn-info btn-sm' quality='button' data-toggle='modal' data-target='#$product_quality' style='padding:0px 3px;'>แก้ไขข้อมูล</button></b>";
                    echo "<form method='post' action='ajax/quality_update.php' enctype='multipart/form-data'>";
                    echo "<div class='modal fade' id='$product_quality' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
                      echo "<div class='modal-dialog' role='document'>";
                        echo "<div class='modal-content'>";
                          echo "<div class='modal-header'>";
                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
                            echo "<h4 class='modal-title' id='myModalLabel'>แก้ไขหมวดหมู่$quality_name</h4>";
                          echo "</div>";
                          echo "<div class='modal-body'>";
                                echo "<table width='90%'>";
                                    echo "<tr>";
                                        echo "<td width='35%'><p align='right'><b>เลือกประเภทสินค้า : </b>&nbsp;&nbsp;</p></td>";
                                        echo "<td>";
                                            echo "<select class='form-control' name='edit_product_type'>";
                                            $edit_query_type = mysqli_query($_SESSION['connect_db'],"SELECT product_type,type_name FROM type ")or die("ERROR : backend type_add line 92");
                                            while(list($edit_product_type,$edit_type_name)=mysqli_fetch_row($edit_query_type)){
                                                $selected= ($quality_type==$edit_product_type)?"selected='selected'":"";
                                                echo "<option value='$edit_product_type' $selected>$edit_type_name</option>";
                                            }
                                            echo "</select>";
                                        echo "</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    $query_typeanme = mysqli_query($_SESSION['connect_db'],"SELECT quality_name,quality_image FROM quality WHERE product_quality ='$product_quality'")or die("ERROR : backend type_edit line 54");
                                    list($quality_name,$quality_image)=mysqli_fetch_row($query_typeanme);
                                        echo "<td><p align='right'><b>ชื่อหมวดหมู่สินค้า : </b>&nbsp;&nbsp;</p></td>";
                                        echo "<td><input class='form-control' type='text' name='quality_name' value='$quality_name'></td>";
                                        echo "<input type='hidden' name='quality_id' value='$product_quality'>";
                                    echo "</tr>";

                                    echo "<tr> ";   
                                        echo "<td colspan='2'><p><b>เลือกรูปภาพหมวดหมู่สินค้า</b></p></td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                        $quality_img = (empty($quality_image))?"no-images.jpg":$quality_image;
                                        echo "<td><p align='center'><b><img src='../images/icon/$quality_img' id='blah_$product_quality'  width='95' height='95' style='border-radius:100px;border:5px solid #eee;' ></td>";
                                        echo "<td>";
                                            echo "<input type='file' name='quality_image'  multiple onchange=\"document.getElementById('blah_$product_quality').src = window.URL.createObjectURL(this.files[0])\" >";
                                        echo "</td>";
                                    echo "</tr>";

                                echo "</table>";
                          echo "</div>";
                          echo "<div class='modal-footer'>";
                            echo "<button type='submit' class='btn btn-primary'>แก้ไขหมวดหมู่</button>";
                            echo "<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>";
                          echo "</div>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                    echo "</form>";
                    echo "</div>";
                    echo "<div class='col-md-2'>";
                        echo "<b><a  onclick='delete_quality($product_quality)'><button class='btn btn-danger btn-sm' type='button' style='padding:0px 3px;'>ลบข้อมูล</button></a></b>";
                    echo "</div>";
                }
            }
?>
        </div>
    </div>
</div>
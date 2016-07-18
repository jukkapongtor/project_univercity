<?php
    session_start();
    echo "<meta charset='utf8'>";
    include("../../include/function.php");
    connect_db();
?>
<head>
    <title></title>
</head>
<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <a href="#" class="show-sidebar">
            <i class="fa fa-bars"></i>
        </a>
        <ol class="breadcrumb pull-left">
            <li><a href="#">จัดการข้อมูลพนักงาน</a></li>
            <li><a href="#">ข้อมูลพนักงาน</a></li>
            <li><a href="#">เพิ่มข้อมูลพนักงาน</a>

        </ol>
    </div>
</div>

<body>

    <form action="ajax/employee_insert.php" method="POST" enctype="multipart/form-data">

        
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">เพิ่มข้อมูลพื้นฐาน</h3>
            </div>
            <div class="panel-body">
                <div class="container-fluid" style="padding:0px">
                <div class="col-md-9">
         <!--______________________________________________________________________________-->  
                    <table>  
                    <tr>
                    <td style="padding:10px;" >คำนำหน้าชื่อ : </td> 
                    <td style="padding:10px;">
                        <input type="radio" name="titlename" value="นาย" >นาย
                        <input type="radio" name="titlename" value="นาง" >นาง
                        <input type="radio" name="titlename" value="นางสาว" >นางสาว
                    </td>
                    </tr>
                
         <!--______________________________________________________________________________-->
                    <tr>
                        <td style="padding:10px;">ชื่อภาษาไทย : </td>
                        <td style="padding:10px;" >
                            <input type="text" class="form-control" name="name_thai" required>
                        </td>
                        <td style="padding:10px;">นามสกุลภาษาไทย : </td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="surname_thai" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;">ชื่อภาษาอังกฤษ : </td>
                        <td style="padding:10px;" >
                            <input type="text" class="form-control" name="name_eng" required>
                        </td>
                        <td style="padding:10px;">นามสกุลภาษาอังกฤษ : </td>
                        <td style="padding:10px;" >
                            <input type="text" class="form-control" name="surname_eng" required>
                        </td>
                    </tr>
         <!--______________________________________________________________________________-->  
                <tr>
                    <td style="padding:10px;">รหัสบัตรประชาชน : </td>
                    <td style="padding:10px;">
                        <input type="text" class="form-control" name="id_card" required>
                    </td>
                    <td style="padding:10px;">เลือกรูปภาพ : </td>
                    <td style="padding:10px;" >
                        <input  type="file" name="employee_img"  multiple onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    </td>
                </tr> 
                 <tr>
                    <td style="padding:10px;">เบอร์โทรศัพท์ : </td>
                    <td style="padding:10px;">
                        <input type="text" class="form-control" name="phone_number" required>
                    </td>
                </tr> 
                <tr>
                    <td style="padding:10px;">อีเมล์ : </td>
                    <td style="padding:10px;">
                        <input type="text" class="form-control" name="email" >
                    </td>
                </tr> 
         <!--______________________________________________________________________________-->
                    </table>
                </div>
                <div class="col-md-3">
                    <img id='blah' src="../images/icon/no-images.jpg" style="border:1px solid #000;width:100%;height:300px">
                </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">เพิ่มข้อมูลส่วนตัว</h3>
            </div>
            <div class="panel-body">
            <table>
                <tr>
                    <td style="padding:10px;">วันเกิด : </td>
                    <td style="padding: 10px;">
                        <input type="text" class="form-control " id="datepicker" name="birth_date">
                    </td>
                
                    <td style="padding: 10px;">หมู่โลหิต :</td>
                    <td style="padding: 10px;">
                        <select class="form-control" name="blood_group"  required>
                            <option value="ไม่ระบุ" >ไม่ระบุ</option>
                            <option value="A" >A</option>
                            <option value="B" >B</option>
                            <option value="O" >O</option>
                            <option value="AB" >AB</option>
                        </select>
                    </td>

                    <td style="padding: 10px">สัญชาติ :</td>
                    <td style="padding: 10px;">
                        <select name="personnel_nationality"  class="form-control" required>
                          <option value="ไทย">ไทย</option>
                          <option value="กัมพูชา">กัมพูชา</option>
                          <option value="ลาว">ลาว</option>
                          <option value="พม่า">พม่า</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px">เชื้อชาติ :</td>
                    <td style="padding: 10px;">
                        <select name="personnel_race"  class="form-control" required>
                          <option value="ไทย">ไทย</option>
                          <option value="ลาว">ลาว</option>
                          <option value="จีน ">จีน </option> 
                          <option value="มาลายู ">มาลายู </option> 
                          <option value="มอญ ">มอญ </option>
                          <option value="ขะเเมร์ ">ขะเเมร์ </option> 
                          <option value="ไทใหญ่">ไทใหญ่</option>
                          <option value="ชาวเขา">ชาวเขา</option>
                          <option value="จามเวียต">จามเวียต</option> 
                          <option value="เมียนมาร์">เมียนมาร์</option>
                          <option value="เวียต">เวียต</option>
                          <option value="จามส่วย">จามส่วย</option>
                          <option value="ลาวลุ่ม">ลาวลุ่ม</option>
                          <option value="ลาวเทิง">ลาวเทิง</option>
                          <option value="ลาวสูง">ลาวสูง</option>
                          <option value="กระเหรี่ยง">กระเหรี่ยง</option>
                          <option value="ว้า" >ว้า</option>
                          <option value="ยะไข่" >ยะไข่</option>
                        </select>
                    </td>
               
                    <td style="padding: 10px">ศาสนา :</td>
                    <td style="padding: 10px;">
                        <select name="religious"  class="form-control">
                              <option value="ไม่ระบุ">ไม่ระบุ</option>
                              <option value="พุทธ">พุทธ</option>
                              <option value="อิสลาม">อิสลาม</option>
                              <option value="คริสต์">คริสต์</option>
                              <option value="ฮินดู">ฮินดู</option>
                              <option value="ลัทธิขงจื๊อ">ลัทธิขงจื๊อ</option>
                        </select>
                    </td>
                </tr>
            </table>
        <hr style="border-width: 2px;" >
            <table>   
                <tr>
                    <td style="padding: 10px">สถานะภาพ :</td>
                    <td style="padding: 10px;">
                        <select class="form-control" name="mate_status" required="">
                            <option value="ไม่ระบุ">ไม่ระบุ</option>
                            <option value="โสด">โสด</option>
                            <option value="สมรส">สมรส</option>
                            <option value="หย่าร้าง">หย่าร้าง</option>
                            <option value="หม้าย">หม้าย</option>
                        </select>  
                        
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px">ชื่อคู่สมรส :</td>
                    <td style="padding: 10px;">
                        <input type="text" class="form-control" name="mate_name" >
                    </td>
                </tr>
 
            </table> 
            <!--______________________________________________________________________________-->
            </div>
        </div>

         <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">ที่อยู่ตามทะเบียนบ้าน</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td style="padding:10px; width: 15%; " >บ้านเลขที่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="address_hrt">
                        </td>
                    
                        <td style="padding:10px;" >หมู่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village_no_hrt">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ชื่อหมู่บ้าน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village_hrt">
                        </td>
                   
                        <td style="padding:10px;" >ชื่อซอย :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="alley_hrt">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ถนน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="road_hrt">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >จังหวัด :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_provinces" name="province_hrt">
                            <option value='null'>เลือกจังหวัด</option>
<?php
                        $query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces")or die("ERROR : users function line 233");
                        while(list($province_id,$province_name)=mysqli_fetch_row($query_provinces)){
                            if($province==$province_name){
                                echo "<option value='$province_id' selected='selected'>$province_name</option>";
                                $isset_province = $province_id;
                            }else{
                                echo "<option value='$province_id'>$province_name</option>";
                            }
                            
                        }
?>   
                            </select>
                        </td>
                    
                    
                        <td style="padding:10px;" >เขต/อำเภอ :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_districts" name="districts_hrt">
                                <option value='null'>เลือกอำเภอ</option>
                           </select> 
                        </td>
                    </tr>
                     <tr>
                        <td style="padding:10px;" >แขวง/ตำบล :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_subdistricts" name="subdistrict_hrt" >
                                <option value='null'>เลือกตำบล</option>
                            </select>
                        </td>
                        <td style="padding:10px;">รหัสไปรษณีย์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" id="zipcode" name="zipcode_hrt">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;">เบอร์โทรศัพท์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" name="phone_hrt">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

         <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">ที่อยู่ที่ติดต่อได้</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td style="padding:10px;" >บ้านเลขที่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="address_number">
                        </td>
                        <td style="padding:10px;" >หมู่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village_no">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ชื่อหมู่บ้าน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village">
                        </td>
                        <td style="padding:10px;" >ชื่อซอย :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="alley">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ถนน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="road">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >จังหวัด :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_provinces2" name="province">
                            <option value='null'>เลือกจังหวัด</option>
<?php
                        $query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces")or die("ERROR : users function line 233");
                        while(list($province_id,$province_name)=mysqli_fetch_row($query_provinces)){
                            if($province==$province_name){
                                echo "<option value='$province_id' selected='selected'>$province_name</option>";
                                $isset_province = $province_id;
                            }else{
                                echo "<option value='$province_id'>$province_name</option>";
                            }
                            
                        }
?>   
                            </select>
                        </td>
                        <td style="padding:10px;" >เขต/อำเภอ :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_districts2" name="districts">
                                <option value='null'>เลือกอำเภอ</option>
                           </select> 
                        </td>
                    </tr>
                     <tr>
                        <td style="padding:10px;" >แขวง/ตำบล :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_subdistricts2" name="subdistrict" >
                                <option value='null'>เลือกตำบล</option>
                            </select>
                        </td>
                        <td style="padding:10px;">รหัสไปรษณีย์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" id="zipcode2" name="zipcode">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;">เบอร์โทรศัพท์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" name="phone">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

         <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">ติดต่อฉุกเฉิน</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td style="padding:10px;" >คำนำหน้าชื่อ : </td> 
                        <td style="padding:10px;">
                            <input type="radio" name="titlename_er" value="นาย" >นาย
                            <input type="radio" name="titlename_er" value="นาง" >นาง
                            <input type="radio" name="titlename_er" value="นางสาว" >นางสาว
                        </td>
                    </tr>
            
         <!--______________________________________________________________________________-->
                    <tr>
                        <td style="padding:10px;">ชื่อ-นามสกุล : </td>
                        <td style="padding:10px;" >
                            <input type="text" class="form-control" name="name_er" required>
                       
                    </tr>
                    <tr>
                        <td style="padding: 10px;">เบอร์โทรศัพท์ :</td>
                        <td style="padding: 10px;">
                            <input type="text" class="form-control" name="phone_er" required>
                        </td>
                         <td style="padding: 10px;">สถานะ :</td>
                        <td style="padding: 10px;"> 
                            <input type="text" class="form-control" name="status_er" required>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
            <div class="col-md-12"  align="right" style="margin-top: 10px;" >
                 <button type="button" class="btn btn-default" >Close</button>
                 <button type="submit" class="btn btn-primary">Save</button>
            </div>
    
    </form>
<script type="text/javascript">
$( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange:"c-30:c+0"
    });

$(document).ready(function() {
        $('#select_provinces').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $(this).val()},
                url: '../module/index.php?data=provinces',
                success: function(data) {$('#select_districts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_provinces:"null",select_districts:"null"},
                url: '../module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_districts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $('#select_provinces').val(),select_districts: $(this).val()},
                url: '../module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });
        $('#select_subdistricts').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_districts: $(this).val()},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode').val(data);}
            });
            return false;
        });

        $('#select_provinces2').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $(this).val()},
                url: '../module/index.php?data=provinces',
                success: function(data) {$('#select_districts2').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_provinces:"null",select_districts:"null"},
                url: '../module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts2').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode2').val(data);}
            });
            return false;
        });
        $('#select_districts2').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_provinces: $('#select_provinces2').val(),select_districts: $(this).val()},
                url: '../module/index.php?data=districts',
                success: function(data) {$('#select_subdistricts2').html(data);}
            });
            $.ajax({
                type: 'POST',
                data: {select_districts:"null"},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode2').val(data);}
            });
            return false;
        });
        $('#select_subdistricts2').change(function() {
            $.ajax({
                type: 'POST',
                data: {select_districts: $(this).val()},
                url: '../module/index.php?data=zipcode',
                success: function(data) {$('#zipcode2').val(data);}
            });
            return false;
        });

});
</script>
</body>


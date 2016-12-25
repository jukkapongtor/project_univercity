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
            <li><a href="#">แก้ไขข้อมูลพนักงาน</a>
        </ol>
    </div>
</div>

<body>

<?php
        $edit_em = mysqli_query($_SESSION['connect_db'], "SELECT employee_id, employee_img, titlename, name_thai, surname_thai, name_eng, surname_eng, id_card, phone_number, email, birth_date, blood_group, personnel_nationality, personnel_race, religious, mate_status, mate_name, address_hrt, village_no_hrt, village_hrt, alley_hrt, road_hrt, province_hrt, districts_hrt, subdistrict_hrt, zipcode_hrt, phone_hrt, address_number, village_no, village, alley, road, province, districts, subdistrict, zipcode, phone, titlename_er, name_er, phone_er, status_er FROM employee WHERE employee_id='$_GET[employee_id]' ") or die("ERROR : employee_fromupdate line 30");

         list($employee_id, $employee_img, $titlename, $name_thai, $surname_thai, $name_eng, $surname_eng, $id_card, $phone_number, $email, $birth_date, $blood_group, $personnel_nationality, $personnel_race, $religious, $mate_status, $mate_name, $address_hrt, $village_no_hrt, $village_hrt, $alley_hrt, $road_hrt, $province_hrt, $districts_hrt, $subdistrict_hrt, $zipcode_hrt, $phone_hrt, $address_number, $village_no, $village, $alley, $road, $province, $districts, $subdistrict, $zipcode, $phone, $titlename_er, $name_er, $phone_er, $status_er)=mysqli_fetch_row($edit_em)

    
?>

    <form action="ajax/employee_update.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="employee" value="<?php echo "$employee_id"; ?>" >

        <br>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">แก้ไขข้อมูลพื้นฐาน</h3>
            </div>
            <div class="panel-body">
            <div class="container-fluid" style="padding:0px">
                <div class="col-md-9">
         <!--______________________________________________________________________________-->  
                <table>  
                <tr>
                <td style="padding:10px;" >คำนำหน้าชื่อ : </td> 
                <td style="padding:10px;">
<?php
                    if ($titlename=="นาย") {

                        $chk1 = "checked='checked'" ;
                        $chk2="";
                        $chk3="";
                    }else if ($titlename=="นาง") {
                        
                        $chk2 = "checked='checked'" ;
                        $chk1="";
                        $chk3="";
                    }elseif ($titlename=="นางสาว") {
                        $chk3 = "checked='checked'" ;
                        $chk1="";
                        $chk2="";
                    
                    }else{
                        $chk1="";
                        $chk2="";
                        $chk3="";
                    }

?>

                    <input type="radio" name="titlename" value="นาย" <?php echo "$chk1"; ?>>นาย
                    <input type="radio" name="titlename" value="นาง" <?php echo "$chk2"; ?>>นาง
                    <input type="radio" name="titlename" value="นางสาว" <?php echo "$chk3"; ?>>นางสาว
                </td>
                </tr>
            
         <!--______________________________________________________________________________-->
                <tr>
                    <td style="padding:10px;">ชื่อภาษาไทย : </td>
                    <td style="padding:10px;" >
                        <input type="text" class="form-control" name="name_thai"  value="<?php echo "$name_thai"; ?>"required>
                    </td>
                    <td style="padding:10px;">นามสกุลภาษาไทย : </td>
                    <td style="padding:10px;">
                        <input type="text" class="form-control" name="surname_thai" value="<?php echo "$surname_thai"; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;">ชื่อภาษาอังกฤษ : </td>
                    <td style="padding:10px;" >
                        <input type="text" class="form-control" name="name_eng" value="<?php echo "$name_eng"; ?>" required>
                    </td>
                     <td style="padding:10px;">นามสกุลภาษาอังกฤษ : </td>
                    <td style="padding:10px;" >
                        <input type="text" class="form-control" name="surname_eng" value="<?php echo "$surname_eng"; ?>" required>
                    </td>
                </tr>
            <!--______________________________________________________________________________-->  
            <tr>
                <td style="padding:10px;">รหัสบัตรประชาชน : </td>
                <td style="padding:10px;">
                    <input type="text" class="form-control" name="id_card" value="<?php echo "$id_card"; ?>" required>
                </td>
                <td style="padding:10px;">เลือกรูปภาพ : </td>
                <td style="padding:10px;" >
                    <input  type="file" name="employee_img"  multiple onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                </td>
            </tr> 
             <tr>
                <td style="padding:10px;">เบอร์โทรศัพท์ : </td>
                <td style="padding:10px;">
                    <input type="text" class="form-control" name="phone_number" value="<?php echo "$phone_number"; ?>" required>
                </td>
            </tr> 
            <tr>
                <td style="padding:10px;">อีเมล์ : </td>
                <td style="padding:10px;">
                    <input type="text" class="form-control" name="email" value="<?php echo "$email"; ?>">
                </td>
            </tr> 
         <!--______________________________________________________________________________-->
                </table>
                </div>
                <div class="col-md-3">
                <?php
                    $path = (empty($employee_img))?"icon/no-images.jpg":"employee/$employee_img";
                    echo "<img id='blah' src='../images/$path' style='border:1px solid #000;width:100%;height:300px'>";
                ?>
                </div>
            </div>
        </div>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">แก้ไขข้อมูลส่วนตัว</h3>
            </div>
            <div class="panel-body">
            <table>
                <tr>
                    <td style="padding:10px;">วันเกิด : </td>
                    <td style="padding: 10px;">
                    <?php
                        $day = substr($birth_date,8,10);
                        $month = substr($birth_date,5,2);
                        $year = substr($birth_date,0,4);
                        $birth_date = "$day/$month/$year";
                    ?>
                        <input type="text" class="form-control " id="datepicker" name="birth_date" value="<?php echo "$birth_date"; ?>" >
                    </td>
                
                    <td style="padding: 10px;">หมู่โลหิต :</td>
                    <td style="padding: 10px;">


                        <select class="form-control" name="blood_group"  required>
<?php
                       $blood = array("ไม่ระบุ","A","B","O","AB");

                        for ($i=0; $i <count($blood) ; $i++) { 
                            $selected=($blood_group == $blood[$i])?"selected='selected'":"";
                            echo "<option value='$blood[$i]' $selected>$blood[$i]</option>";     
                        }
?>
                        </select>
                    </td>

                    <td style="padding: 10px">สัญชาติ :</td>
                    <td style="padding: 10px;">
                        <select name="personnel_nationality"  class="form-control" required>
<?php
                       $pn = array("ไทย","กัมพูชา","ลาว","พม่า");

                        for ($i=0; $i <count($pn) ; $i++) { 
                            $selected=($personnel_nationality == $pn[$i])?"selected='selected'":"";
                            echo "<option value='$pn[$i]' $selected>$pn[$i]</option>";     
                        }
?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px">เชื้อชาติ :</td>
                    <td style="padding: 10px;">
                        <select name="personnel_race"  class="form-control" required>
<?php
                       $prace = array("ไทย","ลาว","จีน","มาลายู","มอญ","ขะเเมร์","ไทใหญ่","ชาวเขา","จามเวียต","เมียนมาร์","เวียต","จามส่วย","ลาวลุ่ม","ลาวเทิง","ลาวสูง","กระเหรี่ยง","ว้า","ยะไข่");

                        for ($i=0; $i <count($prace) ; $i++) { 
                            $selected=($personnel_race == $prace[$i])?"selected='selected'":"";
                            echo "<option value='$prace[$i]' $selected>$prace[$i]</option>";     
                        }
?>                        
                        </select>
                    </td>
               
                    <td style="padding: 10px">ศาสนา :</td>
                    <td style="padding: 10px;">
                        <select name="religious"  class="form-control">
<?php
                       $re = array("ไม่ระบุ","พุทธ","อิสลาม","คริสต์","ฮินดู","ลัทธิขงจื๊อ");

                        for ($i=0; $i <count($re) ; $i++) { 
                            $selected=($religious == $re[$i])?"selected='selected'":"";
                            echo "<option value='$re[$i]' $selected>$re[$i]</option>";     
                        }
?>     
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
                        <?php
                       $ms = array("ไม่ระบุ","โสด","สมรส","หย่าร้าง","หม้าย");

                        for ($i=0; $i <count($ms) ; $i++) { 
                            $selected=($mate_status == $ms[$i])?"selected='selected'":"";
                            echo "<option value='$ms[$i]' $selected>$ms[$i]</option>";     
                        }
?>     
                        </select>  
                        
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px">ชื่อคู่สมรส :</td>
                    <td style="padding: 10px;">
                        <input type="text" class="form-control" name="mate_name" value="<?php echo "$mate_name"; ?>" >
                    </td>
                </tr>
 
            </table> 
            <!--______________________________________________________________________________-->
            </div>
        </div>

         <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">แก้ไขที่อยู่ตามทะเบียนบ้าน</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td style="padding:10px; width: 15%; " >บ้านเลขที่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="address_hrt" value="<?php echo "$address_hrt"; ?>" >
                        </td>
                    
                        <td style="padding:10px;" >หมู่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village_no_hrt" value="<?php echo "$village_no_hrt"; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ชื่อหมู่บ้าน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village_hrt" value="<?php echo "$village_hrt"; ?>" >
                        </td>
                   
                        <td style="padding:10px;" >ชื่อซอย :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="alley_hrt" value="<?php echo "$alley_hrt"; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ถนน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="road_hrt" value="<?php echo "$road_hrt"; ?>" >
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
                            if($province_hrt==$province_id){
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
                                
<?php
                    if(empty($districts_hrt)){
                        echo "<option value='null'>เลือกอำเภอ</option>";
                    }else{
                        $query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province'")or die("ERROR : users function line 259");
                        while(list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict)){
                            if($districts_hrt == $amphure_id){
                                echo "<option value='$amphure_id' selected='selected'>$amphure_name</option>";
                                $isset_district = $amphure_id;
                            }else{
                                echo "<option value='$amphure_id'>$amphure_name</option>";
                            }
                        }
                    }   
?>   

                           </select> 
                        </td>
                    </tr>
                     <tr>
                        <td style="padding:10px;" >แขวง/ตำบล :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_subdistricts" name="subdistrict_hrt" >
<?php
                            if(empty($subdistrict_hrt)){
                        echo "<option value='null'>เลือกตำบล</option>";
                    }else{
                        $query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district'")or die("ERROR : users function line 259");
                        while(list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict)){
                            if($subdistrict_hrt == $disrtict_code){
                                echo "<option value='$disrtict_code' selected='selected'>$disrtict_name</option>";
                            }else{
                                echo "<option value='$disrtict_code'>$disrtict_name</option>";
                            }
                        }
                    }
?>
                            </select>
                        </td>
                        <td style="padding:10px;">รหัสไปรษณีย์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" id="zipcode" name="zipcode_hrt" value="<?php echo "$zipcode_hrt"; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;">เบอร์โทรศัพท์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" name="phone_hrt" value="<?php echo "$phone_hrt"; ?>" >
                        </td>
                    </tr>
                </table>
            </div>
        </div>

         <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">แก้ไขที่อยู่ที่ติดต่อได้</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td style="padding:10px;" >บ้านเลขที่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="address_number" value="<?php echo "$address_number"; ?>" >
                        </td>
                        <td style="padding:10px;" >หมู่ :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village_no" value="<?php echo "$village_no"; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ชื่อหมู่บ้าน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="village" value="<?php echo "$village"; ?>" >
                        </td>
                        <td style="padding:10px;" >ชื่อซอย :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="alley" value="<?php echo "$alley"; ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;" >ถนน :</td>
                        <td style="padding:10px;">
                            <input type="text" class="form-control" name="road" value="<?php echo "$road"; ?>">
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
                            if($province==$province_id){
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
 <?php
                    if(empty($districts)){
                        echo "<option value='null'>เลือกอำเภอ</option>";
                    }else{
                        $query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province'")or die("ERROR : users function line 259");
                        while(list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict)){
                            if($districts == $amphure_id){
                                echo "<option value='$amphure_id' selected='selected'>$amphure_name</option>";
                                $isset_district = $amphure_id;
                            }else{
                                echo "<option value='$amphure_id'>$amphure_name</option>";
                            }
                        }
                    }   
?>   
                           </select> 
                        </td>
                    </tr>
                     <tr>
                        <td style="padding:10px;" >แขวง/ตำบล :</td>
                        <td style="padding:10px;">
                            <select class="form-control" id="select_subdistricts2" name="subdistrict" >
 <?php
                            if(empty($subdistrict)){
                        echo "<option value='null'>เลือกตำบล</option>";
                    }else{
                        $query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district'")or die("ERROR : users function line 259");
                        while(list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict)){
                            if($subdistrict == $disrtict_code){
                                echo "<option value='$disrtict_code' selected='selected'>$disrtict_name</option>";
                            }else{
                                echo "<option value='$disrtict_code'>$disrtict_name</option>";
                            }
                        }
                    }
?>
                            </select>
                        </td>
                        <td style="padding:10px;">รหัสไปรษณีย์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" id="zipcode2" name="zipcode" value="<?php echo "$zipcode"; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px;">เบอร์โทรศัพท์ :</td>
                        <td style="padding:10px;">
                            <input class="form-control" tyle="text" name="phone" value="<?php echo "$phone"; ?>">
                        </td>
                    </tr>
                </table>
            </div>
        </div>

         <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">ติดต่อฉุกเฉิน</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
<?php
                    if ($titlename_er=="นาย") {

                        $chk1 = "checked='checked'" ;
                        $chk2="";
                        $chk3="";
                    }else if ($titlename_er=="นาง") {
                        
                        $chk2 = "checked='checked'" ;
                        $chk1="";
                        $chk3="";
                    }elseif ($titlename_er=="นางสาว") {
                        $chk3 = "checked='checked'" ;
                        $chk1="";
                        $chk2="";
                    
                    }else{
                        $chk1="";
                        $chk2="";
                        $chk3="";
                    }

?>
                        <td style="padding:10px;" >คำนำหน้าชื่อ : </td> 
                        <td style="padding:10px;">
                            <input type="radio" name="titlename_er" value="นาย" <?php echo "$chk1"; ?> >นาย
                            <input type="radio" name="titlename_er" value="นาง" <?php echo "$chk2"; ?>>นาง
                            <input type="radio" name="titlename_er" value="นางสาว" <?php echo "$chk3"; ?> >นางสาว
                        </td>
                    </tr>
            
         <!--______________________________________________________________________________-->
                    <tr>
                        <td style="padding:10px;">ชื่อ-นามสกุล : </td>
                        <td style="padding:10px;" >
                            <input type="text" class="form-control" name="name_er" value="<?php echo "$name_er"; ?>" required>
                        </td>
                    
                    </tr>
                    <tr>
                        <td style="padding: 10px;">เบอร์โทรศัพท์ :</td>
                        <td style="padding: 10px;">
                            <input type="text" class="form-control" name="phone_er" value="<?php echo "$phone_er"; ?>" required>
                        </td>
                         <td style="padding: 10px;">สถานะ :</td>
                        <td style="padding: 10px;"> 
                            <input type="text" class="form-control" name="status_er" value="<?php echo "$status_er"; ?>" required>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
            <div class="col-md-12"  align="right" style="margin-top: 10px;" >
                 <button type="submit" class="btn btn-primary">แก้ไข</button>
            </div>
    
    </form>
<script type="text/javascript">
$( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange:"c-10:c+20"
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


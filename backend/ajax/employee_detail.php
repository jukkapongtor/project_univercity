<?php
    session_start();
    echo "<meta charset='utf8'>";
    include("../../include/function.php");
    connect_db();
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#profile').click(function(){
            var employee_id = document.getElementById('employee_id').value;
            alert(employee_id);
            $.post('ajax/function.php?data=profile',{employee_id:employee_id},function(data){
                $('#employee-detail').html(data);
            });
        });
        $('#salary').click(function(){
            var employee_id = document.getElementById('employee_id').value;
            $.post('ajax/function.php?data=salary',{employee_id:employee_id},function(data){
                $('#employee-detail').html(data);
            });
        });
    });
</script>
<?php
$edit_em = mysqli_query($_SESSION['connect_db'], "SELECT employee_id, employee_img, titlename, name_thai, surname_thai, name_eng, surname_eng, id_card, phone_number, email, birth_date, blood_group, personnel_nationality, personnel_race, religious, mate_status, mate_name, address_hrt, village_no_hrt, village_hrt, alley_hrt, road_hrt, province_hrt, districts_hrt, subdistrict_hrt, zipcode_hrt, phone_hrt, address_number, village_no, village, alley, road, province, districts, subdistrict, zipcode, phone, titlename_er, name_er, phone_er, status_er FROM employee WHERE employee_id='$_GET[employee_id]' ") or die("ERROR : employee_fromupdate line 30");

         list($employee_id, $employee_img, $titlename, $name_thai, $surname_thai, $name_eng, $surname_eng, $id_card, $phone_number, $email, $birth_date, $blood_group, $personnel_nationality, $personnel_race, $religious, $mate_status, $mate_name, $address_hrt, $village_no_hrt, $village_hrt, $alley_hrt, $road_hrt, $province_hrt, $districts_hrt, $subdistrict_hrt, $zipcode_hrt, $phone_hrt, $address_number, $village_no, $village, $alley, $road, $province, $districts, $subdistrict, $zipcode, $phone, $titlename_er, $name_er, $phone_er, $status_er)=mysqli_fetch_row($edit_em)


?>
<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <a href="#" class="show-sidebar">
            <i class="fa fa-bars"></i>
        </a>
        <ol class="breadcrumb pull-left">
            <li><a href="#">จัดการข้อมูลพนักงาน</a></li>
            <li><a href="#">ข้อมูลพนักงาน</a></li>
            <li><a href="#">รายละเอียดพนักงาน <?php echo "\"$name_thai $surname_thai\""; ?></a>

        </ol>
        <div id="social" class="pull-right">
            <a href="#"><i class="fa fa-facebook"></i></a>
        </div>
    </div>
</div>

<!--______________________________________________________________________________________-->
    <input type="hidden" id="employee_id" value="<?php echo "$employee_id"; ?>" >
    <div class="col-md-8" id="employee-detail" >    
        <div class="panel panel-info" style="width:100% " >
            <div class="panel-heading">
            
                <h3 class="panel-title">ประวัติส่วนตัว</h3>
            </div>
            <div class="panel-body">
         <!--______________________________________________________________________________-->  
                 
                <div class="col-md-12" style="margin-top:20px;">
                    <table align="center" width="100%">  
                        <tr>
                            <td width="50%" align="right" style="padding:10px;">ชื่อ-นามสกุล : </td>
                            <td style="padding:10px;" >
                                <?php echo "$titlename$name_thai  $surname_thai"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="padding:10px;">ชื่อ-นามสกุล(อังกฤษ) : </td>
                            <td style="padding:10px;" >
                                <?php echo "$name_eng $surname_eng"; ?>
                            </td>
                        </tr> 
            <!--______________________________________________________________________________-->  
                        <tr>
                            <td align="right" style="padding:10px;">รหัสบัตรประชาชน : </td>
                            <td style="padding:10px;">
                                <?php echo "$id_card"; ?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="right" style="padding:10px;">เบอร์โทรศัพท์ : </td>
                            <td style="padding:10px;">
                               <?php echo "$phone_number"; ?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="right" style="padding:10px;">อีเมล์ : </td>
                            <td style="padding:10px;">
                                <?php echo "$email"; ?>
                            </td>
                        </tr> 
         <!--______________________________________________________________________________-->
                    </table>
                </div>
        

<!--______________________________________________-->
    
    <div class="col-md-12">
        <hr style="border-width: 2px;" >
            <table align="center" width="100%">
                <tr>
                    <td width="50%" align="right" style="padding:10px;">วันเกิด : </td>
                    <td style="padding: 10px;">
                        <?php echo "$birth_date"; ?>
                    </td>
                </tr>
                <tr>                
                    <td align="right" style="padding: 10px;">หมู่โลหิต :</td>
                    <td style="padding: 10px;">
                        <?php echo "$blood_group";?>
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">สัญชาติ :</td>
                    <td style="padding: 10px;">
                        <?php echo "$personnel_nationality";?>
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">เชื้อชาติ :</td>
                    <td style="padding: 10px;">
                       <?php echo "$personnel_race"; ?>                        
                    </td>
                </tr>

                <tr>
                    <td align="right" style="padding: 10px">ศาสนา :</td>
                    <td style="padding: 10px;">
                        <?php echo "$religious";?>     
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">สถานะภาพ :</td>
                    <td style="padding: 10px;">
                       <?php echo "$mate_status ";?>     
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 10px">ชื่อคู่สมรส :</td>
                    <td style="padding: 10px;">
                        <?php echo "$mate_name"; ?>
                    </td>
                </tr>
            </table>
    </div>


        <div class="col-md-12">
            <hr style="border-width: 2px;" >
                <table width="100%">
                    <tr>
                        <td width="50%" align="right" style="padding:10px;" >บ้านเลขที่(ตามทะเบียนบ้าน) :</td>
                        <td width="50%" style="padding:10px;">
                            <?php echo "$address_hrt";?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >หมู่(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village_no_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >ชื่อหมู่บ้าน(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >ชื่อซอย(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                           <?php echo "$alley_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >ถนน(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$road_hrt"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding:10px;" >จังหวัด(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            
<?php
                        $query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces WHERE PROVINCE_ID='$province_hrt'")or die("ERROR : employee detail line 190");
                        list($province_id,$province_name)=mysqli_fetch_row($query_provinces);
                                echo "$province_name";
                                $isset_province = $province_id;
                            
                        
?>   
                        </td>
                    </tr>
                    <tr>                    
                        <td align="right" style="padding:10px;" >เขต/อำเภอ(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
<?php
                   
                        $query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$districts_hrt'")or die("ERROR :employee detail line 206");
                        list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict);
                                echo "$amphure_name";
                                $isset_district = $amphure_id;
?>   
                        </td>
                    </tr>

                    <tr>
                        <td align="right" style="padding:10px;" >แขวง/ตำบล(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            
<?php
                        $query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district' AND DISTRICT_CODE='$subdistrict_hrt'")or die("ERROR : employee detail line 219");
                        list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict);
                            echo "$disrtict_name";      
?>
                        </td>
                    </tr>

                    <tr>

                        <td align="right" style="padding:10px;">รหัสไปรษณีย์(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$zipcode_hrt"; ?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" style="padding:10px;">เบอร์โทรศัพท์(ตามทะเบียนบ้าน) :</td>
                        <td style="padding:10px;">
                            <?php echo "$phone_hrt"; ?>
                        </td>
                    </tr>
                </table>
            </div>

        <div class="col-md-12">  
            <hr style="border-width: 2px;" >
               <table width="100%">
                    <tr>
                        <td align="right" width="50%" style="padding:10px;" >บ้านเลขที่(ใช้ติดต่อ) :</td>
                        <td width="50%" style="padding:10px;">
                            <?php echo "$address_number"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >หมู่(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village_no"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >ชื่อหมู่บ้าน(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$village"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >ชื่อซอย(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                           <?php echo "$alley"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >ถนน(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                           <?php echo "$road"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >จังหวัด(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
<?php
                      $query_provinces = mysqli_query($_SESSION['connect_db'],"SELECT PROVINCE_ID,PROVINCE_NAME FROM provinces WHERE PROVINCE_ID='$province'")or die("ERROR : employee detail line 190");
                        list($province_id,$province_name)=mysqli_fetch_row($query_provinces);
                                echo "$province_name";
                                $isset_province = $province_id;
?>   
                        </td>
                    </tr>
                    <tr>    
                        <td  align="right" style="padding:10px;" >เขต/อำเภอ(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
<?php
                     $query_disrtict = mysqli_query($_SESSION['connect_db'],"SELECT AMPHUR_ID,AMPHUR_NAME FROM amphures WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$districts'")or die("ERROR :employee detail line 206");
                        list($amphure_id,$amphure_name)=mysqli_fetch_row($query_disrtict);
                                echo "$amphure_name";
                                $isset_district = $amphure_id;
?>   
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;" >แขวง/ตำบล(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                           
 <?php
                     $query_subdisrtict = mysqli_query($_SESSION['connect_db'],"SELECT DISTRICT_CODE,DISTRICT_NAME FROM districts WHERE PROVINCE_ID = '$isset_province' AND AMPHUR_ID='$isset_district' AND DISTRICT_CODE='$subdistrict'")or die("ERROR : employee detail line 219");
                        list($disrtict_code,$disrtict_name)=mysqli_fetch_row($query_subdisrtict);
                            echo "$disrtict_name";      
?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;">รหัสไปรษณีย์(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$zipcode"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding:10px;">เบอร์โทรศัพท์(ใช้ติดต่อ) :</td>
                        <td style="padding:10px;">
                            <?php echo "$phone"; ?>
                        </td>
                    </tr>
                </table>
        </div>
            

         <!--________________________________________________________-->
        <div class="col-md-12">
            <hr style="border-width: 2px;" >
                <table width="100%">
                    <tr>
                        <td width="50%" align="right" style="padding:10px;">ชื่อ-นามสกุล(ติดต่อฉุกเฉิน) : </td>
                        <td width="50%" style="padding:10px;" >
                            <?php echo "$titlename_er$name_er"; ?> 
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding: 10px;">เบอร์โทรศัพท์(ติดต่อฉุกเฉิน) :</td>
                        <td style="padding: 10px;">
                           <?php echo "$phone_er"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" style="padding: 10px;">สถานะ(ติดต่อฉุกเฉิน) :</td>
                        <td style="padding: 10px;"> 
                            <?php echo "$status_er"; ?>
                        </td>
                    </tr>

                </table>
        </div>
</div>
</div> <!--panal--> 
</div> <!-- end onpanal col-md-8--> 

<div class="col-md-4" >
<?php

if (empty($image)) {
            $image="<center><img src='../images/icon/no-images.jpg' width='120px' height='120px' style='border-radius:60px;' ></center>";
        }else{
            $image="<center><img src = '../images/employee/$employee_img' width='120px' height='120px' style='border-radius:60px;' ></center>";
        }
?>  
    <div class="col-md-12" style="border: 1px solid; margin-bottom:20px;  ">
        <center><?php echo "$image";?></center>
    </div>

        <!--______________________________________________________________________________--> 
<div class="col-md-12">
    <div class="list-group">
        <a class="list-group-item " id="profile" >ประวัติส่วนตัว</a>
        <a class="list-group-item " id="salary" >ข้อมูลเงินเดือน</a>
    </div>
</div>    

</div>  <!--col-md-4-->         
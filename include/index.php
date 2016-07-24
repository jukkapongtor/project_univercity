<?php
    session_start();
    include("function.php");
    connect_db();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MUMFERN SHOP</title>
 <link rel="shortcut icon" href="images/icon/logomumfern.png" />
 <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
 <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
 <link rel="stylesheet" type="text/css" href="../sweetalert/sweetalert.css">
 <script src="../js/jquery-1.11.3.min.js"></script>
 <script src="../js/bootstrap.min.js"></script>
 <script src="../sweetalert/sweetalert.min.js"></script> 
 <script>
    $(document).ready(function() {
      $(".btn_forgot_passwd").click(function(){
        var username = document.getElementById("username_forgot").value;
        var email = document.getElementById("email_forgot").value;
        $.post('forgot_passwd.php',{username_forgot:username,email_forgot:email},function(data){ 
          if(data=="username or email not match"){
            swal("", "ชื่อผู้ใช้งานกับอีเมล์ ไม่สอดคล้องกัน", "error");
          }else{
            swal("", "ระบบส่งรหัสผ่านไปยังอีเมล์ของท่านเรียบร้อยแล้ว", "success");
          }  
        });
      });

    });
 </script>
</head>
<body>
<div class="display_com">
<?php
  if(empty($_GET['action'])){
?>
    <div class="container-fluid">
    <div class="col-md-4 "></div>
    <div class="col-md-4 col-xs-12" style="margin-top:30px;">
        <div class="panel panel-default">
          <div class="panel-body">
          <center><img src="../images/icon/logomumfern.png" class='include-imglogin'></center>
          <form action="index.php?action=check_login" method="post">
            <div class="input-group ">
              <span class="input-group-addon " aria-hidden="true"><img src="../images/icon/man-user.png" width="20"></span>
              <input type="text" name='username' class="form-control" placeholder="Username">
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon "  aria-hidden="true"><img src="../images/icon/locked-padlock.png" width="20"></span>
              <input type="password" name='passwd' class="form-control" placeholder="Password">
            </div>
          <p style="margin-top:10px;" ><a href='../index.php?module=users&action=register' style="text-decoration: none;">สมัครสมาชิก</a></p>
          <p style="margin-top:10px;" ><a data-toggle="modal" data-target="#forgot_passwd" style="text-decoration: none;cursor:pointer">ลืมรหัสผ่าน</a></p>
              <!-- Modal -->
              <div class="modal fade" id="forgot_passwd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top:70px;">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel"><center><b>ขั้นตอนการข้อรหัสผ่าน</b></center></h4>
                    </div>
                    <div class="modal-body">
                        <p>กรุณากรอกชื่อผู้ใช้และอีเมล์ของท่าน ระบบจะส่งรหัสไปยังอีเมล์ของท่าน</p>
                        <div class="container-fluid">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 col-xs-12">
                         
                          <table width="100%" >
                            <tr>
                              <td width="15%">
                                <p>ชื่อผู้ใช้งาน</p>
                              </td>
                              <td width="5%">
                                <p>&nbsp;:&nbsp;</p>
                              </td>
                              <td>
                                <p><input type='text' class='form-control' id='username_forgot' placeholder="Username..." ></p>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <p>อีเมล์</p>
                              </td>
                              <td>
                                <p>&nbsp;:&nbsp;</p>
                              </td>
                              <td>
                                <p><input type='text' class='form-control' id='email_forgot'  placeholder="E-mail..." ></p>
                              </td>
                            </tr>
                          </table>
                          <br>
                          <center><input type='button' class='btn btn-primary btn_forgot_passwd' value="ส่งข้อมูล"></center>
                        </div>
                        <div class="col-md-1"></div>
                        </div>
                        
                    </div>
                  </div>
                </div>
              </div>
              
          <div class="col-md-12">
              <p>
                  <center><button type="submit" class="btn btn-success ">เข้าสู่ระบบ</button>
                  <a href='../index.php'><button type="button" class="btn btn-danger">ยกเลิก</button></a></center>
              </p>
          </div>
          </form>
          </div>

        </div>
    </div>
    <div class="col-md-4"></div>
    </div>
<?php
  }elseif($_GET['action']=="check_login"){
    check_login();
  }
  elseif($_GET['action']=="logout"){
    logout();
  }
?>
    

</div>
<div class="display_mobile">
    
</div>
</body>
</html>
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
          <p style="margin-top:10px;" ><a href='#' style="text-decoration: none;">ลืมรหัสผ่าน</a></p>
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
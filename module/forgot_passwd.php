<?php
    session_start();
    include("../include/function.php");
    connect_db();

    $query_user =mysqli_query($_SESSION['connect_db'],"SELECT passwd,fullname,lastname FROM users WHERE username='$_POST[username_forgot]' AND email='$_POST[email_forgot]'" )or die("ERROR forgot passwword line 6");
    $row = mysqli_num_rows($query_user);
    if(!empty($row)){
        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
    	list($passwd,$fullname,$lastname)=mysqli_fetch_row($query_user);
    	$strTo = "$_POST[email_forgot]";
        $strSubject = "=?UTF-8?B?".base64_encode("รหัสผ่านของผู้ใช้งาน $_POST[username_forgot]")."?=";
        $strHeader  = "MIME-Version: 1.0' . \r\n";
        $strHeader .= "Content-type: text/html; charset=utf-8\r\n";
        $strHeader .= "From: jukkapong Marsri<jukkapong@mumfern.com>\r\nReply-To: jukkapong.marsri@gmail.com";
        $strMessage = "ผู้ใช้งาน $_POST[username_forgot] \r\n<br>
        ชื่อ : $fullname &nbsp;&nbsp; นามสกุล : $lastname\r\n<br>
        รหัสเข้าใช้งานของคุณคือ $passwd\r\n<br>
        กลับเข้าสู่ระบบเพื่อลงชื่อเข้าใช้งาน\r\n
        <a href='http://www.mumfern.com/include'>คลิกที่นี้</a>";
        $flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
        if($flgSend)
        {
            echo "Email Sending.";
        }
        else
            echo "Email Can Not Send.";
    }else{
    	echo "username or email not match";
    }


?>
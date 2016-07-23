<?php
    session_start();
    include("function.php");
    connect_db();

    $query_user =mysqli_query($_SESSION['connect_db'],"SELECT passwd FROM users WHERE username='$_POST[username]' AND email='$_POST[email]'" )or die("ERROR forgot passwword line 6");
    $row = mysqli_num_rows($query_user);
    if(!empty($row)){
    	list($passwd)=mysqli_fetch_row($query_user);
    	$strTo = "$_POST[email]";
		$strSubject = "Fogot Password";
		$strHeader = "MIME-Version: 1.0'";
		$strHeader .= "Content-type: text/html; charset=utf-8"; 
		$strHeader .= "From: System-Contact\r\nReply-To: veerada@mimfern.com";	
		$strMessage = "password ของคุณคือ $passwd";


		$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader); 
    }else{
    	echo "username or email not match";
    }


?>
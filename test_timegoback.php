<script language="JavaScript">
	secound=0;
	minute=0;
	hours=1;
	function tplus() {
		
		document.getElementById("OutputText").innerHTML="<font color=\'red\'>" + hours+":"+minute+":"+ secound + " </font> Sec.";
		secound-=1;
		if(secound < 0){
			if (secound<0 && minute==0 && hours==0) {
			document.getElementById("OutputText").innerHTML="Go!";
			document.getElementById("OutputText2").innerHTML="";
			window.location.replace("index.php");
			}
			if(minute==0 && secound<0){
				hours-=1;
				minute=2;
				secound=4;
			}else{
			minute-=1;
			secound=4;
			}
		}
		if (secound>=0) {setTimeout("tplus()",1000);}
	}
	setTimeout("tplus()",1000);
</script>
		
<div align="center" id="OutputText"></div>
<div id="OutputText2">
	<div align="center">Please wait...</div>
</div>
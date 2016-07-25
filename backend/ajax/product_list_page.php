<?php
	echo "<meta charset='utf8'>";
	$_GET['keywords'] = (empty($_GET['keywords']))?"":$_GET['keywords'];
	$_GET['product_type'] = (empty($_GET['product_type']))?"":$_GET['product_type'];
	echo "<script>window.location='../#ajax/product_list.php?page=$_GET[page]&keywords=$_GET[keywords]&product_type=$_GET[product_type]'</script>";
?>
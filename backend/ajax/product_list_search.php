<?php
	echo "<meta charset='utf8'>";
	$_GET['keywords'] = (empty($_GET['keywords']))?"":$_GET['keywords'];
	$_GET['product_type'] = (empty($_GET['product_type']))?"":$_GET['product_type'];
	$_GET['product_quality'] = (empty($_GET['product_quality']))?"":$_GET['product_quality'];
	echo "<script>window.location='../#ajax/product_list.php?keywords=$_GET[keywords]&product_type=$_GET[product_type]&product_quality=$_GET[product_quality]'</script>";
?>
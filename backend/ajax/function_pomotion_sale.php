<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	date_default_timezone_set('Asia/Bangkok');
	connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
switch ($_GET['data']) {
	case 'pomotion_sale_add_search':
		$_GET['keywords'] = (empty($_GET['keywords']))?"":$_GET['keywords'];
		$_GET['product_type'] = (empty($_GET['product_type']))?"":$_GET['product_type'];
		$_GET['product_quality'] = (empty($_GET['product_quality']))?"":$_GET['product_quality'];
		echo "<script>window.location='../#ajax/pomotion_sale_add.php?keywords=$_GET[keywords]&product_type=$_GET[product_type]'</script>";
	break;
	case 'pomotion_sale_add_page':
		$_GET['keywords'] = (empty($_GET['keywords']))?"":$_GET['keywords'];
		$_GET['product_type'] = (empty($_GET['product_type']))?"":$_GET['product_type'];
		$_GET['product_quality'] = (empty($_GET['product_quality']))?"":$_GET['product_quality'];
		echo "<script>window.location='../#ajax/pomotion_sale_add.php?page=$_GET[page]&keywords=$_GET[keywords]&product_type=$_GET[product_type]&product_quality=$_GET[product_quality]'</script>";
	break;
	case 'update_pomotion':
		foreach ($_POST['product_size_id'] as $key => $value) {
			//echo $value." => ".$_POST['sprice_web'][$key]." => ".$_POST['sprice_shop'][$key]."<br>";
			mysqli_query($_SESSION['connect_db'],"UPDATE product_size SET product_sprice_web='".$_POST['sprice_web'][$key]."',product_sprice_shop='".$_POST['sprice_shop'][$key]."' WHERE product_size_id='$value'")or die("ERROR function pomotion sale line 19");
		}
		echo "<script>swal({title:'',text: \"เพิ่มสินค้าลดราคาเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/pomotion_sale_add.php';})</script>";
	break;
}
	
	
?>
</body>
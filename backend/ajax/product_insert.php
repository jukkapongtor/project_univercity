<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();
?>
<head>
	<link rel="stylesheet" type="text/css" href="../../sweetalert/sweetalert.css">
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="../../sweetalert/sweetalert.min.js"></script> 
</head>
<body>
<?php
	echo "<meta charset='utf-8'>";
	//echo "<pre>".print_r($_POST['product_size'],true)."</pre>";
	//echo "<pre>".print_r($_FILES['product_image'],true)."</pre>";

	
	if(empty($_POST['product_name'])||empty($_POST['product_type'])||empty($_POST['product_quality'])||empty($_POST['product_detail'])||empty($_POST['product_size'])||empty($_FILES['product_image'])){

		echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');window.location='../#ajax/product_add.php'</script>";
	}else{
		$_POST['product_stock'] = (empty($_POST['product_stock']))?0:1;
		$sql_insert_product = "INSERT INTO product VALUES('','$_POST[product_name]','$_POST[product_detail]','$_POST[product_type]','$_POST[product_quality]','$_POST[product_stock]')";
		mysqli_query($_SESSION['connect_db'],$sql_insert_product)or die("ERROR : backend porduct insert line 17");

		$query_product = mysqli_query($_SESSION['connect_db'],"SELECT product_id FROM product ORDER BY product_id DESC")or die("ERROR : product insert line 21");
		list($product_id)=mysqli_fetch_row($query_product);
		$sql_insert_product_size = "INSERT INTO product_size VALUES('','$product_id','".$_POST['product_size'][0]."','0','0','0','".$_POST['product_price_shop'][0]."','0','".$_POST['product_price_web'][0]."','0')";
		for($i=1;$i<count($_POST['product_size']);$i++){
			$sql_insert_product_size .= ",('','$product_id','".$_POST['product_size'][$i]."','0','0','0','".$_POST['product_price_shop'][$i]."','0','".$_POST['product_price_web'][$i]."','0')";
		}
		mysqli_query($_SESSION['connect_db'],$sql_insert_product_size)or die("ERROR : backend porduct insert line 25");

		$query_type=mysqli_query($_SESSION['connect_db'],"SELECT type_name_eng FROM type WHERE  product_type='$_POST[product_type]'")or die("ERROR : backend porduct insert line 27");
		list($type_name_eng)=mysqli_fetch_row($query_type);
		$folder = iconv("utf-8","tis-620",$type_name_eng);
		copy($_FILES['product_image']['tmp_name'][0],"../../images/$folder/".$_FILES['product_image']['name'][0]);
		$sql_insert_product_image = "INSERT INTO product_image VALUES('','$product_id','".$_FILES['product_image']['name'][0]."')";
		for($i=1;$i<count($_FILES['product_image']['name']);$i++){
			$sql_insert_product_image .= ",('','$product_id','".$_FILES['product_image']['name'][$i]."')";
			copy($_FILES['product_image']['tmp_name'][$i],"../../images/$folder/".$_FILES['product_image']['name'][$i]);
		}
		mysqli_query($_SESSION['connect_db'],$sql_insert_product_image)or die("ERROR : backend porduct insert line 31");
		/*
		$image_name = $_FILES['product_image']['name'];
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE  product_type='$_POST[product_type]'")or die("ERROR : backend porduct insert line 12");
		list($type_name)=mysqli_fetch_row($query_type);
		$folder =($type_name=="เฟิร์น")?"fern":"$type_name";
		$folder =($folder=="กระถาง")?"pots":"$folder";
		copy($_FILES['product_image']['tmp_name'],"../../images/$folder/$image_name");


		
		$sql ="INSERT INTO product VALUES('','$_POST[product_name]','$_POST[product_price_web]','$_POST[product_price_web]','','','$_POST[product_detail]','$_POST[product_type]','$_POST[product_quality]','$_POST[product_size]','','$_POST[product_stock]','$image_name')";
		mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend product insert line 21");
		*/
		echo "<script>swal({title:'',text: \"เพิ่มสินค้าเรียบร้อยแล้ว\",type:'success',showCancelButton: false,confirmButtonColor: '#1ca332',confirmButtonText: 'ยันยัน',closeOnConfirm: false },function(){ window.location='../#ajax/product_add.php';})</script>";
	}
	
?>
</body>
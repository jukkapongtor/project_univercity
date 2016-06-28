<?php
	session_start();
	echo "<meta charset='utf8'>";
	include("../../include/function.php");
	connect_db();

	if(empty($_POST['product_name'])||empty($_POST['product_type'])||empty($_POST['product_quality'])||empty($_POST['product_detail'])||empty($_POST['product_size'])||empty($_POST['product_price_web'])){

		echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');window.location='../#ajax/product_add.php'</script>";
	}else{
		$image_name = $_FILES['product_image']['name'];
		$query_type = mysqli_query($_SESSION['connect_db'],"SELECT type_name FROM type WHERE  product_type='$_POST[product_type]'")or die("ERROR : backend porduct insert line 12");
		list($type_name)=mysqli_fetch_row($query_type);
		$folder =($type_name=="เฟิร์น")?"fern":"$type_name";
		$folder =($folder=="กระถาง")?"pots":"$folder";
		copy($_FILES['product_image']['tmp_name'],"../../images/$folder/$image_name");


		$_POST['product_stock'] = (empty($_POST['product_stock']))?0:1;
		$sql ="INSERT INTO product VALUES('','$_POST[product_name]','$_POST[product_price_web]','$_POST[product_price_web]','','','$_POST[product_detail]','$_POST[product_type]','$_POST[product_quality]','$_POST[product_size]','','$_POST[product_stock]','$image_name')";
		mysqli_query($_SESSION['connect_db'],$sql)or die("ERROR : backend product insert line 21");
		echo "<script>alert('เพิ่มสินค้าเรียบร้อยแล้ว');window.location='../#ajax/product_add.php'</script>";

	}

?>
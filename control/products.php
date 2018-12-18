<?php

	ob_start();
	session_start();
	require_once('classes/DB.php');
	include('classes/class.header.php');
	include('classes/class.product.php');
	include('classes/class.footer.php');
	$user = new product();
	if(!isset($_SESSION['userId']))
	{
		header('location:login.php');
		die();
	}
	$user->access("1");
	header::doHeader('Products');

?>

	<h1 class="product-title"> Products </h1> <br/> <a href="newProduct.php" data-toggle="tooltip" title="" class="btn btn-primary " data-original-title="Add New"><i class="fa fa-plus"></i></a> 
	<br/><hr/><br/>

<?php

	$user->displayProducts();
	footer::doFooter();
	ob_end_flush();

?>						

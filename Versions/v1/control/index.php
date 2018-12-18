<?php

	ob_start();
	session_start();
	require_once('classes/DB.php');
	include('classes/class.product.php');
	include('classes/class.header.php');
	include('classes/class.footer.php');
	$user = new product();
	if(!isset($_SESSION['userId']))
	{
		header('location:login.php');
	}
	header::doHeader('Dashboard');
		$user->updateDelivery();
	?>

	<h1 class="product-title"> Orders </h1> 
	<br/><hr/><br/>

<?php
	
	$user->displayorders();
	footer::doFooter();
	ob_end_flush();

?>






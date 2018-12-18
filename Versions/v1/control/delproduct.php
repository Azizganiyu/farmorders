<?php
	session_start();
	ob_start();
	if(isset($_GET['product']))
	{
		require_once('classes/DB.php');
		include('classes/class.product.php');
		$user = new product();
		if(!isset($_SESSION['userId']))
		{
			header('location:login.php');
			die();
		}
		$user->access("1");
		$user->delProduct();
		header('location:products.php');
	}
	else
	{
		header('location:products.php');
	}
	ob_end_flush();

?>		
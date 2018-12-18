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
		header::doHeader('Inbox');
		if(isset($_GET['delmail'])){
			DB::query('DELETE FROM messages WHERE id = :i', array(':i'=>$_GET['delmail']));
			header('location:inbox.php');
		}
	


	echo "<h3 class='title1'>Inbox</h3>";
				
	$user->getMail();

    footer::doFooter();
    ob_end_flush();

?>		
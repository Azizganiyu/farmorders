<?php

	ob_start();
	session_start();
	if(!isset($_SESSION['userId']))
	{
		header('location:login.php');
	}
	unset($_SESSION['userId']);
	header('location:/farmorders/control/login.php');
	ob_end_flush();

?>
	


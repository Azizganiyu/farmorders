<?php

	require_once('classes/DB.php');
	include('classes/class.user.php');
	$user = new user();
	if(!$user->isLoggedIn())
	{
		header('location:index.php');
	}
	user::logout();
	header('location:index.php');
	
?>
	


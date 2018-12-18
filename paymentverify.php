<?php
session_start();
require_once('classes/DB.php');
include('classes/class.header.php');
include('classes/class.product.php');
include('classes/class.footer.php');
$user = new product();
header::doHeader('Payment');
if(!$user->isLoggedIn())
{
header('location:index.php');
exit();
}
 $id = $_GET['orderid'];
 $reference = $_GET['reference'];
 if($reference == $user->display_user('password')){
     $user->paymentUpdate($id);
 }

 footer::doFooter();
?>
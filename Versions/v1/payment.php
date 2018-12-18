<?php

    ob_start();
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
    if (isset($_POST['bank']))
    {
        header('location:bankpayment.html');
    }
 
?>
<form method="post" action="payment.php?order=<?php echo $_GET['order']; ?>">
<div class="row">
    <h2 style="color: #9ACD32; margin-bottom: 30px; margin-top: 30px;" class="text-center"> Payment options</h2>
    <div class="col-sm-6">
        <div class="box">
            <h4>Paypal</h4>
            <p>We like it all.</p>
            <div class="box-footer text-center">
                <button disabled  class="btn btn-danger" name="paypal">Select</button>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box payment-method">
            <h4>Bank Tansfer</h4>
            <p>ATM and Bank deposit</p>
            <div class="box-footer text-center">
                <button class="btn btn-danger" name="bank">Select</button>
            </div>
        </div>
    </div>
</div>
</form>

<?php

    footer::doFooter();
    ob_end_flush();

?>
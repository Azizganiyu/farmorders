<?php

    //ob_start();
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
    if (!isset($_GET['order']))
    {
        header('location:index.php');
        exit();
    }
    $details = $user->getPaymentInfo();
?>
<div class="col-sm-12">
<form action="#" method="post">
 <script src="https://js.paystack.co/v1/inline.js"></script>
 <div class="row">
    <h2 style="color: #9ACD32; margin-bottom: 30px; margin-top: 30px;" class="text-center"> Payment options</h2>
    <div class="col-sm-6">
        <div class="box">
            <h4>Paystack</h4>
            <p>online payment.</p>
            <div class="box-footer text-center">
                <button  class="btn btn-danger"  onclick="payWithPaystack()">Select</button>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box payment-method">
            <h4>Bank Tansfer</h4>
            <p>ATM and Bank deposit</pt>
            <div class="box-footer text-center">
                <button class="btn btn-danger" onclick="bankPay()">Select</button>
            </div>
        </div>
    </div>
</div>
</form>
</div>

<script>
  function bankPay(){
      alert('bankpayment');
    }

  function payWithPaystack(){
    var handler = PaystackPop.setup({
      // This assumes you already created a constant named
      // PAYSTACK_PUBLIC_KEY with your public key from the
      // Paystack dashboard. You can as well just paste it
      // instead of creating the constant
      key: 'pk_live_25a55e1e03523167ed69aa016acfcd2178c40e04',
      email: '<?php echo $details['email'] ?>',
      amount: '<?php echo $details['amount'] ?>00',
      ref: '<?php echo $user->display_user('password') ?>',
      metadata: {
        cartid: '<?php echo $details['productCode'] ?>',
        orderid: '<?php echo $details['id'] ?>',
        custom_fields: [
          {
            display_name: "Name",
            variable_name: "name",
            value: '<?php echo $details['username'] ?>'
          },
          {
            display_name: "Product name",
            variable_name: "product_name",
            value: '<?php echo $details['productName'] ?>'
          }
        ]
      },
      callback: function(response){
        // post to server to verify transaction before giving value
        var id = '<?php echo $details['id'] ?>';
        var verifying = $.get( 'paymentverify.php?reference=' + response.reference + '&orderid=' + id );
        
      },
      onClose: function(){
        alert('Please select Paystack to retry payment.');
      }
    });
    handler.openIframe();
  }
  
  </script>

<?php

    footer::doFooter();
    //ob_end_flush();

?>
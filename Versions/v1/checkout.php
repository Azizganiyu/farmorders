<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    if(isset($_POST['submit']))
    {
        $user->placeOrder();
        //$user->paymentdet();
        unset($_SESSION['cart']);
        //unset($_SESSION['codes']);
        unset($_SESSION['totalPrice']);
        unset($_SESSION['payment_mode']);
        header('location:account.php');
    }
    if(!$user->isLoggedIn())
    {
        header('location:index.php');
        exit();
    }
    if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0)
    {
        header('location:account.php');
        exit();
    }
    echo $user->login();
    $user->removeCart();
    header::doHeader('checkout.php');

?>

<div id="content">
    <div class="container">
        <div class="col-md-9" id="checkout">
            <div class="box">
                <form method="post" action="checkout.php">
                    <div class="content">
                        <h1>Update - Address</h1>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" class="form-control" id="street" name="street" value="<?php echo $user->display_user('street'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Telephone</label>
                                    <input type="text" class="form-control" id="phone" name="telephone" value="<?php echo $user->display_user('telephone'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo $user->display_user('state'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Order description</label>
                                    <textarea class="form-control" name="desc" id="desc"></textarea>
                                    <p> *Enter additional information on your order. </p>
                                        Or simply call or email for further instructions on your orders.
                                </div>
                            </div>
                        </div>
                    </div>                     
                    <div class="box-footer">
                        <div class="pull-left">
                            <a href="cart.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Cart</a>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn view" name="submit">Continue to Place order<i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box" id="order-summary">
                <div class="box-header">
                    <h3>Order summary</h3>
                </div>
                <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Order subtotal</td>
                                <th><span>&#8358;</span><?php echo $_SESSION['totalPrice']; ?></th>
                            </tr>
                            <tr>
                                <td>Shipping and handling</td>
                                <th><span>&#8358;</span>
                                    <?php 
                                        if(count($_SESSION['cart']) > 0)
                                        {
                                            echo "00.00";
                                        }
                                        else
                                        {
                                            echo "0";
                                        } 
                                    ?>
                                </th>
                            </tr>
                            <tr class="total">
                                <td>Total</td>
                                <th><span>&#8358;</span>
                                    <?php 
                                        if(count($_SESSION['cart']) > 0)
                                        {
                                            echo $_SESSION['totalPrice'] + 00;
                                        }
                                        else
                                        {
                                            echo "0";
                                        }
                                    ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    footer::doFooter();
    ob_end_flush();

?>

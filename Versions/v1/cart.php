<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    echo $user->login();
    $user->removeCart();
    header::doHeader('cart');
 
?>

<div id="content">
    <div class="container">
        <div class="col-md-9" id="basket">
            <div class="box">
                <form method="post" action="
                    <?php  
                        if(!$user->isLoggedIn())
                        {
                            echo "cart.php";}else{echo "checkout.php";
                        }
                    ?>
                ">
                    <h1>Your cart</h1>
                    <p class="text-muted">You currently have <?php echo $user->countCartItem(); ?> item(s) in your cart.</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Product</th>
                                    <th>Quantity</th>
                                    <th>Unit price</th>
                                    <th>Delivery?</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $user->displayCartItems(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th colspan="2"><span>&#8358;</span><?php echo $_SESSION['totalPrice']; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="pull-left">
                            <a href="market.php"  class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue shopping</a>
                        </div>
                        <div class="pull-right">
                            <?php
                                if (count($_SESSION['cart'])>0)
                                {
                            ?>
                                    <button type="submit" name="checkout" class="btn view">Proceed to checkout <i class="fa fa-chevron-right"></i>
                                    </button>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <button type="submit" name="checkout" class="btn view disabled">Proceed to checkout <i class="fa fa-chevron-right"></i>
                                    </button>
                            <?php
                                }
                                if(isset($_POST['checkout']))
                                {
                                    echo "<br/>You must"."<a href='#' data-toggle='modal' data-target='#login-modal'> Login </a>"."to continue";
                                }
                            ?>
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
                                            echo "0";} 
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
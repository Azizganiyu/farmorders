<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    header::doHeader('You');
    if(!$user->isLoggedIn())
    {
    header('location:index.php');
    exit();
    }
    $user->cancelOrder();
 
?>

<div id="content">
    <div class="container">
        <div class="col-sm-12" id="customer-orders">
            <div class="box">
                <h3 class="username"><?php echo $user->display_user('fullName'); ?></h3>
                <p class="lead">Your orders on one place.</p>
                <p class="text-muted">Please always check back to know the status of your orders. If you have any questions, please feel free to contact us, our customer service center is working for you 24/7.</p>
                <hr>
                <?php
                    if (isset($_SESSION['payment_update'])) {
                        echo $_SESSION['payment_update'];
                        unset($_SESSION['payment_update']);
                    }
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $user->getUserOrders(); ?> 
                        </tbody>
                    </table>
                </div>
                <p class="text-muted">All unpaid orders will be canceled after 3 days of placing orders.</p>
            </div>
            
                <?php $user->getUserOrdersDetails(); ?> 
            
        </div>
    </div>       
</div>

<?php

    footer::doFooter();
    ob_end_flush();

?>
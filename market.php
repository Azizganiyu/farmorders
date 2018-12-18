<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    //session_destroy();
    header::doHeader('Market');
 
?>



<div class="container content">
    <div class="row">
        <div class="col-md-3">
            <div>
                <a href="#" class="list-group-item active">Categories</a>
                <ul class="list-group">
                    <?php $user->getCategories(); ?>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row filter">
                <div class="btn-group alg-right-pad">
                    <button type="button" class="btn btn-default cat"><strong> Displaying for <?php echo $user->marketCategory(); ?></strong>(<?php echo $user->countProduct(); ?>) Items</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Sort Products &nbsp;<span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="market.php?<?php echo $user->sortProduct()?>ptl">By Price Low</a></li>
                            <li class="divider"></li>
                            <li><a href="market.php?<?php echo $user->sortProduct()?>pth">By Price High</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $user->displayProducts(); ?>  
            </div>                
        </div>
    </div>
</div>

<?php

    footer::doFooter();
    ob_end_flush();

?>
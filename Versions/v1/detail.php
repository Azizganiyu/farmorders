<?php

    ob_start();
    session_start();
    if(!isset($_GET['product']))
    {
        header('location:index.php');
    }
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    $user->addCart();
    header::doHeader('product-detail');
  
?>

<div id="content">
    <div class="container">
        <div class="col-md-3"  style="margin-top:30px;">
            <div>
                <a href="#" class="list-group-item active">Categories</a>
                <ul class="list-group">
                    <?php $user->getCategories(); ?>
                </ul>
            </div>
        </div>
        <div class="col-md-9"  style="margin-top:30px;">
            <div class="row" id="productMain">
                <div class="col-sm-6">
                    <div id="mainImage">
                        <img src="control/<?php echo $user->display_product('image'); ?>" alt="No Image" class="img-responsive">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box">
                        <h3 class="text-center"><?php echo $user->display_product('name'); ?></h3>
                        <p class="goToDescription"><a href="#details" class="scroll-to">Scroll to product details</a></p>
                        <p class="price"><?php echo 'Price: <span>&#8358;</span> '.$user->display_product('price'); ?></p>
                        <p class="text-center buttons">
                            <form action="detail.php?product=<?php echo $user->display_product('id'); ?>&productcode=<?php echo $user->display_product('id');?>" method="post" class="">
                                <span class="label label-success">Order Quantity:</span>
                                <input type="number" min="1" value="1" name="qty" class="form-control qty-box">
                                <i class="fa fa-shopping-cart"></i>
                                <input type="submit" name="add_to_cart" value="Add to cart" class="btn btn-primary add-to-cart btn">
                            </form>
                        </p>
                    </div>
                </div>
            </div>
            <div class="box" id="details">
                <p>
                    <h4>Delivery?</h4>
                    <p><?php echo $user->display_product('delivery'); ?></p>
                    <h4>Added by</h4>
                    <?php echo $user->display_product('owner_company'); ?>
                    <h4>weight</h4>
                    <?php echo $user->display_product('weight'); ?>
                    <blockquote>
                        <p><em><?php echo $user->display_product('description'); ?></em></p>
                    </blockquote>
                    <hr>
                <!--<div class="social">
                        <h4>Show it to your friends</h4>
                        <p>
                            <a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
                        </p>
                    </div>-->
                </p>
            </div>  
        </div>
        <div class="box box-relted">
            <div class="container">
                <div class="col-md-12">
                <h3>Related Products </h3>
                    <?php 
                        $name = $user->display_product('name');
                        $user->relatedProducts($name);
                    ?> 
                
                </div>
            </div>
        </div>  
    </div>
</div>

<?php

    footer::doFooter();
    ob_end_flush();

?>
                   
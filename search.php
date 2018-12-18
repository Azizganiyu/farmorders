<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    header::doHeader('Search page');

?>

<div class="container search-row content">
	<div class="col-sm-12">
        <form role="search" method="post" action="search.php">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search product" name="key" value="<?php echo @$_POST['key']; ?>">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>
    <?php $user->searchProduct(); ?>
</div>

<?php

    //$user->searchProduct();
    footer::doFooter();
    ob_end_flush();

?>
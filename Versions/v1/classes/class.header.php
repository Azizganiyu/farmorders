<?php

    class Header
        {
             public static function doHeader($pageTitle)
            {

?>

                <!DOCTYPE HTML>
                <html>
                <head>
                <title>
                        <?php echo $pageTitle; ?>
                </title>
                    <meta charset="utf-8">
                    <meta name="robots" content="all,follow">
                    <meta name="googlebot" content="index,follow,snippet,archive">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta name="description" content="Farm Orders">
                    <meta name="author" content="">
                    <meta name="keywords" content="">
                    <meta name="keywords" content="">
                    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>
                    <!-- styles -->
                    <link href="includes/css/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
                    <link href="includes/css/bootstrap.min.css" rel="stylesheet">
                    <link href="includes/css/bootstrap.css" rel="stylesheet">
                    <link href="includes/css/animate.min.css" rel="stylesheet">
                    <link href="includes/css/owl.carousel.css" rel="stylesheet">
                    <link href="includes/css/owl.theme.css" rel="stylesheet">
                    <!-- theme stylesheet -->
                    <link href="includes/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
                    <!-- your stylesheet with modifications -->
                    <link href="includes/css/custom.css" rel="stylesheet">
                    <script src="includes/js/respond.min.js"></script>
                </head>
                <?php include_once("googleanalytics.php") ?>
                <body>
                    <!-- *** TOPBAR ***
                 ___________________________________________________________ -->
                    <div id="top">
                        <div class="container">

                            <div class="col-md-6 offer" data-animate="fadeInDown">

                                <div class="navbar-collapse collapse right" id="basket-overview">
                                    <a href="cart.php" class="btn btn-primary navbar-btn navbar-toggle-color"><i class="fa fa-shopping-cart"></i>
                                        <span class="hidden-sm"><?php echo product::countCartItem(); ?> items in cart</span>
                                    </a>
                                </div>
                                <div class="navbar-collapse collapse right" id="search-not-mobile">
                                    <button type="button" class="btn navbar-btn btn-primary navbar-toggle-color" data-toggle="collapse" data-target="#search">
                                        <span class="sr-only">Toggle search</span>
                                        <i class="fa fa-search disabled"></i>
                                    </button>
                                </div>                 
                            </div>
                            <div class="col-md-6 top-menu" data-animate="fadeInDown">
                                <ul class="menu">
                                    <?php
                                        if(!user::isLoggedIn())
                                        {
                                    ?>
                                    <li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>
                                    <?php
                                        }
                                        elseif(user::isLoggedIn())
                                        {
                                    ?>
                                     <li><a href="logout.php">Logout</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li class="contact-btn"><a href="contact.php">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="Login">Customer login</h4>
                                    </div>
                                    <div class="modal-body" id="login">
                                        <form action="index.php" method="post">
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="email-modal" placeholder="Email" name="email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="password-modal" placeholder="password" name="password">
                                            </div>
                                            <p class="text-center">
                                                <button class="btn btn-primary view" name="login"><i class="fa fa-sign-in"></i> Log in</button>
                                            </p>
                                        </form>
                                        <p class="text-center text-muted">Not registered yet?</p>
                                        <p class="text-center text-muted"><a href="register.php"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade full" id="about-us" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
                            <div class="modal-dialog modal-sm full">
                                <div class="modal-content full">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="Login">About Us</h4>
                                    </div>
                                    <div class="modal-body" id="login">
                                        <div class="outer-about-logo"><img src="img/fo.jpg" alt="logo" class="img-responsive about-logo text-center" /></div>
                                        <h1 class="text-center">JEM FARM ORDER AND SALES ENTERPRISE </h1>
                                        <h4 class="text-center text-muted">farmorders.com.ng</h4>
                                        <p class="text-center text-muted">Farmorders is a subsidiary of JEM FARM ORDER AND SALES ENTERPRISE a registered business under Corporate Affairs Commission (CAN) BN 2628600, our main aim is to strive to achieve excellence in satisfying our customers by delivering farm products at their doorstep at reasonable and affordable prices, we also guarantee safe transaction and delivery. We deliver anywhere in Nigeria, our goal is to supply farm products at affordable prices in bulk to places where they are not readily available in large quantities.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- *** TOP BAR END *** -->

                    <!-- *** NAVBAR ***
                 _________________________________________________________ -->

                    <div class="navbar navbar-default yamm" role="navigation" id="navbar">
                        <div class="container">
                            <div class="navbar-header">
                                <a class="navbar-brand home" href="index.php">
                                    <img src="includes/img/logo.png" alt="FarmOrders logo" class="img-responsive">
                                    <!--<img src="includes/img/logo-small.png" alt="FarmOrders logo" class="visible-xs">--><span class="sr-only">FarmOrders - go to homepage</span>
                                </a>
                                <div class="navbar-buttons">
                                    <button type="button" class="navbar-toggle navbar-toggle-color" data-toggle="collapse" data-target="#navigation">
                                        <span class="sr-only">Toggle navigation</span>
                                        <i class="fa fa-align-justify"></i>
                                    </button>
                                    <button type="button" class="navbar-toggle navbar-toggle-color" data-toggle="collapse" data-target="#search">
                                        <span class="sr-only">Toggle search</span>
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <a class="btn btn-default navbar-toggle navbar-toggle-color" href="cart.php">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span class="badge"><?php echo product::countCartItem(); ?></span>
                                    </a>
                                </div>
                            </div>
                            <div class="navbar-collapse collapse " id="navigation">
                                <ul class="nav navbar-nav navbar-left" style="font-family:'quickSandBook'">
                                    <li class="activ"><a href="index.php">Home</a></li>
                                        <?php
                                            if(user::isLoggedIn())
                                            {
                                        ?>
                                    <li class="yamm-fw"><a href="account.php">You</a></li>
                                        <?php
                                            }
                                        ?>
                                    <li class="yamm-fw"><a href="market.php">Market</a></li>
                                    <li class="yamm-fw"><a href="#" data-toggle="modal" data-target="#about-us">About</a></li>
                                </ul>
                            </div>
                            <div class="collapse clearfix" id="search">
                                <form class="navbar-form" role="search" method="post" action="search.php">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search product" name="key">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="all">

<?php

        }
            }

?>

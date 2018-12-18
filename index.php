<?php
        ob_start();
        session_start();
        require_once('classes/DB.php');
        include('classes/class.header.php');
        include('classes/class.product.php');
        include('classes/class.footer.php');
        header::doHeader('Home');
        if(isset($_SESSION['login_error']))
        {
            echo $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }
        $user = new product();
        echo $user->login();

?>
 <!--<div class="container full">
    <div class="full">
        <div id="main-slider" class="full">
            <div class="item full">
                <img src="img/main-slider1.jpg" alt="" class="img-responsive full">
            </div>
            <div class="item full">
                    <img class="img-responsive full" src="img/main-slider2.jpg" alt="">
            </div>
            <div class="item full">
                <img class="img-responsive full" src="img/main-slider3.jpg" alt="">
            </div>
            <div class="item full">
                <img class="img-responsive full" src="img/main-slider4.jpg" alt="">
            </div>
        </div>
    </div>
</div>-->
<div class="container full">
    <div class="full">
        <div id="main-slider" class="full">
            <div class="item text-center img-responsive full">
                <h5 class="first">Best farm product </h5>
                <h1 style="color:white;">You deserve it</h1>
                <h5 class="second">Farmorders guarantees 100% satisfaction by offering the best farm products at best affordable prices possible. We love our customers, just order it!</h5>
                <!--<img src="img/main-slider1.jpg" alt="" class="img-responsive full">-->
                <div class=" col-xm-12 col-md-4 col-md-offset-4">
            <div class="box welcome-button">
                <?php
                    if($user->isLoggedIn())
                    {
                        echo '<a href="account.php"><button class="btn view btn-success">Your Account</button></a>';
                    }
                    else
                    {
                        echo '<a href="register.php"><button class="btn view">Join us today</button></a>';
                    }
                    ?>
                <a href="market.php"><button class="btn btn-success white">Start ordering</button></a> 
            </div>
            <div class="box same-height offer clickable">
                    <div class="ball  icon3"><i class="fa fa-leaf"></i></div>
                </div>
        </div>
            </div>
        </div>
    </div>
    <?php $user->topFeatured(); ?>
</div>

<div id="advantages">
    <div class="box box-featured">
        <div class="container">
            <div class="col-md-12">
            <h3 class="offer-head"> Featured products  </h3>
                <?php 
                
                $user->featuredProducts();
                ?>  
            </div>
        </div>
    </div>
    <div class="container">
        <div class="same-height-row">
            <h3 class="offer-head"> This is what we do  </h3>
            <div class="col-sm-4 offer-body">
                <div class="box same-height offer clickable">
                    <div class="ball icon1"><i class="fa fa-truck"></i></div>
                    <h4><a href="#">Product Ordering</a></h4>
                    <p>We deliver ordered farm products anywhere in Nigeria with low delivery rate. Just order and we will deliver right to your location. </p>
                    <a href="#" data-toggle="modal" data-target="#about-us"><button class='btn view' dissabled >About us </button></a>
                </div>
            </div>
            <div class="col-sm-4 offer-body">
                <div class="box same-height offer clickable">
                    <div class="ball icon2"><i class="fa fa-users"></i></div>
                    <h4><a href="#">Third party selling</a></h4>
                    <p>We offer third party selling i.e you can sell your farm products too. Contact us today to start selling</p>
                    <a href='contact.php'><button class='btn view'>Contact Us</button></a>
                </div>
            </div>
            <div class="col-sm-4 offer-body">
                <div class="box same-height offer clickable">
                    <div class="ball  icon3"><i class="fa fa-leaf"></i></div>
                    <h4><a href="#">Selling of farm product</a></h4>
                    <p>We sell farm products of various kinds, mainly cash crops and edible tubers.</p>
                    <a href='market.php'><button class='btn view'>Market</button></a> 
                </div>
            </div>
        </div>
    </div>
</div>


<?php

    footer::doFooter();
    ob_end_flush();

?>
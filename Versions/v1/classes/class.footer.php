<?php

    class Footer
    {
        public static function doFooter()
        {

?>

            <div id="footer" data-animate="fadeInUp">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <h4>Pages</h4>
                            <ul>
                                <li><a href="#" data-toggle="modal" data-target="#about-us">About us</a></li>
                                <li><a href="market.php">Market</a></li>
                                <li><a href="contact.php">Contact us</a></li>
                            </ul>
                            <hr>
                            <h4>User section</h4>
                            <ul>
                                <li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>
                                <li><a href="register.php">Register</a></li>
                            </ul>
                            <hr class="hidden-md hidden-lg hidden-sm">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <h4>All Categories</h4>
                            <ul>
                               <?php product::getCategoriesFooter(); ?>
                            </ul>
                            <hr class="hidden-md hidden-lg">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <h4>How to contact us</h4>
                            <p>
                                <strong>Farmorders sales</strong>
                                <br><br>No1. 08123645460
                                <br>No2. 07033968518
                                <br>No3. 08079028695
                                <h4><i class="fab fa-whatsapp"></i> Whatsapp <br/>08123645460</h4>
                                <strong>farmorders.com.ng@gmail.com</strong>
                            </p>
                            <a href="contact.php">Go to contact page</a>
                            <hr class="hidden-md hidden-lg">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <h4>Stay in touch</h4>
                            <p class="social">
                                <a href="https://instagram.com/farmorders.com.ng" class="instagram external" data-animate-hover="shake"><i class="fab fa-instagram"></i></a>
                                <!--<a href="#" class="facebook external" data-animate-hover="shake"><i class="fa fa-facebook"></i></a>
                                <a href="#" class="twitter external" data-animate-hover="shake"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="gplus external" data-animate-hover="shake"><i class="fa fa-google-plus"></i></a>
                                <a href="#" class="email external" data-animate-hover="shake"><i class="fa fa-envelope"></i></a>-->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="copyright">
                <div class="container">
                    <div class="col-md-6">
                        <p class="pull-left">© 2018 Farmorders. All Rights Reserved | <a href="https://farmorders.com.ng/" target="_blank">site.</a></p>
                    </div>
                    <div class="col-md-6">
                        <!-- <p class="pull-right">Template by <a href="https://bootstrapious.com/e-commerce-templates">Bootstrapious</a> & <a href="https://fity.cz">Fity</a>
                             Not removing these links is part of the license conditions of the template. Thanks for understanding :) If you want to use the template without the attribution links, you can do so after supporting further themes development at https://bootstrapious.com/donate  
                        </p> -->
                    </div>
                </div>
            </div>
            </div> <!-- /#all -->

            <!-- *** SCRIPTS TO INCLUDE ***
         _________________________________________________________ -->
            <script src="includes/js/jquery-1.11.0.min.js"></script>
            <script src="includes/js/bootstrap.min.js"></script>
            <script src="includes/js/jquery.cookie.js"></script>
            <script src="includes/js/waypoints.min.js"></script>
            <script src="includes/js/modernizr.js"></script>
            <script src="includes/js/bootstrap-hover-dropdown.js"></script>
            <script src="includes/js/owl.carousel.min.js"></script>
            <script src="includes/js/front.js"></script>

            </body>

            </html>


 <?php
  
    }
        }
        
?>
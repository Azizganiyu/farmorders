<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    $user = new product();
    header::doHeader('Register');

?>

        <div id="content">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box">
                        <h1>New account</h1>
                        <p class="lead">Not our registered customer yet?</p>
                        <hr>
                        <form action="register.php" method="post">
                            <div class="form-group">
                                <?php $user->register(); ?>
                                <div class="clearfix"></div><hr/>
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required="required" data-error="First name is required." value="<?php echo @$_POST['fname'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required="required" data-error="First name is required." value="<?php echo @$_POST['fname'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required="required" data-error="email is required." value="<?php echo @$_POST['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required="required" data-error="password is required." value="<?php echo @$_POST['password'] ?>">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary view" name="register"><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
<?php
        
    footer::doFooter();
    ob_end_flush();

?>
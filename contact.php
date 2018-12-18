<?php

    ob_start();
    session_start();
    require_once('classes/DB.php');
    include('classes/class.header.php');
    include('classes/class.product.php');
    include('classes/class.footer.php');
    require('classes/PHPMailer_5.2.0/class.phpmailer.php');
    header::doHeader('Contact');
    $user = new product();

?>



<div id="content">
    <div class="container">
        <div class="col-md-3">
            <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                    <h3 class="panel-title">Pages</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="market.php">Market</a></li>
                        <li><a href="contact.php">Contact page</a></li>  
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box" id="contact">
                <h1>Contact</h1>
                <p class="lead">Are you curious about something? Do you have some kind of problem with our products?</p>
                <p>Please feel free to contact us, our customer service center is working for you 24/7.</p>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h3><i class="fa fa-phone"></i> Call center</h3>
                        <p class="text-muted">Call to this numbers incures charges otherwise we advise you to use the electronic form of communication.</p>
                        <p><strong>No1. 08123645460
                            <br>No2. 07033968518
                            <br>No3. 08079028695
                            <br></strong>
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <h3><i class="fab fa-whatsapp"></i> Whatsapp</h3>
                        <p class="text-muted">Our whatsapp contact, please feel free to chat with us.</p>
                        <h3 style="color: #9ACD32;">08123645460</h3>
                    </div>
                    <div class="col-sm-4">
                        <h3><i class="fa fa-envelope"></i> Electronic support</h3>
                        <p class="text-muted">Please feel free to write an email to us.</p>
                        <ul>
                            <li><strong><a style="color: #CD0000;" href="mailto:">farmorders.com.ng@gmail.com</a></strong></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <h2>Contact form</h2>
                <form method="post" action="contact.php">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required="required" value="<?php echo @$_POST['firstname'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required="required"  value="<?php echo @$_POST['lastname'] ?>">
                            </div>
                        </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required="required"  value="<?php echo @$_POST['email'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required="required"  value="<?php echo @$_POST['subject'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="message" class="form-control" name="message" required="required" ><?php echo @$_POST['message'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary view" name="submit"><i class="fa fa-envelope-o"></i> Send message</button>
                            </div>
                    </div>
                </form>
                <div>
                    <?php $user->sendMail(); ?>                        
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    footer::doFooter();
    ob_end_flush();

?>

<?php

  ob_start();
  session_start();
  require_once('classes/DB.php');
  include('classes/class.header.php');
  include('classes/class.product.php');
  include('classes/class.footer.php');
  $user = new product();
  header::doHeader('Error page');

 
?>

<div id="content">
  <div class="container">
    <div class="row" id="error-page">
      <div class="col-sm-6 col-sm-offset-3">
        <div class="box">
          <p class="text-center">
            <img src="includes/img/logo.png" alt="Obaju template">
          </p>
          <h3>We are sorry - Page requested can not be found</h3>
          <h4 class="text-muted">Error 404 - Page not found</h4>
          <p class="text-center">To continue please use the <strong>Search form</strong> or <strong>Menu</strong> above.</p>
          <p class="buttons"><a href="index.php" class="btn btn-primary"><i class="fa fa-home"></i> Go to Homepage</a></p>
        </div>
      </div>
    </div>
  </div>
  </div>

<?php

  footer::doFooter();
  ob_end_flush();

?>
<?php

	ob_start();
	session_start();
	require_once('classes/DB.php');
	require_once('classes/class.admin.php');
	$user = new admin();

?>
 <!DOCTYPE html>
 <html lang="en">
    <head>

      <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">

      <link rel="stylesheet"  href="includes/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet"  href="includes/CSS/stylesheet.css">

      <script src="includes/jquery/jquery.min.js"></script>
      <script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>

      <title> Admin Login </title>

    </head>

    <body class="login-page">

    	<div class="container login-panel">
    		<div class="row">
    			<div class=" col-10 offset-1 col-sm-8 offset-sm-2 login-header">Login
    				<button class="btn btn-secondary btn-sm btn-right">Forgot password</button> </div>
    			<div class=" col-10 offset-1 col-sm-8 offset-sm-2 login-form">
    				<div class="col-12 login-info">
    					Welcome to Farmorders.com.ng Admin area. Enter details to <font color="black">Login</font>
    				</div>
    				<form action="login.php" method="post" role="form" class=" col-12 form-horizontal">
						<div class="row">
							<div class="col-12">
								<div role="alert" class="alert-danger"><strong><?php echo $user->login(); ?></strong></div>
								<div class="form-group">
									<input type="text" name="username" placeholder="Username" id="name" class="form-control" required="required" data-error="Username is required."/><br>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<input type="password" name="password" placeholder="Password" id="pass" class="form-control" required="required" data-error="Valid password is required." />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<input type="submit" name="login" value="Login" class="btn btn-secondary login-btn btn-sm pull-left">
								</div>
							</div>
						</div>
					</form>
    			</div>
    		</div>
    	</div>
	
	</body>

</html>

<?php

	ob_end_flush();

?>
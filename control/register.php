<?php

	ob_start();
	session_start();
	require_once('classes/DB.php');
	include('classes/class.admin.php');
	include('classes/class.header.php');
	include('classes/class.footer.php');
	$user = new admin();
	if(!isset($_SESSION['userId']))
	{
		header('location:login.php');
		die();
	}
	$user->access("1");
	header::doHeader('Registeration');

?>
<div class=" form-grids row form-grids-right">
	<div class="widget-shadow " data-example-id="basic-forms"> 
		<div class="form-title">
			<h4>Add new admin</h4>
			<p class="lead">please fill in all field to add new admin</p>
		</div>
		<div class="form-body">
			<form class="form-horizontal" method="post" action="register.php" role="form">
				<div class="form-group">
					<?php $user->register(); ?>
					<div class="clearfix"></div>
					<hr/>
					<label for="username" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="username" name="username" placeholder="Username" required="required" data-error="username is required." value="<?php echo @$_POST['username'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="Password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="Password" placeholder="Password" name="password" required="required" data-error="Valid password is required." value="<?php echo @$_POST['password'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="cPassword" class="col-sm-2 control-label">Confirm password</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="cPassword" placeholder="Confirm password" name="cpassword" required="required" data-error=" password confirm is required.">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input id="admin" type="checkbox" name="role" value="administrator"> Act as administrator
							</label>
						</div>
					</div>
				</div>
				<div class="col-sm-offset-2">
					<input type="submit" name="register" class="btn btn-success btn-send btn-sm" value="Add">
				</div>
			</form> 
		</div>
	</div>
</div>
<br/><br/><hr/><br/>

<?php

	$user->displayAdmins();
	footer::doFooter();
	ob_end_flush();

?>
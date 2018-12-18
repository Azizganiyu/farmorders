<?php

	ob_start();
	session_start();
	require_once('classes/DB.php');
	include('classes/class.header.php');
	include('classes/class.product.php');
	include('classes/class.footer.php');
	$user = new product();
	if(!isset($_SESSION['userId']))
	{
		header('location:login.php');
		die();
	}
	header::doHeader('categories');
	$user->access("1");

?>							

<div class="inline-form widget-shadow">
	<div class="form-title">
		<h4>Add new category :</h4>
	</div>
	<div class="form-body">
		<form data-toggle="validator" method="post" action="categories.php">
			<?php $user->addCategory(); ?>
			<div class="clearfix"></div>
			<hr/>
			<div class="form-group has-feedback">
				<input type="text" class="form-control" id="inputName" placeholder="category name" data-error="Bruh, that name is invalid" required name="name" value="<?php echo @$_POST['name'] ?>">
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
			</div>
			<div class="form-group">
				<textarea data-toggle="validator" data-minlength="6" class="form-control" id="inputName" required name="description"><?php echo @$_POST['description'] ?> </textarea>
			</div>
			<div class="bottom">
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="add">Add</button>
				</div>
			</div>
		</form>
	</div>
</div>
<br/><br/><hr/><br/>

<?php

	$user->displayCategories();
	footer::doFooter();
	ob_end_flush();

?>
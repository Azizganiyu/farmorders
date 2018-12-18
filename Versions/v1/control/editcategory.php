<?php

	ob_start();
	session_start();
	if(isset($_GET['cat']))
	{
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
		$user->access("1");
		header::doHeader('Edit category');

?>		

<div class="inline-form widget-shadow">
	<div class="form-title">
		<h4>Edit category : <?php echo $user->display_cat('catName');?></h4>
	</div>
	<div class="form-body">
		<form data-toggle="validator" method="post" action="editcategory.php?cat=<?php echo $user->display_cat('id'); ?>">
			<?php $user->updateCat(); ?>
			<div class="clearfix"></div>
			<hr/>
			<div class="form-group has-feedback">
				<input type="text" class="form-control" id="inputName" placeholder="category name" data-error="Bruh, that name is invalid" required name="name" value="<?php echo $user->display_cat('catName'); ?>">
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
			</div>
			<div class="form-group">
				<textarea data-toggle="validator" data-minlength="6" class="form-control" id="inputName" required name="description"><?php echo $user->display_cat('catDesc'); ?> </textarea>
			</div>
			<div class="bottom">
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="update">Update</button>
				</div>
			</div>
		</form>
	</div>
</div>
<br/><br/><hr/><br/>
<br/><hr/><br/>

<?php

	footer::doFooter();
	}
	else
	{
		header('location:products.php');
	}
	ob_end_flush();

?>						

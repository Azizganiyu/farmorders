<?php

	ob_start();
	session_start();
	if(isset($_GET['productimg']))
	{
		$_SESSION['productimgupdate'] = $_GET['productimg'];
		header('location:image.php');
	}
	elseif(isset($_GET['product']))
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
		header::doHeader('Update Products');

?>		

<div class="row">
	<div class="form-title">
		<h3 class="title1">Update product : <?php echo $user->display_product('name');?></h3>
	</div>
	<div class="form-body" data-example-id="simple-form-inline">
		<form class="form-horizontal" enctype="multipart/form-data" method="post" action="editproduct.php?product=<?php echo $user->display_product('id'); ?>">
			<?php $user->updateProduct(); ?>
			<div class="clearfix"></div>
			<hr/>
			<div class="form-group">
				<label for="productName" class="col-sm-2 control-label">Product Name *</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="productName" placeholder="Product Name" name="name" required="required" data-error="username is required." value="<?php echo $user->display_product('name'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="Description" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-8"><textarea name="description" id="Description" cols="50" rows="4" class="form-control1"><?php echo $user->display_product('description'); ?></textarea></div>
			</div>
			<div class="form-group">
				<label for="metatt" class="col-sm-2 control-label">Meta tag title</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="productName" placeholder="Meta tag title" name="metatt" value="<?php echo $user->display_product('metaTagTitle'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="metatd" class="col-sm-2 control-label">Meta tag description</label>
				<div class="col-sm-8">
					<textarea name="metatd" id="metatd" cols="50" rows="4" class="form-control1"><?php echo $user->display_product('metaTagDescription'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="metatk" class="col-sm-2 control-label">Meta tag keyword</label>
				<div class="col-sm-8">
					<textarea name="metatk" id="metatk" cols="50" rows="4" class="form-control1"><?php echo $user->display_product('metaTagKeyword'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="oc" class="col-sm-2 control-label">Owner/Company *</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="oc" placeholder="Owner/Company Name" name="oc" required="required" data-error="username is required." value="<?php echo $user->display_product('owner_company'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="cat" class="col-sm-2 control-label">Category *</label>
				<div class="col-sm-8">
					<select name="category" id="cat" class="form-control1">
				
					<?php

						$dbquery = DB::query('SELECT * FROM categories');
						foreach ($dbquery as $p)
						{
							
							?>

							<option
							<?php
								if ($user->display_product('categoryId') == $p['id'] )
								{
									echo "selected";
								}

							?>
							><?php echo $p['catName']; ?></option>
						
							<?php

						}

							?>
			
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="price" class="col-sm-2 control-label abe">Price *</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="price" placeholder="price detail" name="price" required="required" data-error="Price details required." value="<?php echo $user->display_product('price'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="qty" class="col-sm-2 control-label">Quantity *</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="qty" placeholder="Available Quantity" name="qty" required="required" data-error="Quantity required." value="<?php echo $user->display_product('quantity'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="radio" class="col-sm-2 control-label">Delivery?</label>
				<div class="col-sm-8">
					<div class="radio-inline">
						<label><input type="radio" checked="" value="yes" name="delivery"> Yes </label>
					</div>
					<div class="radio-inline">
						<label><input type="radio" name="delivery" value="no"> No </label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="weight" class="col-sm-2 control-label">Weight (kg) *</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="weight" placeholder="Weight of product" name="weight" value="<?php echo $user->display_product('weight'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="status" class="col-sm-2 control-label">Status</label>
				<div class="col-sm-8">
					<div class="radio-inline">
						<label><input type="radio" 
						<?php
						if ($user->display_product('status') == 'Active')
						{
							echo "checked";
						}
						?>
						 value="Active" name="status"> Active </label>
					</div>
					<div class="radio-inline">
						<label><input type="radio"
						<?php
						if ($user->display_product('status') == 'Inactive')
						{
							echo "checked";
						}
						?>
						 name="status" value="Inactive"> Inactive </label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-8">
					<input type="submit" class="btn btn-primary " name="submit" value="Submit" />
				</div>
			</div>
		</form>
	</div>
</div>
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

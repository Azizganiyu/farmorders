<?php
include('classes/class.admin.php');
class product extends admin
{
	public function addCategory()
	{
		$error = false;
		$errmsg = array();
		if (isset($_POST['add']))
		{
			$name = FilterVars::filterString($_POST['name']);
			$description = FilterVars::filterString($_POST['description']);

			if(empty($name))
				{
					$error = true;
					array_push($errmsg, "Please enter a category name");
				}
				elseif(strlen($name) <3 || strlen($name) >32)
				{
					$error = true;
					array_push($errmsg, "name length error. min 3 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$name))
				{
					$error = true;
					array_push($errmsg, "Invalid name");
				}
				elseif(DB::query('SELECT catName FROM categories WHERE catName = :c', array(':c'=>$name)))
				{
					$error = true;
					array_push($errmsg, "Category already exist");	
				}

			if(empty($description))
				{
					$error = true;
					array_push($errmsg, "Please Describe the category");
				}

			if(!$error)
				{
					//Insert data into database if no errors
					DB::query('INSERT INTO categories VALUES (\'\', :n, :d)', array(':n'=>$name, ':d'=>$description));
					?>
						<div role="alert" class="col-sm-10 alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo "<font color='green'>Succesfully added</font>"; ?></strong><br/>
						</div>
						<?php
					
				}else 
				{
					foreach ($errmsg as $e) {
						?>
						<div role="alert" class="col-sm-10 alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo $e."<br>"; ?></strong></div>
						<?php
					}
				}
				
		}
	}

	public function updateCat()
	{
		$error = false;
		$errmsg = array();
		$id = $_GET['cat'];
		if (isset($_POST['update']))
		{
			$name = FilterVars::filterString($_POST['name']);
			$description = FilterVars::filterString($_POST['description']);

			if(empty($name))
				{
					$error = true;
					array_push($errmsg, "Please enter a category name");
				}
				elseif(strlen($name) <3 || strlen($name) >32)
				{
					$error = true;
					array_push($errmsg, "name length error. min 3 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$name))
				{
					$error = true;
					array_push($errmsg, "Invalid name");
				}
				elseif(DB::query('SELECT catName FROM categories WHERE catName = :c', array(':c'=>$name)))
				{
					$error = true;
					array_push($errmsg, "Category already exist");	
				}

			if(empty($description))
				{
					$error = true;
					array_push($errmsg, "Please Describe the category");
				}

			if(!$error)
				{
					//Insert data into database if no errors
					DB::query('UPDATE Categories SET catName =:n, catDesc = :d WHERE id = :i', array(':n'=>$name, ':d'=>$description, ':i'=>$id));
					?>
						<div role="alert" class="col-sm-10 alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo "<font color='green'>Succesfully Updated</font>"; ?></strong><br/>
						</div>
						<?php
					
				}else 
				{
					foreach ($errmsg as $e) {
						?>
						<div role="alert" class="col-sm-10 alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo $e."<br>"; ?></strong></div>
						<?php
					}
				}
				
		}
	}

	public function newProduct()
	{
		$error = false;
		$errmsg = array();

		if(isset($_POST['submit']))
		{
			$name = FilterVars::filterString($_POST['name']);
			$description = FilterVars::filterString($_POST['description']);
			$metatt = FilterVars::filterString($_POST['metatt']);
			$metatd = FilterVars::filterString($_POST['metatd']);
			$metatk = FilterVars::filterString($_POST['metatk']);
			$oc = FilterVars::filterString($_POST['oc']);
			$category = FilterVars::filterString($_POST['category']);
			$price = FilterVars::filterString($_POST['price']);
			$qty = FilterVars::filterString($_POST['qty']);
			$delivery = FilterVars::filterString($_POST['delivery']);
			$weight = FilterVars::filterString($_POST['weight']);
			$status = FilterVars::filterString($_POST['status']);

			//name validate
			if(empty($name))
				{
					$error = true;
					array_push($errmsg, "Please enter a Product name");
				}
				elseif(strlen($name) >32)
				{
					$error = true;
					array_push($errmsg, "name length error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$name))
				{
					$error = true;
					array_push($errmsg, "Invalid Product name");
				}
				elseif(DB::query('SELECT name FROM products WHERE name = :c', array(':c'=>$name)))
				{
					$error = true;
					array_push($errmsg, "Product already exist");	
				}

			//oc/company name validate
				if(empty($oc))
				{
					$error = true;
					array_push($errmsg, "Please enter an owner or company name");
				}
				elseif(strlen($oc) >64)
				{
					$error = true;
					array_push($errmsg, "name length error. max 64 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$oc))
				{
					$error = true;
					array_push($errmsg, "Invalid owner/company name");
				}

			//category id
				$categoryId = DB::query('SELECT id FROM categories WHERE catName = :c', array(':c'=>$category))[0]['id'];

			//Price validate
				if(empty($price))
				{
					$error = true;
					array_push($errmsg, "Please enter price of product");
				}
				elseif(strlen($price) >32)
				{
					$error = true;
					array_push($errmsg, "price length error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_(). ]+$/",$price))
				{
					$error = true;
					array_push($errmsg, "Price");
				}

				//Quantity validate
				if(empty($qty))
				{
					$error = true;
					array_push($errmsg, "Specify quantity");
				}
				elseif(strlen($qty) >32)
				{
					$error = true;
					array_push($errmsg, "Quantity length error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$qty))
				{
					$error = true;
					array_push($errmsg, "Invalid Quantity");
				}

				//weight validate
				if(empty($weight))
				{
					$error = true;
					array_push($errmsg, "Please enter weight");
				}
				elseif(strlen($weight) >32)
				{
					$error = true;
					array_push($errmsg, "weight error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$weight))
				{
					$error = true;
					array_push($errmsg, "Invalid weight");
				}

				if(!$error)
				{
					//Insert data into database if no errors
					DB::query('INSERT INTO products VALUES (\'\', :n, :d, :mt, :md, :mk, :o, :c, :p, :q, :y, :w, :s )', array(':n'=>$name, ':d'=>$description, ':mt'=>$metatt, ':md'=>$metatd, ':mk'=>$metatk, ':o'=>$oc, ':c'=>$categoryId, ':p'=>$price, ':q'=>$qty, ':y'=>$delivery, ':w'=>$weight, ':s'=>$status));
					$productId = DB::query('SELECT id FROM products WHERE name = :n', array(':n'=>$name))[0]['id'];
					$_SESSION['productimg'] = $productId;
					?>
						<div role="alert" class="col-sm-10 alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo "<font color='green'>Succesfully added</font>"; ?></strong><br/>
						</div>
						<div class="col-sm-10">
							<a class="btn btn-secondary" href="image.php" target="_blank"> Click here to add pictures </a>
						</div>
						

						<?php
					
				}else 
				{
					foreach ($errmsg as $e) {
						?>
						<div role="alert" class="col-sm-10 alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo $e."<br>"; ?></strong></div>
						<?php
					}
				}
		}
	}


	public function updateProduct()
	{
		$error = false;
		$errmsg = array();
		$id = $_GET['product'];
		if(isset($_POST['submit']))
		{
			$name = FilterVars::filterString($_POST['name']);
			$description = FilterVars::filterString($_POST['description']);
			$metatt = FilterVars::filterString($_POST['metatt']);
			$metatd = FilterVars::filterString($_POST['metatd']);
			$metatk = FilterVars::filterString($_POST['metatk']);
			$oc = FilterVars::filterString($_POST['oc']);
			$category = FilterVars::filterString($_POST['category']);
			$price = FilterVars::filterString($_POST['price']);
			$qty = FilterVars::filterString($_POST['qty']);
			$delivery = FilterVars::filterString($_POST['delivery']);
			$weight = FilterVars::filterString($_POST['weight']);
			$status = FilterVars::filterString($_POST['status']);

			//name validate
			if(empty($name))
				{
					$error = true;
					array_push($errmsg, "Please enter a Product name");
				}
				elseif(strlen($name) >32)
				{
					$error = true;
					array_push($errmsg, "name length error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$name))
				{
					$error = true;
					array_push($errmsg, "Invalid Product name");
				}

			//oc/company name validate
				if(empty($oc))
				{
					$error = true;
					array_push($errmsg, "Please enter an owner or company name");
				}
				elseif(strlen($oc) >64)
				{
					$error = true;
					array_push($errmsg, "name length error. max 64 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$oc))
				{
					$error = true;
					array_push($errmsg, "Invalid owner/company name");
				}

			//category id
				$categoryId = DB::query('SELECT id FROM categories WHERE catName = :c', array(':c'=>$category))[0]['id'];

			//Price validate
				if(empty($price))
				{
					$error = true;
					array_push($errmsg, "Please enter price of product");
				}
				elseif(strlen($price) >32)
				{
					$error = true;
					array_push($errmsg, "price length error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_(). ]+$/",$price))
				{
					$error = true;
					array_push($errmsg, "Price");
				}

				//Quantity validate
				if(empty($qty))
				{
					$error = true;
					array_push($errmsg, "Specify quantity");
				}
				elseif(strlen($qty) >32)
				{
					$error = true;
					array_push($errmsg, "Quantity length error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$qty))
				{
					$error = true;
					array_push($errmsg, "Invalid Quantity");
				}

				//weight validate
				if(empty($weight))
				{
					$error = true;
					array_push($errmsg, "Please enter weight");
				}
				elseif(strlen($weight) >32)
				{
					$error = true;
					array_push($errmsg, "weight error. max 32 chars");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_() ]+$/",$weight))
				{
					$error = true;
					array_push($errmsg, "Invalid weight");
				}

				if(!$error)
				{
					//update data into database if no errors
					DB::query('UPDATE products SET name = :n, description = :d, metaTagTitle = :mt, metaTagDescription = :md, metaTagKeyword = :mk, owner_company = :o, categoryId = :c, price = :p, quantity = :q, Delivery = :y, weight = :w, status = :s Where id = :i', array(':n'=>$name, ':d'=>$description, ':mt'=>$metatt, ':md'=>$metatd, ':mk'=>$metatk, ':o'=>$oc, ':c'=>$categoryId, ':p'=>$price, ':q'=>$qty, ':y'=>$delivery, ':w'=>$weight, ':s'=>$status, ':i'=>$id));
					?>
						<div role="alert" class="col-sm-10 alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo "<font color='green'>Succesfully Updated</font>"; ?></strong><br/>
						</div>
						
						

						<?php
					
				}else 
				{
					foreach ($errmsg as $e) {
						?>
						<div role="alert" class="col-sm-10 alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo $e."<br>"; ?></strong></div>
						<?php
					}
				}
		}
	}



	public function displayproducts()
	{
		?>
		<div class="table-responsive bs-example widget-shadow">
		<h4 class="product-list-shift"><i class="fa fa-list"></i>&nbsp;List of products</h4>
		<table class="table table-hover table-bordered">
			<thead style="color: #4876FF;">
				<tr>
					<th>Image</th> <th>Product Name</th> <th>Price</th>  <th>Quantity</th> <th>Status</th> <th>Action</th>
				</tr>
			</thead>
			<tbody>
				<div class="bs-example widget-shadow" data-example-id="hoverable-table">
		<?php
		$dbPost = DB::query('SELECT * FROM products order by id desc');
		foreach ($dbPost as $p)
	{
		$imgUrl="";
		if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id'])))
			{
				$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id']))[0]['url'];
			}
			?>
						
			<tr>
				<th scope="row"><div class="product-img-container"><img src="<?php echo $imgUrl; ?>" alt="No image"></div><a href="editProduct.php?productimg=<?php echo $p['id']?>" data-toggle="tooltip" title="" class="btn btn-default " data-original-title="Edit image" target="_blank"><i class="fa fa-pencil product-img-btn"></i></a></th>
				<td><?php echo $p['name']; ?></td>
				<td><?php echo $p['price']; ?></td> 
				<td><span class="label label-success"><?php echo $p['quantity']; ?></span></td> 
				<td><?php echo $p['status']; ?></td> 
				<td><a href="editproduct.php?product=<?php echo $p['id']?>" data-toggle="tooltip" title="" class="btn btn-primary " data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="delProduct.php?product=<?php echo $p['id']?>" data-toggle="tooltip" title="" class="btn btn-danger product-del-btn " data-original-title="Delete" onclick="return confirm('Are you sure you want to delete');"><i class="fa fa-trash-o" ></i></a> </td> </tr>
			<?php
		} ?>

		</tbody>
	</table>
	</div>
	<?php
	}

	public static function display_product($item){
	//get contents from database using admin id to extract information from database 
	$id = $_GET['product'];
  	$query = DB::query('SELECT * FROM products WHERE id = :i', array(':i'=>$id))[0][$item];
  		return $query; //display item
		}

	public static function display_cat($item){
	//get contents from database using admin id to extract information from database 
	$id = $_GET['cat'];
  	$query = DB::query('SELECT * FROM categories WHERE id = :i', array(':i'=>$id))[0][$item];
  		return $query; //display item
		}

	public static function delProduct(){
		$id = $_GET['product'];
		DB::query('DELETE from products WHERE id = :i', array(':i'=>$id));
		DB::query('DELETE from prdctimgurl WHERE productId = :i', array(':i'=>$id));
}

	public function displaycategories()
	{
		?>
		<div class="table-responsive bs-example widget-shadow">
		<h4 class="product-list-shift"><i class="fa fa-list"></i>&nbsp;List of categories</h4>
		<table class="table table-hover table-bordered">
			<thead style="color: #4876FF;">
				<tr>
					<th>Category</th> <th>Number of products</th> <th>Action</th>
				</tr>
			</thead>
			<tbody>
				<div class="bs-example widget-shadow" data-example-id="hoverable-table">
		<?php
		$dbPost = DB::query('SELECT * FROM Categories order by id desc');
		foreach ($dbPost as $p)
	{
		$query = DB::query('SELECT * FROM products Where categoryId = :i', array(':i'=>$p['id']));
		$numberOfProduct = count($query);
			?>
						
			<tr>
				<th><?php echo $p['catName']; ?></th>
				<td><?php echo $numberOfProduct ?></td> 
				<td><a href="editCategory.php?cat=<?php echo $p['id']?>" data-toggle="tooltip" title="" class="btn btn-primary " data-original-title="Edit"><i class="fa fa-pencil"></i> </td>
				</tr>
			<?php
		} ?>

		</tbody>
	</table>
	</div>
	<?php
	}


	public function displayorders()
	{
		?>
		<div class="table-responsive bs-example widget-shadow">
		<h4 class="product-list-shift"><i class="fa fa-list"></i>&nbsp;List of Orders</h4>
		<table class="table table-hover table-bordered">
			<thead style="color: #4876FF;">
				<tr>
					<th>Code</th><th>Product</th> <th>Quantity</th> <th>Address</th> <th>Phone</th> <th>Email</th> <th>Date ordered</th>  <th>Payment status</th> <th>Delivery status</th>
				</tr>
			</thead>
			<tbody>
				<div class="bs-example widget-shadow" data-example-id="hoverable-table">
		<?php
		$dbPost = DB::query('SELECT * FROM orders order by id desc');
		foreach ($dbPost as $p)
	{
			?>
						
			<tr>
				
				<td>#<?php echo $p['id'].$p['productCode']; ?></td>
				<td><?php echo $p['productName']; ?></td>  
				<td><span class="label label-success"><?php echo $p['productQty']; ?></span></td>  
				<td><?php echo $p['street_city'].' '.$p['state']; ?></td>
				<td><?php echo $p['telephone']; ?></td> 
				<td><?php echo $p['emailAddress']; ?></td>  
				<td><?php echo $p['date']; ?></td>
				<td><?php echo $p['paymentStatus']; ?></td> 
				<td><form action="index.php" method="post" class="form-inline" role="form">
					<div class="form-group">
					<select name="status" id="cat" class="form-control1" style="display: inline;">
					<option selected=""><?php echo $p['deliveryStatus']; ?></option>
					<option>Being prepared</option>
					<option>Recieved</option>
					<option>cancelled</option>
					<option>On hold</option>
					</select></div><input type="hidden" name="id" value="<?php echo $p['id']; ?>"><button class="btn btn-link deliveryUpdate" type="submit" name="deliveryUpdate"><i class="fa fa-refresh"></i> Update</button><span class="label label-primary">
					<?php echo $p['deliveryStatus']; ?></span>
					</form>
				</td> 
			</tr>
			<?php
		} ?>

		</tbody>
	</table>
	</div>
	<?php
	}

	public function updateDelivery(){
		if (isset($_POST['deliveryUpdate'])){
			$status = $_POST['status'];
			$id =  $_POST['id'];

			DB::query('UPDATE orders SET deliveryStatus = :d WHERE id = :i', array(':d'=>$status, ':i'=>$id));
							
		}
	}
}
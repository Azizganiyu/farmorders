<?php

		include('classes/class.user.php');
		class Product extends user
		{
			
			public function getCategories()
			{
				$alllist = DB::query('SELECT * FROM products WHERE status != :a', array(':a'=>'inactive'));

				?>

				<li class="list-group-item">
					<a class="category-link" href="market.php">All</a>
		      		<span class="label label-primary pull-right"><?php echo count($alllist); ?></span>
		        </li>

				<?php

				$query = DB::query('SELECT * FROM categories');
				foreach ($query as $p)
				{ 
					$catlist = DB::query('SELECT * FROM products WHERE categoryId = :i AND status != :a', array(':i'=>$p['id'], ':a'=>'inactive'));

				?>

				<li class="list-group-item">
					<a class="category-link" href="market.php?cat=<?php echo $p['id']; ?>"><?php echo $p['catName']; ?></a>
		      		<span class="label label-primary pull-right"><?php echo count($catlist); ?></span>
		        </li>

		        <?php

				}
			}


			public function getCategoriesFooter()
			{
				$query = DB::query('SELECT * FROM categories');
				foreach ($query as $p)
				{ 
				$catlist = DB::query('SELECT * FROM products WHERE categoryId = :i AND status = :a', array(':i'=>$p['id'], ':a'=>'active'));

				?>

				<li>
					<a href="market.php?cat=<?php echo $p['id']; ?>"><?php echo $p['catName']; ?></a>
		        </li>

		        <?php

				}
			}


			public function displayProducts()
			{
				if(isset($_GET['cat']))
				{	
					if(isset($_GET['filter']))
					{
						if($_GET['filter']=='ptl')
						{
							$dbPost = DB::query('SELECT * FROM products WHERE categoryId = :i AND status != :a order by price asc', array(':i'=>$_GET['cat'], ':a'=>'inactive'));
						}
						elseif($_GET['filter']=='pth')
						{
							$dbPost = DB::query('SELECT * FROM products WHERE categoryId = :i  AND status != :a order by price desc', array(':i'=>$_GET['cat'], ':a'=>'inactive'));
						}
					}
					else
					{
						$dbPost = DB::query('SELECT * FROM products WHERE categoryId = :i AND status != :a order by id desc', array(':i'=>$_GET['cat'], ':a'=>'inactive'));
					}
				}
				else
				{
					if(isset($_GET['filter']))
					{
						if(isset($_GET['filter'])=='ptl')
						{
							$dbPost = DB::query('SELECT * FROM products WHERE status != :a order by price asc', array(':a'=>'inactive'));
						}
						elseif(isset($_GET['filter'])=='pth')
						{
						$dbPost = DB::query('SELECT * FROM products WHERE status != :a order by price desc', array(':a'=>'inactive'));
						} 
					}
					else
					{
						$dbPost = DB::query('SELECT * FROM products WHERE status != :a order by id desc', array(':a'=>'inactive'));
					}
				}
				foreach ($dbPost as $p)
				{
					$imgUrl="";
					if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id'])))
						{
							$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id']))[0]['url'];
						}

						?>

						<div class="col-md-4 text-center col-xs-offset-1 col-xs-10">
							<div class="thumbnail product-box">        	
								<img src="control/<?php echo $imgUrl; ?>" alt="No image" />
								<div class="caption">
									<h4><a href="#"><?php echo $p['name']; ?></a></h4>
									<p><a href="#"><span>&#8358;</span><?php echo $p['price']; ?></a></p>
									<p><a href="detail.php?product=<?php echo $p['id']; ?>" class="btn btn-success view" role="button">View</a></p>
								</div>
							</div>
						</div>

			            <?php

				}
			}


			public function sortProduct()
			{
				if(isset($_GET['cat']))
				{
					return "cat=".$_GET['cat']."&filter=";
				}
				else
				{
					return "filter=";
				}
			}


			public function marketCategory()
			{
				if(isset($_GET['cat']))
				{
					$query = DB::query('SELECT catName FROM categories Where id = :i', array(':i'=>$_GET['cat']))[0]['catName'];
					return $query.". ";
				}
				else
				{
					return "All. ";
				}
			}


			public function countProduct()
			{
				if(isset($_GET['cat']))
				{
					$query = DB::query('SELECT * FROM products Where categoryId = :i AND status != :a', array(':i'=>$_GET['cat'], ':a'=>'inactive'));
					return count($query);
				}
				else
				{
					$query = DB::query('SELECT * FROM products WHERE status != :a', array(':a'=>'inactive'));
					return count($query);
				}
			}


			public function addCart()
			{
				$error = false;
				$errmsg = array();
				if(isset($_POST['add_to_cart']))
				{
					if(!isset($_SESSION['cart']))
					{
						$_SESSION['cart'] = array();
					}
					if(isset($_GET['productcode']))
					{
						$qty = FilterVars::filterString($_POST['qty']);
						if (!preg_match("/^[0-9]+$/",$qty))
						{
							$error = true;
							array_push($errmsg, "Invalid Quantity");
						}
						elseif(in_array($_GET['productcode'], $_SESSION['cart']))
						{
							$error = true;
							array_push($errmsg, "Product already in cart");	
						} 
						if(!$error)
						{
							$_SESSION['cart'][$_GET['productcode']] = $qty;
							header('location:cart.php');
						}
						else
						{
							foreach ($errmsg as $e)
							{

							?>

							<div role="alert" class="col-sm-10 alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a><strong><?php echo $e."<br>"; ?></strong></div>
							
							<?php

							}
						}

					}
				}
			}


			public function removeCart()
			{
				if(!isset($_SESSION['cart']))
				{
					$_SESSION['cart'] = array();
				}
				if(isset($_GET['remcart']))
				{
					unset($_SESSION['cart'][$_GET['remcart']]);
					$itemPrice = DB::query('SELECT price FROM products WHERE id = :i', array(':i'=>$_GET['remcart']))[0]['price'];
					if($_SESSION['totalPrice'] > 0)
					{
						$_SESSION['totalPrice'] -=  $itemPrice;	
					}
				} 
			}


			public function countCartItem()
			{
				if(isset($_SESSION['cart']))
				{
					return count($_SESSION['cart']);
				}
				else
				{
					return 0;
				}
			}

			
			public function displayCartItems()
			{
				if(isset($_SESSION['cart']))
				{
					$_SESSION['totalPrice'] = 0;
					foreach ($_SESSION['cart'] as $key => $value)
					{
						$query = DB::query('SELECT * FROM products WHERE id = :i', array(':i'=>$key));
						foreach ($query as $p)
						{
							@$total = $p['price']*$value;
							$imgUrl="";
							if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id'])))
							{
								$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id']))[0]['url'];
							}

							?>

							<tr>
								<td>
									<a href="#"><img src="control/<?php echo $imgUrl; ?>" alt="No image"></a>
								</td>
								<td>
									<a href="detail.php?product=<?php echo $p['id']; ?>"><?php echo $p['name']; ?></a>
								</td>
								<td>
									<?php echo $value; ?>
								</td>
								<td>
								<span>&#8358;</span><?php echo $p['price']; ?>
								</td>
								<td>
									<?php echo $p['delivery']; ?>
								</td>
								<td>
								<span>&#8358;</span><?php echo $total; ?>
								</td>
								<td>
									<a href="cart.php?remcart=<?php echo $p['id']; ?>"><i class="fab fa-trash-o">Remove</i></a>
								</td>
							</tr>

		                  	<?php

		                  	$_SESSION['totalPrice'] +=  $total;
						}
					}
				}
			}


				
			public function topFeatured()
			{
			$topFeatured = DB::query('SELECT * FROM products WHERE status = :a order by id desc limit 4', array(':a'=>'top-featured'))[0];
				if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$topFeatured['id'])))
					{
						$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$topFeatured['id']))[0]['url'];
					}
					?>
					<div class='row'>
						<div class="col-sm-6 box box-top-featured" style="padding-left:30px;">
							<img src="control/<?php echo $imgUrl; ?>" alt="No image" class="img-responsive" />
						</div>
						<div class="col-sm-6" style='padding-left:50px; padding-right:50px;'>
							<div class='row'>
								<h3 class='featuredTitle'><?php echo $topFeatured['name']; ?></h3>
								<h4 class='featuredDescription' style='font-family: arial, Helvetica, sans-serif; font-weight:light; margin-bottom:40px; padding-left:50px; padding-right:50px; line-height:30px;'><?php echo $topFeatured['description']; ?></h4>
								<div class='row'>
									<div class='col-sm-5 col-sm-offset-7'>
										<a href="detail.php?product=<?php echo $topFeatured['id']; ?>"><button class='btn btn-default' style='margin-right:10px;margin-bottom:10px;'>More Info</button></a>
										<a href="detail.php?product=<?php echo $topFeatured['id']; ?>"><button class='btn btn-default' style='margin-bottom:10px;'>Buy Now</button></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				
			}

			public function featuredProducts()
			{
				$dbPost = DB::query('SELECT * FROM products WHERE status = :a order by id desc limit 4', array(':a'=>'featured'));
				foreach ($dbPost as $p)
				{
					$imgUrl="";
					if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id'])))
						{
							$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id']))[0]['url'];
						}

						

						?>
						

						<div class="col-sm-3">
							<div class="box same-height clickable">
								<div class="product">
									<a href="detail.php?product=<?php echo $p['id']; ?>" class="latest-product">
										<img src="control/<?php echo $imgUrl; ?>" alt="No image" class="img-responsive" />
									</a>			                            
								</div>
								<div class="text">
										<h4><a href="detail.php?product=<?php echo $p['id']; ?>">
										<?php echo $p['name']; ?></a></h4>
										<h5><a href="detail.php?product=<?php echo $p['id']; ?>"><span>&#8358;</span>
										<?php echo $p['price']; ?></a></h5>
									
								</div>
							</div>
						</div>
			                    <?php

				}
			}


			public function relatedProducts($related)
			{
					$string = $related;
					$searchKeys = str_split($string, 4);
					$product = array();
					foreach ($searchKeys as $s)
					{
						if(strlen($s) > 2)
						{
							$key ='%'.$s.'%';
							$query=DB::query('SELECT * FROM products WHERE name like :k AND status != :s', array(':k'=>$key, ':s'=>'inactive'));
							if (count($query)>0)
							{ 
								foreach ($query as $p)
								{
									if(!in_array($p['name'],$product) && $p['name'] != $related )
									{
										array_push($product, $p['name']);
									}
									
								}
							}
						}
					}

					if(count($product)>0)
					{
						foreach ($product as $k)
		    			{
							$query=DB::query('SELECT * FROM products WHERE name = :k AND status != :s', array(':k'=>$k,':s'=>'inactive'))[0];
							if($query)
							{
								$imgUrl="";
								if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$query['id'])))
								{
									$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$query['id']))[0]['url'];
								}
								
								?>

								<div class="col-sm-3">
								<div class="box same-height clickable">
									<div class="product">
										<a href="detail.php?product=<?php echo $query['id']; ?>" class="latest-product">
											<img src="control/<?php echo $imgUrl; ?>" alt="No image" class="img-responsive" />
										</a>			                            
									</div>
									<div class="text">
										<h4>
											<a href="detail.php?product=<?php echo $query['id']; ?>">
											<?php echo $query['name']; ?></a></h4>
										
									</div>
								</div>
								</div>
								
							
								<?php
							}

		    			} 

		    				?>


		    		<?php
		    		
					}
		    		else
		    		{
		    		echo "<h4> No related product </h4></div>";
					}
			}
				
			
			
			public function latestProduct()
			{
				$dbPost = DB::query('SELECT * FROM products WHERE status != :a order by id desc limit 4', array(':a'=>'inactive'));
				foreach ($dbPost as $p)
				{
					$imgUrl="";
					if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id'])))
						{
							$imgUrl=DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id']))[0]['url'];
						}

						

						?>
						

						<div class="col-sm-3">
							<div class="box same-height clickable">
								<div class="product">
									<a href="detail.php?product=<?php echo $p['id']; ?>" class="latest-product">
										<img src="control/<?php echo $imgUrl; ?>" alt="No image" class="img-responsive" />
									</a>			                            
								</div>
								<div class="text">
									<h4>
										<a href="detail.php?product=<?php echo $p['id']; ?>"><span>&#8358;</span>
										<?php echo $p['price']; ?></a></h4>
									
								</div>
							</div>
						</div>
			                    <?php

				}
			}


			public static function display_product($item)
			{
				if(isset($_GET['product']))
				{
					$id = $_GET['product'];
					if($item == "image")
					{
						$query = DB::query('SELECT url FROM prdctimgurl WHERE productId = :i', array(':i'=>$id))[0]['url'];
			  			return $query;
					}
					else
					{
						//get contents from database using admin id to extract information from database 
						$id = $_GET['product'];
				  		$query = DB::query('SELECT * FROM products WHERE id = :i', array(':i'=>$id))[0][$item];
				  		return $query; //display item
					}
				}

			}


			public function placeOrder()
			{
				if(isset($_SESSION['cart']))
				{
					$_SESSION['codes'] ="";
					foreach ($_SESSION['cart'] as $key => $value)
					{
						$query = DB::query('SELECT * FROM products WHERE id = :i', array(':i'=>$key));
						foreach ($query as $p)
						{	
							$imgUrl="";
							if(DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id'])))
							{
								$imgUrl= DB::query('SELECT url FROM prdctimgurl Where productId = :i', array(':i'=>$p['id']))[0]['url'];
							}
							$productName = $p['name']; 
		                    $productQuantity = $value; 
		                    $productPrice = $p['price'];
		                    $delivery = $p['delivery']; 
		                    $total = $p['price']*$value;
		                    $productId = $p['id'];
		                    $customerId = user::isLoggedIn();
		                    $query2 = DB::query('SELECT * FROM users WHERE id = :i', array(':i'=>$customerId));
		                    foreach ($query2 as $c)
		                    {
		                    	$customerUsername = $c['username'];
		                    	$customerStreet_City = FilterVars::filterString($_POST['street']);
								$customerState = FilterVars::filterString($_POST['state']);
								$customerTelephone = FilterVars::filterString($_POST['telephone']);
								$orderDescription = FilterVars::filterString($_POST['desc']);
		                    	$customerEmail = $c['email'];
		                    	$productCode = $customerId.$productId;
		                    	$date = date("Y-m-d H:i:s");
		                    }
						}
						//$_SESSION['codes'] .=" ".$productCode;
						DB::query('INSERT INTO orders VALUES(\'\', :pc, :ci, :pi, :cn, :pn, :pq, :pp, :t, :csc, :cs, :ct, :ce, :od, :iu, :d, :to, :ps, :ds)', array(':pc'=>$productCode, ':ci'=>$customerId, ':pi'=>$productId, ':cn'=>$customerUsername, ':pn'=>$productName, ':pq'=>$productQuantity, ':pp'=>$productPrice, ':t'=>$total, ':csc'=>$customerStreet_City, ':cs'=>$customerState, ':ct'=>$customerTelephone, ':ce'=>$customerEmail, ':od'=>$orderDescription, ':iu'=>$imgUrl, ':d'=>$date, ':to'=>time(), ':ps'=>"Unpaid", ':ds'=>"Pending"));
						DB::query('UPDATE users SET street = :str, state = :sta, telephone =:t WHERE id = :i', array(':str'=>$customerStreet_City, ':sta'=>$customerState, ':t'=>$customerTelephone, ':i'=>$customerId));
					}
				}
			}


			/*public function paymentdet()
			{
				$customerId = user::isLoggedIn();
				$productCodes = $_SESSION['codes'];
				$amount = $_SESSION['totalPrice'];
				$shippingFee = 00;
				$total = $amount + $shippingFee;
				$date = date("Y-m-d H:i:s");
				DB::query('INSERT INTO payment VALUES(\'\', :ci, :pc, :a, :sf, :t, :d, :s)', array(':ci'=>$customerId, ':pc'=>$productCodes, ':a'=>$amount, ':sf'=>$shippingFee, ':t'=>$total, ':d'=>$date, ':s'=>"Unpaid"));
			}*/


			public function searchProduct()
			{
				if((isset($_POST['submit'])))
				{
					$string = FilterVars::filterString($_POST['key']);
					$searchKeys = str_split($string, 4);
					$product = array();
					foreach ($searchKeys as $s)
					{
						if(strlen($s)>2)
						{
							$key ='%'.$s.'%';
							$query=DB::query('SELECT * FROM products WHERE name like :k AND status != :s', array(':k'=>$key, ':s'=>'inactive'));
							if (count($query)>0)
							{ 
								foreach ($query as $p)
								{
									if(!in_array($p['name'],$product))
									{
										array_push($product, $p['name']);
									}
									
								}
							}
						}
					}

					?>

					<div class="container">
						<div class="col-sm-12 col-md-6">
							<h4>Result(s) - <?php echo count($product); ?> </h4>

					<?php

					if(count($product)>0)
					{
						foreach ($product as $k)
		    			{
							$query=DB::query('SELECT * FROM products WHERE name = :k AND status != :s', array(':k'=>$k, ':s'=>'inactive'))[0];
							if($query)
							{
							?>
		    				<div class="col-sm-10 col-sm-offset-1 search-result">
		    					<h4><a href="detail.php?product=<?php echo $query['id']; ?>"><?php echo $query['name']; ?></a></h4>
								<h6> <?php echo $query['description']; ?> </h6>
							</div>
							
		    			
		                    <?php
							}
		    			} 

		    				?>

		    			</div>
		    		

		    		<?php
		    		
					}
		    		else
		    		{
		    		echo "<h4> No result found </h4></div>";
					}
				}
		    	
			}

		}

?>
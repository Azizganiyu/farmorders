<?php
	include('class.filtervars.php');
	class user
	{
	
		public function register()
		{
			$error = false;
			$errmsg = array();
			if (isset($_POST['register']))
			{
				$name = FilterVars::filterString($_POST['name']);
				$username = FilterVars::filterString($_POST['username']);
				$password = FilterVars::filterString($_POST['password']);
				$email = FilterVars::filterEmail($_POST['email']);

					//username validation
					if(empty($name))
					{
						$error = true;
						array_push($errmsg, "Please enter your full name");
					}
					elseif(strlen($name) >32)
					{
						$error = true;
						array_push($errmsg, "names too long");
					}

					elseif (!preg_match("/^[a-zA-Z0-9_ ]+$/",$name))
					{
						$error = true;
						array_push($errmsg, "Invalid name");
					}
					
					if(DB::query('SELECT username FROM users WHERE username = :u', array(':u'=>$username)))
					{
						$error = true;
						array_push($errmsg, "User name already exist");	
					}
					elseif(empty($username))
					{
						$error = true;
						array_push($errmsg, "Please enter your full name");
					}
					elseif(strlen($username) >32)
					{
						$error = true;
						array_push($errmsg, "names too long");
					}

					elseif (!preg_match("/^[a-zA-Z0-9_ ]+$/",$username))
					{
						$error = true;
						array_push($errmsg, "Invalid name");
					}

					//email validation
					if(empty($email))
					{
						$error = true;
						array_push($errmsg, "Please enter email");
					}

					//Password validation
					if(empty($password))
					{
						$error = true;
						array_push($errmsg, "Please enter password");
					}
					elseif(strlen($password) < 8 || strlen($password) > 32)
					{
						$error = true;
						array_push($errmsg, "Invalid password");
					}
					elseif (DB::query('SELECT email FROM users WHERE email = :email', array(':email'=>$email)))
					{
						$error = true;
						array_push($errmsg, "Email already exist");
					}
					if(!$error)
					{
						//Insert data into database if no errors
						DB::query('INSERT INTO users VALUES (\'\', :u, :n, :str, :sta, :t,  :p, :e)', array(':u'=>$username, ':n'=>$name, ':str'=>'', ':sta'=>'', ':t'=>'', ':p'=>password_hash($password,PASSWORD_DEFAULT), 'e'=>$email));

						?>

						<div role="alert" class="col-sm-10 alert-success alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-abel="close">&times;</a>
							<strong><?php echo "<font color='green'>Successfully registerd! </font><a href='#' data-toggle='modal' data-target='#login-modal'> Login </a> to continue."; ?></strong>
							<br/>
						</div>

						<?php

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


		public function login()
		{
			global $error;
			$error = true;
			if (isset($_POST['login']))
			{
				$email = FilterVars::filterEmail($_POST['email']);
				$password = FilterVars::filterString($_POST['password']);
				if(DB::query('SELECT email FROM users WHERE email=:e', array(':e'=>$email)))
					{
						if(password_verify($password, DB::query('SELECT password FROM users WHERE email = :e', array(':e'=>$email))[0]['password']))
							{
								$userId = DB::query('SELECT id FROM users WHERE email = :e', array(':e'=>$email))[0]['id'];
								$csstrong = true;
								$token = bin2hex(openssl_random_pseudo_bytes(64, $csstrong));
								//echo $token;
								DB::query('INSERT INTO login_tokens VALUES (\'\', :ui, :t)', array(':t'=>sha1($token), ':ui'=>$userId));
								setcookie("SNID", $token, time() + 60 * 60 * 24 * 7,'/', NULL, NULL, TRUE);
								setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3,'/', NULL, NULL, TRUE);
								header('location:index.php');
							}
							else
							{
								$_SESSION['login_error'] = "<div role='alert' class='col-sm-10 alert-danger alert-dismissible'><a href='#'' class='close' data-dismiss='alert' aria-abel='close'>&times;</a><strong>Email not found!</strong></div><div class='clearfix'></div>";
							}
					}
					else
					{
						$_SESSION['login_error'] = "<div role='alert' class='col-sm-10 alert-danger alert-dismissible'><a href='#'' class='close' data-dismiss='alert' aria-abel='close'>&times;</a><strong>Invalid password!</strong></div><div class='clearfix'></div>";
					}
			}
		}

		
		public static function isLoggedIn()
		{
			//check is cookie is set
			if (isset($_COOKIE['SNID']))
			{
			//if cookie is set verify the cookie in the database
				if(DB::query('SELECT user_id FROM login_tokens WHERE token = :t', array(':t'=>sha1($_COOKIE['SNID']))))
				{
					//if token is verified get the userid
					$userId = DB::query('SELECT user_id FROM login_tokens WHERE token = :t', array(':t'=>sha1($_COOKIE['SNID'])))[0]['user_id'];
					//check if the second cookie is not expired
					if (isset ($_COOKIE['SNID_']))
					{
						return $userId;
					} 
					//if expired create a new cookie in the database and delete the old one
					else 
					{
						$csstrong = true;
						$token = bin2hex(openssl_random_pseudo_bytes(64, $csstrong));
						DB::query('INSERT INTO login_tokens VALUES (\'\', :ui, :t)', array(':t'=>sha1($token), ':ui'=>$userId));
						DB::query('DELETE FROM login_tokens WHERE token = :t', array(':t'=>sha1($_COOKIE['SNID'])));
						//set the cookies and return user_id
						setcookie("SNID", $token, time() + 60 * 60 * 24 * 7,'/', NULL, NULL, TRUE);
						setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3,'/', NULL, NULL, TRUE);

						return $userId;
					}
				}
				else 
				{
					return false;
				}
			} 
			//if no cookies is set at_all
			else
			{
				return false;
			}
		}


		public static function changePass()
		{
			if((isset($_POST['change'])))
			{
				$curr_pass = FilterVars::filterString($_POST['curr_pass']);
				$password = FilterVars::filterString($_POST['password']);
				$cpassword = FilterVars::filterString($_POST['cpassword']);
				$id = user::isLoggedin();
				if(password_verify($curr_pass, DB::query('SELECT password FROM users WHERE id = :i', array(':i'=>$id))[0]['password']))
				{
					if ($password == $cpassword)
					{
						if(strlen($password) >7 && strlen($password) <33)
						{
							DB::query('UPDATE users SET password = :p WHERE id = :i', array(':p'=>password_hash($password, PASSWORD_DEFAULT), ':i'=>$id));
							$_SESSION['change_pass'] = "password successfully changed!";
						}
						else 
						{
							return "invalid password!";
						}
					}
					else
					{
						return "password does not match!";
					}
				}
				else
				{
					return "incorrect password";
				}
			}
		}


		public static function logout()
		{
			$id = user::isLoggedIn();
				if (isset($_COOKIE['SNID']))
				{
					//delete all tokens with the user id from database
					DB::query('DELETE FROM login_tokens WHERE user_id = :user_id', array(':user_id'=>$id));
					echo "successfully logged out!";
				}
					//unset cookie
					setcookie('SNID', '1', time()-3600);
					setcookie('SNID_', '1', time()-3600);
				
		}


		public static function display_user($item)
		{
			$id = user::isLoggedIn();
		  	$query = DB::query('SELECT * FROM users WHERE id = :i', array(':i'=>$id))[0][$item];
		  	return $query; //display item
		}
		

		public function getUserOrders()
		{
			$id = user::isLoggedin();
			$query = DB::query('SELECT * FROM orders WHERE customerId = :i ORDER BY id DESC', array(':i'=>$id));
			foreach ($query as $e)
			{

				?>

				
				<tr>
	                <th>#<?php echo $e['id'].$e['productCode']; ?></th>
					<td><a href="#<?php echo $e['id']; ?>" class="scroll-to"><?php echo $e['productName']; ?></a></td>
	                 <td><span class="label label-info"><?php echo $e['paymentStatus']; ?></span></td>
	                <td><a href="#<?php echo $e['id']; ?>" class="scroll-to"><button class="btn view">View</button></a>
	                	<?php
	                	if ($e['paymentStatus']!='Paid')
                        {
                            echo "&nbsp;|&nbsp;<a href='account.php?cancel_order={$e['id']}'><button class='btn btn-danger' onclick='return confirm('Are you sure you want to cancel this order');'>Cancel</button></a>";
                        }
                        ?>
                    </td>
			
	            </tr>
	        	

				<?php

			}
		}

		public function cancelOrder(){
			if(isset($_GET['cancel_order']))
			{
				$orderId = $_GET['cancel_order'];
				if(DB::query('SELECT * FROM orders WHERE id = :i', array(':i'=>$orderId)))
				{
					DB::query('DELETE from orders WHERE id = :i', array(':i'=>$orderId));
				}
				else{
					header('location:account.php');
				}
			}
		}
		public function orderExpiryDate($orderTime,$orderId)
		{
			$expireDate = $orderTime + 60 * 60 * 24 * 3;
			if($expireDate > time())
			{
				$timeRemaining = $expireDate - time();
				$remHour = floor(($timeRemaining % 86400) / 3600);
				$remDay = floor($timeRemaining / 86400);
				$remMin = floor(($timeRemaining % 3600) / 60);
				return $remDay." days, ".$remHour." hours, ".$remMin." minutes. ";
			}
			elseif($expireDate < time())
			{
				DB::query('DELETE from orders WHERE id = :i', array(':i'=>$orderId));
				header('location:account.php');
			}
		}

		public function getUserOrdersDetails()
		{
			$id = user::isLoggedin();
			$query = DB::query('SELECT * FROM orders WHERE customerId = :i ORDER BY id DESC', array(':i'=>$id));
			foreach ($query as $e)
			{

				?>
				<div class="box">
					<p class="lead" id="<?php echo $e['id']; ?>"><?php echo $e['productName']; ?> Order #<?php echo $e['id']; ?> </p>
	                <hr>
	                <p>Order ID : #<?php echo $e['id'].$e['productCode']; ?></p>
	                <p>Price <span class="label label-info">per</span> : <span>&#8358;</span><?php echo $e['productPrice']; ?></p>
	                <p>Quantity : <?php echo $e['productQty']; ?></p>
	                <p>Total price : <span>&#8358;</span><?php echo $e['totalPrice']; ?></p>
	                <p>Payment status : <?php echo $e['paymentStatus']; ?></p>
	                <p>Delivery status : <?php echo $e['deliveryStatus']; ?></p>
	                <?php
	                	if ($e['paymentStatus']!='Paid')
	                	{
	                		echo "<a href='payment.php?order={$e['id']}'><button class='btn btn-success'>Pay now</button></a>";
							 echo "<a href='account.php?cancel_order={$e['id']}'> <button class='btn btn-danger' onclick='return confirm('Are you sure you want to cancel this order');'>Cancel</button></a>";
							 echo "<div class='rem-date'> Your orders Expires in ".user::orderExpiryDate($e['timeOrdered'],$e['id']). " Please make payment to avoid order cancellation.</h4>";
							 
	             		}

	                 ?>
	                
	            </div>
				<?php

			}
		}


		/* public function sendMail()
		{
			if (isset($_POST['submit']))
			{
				$firstName = FilterVars::filterString($_POST['firstname']);
				$lastName = FilterVars::filterString($_POST['lastname']);
				$email = FilterVars::filterString($_POST['email']);
				$subject = FilterVars::filterString($_POST['subject']);
				$message = FilterVars::filterString($_POST['message']);

				try
				{
					$mail = new PHPMailer(true); //New instance, with exceptions enabled
					$mail->IsSMTP();                           // tell the class to use SMTP
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->Port       = 25;                    // set the SMTP server port
					$mail->Host       = "mail.farmorders.com.ng"; // SMTP server
					$mail->Username   = " farmorders@farmorders.com.ng ";     // SMTP server username   
					$mail->Password   = "edk68*2N8Qz";            // SMTP server password
					$mail->IsSendmail();  // tell the class to use Sendmail
					$mail->AddReplyTo($email, $firstName." ".$lastName);
					$mail->From       = $email;
					$mail->FromName   = $firstName." ".$lastName;
					$to = "farmorders@gmail.com";
					$mail->AddAddress($to);
					$mail->Subject  = $subject;
					$mail->Body    = $message;
					$mail->AltBody    = $message; // optional, comment out and test
					$mail->WordWrap   = 80; // set word wrap
					$mail->MsgHTML($message);
					$mail->IsHTML(true); // send as HTML
					$mail->Send();
					echo "<div role='alert' class='col-sm-10 alert-success alert-dismissible'><a href='#'' class='close' data-dismiss='alert' aria-abel='close'>&times;</a><strong>Message successfully sent!</strong></div><div class='clearfix'></div>";
				}
				catch (phpmailerException $e)
				{
					echo $e->errorMessage();
				}
			}
		}*/


		public function sendMail()
		{
			if (isset($_POST['submit']))
			{
				$error = false;
				$errmsg = array();
				$firstName = FilterVars::filterString($_POST['firstname']);
				$lastName = FilterVars::filterString($_POST['lastname']);
				$email = FilterVars::filterString($_POST['email']);
				$subject = FilterVars::filterString($_POST['subject']);
				$message = FilterVars::filterString($_POST['message']);
				$name   = $firstName." ".$lastName;
				$date = date("d M Y H:i");

					if(empty($name))
					{
						$error = true;
						array_push($errmsg, "Please enter your full name");
					}
					elseif(strlen($name) >32)
					{
						$error = true;
						array_push($errmsg, "Name too long");
					}

					elseif (!preg_match("/^[a-zA-Z0-9_ ]+$/",$name))
					{
						$error = true;
						array_push($errmsg, "Invalid name");
					}

					if(empty($subject))
					{
						$error = true;
						array_push($errmsg, "Please enter your full name");
					}
					elseif(strlen($subject) >64)
					{
						$error = true;
						array_push($errmsg, "subject too long");
					}

					//email validation
					if(empty($email))
					{
						$error = true;
						array_push($errmsg, "Please enter email");
					}

					if(!$error)
					{
						//Insert data into database if no errors
						$query = DB::query('INSERT INTO messages VALUES (\'\', :n, :s, :e, :m, :d)', array(':n'=>$name, ':s'=>$subject, 'e'=>$email, ':m'=>$message, ':d'=>$date));
						
							echo "<br/><div role='alert' class='col-sm-10 alert-success alert-dismissible'><a href='#'' class='close' data-dismiss='alert' aria-abel='close'>&times;</a><strong>Message successfully sent!</strong></div><div class='clearfix'></div>";
						

					}
					else 
					{
						foreach ($errmsg as $e)
						{

							echo "<br/><div role='alert' class='col-sm-10 alert-danger alert-dismissible'><a href='#'' class='close' data-dismiss='alert' aria-abel='close'>&times;</a><strong>".$e."</strong></div><div class='clearfix'></div>";
						
						}
					}
											
			}
					
		}
		public function getPaymentInfo(){
			$dbPost = DB::query('SELECT * FROM orders WHERE id = :id order by id desc', array(':id'=>FilterVars::filterString($_GET['order'])))[0];
			$details = array(
							'id'=>$dbPost['id'], 
							'email'=>$dbPost['emailAddress'], 
							'amount'=>$dbPost['totalPrice'],
							'productCode'=>$dbPost['productCode'],
							'username'=>$dbPost['customerUsername'],
							'productName'=>$dbPost['productName']
						);
			return $details;
		}

		public function paymentUpdate($id){
			DB::query('UPDATE orders SET paymentStatus = :p WHERE id = :i', array(':p'=>'Paid', ':i'=>$id));

		}


	}

?>
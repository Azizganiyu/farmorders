<?php
include('class.filtervars.php');
class admin
{
	
		//Registeration new users
	
	public function register()
	{
		$error = false;
		$errmsg = array();
		if (isset($_POST['register']))
		{
			$username = FilterVars::filterString($_POST['username']);
			$password = FilterVars::filterString($_POST['password']);
			$cpassword = FilterVars::filterString($_POST['cpassword']);
			$date = date("Y-m-d H:i:s");
			if (isset($_POST['role']))
			{
				$role = $_POST['role'];
			}
			else
			{
				$role = "super-user";
			}

				//username validation
				if(empty($username))
				{
					$error = true;
					array_push($errmsg, "Please enter username");
				}
				elseif(strlen($username) <3 || strlen($username) >32)
				{
					$error = true;
					array_push($errmsg, "username length error");
				}

				elseif (!preg_match("/^[a-zA-Z0-9_ ]+$/",$username))
				{
					$error = true;
					array_push($errmsg, "Invalid username");
				}
				elseif(DB::query('SELECT username FROM super_user WHERE username = :u', array(':u'=>$username)))
				{
					$error = true;
					array_push($errmsg, "User name already exist");	
				}


				//Password validation
				if(empty($password))
				{
					$error = true;
					array_push($errmsg, "Please enter password");
				}
				elseif(strlen($password) < 8 || strlen($password) > 16)
				{
					$error = true;
					array_push($errmsg, "Password must be between 8 - 16 characters");
				}
				elseif ($password != $cpassword)
				{
					$error = true;
					array_push($errmsg, "Password confirm error");
				}
				


				if(!$error)
				{
					//Insert data into database if no errors
					DB::query('INSERT INTO super_user VALUES (\'\', :u, :p, :r,:d)', array(':u'=>$username, ':p'=>password_hash($password,PASSWORD_DEFAULT), ':r'=>$role, ':d'=>$date));
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


	

	public function login()
	{
		global $error;
		$error = true;
		if (isset($_POST['login']))
		{
			$username = FilterVars::filterString($_POST['username']);
			$password = FilterVars::filterString($_POST['password']);

			if(DB::query('SELECT username FROM super_user WHERE username=:u', array(':u'=>$username)))
				{
					if(password_verify($password, DB::query('SELECT password FROM super_user WHERE username = :u', array(':u'=>$username))[0]['password']))
						{
							$userId = DB::query('SELECT id FROM super_user WHERE username = :u', array(':u'=>$username))[0]['id'];
							$_SESSION['userId'] = $userId;
							header('location:index.php');
						}
						else
						{
							$errmsg = "Invalid password!";
							return $errmsg;
						}
				}
				else
				{
					
					$errmsg = "User does not exist!";
					return $errmsg;
				}
		}
	}


	public static function changePass()
	{
		if((isset($_POST['change'])))
		{

			$curr_pass = FilterVars::filterString($_POST['curr_pass']);
			$password = FilterVars::filterString($_POST['password']);
			$cpassword = FilterVars::filterString($_POST['cpassword']);
			$id = $_SESSION['userId'];

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

	
	public function access($value)
	{
		$id = $_SESSION['userId'];
		$role = DB::query('SELECT role FROM super_user WHERE id = :i', array(':i'=>$id))[0]['role'];
		if($role == "administrator" )
		{
			if ($value == "0")
			{
			die("Access Denied!");
			}
		}
		elseif($role == "super-user")
		{
			if ($value == "1" || $value == "0")
			{
				die("Access Denied");
			}
		}
	}

	public static function display_admin($item){
	//get contents from database using admin id to extract information from database 
	$id = $_SESSION['userId'];
  	$query = DB::query('SELECT * FROM super_user WHERE id = :i', array(':i'=>$id))[0][$item];
  		return $query; //display item
		}

	public function displayAdmins()
	{
		?>
		<h4>List of users</h4>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Username</th> <th>Role</th> <th>Date registered</th>  
				</tr>
			</thead>
			<tbody>
				<div class="bs-example widget-shadow" data-example-id="hoverable-table">
		<?php
		$dbPost = DB::query('SELECT * FROM super_user WHERE role != "super admin"');
		foreach ($dbPost as $p)
	{
			?>
						
			<tr> <th scope="row"><?php echo $p['username']; ?></th> <td><?php echo $p['role']; ?></td> <td><?php echo $p['dateReg']; ?></td> </tr>
			<?php
		} ?>

		</tbody>
	</table>
					</div>
	<?php
	}
}
?>
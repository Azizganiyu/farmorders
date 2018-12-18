<?php

	session_start();
	require_once('classes/DB.php');
	if(!empty($_FILES)) 
	{
		if(is_uploaded_file($_FILES['userImage']['tmp_name']))
		{
			$error = false;
			$errmsg = array();
			$sourcePath = $_FILES['userImage']['tmp_name'];
			$targetPath = "images/".$_FILES['userImage']['name'];
			$errors = array();
			$extension = array("jpeg","jpg","png","gif");
			$bytes = 1024;
			$KB = 1024;
			$totalBytes = $bytes * $KB;
			$UploadFolder = "images";
			$ext = pathinfo($targetPath, PATHINFO_EXTENSION);
			if($_FILES["userImage"]["size"] > $totalBytes)
			{
				$error = true;
				array_push($errmsg, " file size is larger than the 1 MB.");
			}
			elseif(in_array($ext, $extension) == false)
			{
				$error = true;
				array_push($errmsg," is invalid file type.");
			}
			if($error == false)
			{
				if(move_uploaded_file($sourcePath,$targetPath))
				{
					//insert image url to database for product image2wbmp(image)
					if(isset($_SESSION['productimg']))
					{
						$id = $_SESSION['productimg'];
						$query = DB::query('SELECT url FROM prdctimgurl WHERE url = :t', array(':t'=>$targetPath));
						if(count($query) == 0)
						{
							DB::query('INSERT INTO prdctimgurl VALUES(\'\', :p, :u)', array(':p'=>$id, ':u'=>$targetPath));
						}
						unset($_SESSION['productimg']);
					}
					if(isset($_SESSION['productimgupdate']))
					{
						$id = $_SESSION['productimgupdate'];
						if(DB::query('SELECT productId FROM prdctimgurl WHERE productId = :i', array(':i'=>$id)))
						{
							DB::query('UPDATE prdctimgurl SET url = :u WHERE productId = :i', array(':i'=>$id, ':u'=>$targetPath));
						}
						else
						{
								DB::query('INSERT INTO prdctimgurl VALUES(\'\', :p, :u)', array(':p'=>$id, ':u'=>$targetPath));
						}
						unset($_SESSION['productimgupdate']);
					}
				}		
				
				?>

				<div role="alert" class="col-sm-10 alert-success">
					<strong><?php echo "Succesfully Uploaded"; ?></strong>
				</div>
				<br/>
				<img src="<?php echo $targetPath; ?>" width="100px" height="100px" />

				<?php

			}
			else
			{
				foreach ($errmsg as $e)
				{
					echo $e."<br>";
				}
			}

		}
	}

?>



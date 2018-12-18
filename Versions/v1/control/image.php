<?php

	ob_start();
	session_start();
	require_once('classes/DB.php');
	include('classes/class.product.php');
	$user = new product();
	if(!isset($_SESSION['userId']))
	{
		header('location:login.php');
		die();
	}
	$user->access("1");

?>

<!DOCTYPE html>
 <html lang="en">
    <head>
	    <meta charset="utf-8"/>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta http-equiv="x-ua-compatible" content="ie=edge">
	    <script src="includes/jquery-3.3.1.min.js" type="text/javascript"></script>
		<script src="includes/jquery.form.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="includes/image.css">
		<link rel="stylesheet"  href="includes/bootstrap/css/bootstrap.min.css">
		<script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>
	    <title> Image upload </title>
    </head>
    <body class="page-wraper">
		<script type="text/javascript">
		$(document).ready(function()
		{ 
			 $('#uploadForm').submit(function(e)
			 {	
				if($('#userImage').val())
				{
					e.preventDefault();
					$('#loader-icon').show();
					$(this).ajaxSubmit(
					{ 
						target:   '#targetLayer', 
						beforeSubmit: function()
						{
						  $("#progress-bar").width('0%');
						},
						uploadProgress: function (event, position, total, percentComplete)
						{	
							$("#progress-bar").width(percentComplete + '%');
							$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
						},
						success:function ()
						{
							$('#loader-icon').hide();
						},
						resetForm: true 
					}
					); 
					return false; 
				}
			}
			);
		}
		); 
		</script>
		<script type="text/javascript">
			function readURL(input) 
			{
				if(input.files && input.files[0]) 
				{
					var reader = new FileReader();
					reader.onload = function (e) 
					{
						$('#preview img').attr('src', e.target.result);
					};
					reader.readAsDataURL(input.files[0]);
				}
			}
			$(document).on('change','input[type="file"]',function()
			{
				readURL(this);
			}
			)
		</script>
		<div >
			<div class="upload-body container">
				<div class="row">
					<div class="col-10 offset-1 col-sm-8 offset-sm-2 ">
						<div class="upload-title">
							<h3 class="title">Image uploader </h3>
							<div class="form-body">
								<div class="upload-top">
									<h4>Select an image file to upload ! <br> Or enter Url </h4>
								</div>
								<form id="uploadForm" action="upload.php" method="post">
									<div class="file-input-wrapper">
										<button class="btn btn-danger btn-file-input">Select image</button>
										<input name="userImage" id="userImage" type="file" class="demoInputBox" />
									</div>
									<br/>
									<div id="preview" class="col-12"><img src=""></div>
									<h5 class="or"> - OR -</h5>
									<input type="text" name="imageurl" class="form-control" placeholder="Enter image url">
									<div>
										<input type="submit" id="btnSubmit" value="Submit" class=" btn btn-primary btn-sm" name="upload" />
									</div>
									<div id="progress-div">
										<div id="progress-bar"></div>
									</div>
									<div id="targetLayer"></div><br/>
								</form>
								<div id="loader-icon" style="display:none;"><img src="LoaderIcon.gif" /></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php

ob_end_flush();

?>

			
<?php
class Header{
public static function doHeader($pageTitle)
{
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>
        <?php echo $pageTitle; ?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="../includes/dash/application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <link rel="stylesheet"  href="includes/CSS/stylesheet.css">
<!-- Bootstrap Core CSS -->
<link href="includes/dash/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="includes/dash/css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="includes/dash/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="includes/dash/js/jquery-1.11.1.min.js"></script>
<script src="includes/dash/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="includes/dash/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="includes/dash/js/wow.min.js"></script>
  <script>
     new WOW().init();
  </script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="includes/dash/js/metisMenu.min.js"></script>
<script src="includes/dash/js/custom.js"></script>
<link href="includes/dash/css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
  <div class="main-content">
    <!--left-fixed -navigation-->
    <div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
          <ul class="nav" id="side-menu">
            <li>
              <a href="index.php" class="active"><i class="fa fa-home nav_icon"></i>Dashboard</a>
            </li>
                <?php
                if(admin::display_admin("role") == "administrator" || admin::display_admin("role") == "super admin")
                {?>
            <li>
              <a href="#"><i class="fa fa-cogs nav_icon"></i>Components<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="register.php">Admins</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
                <?php
              }?>
             
            <li class="">
              <a href="#"><i class="fa fa-book nav_icon"></i>Products<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li>
                  <a href="categories.php">Categories</a>
                </li>
                <li>
                  <a href="products.php">Products</a>
                </li>
              </ul>
              <!-- /nav-second-level -->
            </li>
            <li>
							<a href="inbox.php"><i class="fa fa-envelope nav_icon"></i>Inbox</a>
						</li>
          </ul>
          <!-- //sidebar-collapse -->
        </nav>
      </div>
    </div>
    <!--left-fixed -navigation-->
    <!-- header-starts -->
    <div class="sticky-header header-section ">
      <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <!--logo -->
        <div class="logo">
          <a href="index.html">
            <h1>FARMORDERS</h1>
            <span>ControlPanel</span>
          </a>
        </div>
        <!--//logo-->
        <!--search-box-->
      </div>
      <div class="header-right">
       
        <!--notification menu end -->
        <div class="profile_details">   
          <ul>
            <li class="dropdown profile_details_drop">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <div class="profile_img"> 
                  <span class="prfil-img"><img src="includes/dash/images/a.png" alt="" width="50" height="50"> </span> 
                  <div class="user-name">
                    <p><?php echo admin::display_admin("username"); ?></p>
                    <span><?php echo admin::display_admin("role"); ?></span>
                  </div>
                  <i class="fa fa-angle-down lnr"></i>
                  <i class="fa fa-angle-up lnr"></i>
                  <div class="clearfix"></div>  
                </div>  
              </a>
              <ul class="dropdown-menu drp-mnu">
                <li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li> 
                <li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li> 
                <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="clearfix"> </div>       
      </div>
      <div class="clearfix"> </div> 
    </div>
    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
      <div class="main-page">
        <div class="row-one">
          
        </div>

         <?php
  }
  }
?>

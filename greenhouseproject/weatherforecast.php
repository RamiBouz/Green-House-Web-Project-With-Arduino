<?php 
	session_start(); 
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Weather Forecast</title>
	<!-- Bootstrap CDN -->
<body>
    <div id="wrapper">  
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-gradient-info topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none bg-white rounded-circle mr-3">
    <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
    <!-- Nav Item - User Information -->
	<?php  if (isset($_SESSION['username'])) : ?>
    <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="h4 rounded-circle text-dark"><i class="fas fa-user"></i> Welcome <?php echo $_SESSION['username']; ?></a><?php endif ?></span>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"> 
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="login.php" data-toggle="modal" data-target="#logoutModal">
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </a>
    </div>
    </li>
    </nav>
    <div class="col-md-12 mt-5 ">
    <h1 class="text-center text-gray-900">Weather Forecast</h1>
    <hr>
    </div>
    <div class="p-5">
	<div class="row justify-content-center">
	<div class="col-md-3">  
    <div class="input-group mb-5 ">
    <input type="text" autocomplete="off" class="search-box form-control form-control-user text-gray-900" placeholder="Search for a city..." ></input>
    </div>
	<div class="h4 text-gray-900 mb-3 text-center"> 
    <div class="location">
    <div class="city">---</div>
    <div class="date">---</div>
    </div>
	</div>
    <div class="h5 text-gray-900 mb-3 text-center">
	<div class="current">
    <div class="temp">--<span>--</span></div>
    <div class="weather">--</div>
    <div class="hi-low">-- / --</div>
	</div>
    </div>
	</div>
    </div>
    </div>
    </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div>
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.
    <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
    <a class="btn btn-primary" href="login.php">Logout</a>
    </div>
    </div>
    </div>
    </div>
     <script src="js/weather.js">
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js">
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js">

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js">
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js">
</body>
</html>
<?php include ('reglogserv.php')?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <form method="post" action="login.php" class="user"><div  class="bg-image"  style="    background-image: url('images/image.jpg');    height: 100vh;	webkit-background-size: cover;    moz-background-size: cover;    background-size: cover;  "> 
    <div class="container">
    <!-- Outer Row -->    
    <div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8 col-md-9">	
	<?php  if (count($errors) > 0) : ?>
	<div class="alert alert-danger" role="alert">
    <?php foreach ($errors as $error) : ?>
	<p><?php echo $error ?></p>
	<?php endforeach ?>
	</div>
    <?php  endif ?>	
    <div class="card o-hidden border-0 shadow-lg my-4 ">
    <div class="card-body p-0">	
    <!-- Nested Row within Card Body -->	
    <div class="p-5">
    <div class="p-3">
    <div class="text-center">	<div class="navbar-brand  d-flex align-items-center justify-content-center" href="#"><img src="images/logologin.png" alt="logo"></div>
    </div>   	
    <div class="form-group">
    <input type="text" required class="form-control form-control-user" name="username" placeholder="Username">    </div>	
    <div class="form-group">
    <input type="password" required class="form-control form-control-user" name="password" placeholder="Password">
    </div>                                                                					
    <button type="sumbit" name="login_user" class="btn btn-primary btn-user btn-block"> Login
    </button>
    <hr>
    <div class="text-center">
    <a class="small" href="register.php">Create an Account!</a>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
	</div>
    </div> </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js">	</script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js">	</script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js">	</script>
    <!-- Custom scripts for all pages-->	
    <script src="js/sb-admin-2.min.js">	</script>
</form>
</body>

</html>
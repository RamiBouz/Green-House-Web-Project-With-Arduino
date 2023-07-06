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
?><?phprequire('chartdb.php');$query = "SELECT AVG(amount) AS amount , dateFROM watertableGROUP BY date";$result = mysqli_query($conn, $query);$amountdata = '';while($row = mysqli_fetch_array($result)){ $amountdata .= "{ date:'".$row["date"]."', amount:'".$row["amount"]."'}, ";}$amountdata = substr($amountdata, 0, -2);?><?phprequire('chartdb.php');$query = "SELECT AVG(sum) AS sum , dateFROM watertableGROUP BY date";$result = mysqli_query($conn, $query);$sumdata = '';while($row = mysqli_fetch_array($result)){ $sumdata .= "{ date:'".$row["date"]."', sum:'".$row["sum"]."'}, ";}$sumdata = substr($sumdata, 0, -2);?>
<!DOCTYPE html>
<html style="scroll-behavior: smooth;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Water Consumption</title>		<!-- Bootstrap CDN -->    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">    <script src="https://code.jquery.com/jquery-3.4.0.js"></script>    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>	
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<!-- Datepicker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    </head>
    <body>
    <div id="wrapper">  	    <!-- Sidebar -->    <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">    <a class="navbar-brand  d-flex align-items-center justify-content-center" href="index.php">	<img src="images/logoo.png" alt="logo">	</a>    <hr class="sidebar-divider">    <li class="nav-item">    <a class="nav-link" href="index.php">    <h6><i class="fas fa-database"></i> Data Sheet</h6></a>    </li>    <li class="nav-item">    <a class="nav-link" href="controlpanel.php">    <h6><i class="fas fa-gamepad"></i> Control Panel</h6></a>    </li>    <li class="nav-item">    <a class="nav-link" href="watertable.php">    <h6><i class="fas fa-faucet"></i> Water Consumption</h6></a>    </li>	<li class="nav-item">    <a class="nav-link" href="weatherforecast.php">    <h6><i class="fas fa-cloud-sun"></i> Weather Forecast</h6></a>    </li>    <hr class="sidebar-divider">    <!-- Sidebar Toggler (Sidebar) -->    <div class="text-center d-none d-md-inline">    <button class="rounded-circle border-0" id="sidebarToggle"></button>    </div>    </ul>    <div id="content-wrapper" class="d-flex flex-column">    <div id="content">	
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-gradient-info topbar mb-4 static-top shadow">	
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none bg-white rounded-circle mr-3"> <i class="fa fa-bars"></i>    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
    <!-- Nav Item - User Information -->
	<?php  if (isset($_SESSION['username'])) : ?>
    <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    <span class="h4 rounded-circle text-dark"><i class="fas fa-user"></i> Welcome <?php echo $_SESSION['username']; ?></a><?php endif ?></span>     	
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"> 
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="login.php" data-toggle="modal" data-target="#logoutModal">
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </a>
    </div>
    </li>
    </ul>
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
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.	</div>	
    <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel	</button>
    <a class="btn btn-primary" href="login.php">Logout	</a>
    </div>
    </div>
    </div>
    </div>	
    </nav>    <div class="col-md-12 mt-5">
    <h1 id="up" class="text-center text-gray-900" >Water Consumption Sheet</h1>
    <hr>
    </div>	
    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <div class="row">
    <div class="col-md-6">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
    <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i>	</span>
    </div>
    <input type="text" class="form-control" id="start_date" placeholder="Start Date" readonly>
    </div>
    </div>
    <div class="col-md-6">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
    <span class="input-group-text bg-info text-white" id="basic-addon1"><i
    class="fas fa-calendar-alt"></i>	</span>
    </div>
    <input type="text" class="form-control" id="end_date" placeholder="End Date" readonly>
    </div>
    </div>
    </div>
    <div>		<a href="#down"><button class="btn btn-info btn-sm">	<i class="fas fa-fw fa-chart-area"></i> Chart	</button></a>	
    <button id="filter" class="btn btn-outline-info btn-sm">Filter	</button>	
    <button id="reset" class="btn btn-outline-warning btn-sm">Reset	</button>	
    </div>
    <div class="row mt-3">
    <div class="col-md-12">
    <!-- Table -->
    <div class="table-responsive">
    <table class="table table-borderless display nowrap" id="recordswt" style="width:100%">
    <thead>
    <tr>
    <th> ID</th>
    <th> Amount / sec <i class="fas fa-stopwatch"></i></th>
    <th> Sum <i class="fas fa-shekel-sign"></i></th>
    <th> Date <i class="fas fa-calendar-alt"></i></th>
    <th> Time <i class="fas fa-clock"></i></th>                               
    </tr>
    </thead>
    </table>    <h5 class="text-gray-900" >*** Amount * 0.50₪ </h5>
    </div>		<div class="col-md-12 mt-5">    <h2 id="down" class="text-center text-gray-900">Amount</h2>    <hr>    </div>	    <div id="amountchart">	</div>	      <div class="col-md-12 mt-5">    <h2 class="text-center text-gray-900">Sum</h2>    <hr>    </div>	    <div id="sumchart">	</div>		<a href="#up"><button class="btn btn-info btn-sm">	<i class="fas fa-fw fa-table"></i> 	Sheet	</button></a>	
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- Bootstrap core JavaScript-->    <script src="vendor/jquery/jquery.min.js"></script>    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js">	</script>    <!-- Core plugin JavaScript-->    <script src="vendor/jquery-easing/jquery.easing.min.js">	</script>
    <!-- Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">	</script>
    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js">	</script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js">	</script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js">
    </script>
    <!-- Momentjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js">	</script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
    $(function() {
        $("#start_date").datepicker({
           "dateFormat": "yy-mm-dd"
        });
        $("#end_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
    });
    </script>
    <script>    $(function() {        $("#start_date").datepicker({            "dateFormat": "yy-mm-dd"        });        $("#end_date").datepicker({            "dateFormat": "yy-mm-dd"        });    });    </script>
    <script>
    // Fetch recordswt
    function fetch(start_date, end_date) {
        $.ajax({
            url: "recordswt.php",
            type: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            dataType: "json",
            success: function(data) {
                // Datatables
                var i = "1";
                $('#recordswt').DataTable({
                    "data": data,
                    // responsive
                    "responsive": true,
                    "columns": [{
                            "data": "id",
                            "render": function(data, type, row, meta) {
                                return i++;
                            }
                        },
                        {
                            "data": "amount"
                        },
                        {
                            "data": "sum"
                        },
                        {
                            "data": "date",
                            "render": function(data, type, row, meta) {
                                return moment(row.date).format('DD-MM-YYYY');
                           }
                        },											{                            "data": "time"                        },
                    ]
                });
            }
        });
    }
    fetch();
    // Filter
    $(document).on("click", "#filter", function(e) {
        e.preventDefault();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        if (start_date == "" || end_date == "") {
            alert("both date required");
        } else {
            $('#recordswt').DataTable().destroy();
            fetch(start_date, end_date);
        }
    });
    // Reset
    $(document).on("click", "#reset", function(e) {
        e.preventDefault();
        $("#start_date").val(''); // empty value
        $("#end_date").val('');
        $('#recordswt').DataTable().destroy();
        fetch();
    });
    </script>	    <script>    Morris.Bar({    element : 'amountchart',    data:[<?php echo $amountdata; ?>],    xkey:'date',    ykeys:['amount'],    labels:['amount'],    hideHover:'auto',    stacked:true    });    </script>	<script>    Morris.Bar({    element : 'sumchart',    data:[<?php echo $sumdata; ?>],    xkey:'date',    ykeys:['sum'],    labels:['sum'],    hideHover:'auto',    stacked:true    });    </script>
</body>
</html>
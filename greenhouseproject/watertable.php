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
<html style="scroll-behavior: smooth;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Water Consumption</title>
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
    <div id="wrapper">  
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-gradient-info topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none bg-white rounded-circle mr-3"> <i class="fa fa-bars"></i>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
    <!-- Nav Item - User Information -->
	<?php  if (isset($_SESSION['username'])) : ?>
    <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.
    <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel
    <a class="btn btn-primary" href="login.php">Logout
    </div>
    </div>
    </div>
    </div>
    </nav>
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
    <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i>
    </div>
    <input type="text" class="form-control" id="start_date" placeholder="Start Date" readonly>
    </div>
    </div>
    <div class="col-md-6">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
    <span class="input-group-text bg-info text-white" id="basic-addon1"><i
    class="fas fa-calendar-alt"></i>
    </div>
    <input type="text" class="form-control" id="end_date" placeholder="End Date" readonly>
    </div>
    </div>
    </div>
    <div>
    <button id="filter" class="btn btn-outline-info btn-sm">Filter
    <button id="reset" class="btn btn-outline-warning btn-sm">Reset
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
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- Bootstrap core JavaScript-->
    <!-- Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">
    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js">
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js">
    </script>
    <!-- Momentjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js">
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
    <script>
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
                        },
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
    </script>
</body>
</html>
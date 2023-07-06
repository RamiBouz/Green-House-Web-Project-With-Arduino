<?php 
<!DOCTYPE html>
<html style="scroll-behavior: smooth;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Date Sheet</title>
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
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="navbar-brand  d-flex align-items-center justify-content-center" href="index.php">
    <hr class="sidebar-divider">
    <li class="nav-item">
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <!-- Topbar -->
    <nav class=" navbar navbar-expand navbar-light bg-gradient-info topbar mb-4 static-top shadow">
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
    <i class=" fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </a>
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
    </div>
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
    <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel
    <a class="btn btn-primary" href="login.php">Logout</a>
    </div>
    </div>
    </div>
    </div>
    </nav>
    <div class="col-md-12 mt-5">
    <h1 id="up" class="text-center text-gray-900">Data Sheet</h1>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
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
    // Fetch recordsdt
    function fetch(start_date, end_date) {
        $.ajax({
            url: "recordsdt.php",
            type: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            dataType: "json",
            success: function(data) {
                // Datatables
                var i = "1";
                $('#recordsdt').DataTable({
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
                            "data": "temperature"
                        },
                       {
                            "data": "humidity"
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
            $('#recordsdt').DataTable().destroy();
            fetch(start_date, end_date);
        }
    });
    // Reset
    $(document).on("click", "#reset", function(e) {
        e.preventDefault();
        $("#start_date").val(''); // empty value
        $("#end_date").val('');
        $('#recordsdt').DataTable().destroy();
        fetch();
    });
    </script>
</body>
</html>
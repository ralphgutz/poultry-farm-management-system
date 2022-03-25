<?php
    include("connection.php");
    session_start();

    // check if user is logged in (if there's session)
    if(!$_SESSION["username_s"]) {
      header("location: login.php");
      exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte-modified.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <style>
    .btn-info, .btn-danger {
      padding: 1px 12px 1px 12px !important;
    }
    select {
      padding: 6px 14px 10px 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar navbar-dark bg-custom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link font-weight-bold">REPORTS</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" action="search.php" method="get">
            <div class="input-group input-group-sm">
              <?php 
                if(isset($_GET["searchBox"])){ 
                  $_SESSION["search"] = $_GET["searchBox"];
                } 
              ?>
              <input class="form-control form-control-navbar" name="searchBox" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="#" role="button">
          Welcome, <?php echo "{$_SESSION['fname_s']}" ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link logout" href="logout.php" role="button">
          <i class="nav-icon fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-secondary elevation-2 bg-custom2">
    <a href="#" class="brand-link logo-switch bg-warning ">
      <img src="dist/img/logo-xs.svg" alt="RH-logo-small" class="brand-image-xl logo-xs" style="left: 10px">
      <img src="dist/img/logo-xl.svg" alt="RH-logo-large"  class="brand-image-xl logo-xl" style="left: 40px">
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="home.php" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">POULTRY FARM ACTIVITIES</li>

          <li class='nav-item'>
              <a href='#' class='nav-link'>
                <i class='nav-icon fas fa-kiwi-bird'></i>
                <p>
                  Bird Management
                  <i class='fas fa-angle-left right'></i>
                </p>
              </a>
              <ul class='nav nav-treeview'>
                <li class='nav-item'>
                  <a href='add-bird.php' class='nav-link'>
                    <i class='fas fa-plus-circle nav-icon'></i>
                    <p>Add Bird</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='edit-birds.php' class='nav-link'>
                  <i class='fas fa-edit nav-icon'></i>
                    <p>Edit Birds</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='view-records.php' class='nav-link'>
                    <i class='fas fa-list-alt nav-icon'></i>
                    <p>View Records</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class='nav-item'>
              <a href='#' class='nav-link'>
                <i class='nav-icon fas fa-egg'></i>
                <p>
                  Egg Readings
                  <i class='fas fa-angle-left right'></i>
                </p>
              </a>
              <ul class='nav nav-treeview'>
                <li class='nav-item'>
                  <a href='add-reading.php' class='nav-link'>
                    <i class='fas fa-plus-circle nav-icon'></i>
                    <p>Add Reading</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='edit-readings.php' class='nav-link'>
                  <i class='fas fa-edit nav-icon'></i>
                    <p>Edit Readings</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='view-readings.php' class='nav-link'>
                    <i class='fas fa-list-alt nav-icon'></i>
                    <p>View Readings</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class='nav-item'>
            <a href='#' class='nav-link'>
              <i class='nav-icon fas fa-shopping-cart'></i>
              <p>
                Chicken Supply
                <i class='fas fa-angle-left right'></i>
              </p>
            </a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'>
                <a href='add-supply.php' class='nav-link'>
                  <i class='fas fa-plus-circle nav-icon'></i>
                  <p>Add Chicken Supply</p>
                </a>
              </li>
              <li class='nav-item'>
                <a href='edit-supply.php' class='nav-link'>
                <i class='fas fa-edit nav-icon'></i>
                  <p>Edit Chicken Supply</p>
                </a>
              </li>
              <li class='nav-item'>
                <a href='view-supply.php' class='nav-link'>
                  <i class='fas fa-list-alt nav-icon'></i>
                  <p>View Chicken Supply</p>
                </a>
              </li>
            </ul>
          </li>

            <li class='nav-item'>
              <a href='#' class='nav-link'>
                <i class='nav-icon fas fa-archive'></i>
                <p>
                  Resources
                  <i class='fas fa-angle-left right'></i>
                </p>
              </a>
              <ul class='nav nav-treeview'>
                <li class='nav-item'>
                  <a href='add-resources.php' class='nav-link'>
                    <i class='fas fa-plus-circle nav-icon'></i>
                    <p>Add Resources</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='edit-resources.php' class='nav-link'>
                  <i class='fas fa-edit nav-icon'></i>
                    <p>Edit Resources</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='view-resources.php' class='nav-link'>
                    <i class='fas fa-list-alt nav-icon'></i>
                    <p>View Resources</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class='nav-item'>
            <a href='#' class='nav-link'>
              <i class='nav-icon fas fa-box-open'></i>
              <p>
                Consumption
                <i class='fas fa-angle-left right'></i>
              </p>
            </a>
            <ul class='nav nav-treeview'>
              <li class='nav-item'>
                <a href='add-consumption.php' class='nav-link'>
                  <i class='fas fa-plus-circle nav-icon'></i>
                  <p>Add Consumption</p>
                </a>
              </li>
              <li class='nav-item'>
                <a href='edit-consumption.php' class='nav-link'>
                <i class='fas fa-edit nav-icon'></i>
                  <p>Edit Consumption</p>
                </a>
              </li>
              <li class='nav-item'>
                <a href='view-consumption.php' class='nav-link'>
                  <i class='fas fa-list-alt nav-icon'></i>
                  <p>View Consumption</p>
                </a>
              </li>
            </ul>
          </li>
            
            
            <li class='nav-header'>SALES</li>

            <li class='nav-item'>
              <a href='view-sales.php' class='nav-link'>
                <i class='nav-icon fas fa-coins'></i>
                <p>View Sales</p>
              </a>
            </li>
            <li class='nav-item'>
              <a href='add-transaction.php' class='nav-link'>
                <i class='nav-icon fas fa-user-friends'></i>
                <p>Add Transaction</p>
              </a>
            </li>
            <li class='nav-item active-item'>
              <a href='reports.php' class='nav-link  active'>
                <i class='nav-icon fas fa-file-alt'></i>
                <p>Reports</p>
              </a>
            </li>

            <li class='nav-header'>USERS</li>

            <li class='nav-item'>
              <a href='user-activity.php' class='nav-link'>
                <i class='nav-icon fas fa-user-clock'></i>
                <p>User Activity</p>
              </a>
            </li>
            <li class='nav-item'>
              <a href='#' class='nav-link'>
                <i class='nav-icon fas fa-user-cog'></i>
                <p>
                  User Control
                  <i class='fas fa-angle-left right'></i>
                </p>
              </a>
              <ul class='nav nav-treeview'>
                <li class='nav-item'>
                  <a href='add-user.php' class='nav-link'>
                    <i class='fas fa-plus-circle nav-icon'></i>
                    <p>Add User</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='view-users.php' class='nav-link'>
                    <i class='fas fa-list-alt nav-icon'></i>
                    <p>View Users</p>
                  </a>
                </li>
                <li class='nav-item'>
                  <a href='edit-users.php' class='nav-link'>
                  <i class='fas fa-edit nav-icon'></i>
                    <p>Edit Users</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class='nav-item'>
              <a href='logout.php' class='nav-link logout'>
                <i class='nav-icon fas fa-sign-out-alt'></i>
                <p>Logout</p>
              </a>
            </li>

        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper bg-custom1">
    <div class="content-header bg-custom1">
      <div class="container-fluid text-white">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Generate Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Generate Report</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content bg-custom1">
      <div class="container-fluid">
        <div class="col">
          <div class="card bg-custom text-white">
            <div class="card-header border-0">
              <h3 class="card-title">Filter Table</h3>
            </div>
            <div class="card-body">
              <label for="position" class="form-label">Tables</label>
              <form class="" action="reports.php" method="get">
                <div class="mb-3">
                  <div class="form-group">
                    <select name="table" id="position">
                      <option value="sales_t">Sales</option>
                      <option value="customer_t">Customers</option>
                      <option value="employee_t">Users/Employees</option>
                      <option value="activity_t">User Activity</option>
                      <option value="birds_t">Birds</option>
                      <option value="egg_reading_t">Egg Readings</option>
                      <option value="supply_t">Supplies (Birds)</option>
                      <option value="resources_t">Resources</option>
                      <option value="consumption_t">Consumption</option>
                    </select>
                    <button type="submit" class="btn btn-warning">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card bg-custom text-white">
            <div class="card-header border-0">
              <h3 class="card-title">Table</h3>
            </div>
            <div class="card-body">
              <table id="example1" class='table table-striped table-hover'>
                <?php
                  if(isset($_GET["table"])){
                    $table = $_GET["table"];

                    $sql = "SELECT * FROM $table";
                    $query = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_array($query);

                    $col_count = count($result)/2;
                    $query = mysqli_query($conn, $sql);

                    echo "<thead><tr>";
                    while($row = mysqli_fetch_assoc($query)){
                      foreach($row as $key => $value){
                        if($col_count == 0){
                          break;
                        }
                        echo "<th>$key</th>";
                        $col_count--;
                      }
                    }
                    echo "</tr></thead>";

                    $query = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($query)){
                      
                      echo "<tr>";
                      foreach($row as $key => $value){
                        echo "<td>$value</td>";

                      }
                      echo "</tr>";
                    }

                    echo "<a href='generate-pdf-report.php?generate={$table}' class='btn btn-warning mr-2' target='_blank'>Generate PDF Report</a>";
                    echo "<a href='generate-xls-report.php?generate={$table}' class='btn btn-warning'>Generate Excel Report</a><br><br>";

                  }
                ?>
                </table>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer bg-custom1">
    <strong>Copyright &copy; 2022 <a href="#">RedHen Poultry Farm Enterprise</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>

<!-- REQUIRED SCRIPTS -->

<script src="./plugins/jquery/jquery.min.js"></script>
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./plugins/jszip/jszip.min.js"></script>
<script src="./plugins/pdfmake/pdfmake.min.js"></script>
<script src="./plugins/pdfmake/vfs_fonts.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>
<script src="./dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>

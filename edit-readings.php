<?php
    include("connection.php");
    session_start();

    // check if user is logged in (if there's session)
    if(!$_SESSION["username_s"]) {
        header("location: login.php");
        exit;
    }

    function get_old_values($id, $conn) {
        // getting old values
        $sql = "SELECT * FROM egg_reading_t WHERE reading_id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_assoc($query);

        $reading_id_old = $row_data["reading_id"];
        $collection_date_old = $row_data["collection_date"];
        $expiration_date_old = $row_data["expiration_date"];
        $good_condition_old = $row_data["good_condition"];
        $cracked_old = $row_data["cracked"];
        $tray_old = $row_data["tray"];
        $total_old = $row_data["total"];

        return array($id,$reading_id_old,$collection_date_old,$expiration_date_old,$good_condition_old,$cracked_old,$tray_old,$total_old);
    }
    

    $id = $reading_id = $collection_date = $expiration_date = $good_condition = $cracked = $tray = $total = "";

    if(isset($_GET["delete"])){  // for delete
      $id = $_GET["delete"];  
 
          // get values to add to activity_t
          list($id,$reading_id_old,$collection_date_old,$expiration_date_old,$good_condition_old,$cracked_old,$tray_old,$total_old) = get_old_values($id, $conn);

          // add update activity to activity_t
          $activity = "Delete reading_id = {$id}. Values = ({$reading_id_old}, {$collection_date_old}, {$expiration_date_old}, {$good_condition_old}, {$cracked_old}, {$tray_old}, {$total_old})";
          $id = $_SESSION["id_s"];
          date_default_timezone_set("Asia/Manila");
          $datetime = date("Y-m-d H:i:s");
          $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
          $query = mysqli_query($conn, $sql);

        $id_d = $_GET["delete"];
        $sql = "DELETE FROM egg_reading_t WHERE reading_id= $id_d";

        if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Record has been successfully deleted.</div>";
        } 

        $id = $reading_id = $collection_date = $expiration_date = $good_condition = $cracked = $tray = $total = "";

          if($_GET['delete'] == $_SESSION['id_s']){
            header("location: logout.php");
            exit;
          }

      }elseif(isset($_GET["edit"])){  // for edit (moving data to textboxes to update)
          $id = $_GET["edit"];
  
          // select data from employee_t
          $sql = "SELECT * FROM egg_reading_t WHERE reading_id = $id";
          $query = mysqli_query($conn, $sql);
          $row_data = mysqli_fetch_array($query);
  
          $reading_id = $row_data["reading_id"];
          $collection_date = $row_data["collection_date"];
          $expiration_date = $row_data["expiration_date"];
          $good_condition = $row_data["good_condition"];
          $cracked = $row_data["cracked"];
          $tray = $row_data["tray"];
          $total = $row_data["total"];
        }
        elseif(isset($_POST["update"])){ 
          $id = $_POST["readingID"]; //updating data
          
  
          $reading_id = $_POST["readingID"];
          $collection_date = $_POST["collectionDate"];
          $expiration_date = $_POST["expirationDate"];
          $good_condition = $_POST["goodCondition"];
          $cracked = $_POST["cracked"];
          $tray = $_POST["tray"];
          $total = $_POST["totalEggs"];
  
          // getting old values
          list($id,$reading_id_old,$collection_date_old,$expiration_date_old,$good_condition_old,$cracked_old,$tray_old,$total_old) = get_old_values($id, $conn);
  
  
          
  
          // updating data into egg_reading_t table
          $sql = "UPDATE egg_reading_t SET collection_date = '$collection_date', expiration_date = '$expiration_date', good_condition = '$good_condition' , cracked = '$cracked' , tray = '$tray', total = '$total' WHERE reading_id = '$id'";
          $query = mysqli_query($conn, $sql);
          
            echo "<div class='alert alert-success' role='alert'>Record has been successfully updated.</div>";
            
            // add update activity to activity_t
          $activity = "Update reading_id = {$id}. Old values = ({$collection_date_old}, {$expiration_date_old}, {$good_condition_old}, {$cracked_old}, {$tray_old}, {$total_old}). New values = ({$collection_date}, {$collection_date}, {$expiration_date}, {$good_condition}, {$cracked}, {$tray}, {$total})";
          $id = $_SESSION["id_s"];
          date_default_timezone_set("Asia/Manila");
          $datetime = date("Y-m-d H:i:s");
          $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
          $query = mysqli_query($conn, $sql);
  
          $id = $reading_id = $collection_date = $expiration_date = $good_condition = $cracked = $tray = $total = "";
          }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Egg Reading</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte-modified.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <style>
    .btn-warning, .btn-danger {
      padding: 1px 10px 1px 10px !important;
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
        <a class="nav-link font-weight-bold">EGG READINGS</a>
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
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false"><br>
          <li class="nav-item">
            <a href="home.php" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">POULTRY FARM ACTIVITIES</li>

          <?php if($_SESSION["type_s"] == "Admin") echo "
            <li class='nav-item'>
              <a href='#' class='nav-link ' >
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

            <li class='nav-item active-item'>
              <a href='#' class='nav-link active'>
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
            <li class='nav-item'>
              <a href='reports.php' class='nav-link'>
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
            </li>";
            
            else echo "
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
                    <a href='view-records.php' class='nav-link'>
                      <i class='fas fa-list-alt nav-icon'></i>
                      <p>View Records</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class='nav-item active-item'>
                <a href='#' class='nav-link active'>
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
                      <p>Add Resource</p>
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

              <li class='nav-header'>USERS</li>

              <li class='nav-item'>
                <a href='logout.php' class='nav-link logout'>
                  <i class='nav-icon fas fa-sign-out-alt'></i>
                  <p>Logout</p>
                </a>
              </li>";
          ?>

 
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper bg-custom1">
    <div class="content-header bg-custom1">
      <div class="container-fluid text-white">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit/Delete Egg Readings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Egg Readings</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content bg-custom1">
      <div class="container-fluid">
        <div class="col">
          <div class="card bg-custom text-white">
            <div class="card-header bg-custom2 border-0">
              <h3 class="card-title">Egg Readings Table</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Egg Reading ID</th>
                    <th>Collection Date</th>
                    <th>Expiration Date</th>
                    <th>Good Condition</th>
                    <th>Cracked</th>
                    
                    <th>Action</th>
                    
                  </tr>
                </thead>
                <tbody>

                <?php
                  // loop data to display in table

                  $sql = "SELECT * FROM egg_reading_t";
                  $query = mysqli_query($conn, $sql);

                  $count = mysqli_num_rows($query);

                  while($row_data = mysqli_fetch_array($query)){

                    echo "<tr>";

                    if($count = 1){
                        $count++;
                    }

                    for($i = 0; $i < $count-1; $i++){
                        echo "
                        <td>{$row_data['reading_id']}</td>
                        <td>{$row_data['collection_date']}</td>
                        <td>{$row_data['expiration_date']}</td>
                        <td>{$row_data['good_condition']}</td>
                        <td>{$row_data['cracked']}</td>
                        
                        
                        ";

                    }
                    echo "<td><a href='edit-readings.php?edit={$row_data['reading_id']}' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                              <a href='edit-readings.php?delete={$row_data['reading_id']}' class='btn btn-danger' onclick='return confirm(`Are you sure you want to delete this record?`);'><i class='fas fa-trash-alt'></i></a>
                          </td>";
                    echo "</tr>";
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="content bg-custom1">
      <div class="container-fluid">
        <div class="col">
          <div class="card bg-custom text-white">
            <div class="card-header bg-custom2 border-0">
              <h3 class="card-title">Edit Info</h3>
            </div>
            <div class="card-body">
              <form class="row rounded" action="edit-readings.php" method="post">
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="reading_id" class="form-label">Reading ID</label>
                          <input type="text" name="readingID" class="form-control" value="<?php echo $reading_id?>" readonly>
                      </div>
                      <div class="mb-3">
                          <label for="collectionDate" class="form-label">Collection Date</label>
                          <input type="datetime-local" name="collectionDate" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="goodCondition" class="form-label">Good Condition</label>
                          <input type="number" name="goodCondition" class="form-control" id="goodCondition" min="0" value='<?php echo $good_condition?>' required>
                      </div>
                  </div>
                      
                  <div class="col-md-6">
                       <div class="mb-3">
                          <label for="tray" class="form-label">Tray</label>
                          <input type="number" name="tray" class="form-control" id="tray" min="1" value='<?php echo $tray?>' readonly>
                      </div>
                      <div class="mb-3">
                          <label for="expirationDate" class="form-label">Expiration Date</label>
                          <input type="datetime-local" name="expirationDate" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="cracked" class="form-label">Bad Condition</label>
                          <input type="number" name="cracked" class="form-control" id="cracked" min="0" value='<?php echo $cracked?>' required>
                          <small class="form-text text-muted">Cracked or damaged eggs</small>
                      </div>

                    <div>
                        <h2 class="card-title" id="total"></h2>
                        <input type="number" name="totalEggs" id="totalEggs" hidden>
                    </div>
                      
                      <div class="d-flex justify-content-end">
                        <div class='btn-group' role='group' aria-label='action'>
                                <button type="reset" class='btn btn-light'> Clear </button>
                                <button type='submit' class='btn btn-warning' name='update' onclick='return confirm(`Are you sure you want to add this record?`);'>Update</button>
                        </div>
                      </div>
                  </div>
                </form>
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
<script>
  $(function () {
    $("#example1").DataTable().buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<script> // SCRIPT FOR TOTAL # EGGS
    var tray = document.getElementById("tray");
    var goodCondition = document.getElementById("goodCondition");
    var cracked = document.getElementById("cracked");
    var total = document.getElementById("total");
    var totalEggs = document.getElementById("totalEggs");

    goodCondition.addEventListener("input", sum);
    cracked.addEventListener("input", sum);

    function sum() {
        var good = parseFloat(goodCondition.value) || 0;
        var bad = parseFloat(cracked.value) || 0;

        var add = good + bad;
        
        totalTray = Math.ceil(add / 30);

        total.innerHTML = "Total: " + add + " eggs (" + totalTray + " tray/s)";
        tray.value = totalTray;
        totalEggs.value = add;
    }
</script>

</body>
</html>

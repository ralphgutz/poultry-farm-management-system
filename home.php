<?php
    include("connection.php");
    session_start();

    // check if user is logged in (if there's session)
    if(!$_SESSION["username_s"]) {
        header("location: login.php");
        exit;
    }

    // validate data and prevent sql injection
    function validate($data, $conn){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = mysqli_real_escape_string($conn, $data);
        $data = htmlspecialchars($data);
        return $data;
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home | Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte-modified.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <link rel="stylesheet" href="plugins/uplot/uPlot.min.css">
</head>
<body class=" hold-transition  sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-dark bg-custom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link font-weight-bold">DASHBOARD</a>
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
    <br>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false"><br>
          <li class="nav-item active-item">
            <a href="home.php" class="nav-link active">
              <i class="nav-icon fas fa-chart-line fa-2x"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">POULTRY FARM ACTIVITIES</li>

          <?php if($_SESSION["type_s"] == "Admin") echo "
            <li class='nav-item'>
              <a href='#' class='nav-link' >
                <i class='nav-icon fas fa-kiwi-bird fa-2x'></i>
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
                <i class='nav-icon fas fa-egg fa-4x'></i>
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
                    <p>Add Resources</p>
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

  <div class="content-wrapper bg-light">
    <div class="content-header bg-custom1">
      <div class="container-fluid">
        <br>
        <div class="row bg-custom1">
          <div class="col-md-10">
              <canvas id="areaChart" height="80" style=" max-width: 100%;" class="bg-custom"></canvas>
          </div>
          <div class="col-md-2">
            <div class="small-box bg-primary">
              <div class="inner">
                <?php 
                  $sql = "SELECT SUM(total) FROM egg_reading_t";  
                  $query = mysqli_query($conn, $sql);
                  $result = mysqli_fetch_array($query);

                  echo "<h3>$result[0]</h3>";

                ?>
                <p>Total Eggs in Inventory</p>
              </div>

              <div class="icon">
                <i class="fas fa-egg"></i>
              </div>
              <a href="view-readings.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
            <div class="small-box bg-success">
              <div class="inner">
                <?php 
                  $sql = "SELECT SUM(quantity) FROM birds_t";  
                  $query = mysqli_query($conn, $sql);
                  $result = mysqli_fetch_array($query);

                  echo "<h3>$result[0]</h3>";

                ?>
                <p>Total Birds in Inventory</p>
              </div>

              <div class="icon">
                <i class="fas fa-kiwi-bird"></i>
              </div>
              <a href="view-readings.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
            
          </div>
          
          
        </div>
      </div>
    </div>


    <section class="content bg-custom1">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 ">
            <div class="card-footer bg-custom1 ">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <?php
                        $sql = "SELECT SUM(total) FROM sales_t";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        $total = $result[0] / 2;

                        echo "<h4 class='text-light'>PhP $total</h4>";
                      ?>

                      <span class="description-text text-light">REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <?php
                        $sql = "SELECT SUM(total) FROM egg_reading_t";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        if($result[0] == NULL){
                            echo "<h4 class='text-light'>0</h4>";
                        }
                        else{
                            echo "<h4 class='text-light'>$result[0]</h4>";
                        }
                      ?>
                      
                      <span class="description-text text-light">EGG COLLECTION</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <?php
                        $sql = "SELECT SUM(item_sold) FROM sales_t WHERE type = 'Egg'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        if($result[0] == NULL){
                            echo "<h4 class='text-light'>0</h4>";
                        }
                        else{
                            echo "<h4 class='text-light'>$result[0]</h4>";
                        }
                      ?>
                      
                      <span class="description-text text-light">EGG SOLD</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <?php
                        $sql = "SELECT SUM(item_sold) FROM sales_t WHERE type = 'Bird'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);
                        
                        if($result[0] == NULL){
                            echo "<h4 class='text-light'>0</h4>";
                        }
                        else{
                            echo "<h4 class='text-light'>$result[0]</h4>";
                        }

                        
                      ?>
                      <span class="description-text text-light">BIRD SOLD</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
              </div>
            </div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col-md-5">
            <div class="card bg-custom">
              <div class="card-header text-light">
                  <h3 class="card-title">Resouces</h3>
                </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="progress-group text-light">
                      Mush
                      <?php
                        $sql = "SELECT SUM(amount) FROM resources_t WHERE resource_type = 'Mash Feeds'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        $sql2 = "SELECT remaining FROM consumption_t WHERE resource_id = (SELECT resource_id FROM resources_t WHERE resource_type = 'Mash Feeds' ORDER BY resource_id DESC LIMIT 1)";  
                        $query2 = mysqli_query($conn, $sql2);
                        $result2 = mysqli_fetch_array($query2);

                        if(mysqli_num_rows($query) == 0 || mysqli_num_rows($query2) == 0){
                          $width = $result[0] = $result2[0] = 0;
                        }
                        else{
                          $width = $result2[0] / $result[0] * 100;
                        }

                        echo "<span class='float-right text-light'><b>$result2[0]</b>/$result[0]</span>";
                        echo "<div class='progress progress-sm'>";
                        echo "<div class='progress-bar bg-warning' style='width: $width%'></div>";
                        ?>
                        
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group text-light">
                      Pellets
                      <?php
                        $sql = "SELECT SUM(amount) FROM resources_t WHERE resource_type = 'Pellet Feeds'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        $sql2 = "SELECT remaining FROM consumption_t WHERE resource_id = (SELECT resource_id FROM resources_t WHERE resource_type = 'Pellet Feeds' ORDER BY resource_id DESC LIMIT 1)";  
                        $query2 = mysqli_query($conn, $sql2);
                        $result2 = mysqli_fetch_array($query2);

                        if(mysqli_num_rows($query) == 0 || mysqli_num_rows($query2) == 0){
                          $width = $result[0] = $result2[0] = 0;
                        }
                        else{
                          $width = $result2[0] / $result[0] * 100;
                        }
                        

                        echo "<span class='float-right text-light'><b>$result2[0]</b>/$result[0]</span>";
                        echo "<div class='progress progress-sm'>";
                        echo "<div class='progress-bar bg-warning' style='width: $width%'></div>";
                        ?>
                        </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group text-light">
                      <span class="progress-text">Crumbles</span>
                      <?php
                        $sql = "SELECT SUM(amount) FROM resources_t WHERE resource_type = 'Crumbles Feeds'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        $sql2 = "SELECT remaining FROM consumption_t WHERE resource_id = (SELECT resource_id FROM resources_t WHERE resource_type = 'Crumbles Feeds' ORDER BY resource_id DESC LIMIT 1)";  
                        $query2 = mysqli_query($conn, $sql2);
                        $result2 = mysqli_fetch_array($query2);

                        if(mysqli_num_rows($query) == 0 || mysqli_num_rows($query2) == 0){
                          $width = $result[0] = $result2[0] = 0;
                        }
                        else{
                          $width = $result2[0] / $result[0] * 100;
                        }
                        

                        echo "<span class='float-right text-light'><b>$result2[0]</b>/$result[0]</span>";
                        echo "<div class='progress progress-sm'>";
                        echo "<div class='progress-bar bg-warning' style='width: $width%'></div>";
                        ?>
                        </div>
                    </div>

                    <!-- /.progress-group -->

                    <!-- /.progress-group -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-custom">
              <div class="card-header text-light">
                  <h3 class="card-title">Other Resouces</h3>
                </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="progress-group text-light">
                      Vitamins
                      <?php
                        $sql = "SELECT SUM(amount) FROM resources_t WHERE resource_type = 'Vitamins'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        $sql2 = "SELECT remaining FROM consumption_t WHERE resource_id = (SELECT resource_id FROM resources_t WHERE resource_type = 'Vitamins' ORDER BY resource_id DESC LIMIT 1)";  
                        $query2 = mysqli_query($conn, $sql2);
                        $result2 = mysqli_fetch_array($query2);

                        if(mysqli_num_rows($query) == 0 || mysqli_num_rows($query2) == 0){
                          $width = $result[0] = $result2[0] = 0;
                        }
                        else{
                          $width = $result2[0] / $result[0] * 100;
                        }

                        echo "<span class='float-right text-light'><b>$result2[0]</b>/$result[0]</span>";
                        echo "<div class='progress progress-sm'>";
                        echo "<div class='progress-bar bg-warning' style='width: $width%'></div>";
                        ?>
                        
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group text-light">
                      Water
                      <?php
                        $sql = "SELECT SUM(amount) FROM resources_t WHERE resource_type = 'Water'";  
                        $query = mysqli_query($conn, $sql);
                        $result = mysqli_fetch_array($query);

                        $sql2 = "SELECT remaining FROM consumption_t WHERE resource_id = (SELECT resource_id FROM resources_t WHERE resource_type = 'Water' ORDER BY resource_id DESC LIMIT 1)";  
                        $query2 = mysqli_query($conn, $sql2);
                        $result2 = mysqli_fetch_array($query2);

                        if(mysqli_num_rows($query) == 0 || mysqli_num_rows($query2) == 0){
                          $width = $result[0] = $result2[0] = 0;
                        }
                        else{
                          $width = $result2[0] / $result[0] * 100;
                        }
                        

                        echo "<span class='float-right text-light'><b>$result2[0]</b>/$result[0]</span>";
                        echo "<div class='progress progress-sm'>";
                        echo "<div class='progress-bar bg-warning' style='width: $width%'></div>";
                        ?>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="card bg-custom text-white">
              <div class="card-body">
                <div class="card-header">
                  <h3 class="card-title">Egg Readings</h3>
                </div>
                <div class="row">
                  <div class="col-md-12">
                  <canvas id="lineChart" height="100" style="max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
          
         
        
        <div class="row">

        </div>

        


      </div><!-- /.container-fluid -->
    </section>

    

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
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>
<script src="plugins/flot/jquery.flot.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- Page specific script -->


<script>
$(document).ready(function(){
  $.ajax({
    url : "https://redhenpfms.000webhostapp.com/sales_data.php",
    type : "GET",
    success : function(data){
      console.log(data);

      var id = [];
      var salesEgg = [];
      var salesBird = [];


      for(var i in data) {
        id.push(data[i].invoice_date);
        
        if(data[i].type == "Bird"){
          salesBird.push(data[i].total);
        }
        else {
          salesBird.push("0");
        }
        
      }

      for(var i in data) {
        
        if(data[i].type == "Egg"){
          salesEgg.push(data[i].total);
        }
        else {
          salesEgg.push("0");
        }
        
      }

      console.log(salesBird)


      var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

      var chartdata = {
        labels: id,
        datasets: [
          {
            label: "Egg Sales",
            fill: true,
            lineTension: 0.3,
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : true,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: salesEgg
          },
          {
            label: "Bird Sales",
            fill: true,
            lineTension: 0.3,
            backgroundColor     : 'rgba(238, 204, 54, 0.8)',
            borderColor         : 'rgba(185, 161, 54, 0.9)',
            pointRadius          : true,
            pointColor          : '#000000',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: salesBird
          }
        ]
      };

      

      var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: chartdata,
      options: areaChartOptions
    })

      var ctx = $("#areaChart");

      var LineGraph = new Chart(ctx, {
        type: 'line',
        data: chartdata
      });
    },
    error : function(data) {

    }
  });
});
</script>
<script>
$(document).ready(function(){
  $.ajax({
    url : "https://redhenpfms.000webhostapp.com/inventory_data.php",
    type : "GET",
    success : function(data){

      var id = [];
      var goodCondition = [];
      var cracked = [];

      for(var i in data) {
        id.push(data[i].collection_date.substring(0, 16));
        goodCondition.push(data[i].good_condition);
        cracked.push(data[i].cracked);
        
      }


      console.log(goodCondition)


      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')

      var chartdata = {
        labels: id,
        datasets: [
          {
            label: "Good",
            fill: true,
            lineTension: 0.3,
            backgroundColor     : 'rgba(0, 166, 99, 0.8)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : true,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: goodCondition
          },
          {
            label: "Cracked",
            fill: true,
            lineTension: 0.3,
            backgroundColor     : 'rgba(165, 165, 165, 0.8)',
            borderColor         : 'rgba(185, 161, 54, 0.9)',
            pointRadius          : true,
            pointColor          : '#000000',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: cracked
          }
        ]
      };

      

      var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

      var LineGraph = new Chart(lineChartCanvas, {
        type: 'bar',
        data: chartdata
      });
    },
    error : function(data) {

    }
  });
});

</script>



</body>
</html>

<?php
    include("connection.php");
    session_start();

    // check if user is logged in (if there's session)
    if(!$_SESSION["username_s"]) {
        header("location: login.php");
        exit;
    }

    function validate($data, $conn){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = mysqli_real_escape_string($conn, $data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST["breed"]) && isset($_POST["quantity"]) && isset($_POST["price"]) && isset($_POST["supplyid"]) )
    {
      $supplyid_v = validate($_POST["supplyid"], $conn);
      $breed_v = validate($_POST["breed"], $conn);
      $quantity_v = validate($_POST["quantity"], $conn);
      $price_v = validate($_POST["price"], $conn);
      $now_v = (new DateTime('now'))->format('Y-m-d H:i:s'); 


      $sql = "SELECT supply_id FROM supply_t WHERE supply_id = {$_POST['supplyid']}";  
      $result = mysqli_query($conn, $sql);

      $sql2 = "SELECT batch_id, quantity, bird_breed FROM birds_t WHERE batch_id = {$_POST['breed']}";  
      $result2 = mysqli_query($conn, $sql2);
      $row_data = mysqli_fetch_array($result2);
        
      if(mysqli_num_rows($result) > 0){
        echo "<div class='alert alert-danger' role='alert'>Record with the same Supply ID exists.</div>";
      }
      elseif($quantity_v > $row_data[1]) {
        echo "<div class='alert alert-danger' role='alert'>Available quantity is insufficient.</div>";
      }
      else{
        // insert into supply_t
        $sql = "INSERT INTO supply_t VALUES('$supplyid_v', '$row_data[0]', '$row_data[2]', '$quantity_v', '$price_v','$now_v')";  
        $result = mysqli_query($conn, $sql);

        // insert activity to activity_t
        $activity = "Add new Chicken Supply values = ({$supplyid_v}, {$row_data[0]}, {$row_data[2]}, {$quantity_v}, {$price_v}, {$now_v})";
        $id = $_SESSION["id_s"];
        date_default_timezone_set("Asia/Manila");
        $datetime = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
        $result = mysqli_query($conn, $sql);
        echo "<div class='alert alert-success' role='alert'>Record successfully added.</div>";
      }
    }
?>

<?php

  //Connect to our MySQL database using the PDO extension.
  $pdo = new PDO('mysql:host=localhost;dbname=id18514383_pfms_db', 'id18514383_root', 'JItPuFPJlvc9r(=n');

  //Our select statement. This will retrieve the data that we want.
  $sql = "SELECT * FROM birds_t";

  //Prepare the select statement.
  $stmt = $pdo->prepare($sql);

  //Execute the statement.
  $stmt->execute();

  //Retrieve the rows using fetchAll.
  $resource = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<style>
  
input[type=text], select {
  width: 100%;
  padding: 6px 25px;
  margin: 0px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Chicken Supply</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte-modified.css">
  <link rel="stylesheet" href="dist/css/style.css">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar navbar-dark bg-custom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link font-weight-bold">CHICKEN SUPPLY</a>
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

            <li class='nav-item active-item'>
        <a href='#' class='nav-link active'>
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

              <li class='nav-item active-item'>
              <a href='#' class='nav-link active'>
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

  <div class="content-wrapper bg-custom1">
    <div class="content-header bg-custom1">
      <div class="container-fluid text-white">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Chicken Supply</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Chicken Supply</li>
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
              <h3 class="card-title">Add Info</h3>
            </div>
            <div class="card-body">
              <form class="row rounded" action="add-supply.php" method="post">
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="supplyid" class="form-label">Supply ID</label>
                          <input type="number" name="supplyid" class="form-control" min='1' required>
                      </div>
                      <div class="mb-3">
                          <label for="quantity" class="form-label">Available Quantity</label>
                          <input type="number" name="quantity" class="form-control" min='1' required>
                      </div>
                  </div>
                      
                  <div class="col-md-6">
                      <div class="mb-3">
                        <label for="breed" class="form-label">Chicken Breed</label> <!---CONNECT TO DATABASE FOR VALUES--->
                          <select id="breed" name="breed">
                              <?php foreach($resource as $resource): ?>
                                  <option value="<?= $resource['batch_id']; ?>">Batch ID: <?= $resource['batch_id'];  ?> - <?= $resource['bird_breed']; ?> (<?= $resource['quantity']; ?>)</option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="price" class="form-label">Price Per Chicken</label>
                          <input type="number" name="price" class="form-control" min='1' required>
                      </div>
                      <br>
                      <br>
                      <div class="d-flex justify-content-end">
                        <div class='btn-group' role='group' aria-label='action'>
                                <button type="reset" class='btn btn-light'> Clear </button>
                                <button type='submit' class='btn btn-warning' onclick='return confirm(`Are you sure you want to add this record?`);'>Add</button>
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


  <footer class="main-footer bg-custom1 special-color-dark">
  <strong>Copyright &copy; 2022 <a href="#">RedHen Poultry Farm Enterprise</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>



<!-- REQUIRED SCRIPTS -->
<script src="./plugins/jquery/jquery.min.js"></script>
<script src="./dist/js/adminlte.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

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

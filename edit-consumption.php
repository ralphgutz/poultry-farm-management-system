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
        $sql = "SELECT * FROM consumption_t WHERE consumption_id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_assoc($query);

        $consumption_old = $row_data["consumption_id"];
        $resourceid_old = $row_data["resource_id"];
        $amount_old = $row_data["amount"];
        $unit_old = $row_data["unit"];
        $used_old = $row_data["used"];
        $remaining_old = $row_data["remaining"];
        $dateused_old = $row_data["date_used"];

        return array($id, $consumption_old ,$resourceid_old ,$amount_old ,$unit_old , $used_old ,$remaining_old ,$dateused_old );
    }
    

    $id = $consumption = $consumption_id = $resource_id = $amount = $unit = $used = $remaining = $date_used = "";

    if(isset($_GET["delete"])){  // for delete
      $id = $_GET["delete"];  
 
          // get values to add to activity_t
          list($id, $consumption_old ,$resourceid_old ,$amount_old ,$unit_old , $used_old ,$remaining_old ,$dateused_old) = get_old_values($id, $conn);

          // add update activity to activity_t
          $activity = "Delete emp_id = {$id}. Values = ({$consumption_old },{$resourceid_old}, {$amount_old}, {$unit_old}, {$used_old}, {$remaining_old}, {$dateused_old})";
          $id = $_SESSION["id_s"];
          date_default_timezone_set("Asia/Manila");
          $datetime = date("Y-m-d H:i:s");
          $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
          $query = mysqli_query($conn, $sql);

        $id_d = $_GET["delete"];

        $sql = "DELETE FROM consumption_t WHERE consumption_id= $id_d";

        if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Record has been successfully deleted.</div>";;
        } 

          $id = $batch_id = $bird_breed = $quantity = $update_date = "";

          if($_GET['delete'] == $_SESSION['id_s']){
            header("location: logout.php");
            exit;
          }

      }elseif(isset($_GET["edit"])){  // for edit (moving data to textboxes to update)
        $id = $_GET["edit"];

        // select data from employee_t
        $sql = "SELECT * FROM consumption_t WHERE consumption_id = $id";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_array($query);

        $consumption_id = $row_data["consumption_id"];
        $resource_id = $row_data["resource_id"];
        $amount = $row_data["amount"];
        $unit = $row_data["unit"];
        $used = $row_data["used"];
        $remaining = $row_data["remaining"];
        $date_used = $row_data["date_used"];
      }
      elseif(isset($_POST["update"])){ 
        $id = $_POST["consumption"]; //updating data

        $consumption_id = $_POST["consumption"];
        $resource_id = $_POST["resourceid"];
        $amount = $_POST["amount"];
        $unit = $_POST["unit"];
        $used = $_POST["used"];
        $remaining = $_POST["remaining"];
        $date_used = $_POST["dateused"];

        // getting old values
        list($id, $consumption_old ,$resourceid_old ,$amount_old ,$unit_old , $used_old ,$remaining_old ,$dateused_old) = get_old_values($id, $conn);

        // updating data into consumption_t table
        $sql = "UPDATE consumption_t SET resource_id = '$resource_id', amount = '$amount', unit = '$unit', used = '$used', remaining = '$remaining', date_used = '$date_used' WHERE consumption_id = '$id'";
        $query = mysqli_query($conn, $sql);

        // add update activity to activity_t
        $activity = "Update consumption_id = {$id}. Old values = ({$resourceid_old}, {$amount_old}, {$unit_old}, {$used_old}, {$remaining_old}, {$dateused_old}). New values = ({$resource_id}, {$amount}, {$unit}, {$used}, {$remaining}, {$date_used})";
        $id = $_SESSION["id_s"];
        date_default_timezone_set("Asia/Manila");
        $datetime = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
        $query = mysqli_query($conn, $sql);

        echo "<div class='alert alert-success' role='alert'>Record has been successfully updated.</div>";

        $id = $consumption = $resource_id = $amount = $unit = $used = $remaining = $date_used = "";
        }
?>
<?php

//Connect to our MySQL database using the PDO extension.
$pdo = new PDO('mysql:host=localhost;dbname=id18514383_pfms_db', 'id18514383_root', 'JItPuFPJlvc9r(=n');

//Our select statement. This will retrieve the data that we want.
$sql = "SELECT resource_id FROM resources_t";

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
    padding: 6px 14px;
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
  <title>Edit Consumption</title>
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
        <a class="nav-link font-weight-bold">CONSUMPTION</a>
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

          <li class='nav-item active-item'>
          <a href='#' class='nav-link active'>
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
            <h1 class="m-0">Edit/Delete Consumption</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Consumption</li>
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
              <h3 class="card-title">Consumption Table</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Consumption ID</th>
                    <th>Resource ID</th>
                    <th>Amount</th>
                    <th>Unit</th>
                    <th>Used</th>
                    <th>Remaining</th>
                    <th>Date Used</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                  // loop data to display in table

                  $sql = "SELECT * FROM consumption_t";
                  $query = mysqli_query($conn, $sql);

                  $count = mysqli_num_rows($query);

                  while($row_data = mysqli_fetch_array($query)){

                    echo "<tr>";

                    if($count = 1){
                        $count++;
                    }

                    for($i = 0; $i < $count-1; $i++){
                        echo "
                        <td>{$row_data['consumption_id']}</td>
                        <td>{$row_data['resource_id']}</td>
                        <td>{$row_data['amount']}</td>
                        <td>{$row_data['unit']}</td>
                        <td>{$row_data['used']}</td>
                        <td>{$row_data['remaining']}</td>
                        <td>{$row_data['date_used']}</td>
                        
                        
                        ";

                    }
                    echo "<td><a href='edit-consumption.php?edit={$row_data['consumption_id']}' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                              <a href='edit-consumption.php?delete={$row_data['consumption_id']}' class='btn btn-danger' onclick='return confirm(`Are you sure you want to delete this record?`);'><i class='fas fa-trash-alt'></i></a>
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
              <form class="row rounded" action="edit-consumption.php" method="post">
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="consumption" class="form-label">Consumption ID</label>
                          <input type="text" name="consumption" class="form-control" value="<?php echo $consumption_id ?>" readonly>
                      </div>
                      <div class="mb-3">
                          <label for="used" class="form-label">Used</label>
                          <input type="number" name="used" class="form-control" min='1' value="<?php echo $used ?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="amount" class="form-label">Amount</label>
                          <input type="number" name="amount" class="form-control" min='1' value="<?php echo $amount ?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="unit" class="form-label">Unit</label>
                          <select id="unit" name="unit" required>
                            <option <?php if($unit == "kg") echo 'selected' ?> value="kg">kg</option>
                            <option <?php if($unit == "g") echo 'selected' ?> value="g">g</option>
                            <option <?php if($unit == "mL") echo 'selected' ?> value="ml">mL</option>
                            <option <?php if($unit == "L") echo 'selected' ?> value="L">L</option>
                            <option <?php if($unit == "capsules") echo 'selected' ?> value="capsules">Capsules</option>
                            <option <?php if($unit == "gal") echo 'selected' ?> value="gal">gal</option>
                          </select>
                      </div>
                  </div>
                      
                  <div class="col-md-6">
                      <div class="mb-3">
                        <label for="resourceid" class="form-label">Resource ID</label> <!---CONNECT TO DATABASE FOR VALUES--->
                          <select id="resourceid" name="resourceid">
                              <?php foreach($resource as $resource): ?>
                                  <option value="<?= $resource['resource_id']; ?>"><?= $resource['resource_id']; ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label for="remaining" class="form-label">Remaining </label>
                          <input type="number" name="remaining" class="form-control" min='0' value="<?php echo $remaining ?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="dateused" class="form-label">Date Used </label>
                          <input type="date" name="dateused" class="form-control" value="<?php echo $date_used ?>" required>
                      </div>
                      <br>
                      <br>
                      <div class="d-flex justify-content-end">
                        <div class='btn-group' role='group' aria-label='action'>
                                <button type="reset" class='btn btn-light'> Clear </button>
                                <button type='submit' class='btn btn-warning' name="update" onclick='return confirm(`Are you sure you want to update this record?`);'>Update</button>
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
</body>
</html>

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
        $sql = "SELECT * FROM employee_t WHERE emp_id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_assoc($query);

        $firstname_old = $row_data["first_name"];
        $lastname_old = $row_data["last_name"];
        $position_old = $row_data["position_code"];
        $sex_old = $row_data["sex"];
        $birthdate_old = $row_data["birthdate"];
        $contact_old = $row_data["contact_no"];
        $address_old = $row_data["address"];

        $sql = "SELECT * FROM account_t WHERE emp_id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_assoc($query);

        $username_old = $row_data["username"];
        $password_old = $row_data["accpass"];

        return array($id, $firstname_old, $lastname_old, $position_old, $sex_old, $birthdate_old, $contact_old, $address_old, $username_old, $password_old);
    }
    

    $id = $firstname = $lastname = $position_code = $sex = $birthdate = $contact = $address = $username = $password = "";

    if(isset($_GET["delete"])){  // for delete
        $id = $_GET["delete"];

        $sql = "SELECT * FROM account_t WHERE emp_id = {$_GET['delete']}"; 
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_array($query);

        if($row_data['account_type'] == "Admin"){
          echo "<div class='alert alert-danger' role='alert'>Administrator account cannot be deleted.</div>";
          ;
        }
        else{
          // get values to add to activity_t
          list($id, $firstname_old, $lastname_old, $position_old, $sex_old, $birthdate_old, $contact_old, $address_old, $username_old, $password_old) = get_old_values($id, $conn);

          // add update activity to activity_t
          $activity = "Delete emp_id = {$id}. Values = ({$firstname_old}, {$lastname_old}, {$position_old}, {$sex_old}, {$birthdate_old}, {$contact_old}, {$address_old}, {$username_old}, {$password_old})";
          $id = $_SESSION["id_s"];
          date_default_timezone_set("Asia/Manila");
          $datetime = date("Y-m-d H:i:s");
          $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
          $query = mysqli_query($conn, $sql);

          // delete user from table
          $sql = "DELETE FROM employee_t WHERE emp_id = {$_GET['delete']}";  // naka-on delete cascade na sya so if deleted id sa account_t, deleted rin sa employee_t
          $query = mysqli_query($conn, $sql);

          echo "<div class='alert alert-success' role='alert'>Record has been successfully deleted.</div>";

          $id = $firstname = $lastname = $position_code = $sex = $birthdate = $contact = $address = $username = $password = "";

          if($_GET['delete'] == $_SESSION['id_s']){
            header("location: logout.php");
            exit;
          }
        }
    }
    elseif(isset($_GET["edit"])){  // for edit (moving data to textboxes to update)
        $id = $_GET["edit"];

        // select data from employee_t
        $sql = "SELECT * FROM employee_t WHERE emp_id = $id";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_array($query);

        $firstname = $row_data["first_name"];
        $lastname = $row_data["last_name"];
        $position_code = $row_data["position_code"];
        $sex = $row_data["sex"];
        $birthdate = $row_data["birthdate"];
        $contact = $row_data["contact_no"];
        $address = $row_data["address"];

        // select data from account_t
        $sql = "SELECT * FROM account_t WHERE emp_id = $id";
        $query = mysqli_query($conn, $sql);
        $row_data = mysqli_fetch_array($query);

        $username = $row_data["username"];
        $password = $row_data["accpass"];

    }
    elseif(isset($_POST["update"])){  // for updating data
        if(strcmp($_POST["password"], $_POST["passwordConfirm"]) != 0){
            echo "<div class='alert alert-danger' role='alert'>Passwords do not match.</div>";
        }
        elseif(strlen($_POST["password"]) < 6){
            echo "<div class='alert alert-danger' role='alert'>Password must be 6+ characters long.</div>";
        }
        else{
            $id = $_POST["id"];

            $firstname = $_POST["fname"];
            $lastname = $_POST["lname"];
            $position_code = $_POST["position"];
            $sex = $_POST["radioSex"];
            $birthdate = $_POST["birthdate"];
            $contact = $_POST["contact"];
            $address = $_POST["address"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            // getting old values
            list($id, $firstname_old, $lastname_old, $position_old, $sex_old, $birthdate_old, $contact_old, $address_old, $username_old, $password_old) = get_old_values($id, $conn);

            // updating data into account_t and employee_t tables
            $sql = "UPDATE employee_t SET first_name = '$firstname', last_name = '$lastname', position_code = '$position_code', sex = '$sex', birthdate = '$birthdate', contact_no = '$contact', address = '$address' WHERE emp_id = '$id'";
            $query = mysqli_query($conn, $sql);

            $sql = "UPDATE account_t set username = '$username', accpass = '$password' WHERE emp_id = '$id'";
            $query = mysqli_query($conn, $sql);

            // add update activity to activity_t
            $activity = "Update emp_id = {$id}. Old values = ({$firstname_old}, {$lastname_old}, {$position_old}, {$sex_old}, {$birthdate_old}, {$contact_old}, {$address_old}, {$username_old}, {$password_old}). New values = ({$firstname}, {$lastname}, {$position_code}, {$sex}, {$birthdate}, {$contact}, {$address}, {$username}, {$password})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $query = mysqli_query($conn, $sql);

            echo "<div class='alert alert-success' role='alert'>Record has been successfully updated.</div>";

            $id = $firstname = $lastname = $position_code = $sex = $birthdate = $contact = $address = $username = $password = "";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Users</title>
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
    table .btn-warning, .btn-danger {
      padding: 1px 10px 1px 10px !important;
    }
    select, input[type=date] {
      padding: 5px 14px;
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
        <a class="nav-link font-weight-bold">USER CONTROL</a>
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
            <li class='nav-item active-item'>
              <a href='#' class='nav-link active'>
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
            <h1 class="m-0">View/Edit/Delete Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Users</li>
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
              <h3 class="card-title">User Table</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Emp ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position Code</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                  // loop data to display in table

                  $sql = "SELECT * from employee_t";
                  $query = mysqli_query($conn, $sql);

                  $count = mysqli_num_rows($query);

                  while($row_data = mysqli_fetch_array($query)){
                    echo "<tr>";

                    if($count = 1){
                        $count++;
                    }

                    for($i = 0; $i < $count-1; $i++){
                        $sql2 = "SELECT username FROM account_t WHERE emp_id = {$row_data['emp_id']}";
                        $query2 = mysqli_query($conn, $sql2);
                        $row_data2 = mysqli_fetch_array($query2);

                        echo "
                            <td>{$row_data['emp_id']}</td>
                            <td>{$row_data2[0]}</td>
                            <td>{$row_data['first_name']}</td>
                            <td>{$row_data['last_name']}</td>
                            <td>{$row_data['position_code']}</td>
                        ";

                    }
                    echo "<td><a href='edit-users.php?edit={$row_data['emp_id']}' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                              <a href='edit-users.php?delete={$row_data['emp_id']}' class='btn btn-danger' onclick='return confirm(`Are you sure you want to delete this record?`);'><i class='fas fa-trash-alt'></i></a>
                          </td>";
                    echo "</tr>";
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card bg-custom text-white">
            <div class="card-header border-0">
              <h3 class="card-title">Edit Info</h3>
            </div>
            <div class="card-body">
              <form class="row rounded" action="edit-users.php" method="post">
                  <div class="col-md-6">
                      <input type="hidden" name="id" value="<?php echo $id?>">
                      <div class="mb-3">
                          <label for="fname" class="form-label">First Name</label>
                          <input type="text" name="fname" class="form-control" value="<?php echo $firstname?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="position" class="form-label">Position</label>
                          <div class="form-group">
                            <select name="position" id="position">
                                <option <?php if($position_code == "PC-OOM") echo "selected" ?> value="PC-OOM">PC-OOM (Over-all Operations Manager)</option>
                                <option <?php if($position_code == "PC-BM") echo "selected" ?> value="PC-BM">PC-BM (Breeding Manager)</option>
                                <option <?php if($position_code == "PC-HM") echo "selected" ?> value="PC-HM">PC-HM (Hatchery Manager)</option>
                                <option <?php if($position_code == "PC-S") echo "selected" ?> value="PC-S">PC-S (Supervisor)</option>
                                <option <?php if($position_code == "PC-QC") echo "selected" ?> value="PC-QC">PC-QC (Quality Control)</option>
                                <option <?php if($position_code == "PC-MM") echo "selected" ?> value="PC-MM">PC-MM (Marketing Manager)</option>
                                <option <?php if($position_code == "PC-IT") echo "selected" ?> value="PC-IT">PC-IT (IT Support)</option>
                                <option <?php if($position_code == "PC-PL") echo "selected" ?> value="PC-PL">PC-PL (Poultry Laborer)</option>
                                <option <?php if($position_code == "PC-N") echo "selected" ?> value="PC-N">PC-N (Nutritionist)</option>
                            </select>
                          </div>
                      </div>
                      <div class="mb-3 ml-2">
                        <div class="row">
                          <label class="mb-2">Gender</label><br>
                        </div>
                        <div class="row">
                          
                          <div class="col-2 form-check">
                            <input type="radio" class="form-check-input" name="radioSex" id="male" value="Male" <?php echo ($sex=="Male")?"checked":"" ?> required>
                            <label for="male" class="form-check-label me-2">Male</label>
                          </div>
                          <div class="col-2 form-check">
                            <input type="radio" class="form-check-input" name="radioSex" id="female" value="Female" <?php echo ($sex=="Female")?"checked":"" ?> required>
                            <label for="female" class="form-check-label">Female</label>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                          <label for="birthdate" class="mb-2">Birthdate</label><br>
                          <input type="date" name="birthdate" value="<?php echo $birthdate?>" required>
                      </div>
                  </div>
                      
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="lname" class="form-label">Last Name</label>
                          <input type="text" name="lname" class="form-control" value="<?php echo $lastname?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="contact" class="form-label">Contact Number</label>
                          <input type="text" name="contact" class="form-control" value="<?php echo $contact?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" name="address" class="form-control" value="<?php echo $address?>" required>
                      </div>
                      <br><hr><br>
                      <div class="mb-3">
                          <label for="username" class="form-label">Username</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $username?>" readonly>
                      </div>
                      <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" value="<?php echo $password?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="passwordConfirm" class="form-label">Confirm Password</label>
                          <input type="password" name="passwordConfirm" class="form-control" placeholder="Confirm password to update" required>
                      </div>
                      <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-warning" name="update"  onclick='return confirm(`Are you sure you want to update this record?`);'>Update</button>
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
</body>
</html>

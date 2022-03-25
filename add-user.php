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

    if(isset($_POST["fname"]) && isset($_POST["lname"]) &&  isset($_POST["position"]) && isset($_POST["radioSex"]) && isset($_POST["birthdate"]) && 
       isset($_POST["contact"]) && isset($_POST["address"]) && isset($_POST["username"]) && isset($_POST["password"])){

        if(strcmp($_POST["password"], $_POST["passwordConfirm"]) != 0){
            echo "<div class='alert alert-danger' role='alert'>Passwords do not match.</div>";
        }
        elseif(strlen($_POST["password"]) < 6){
            echo "<div class='alert alert-danger' role='alert'>Password must be 6+ characters long.</div>";
        }
        else{
            $fname_v = validate($_POST["fname"], $conn);
            $lname_v = validate($_POST["lname"], $conn);
            $position_v = validate($_POST["position"], $conn);
            $radioSex_v = validate($_POST["radioSex"], $conn);
            $birthdate_v = validate($_POST["birthdate"], $conn);
            $contact_v = validate($_POST["contact"], $conn);
            $address_v = validate($_POST["address"], $conn);
            $username_v = validate($_POST["username"], $conn);
            $password_v = validate($_POST["password"], $conn);

            $sql = "SELECT username FROM account_t WHERE username = '$username_v'";  
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                echo "<div class='alert alert-danger' role='alert'>Record failed to add. Username already exists.</div>";
            }
            else{
                // insert into employee_t
                $sql = "INSERT INTO employee_t(first_name, last_name, position_code, sex, birthdate, contact_no, address) VALUES('$fname_v', '$lname_v', '$position_v', '$radioSex_v', '$birthdate_v', '$contact_v', '$address_v')";  
                $result = mysqli_query($conn, $sql);

                // insert into account_t
                $sql = "INSERT INTO account_t(username, accpass, account_type) VALUES('$username_v', '$password_v', 'Employee')";  
                $result = mysqli_query($conn, $sql);

                // insert activity to activity_t
                $activity = "Add new user values = ({$fname_v}, {$lname_v}, {$position_v}, {$radioSex_v}, {$birthdate_v}, {$contact_v}, {$address_v}, {$username_v}, {$password_v})";
                $id = $_SESSION["id_s"];
                date_default_timezone_set("Asia/Manila");
                $datetime = date("Y-m-d H:i:s");
                $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
                $result = mysqli_query($conn, $sql);
                echo "<div class='alert alert-success' role='alert'>Record successfully added.</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add User</title>
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
            <h1 class="m-0">Add New User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add User</li>
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
              <h3 class="card-title">Add Info</h3>
            </div>
            <div class="card-body">
              <form class="row rounded" action="add-user.php" method="post">
                  <div class="col-md-6">
                      <input type="hidden" name="id">
                      <div class="mb-3">
                          <label for="fname" class="form-label">First Name</label>
                          <input type="text" name="fname" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="position" class="form-label">Position</label>
                          <div class="form-group">
                            <select name="position" id="position">
                                <option value="PC-OOM">PC-OOM (Over-all Operations Manager)</option>
                                <option value="PC-BM">PC-BM (Breeding Manager)</option>
                                <option value="PC-HM">PC-HM (Hatchery Manager)</option>
                                <option value="PC-S">PC-S (Supervisor)</option>
                                <option value="PC-QC">PC-QC (Quality Control)</option>
                                <option value="PC-MM">PC-MM (Marketing Manager)</option>
                                <option value="PC-IT">PC-IT (IT Support)</option>
                                <option value="PC-PL">PC-PL (Poultry Laborer)</option>
                                <option value="PC-N">PC-N (Nutritionist)</option>
                            </select>
                          </div>

                      </div>
                      <div class="mb-3 ml-2">
                        <div class="row">
                          <label class="mb-2">Gender</label><br>
                        </div>
                        <div class="row">
                          <div class="col-2 form-check">
                            <input type="radio" class="form-check-input" name="radioSex" id="male" value="Male" required>
                            <label for="male" class="form-check-label me-2">Male</label>
                          </div>
                          <div class="col-2 form-check">
                            <input type="radio" class="form-check-input" name="radioSex" id="female" value="Female" required>
                            <label for="female" class="form-check-label">Female</label>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                          <label for="birthdate" class="mb-2">Birthdate</label><br>
                          <input type="date" name="birthdate" required>
                      </div>
                  </div>

                  <hr class="hr">
                      
                  <div class="col-md-6">
                    <div class="mb-3">
                          <label for="lname" class="form-label">Last Name</label>
                          <input type="text" name="lname" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="contact" class="form-label">Contact Number</label>
                          <input type="number" name="contact" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" name="address" class="form-control" required>
                      </div>
                      <br><hr><br>
                      <div class="mb-3">
                          <label for="username" class="form-label">Username</label>
                          <input type="text" name="username" class="form-control" placeholer="" required>
                          <small class="form-text text-muted">NOTE: Username must be unique. This cannot be edited later on.</small>
                      </div>
                      <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" placeholder="••••••" required>
                          <small class="form-text text-muted">NOTE: Must be 6+ characters long.</small>
                      </div>
                      <div class="mb-3">
                          <label for="passwordConfirm" class="form-label">Confirm Password</label>
                          <input type="password" name="passwordConfirm" class="form-control" placeholder="••••••" required>
                      </div>
                      
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
<script src="./dist/js/adminlte.min.js"></script>

</body>
</html>

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

    if(isset($_GET["searchBox"])){ 
        $_SESSION["search"] = $_GET["searchBox"];

        // add search activity to activity table
        $activity = "Search keyword \'{$_GET['searchBox']}\'";
        $id = $_SESSION["id_s"];
        date_default_timezone_set("Asia/Manila");
        $datetime = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
        $query = mysqli_query($conn, $sql);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Search Results</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte-modified.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <style>
    .btn-info, .btn-danger {
      padding: 1px 12px 1px 12px !important;
    }
    .card-body a {
      color:  #d4ae01;
    }
    .card-body a:hover {
      color:  #a78800;
    }
    select {
      padding: 6px 14px;
      display: inline-block;
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
        <a class="nav-link font-weight-bold">SEARCH</a>
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
              <input class="form-control form-control-navbar" name="searchBox" type="search" placeholder="Search" aria-label="Search" value="<?php echo $_SESSION["search"] ?>">

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

          <?php if($_SESSION["type_s"] == "Admin") echo "
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

  <div class="content-wrapper bg-custom1">
    <div class="content-header bg-custom1">
      <div class="container-fluid text-white">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Search Results for "<?php echo $_SESSION['search']?>"</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Search Results</li>
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
                <h3 class="card-title">Pages</h3>
            </div>
            <div class="card-body">
                    <?php
                        $data = validate($_SESSION['search'], $conn);
                        $pages = array("Home / Dashboard" => "home.php", "Add Bird" => "add-bird.php", "View Records" => "view-records.php", "Edit/Delete Records" => "edit-birds.php", 
                                        "Add User" => "add-user.php", "Edit/Delete Users" => "edit-users.php", "View Users" => "view-users.php", "User Activity" => "user-activity.php", 
                                        "Add Egg Reading" => "add-reading.php", "View Egg Readings" => "view-readings.php", "Edit/Delete Readings" => "edit-reading.php",
                                        "Add Chicken Supply" => "add-supply.php", "View Chicken Supply" => "view-supply.php", "Edit/Delete Chicken Supply" => "edit-supply.php", 
                                        "Add Resources" => "add-resources.php", "View Resources" => "view-resources.php", "Edit/Delete Resources" => "edit-resources.php",
                                        "Add Consumption" => "add-consumption.php", "View Consumption" => "view-consumption.php", "Edit/Delete Consumption" => "edit-consumption.php",
                                        "Reports" => "reports.php", "View Sales" => "view-sales.php", "Add Transaction" => "add-transaction.php");

                        if($_SESSION["search"]){
                            $regEx_str = "/".$data."/i";
                            
                            $count = 0;
                            foreach($pages as $ind => $value){
                                if(preg_match($regEx_str, $ind)){
                                    echo "<a href='{$value}'>{$ind}</a><br> <i><small>Directory: /{$value}</small></i><br><br>";
                                    $count++;
                                }
                            }

                            if($count == 0){
                                echo "No results found.";
                            }
                        }
                        else {
                          echo "No results found.";
                        }
                    ?>
            </div>
          </div>
        </div>

        <?php if($_SESSION["type_s"] == "Admin"){ echo "
          <div class='col'>
            <div class='card bg-custom text-white'>
              <div class='card-header border-0'>
                  <h3 class='card-title'>Users</h3>
              </div>
              <div class='card-body'>
                  <form action='search.php' method='post'>
                      <div class='form-group'>
                          Search in:
                          <select name='sort' id='sort' class='mx-2'>
                              <option value='name'>Name</option>
                              <option value='username'>Username</option>
                              <option value='position'>Position</option>
                              <option value='address'>Address</option>
                          </select>
                          <button type='submit' class='btn btn-warning'><b>Go</b></button>
                      </div>
                  </form>";

                          if(!empty($_POST['sort'])) {
                              $selected = $_POST['sort'];

                              if($selected == 'username'){
                                  $sql = "SELECT a.emp_id, b.username, a.first_name, a.last_name, a.position_code, a.sex, a.birthdate, a.contact_no, a.address FROM employee_t as a, account_t as b WHERE (a.emp_id = b.emp_id) AND (b.username LIKE '%$data%')";
                              }
                              elseif($selected == 'name'){
                                  $sql = "SELECT * FROM employee_t WHERE (first_name LIKE '%$data%') OR (first_name LIKE '%$data') OR (first_name LIKE '%$data%') OR (last_name LIKE '%$data%') OR (last_name LIKE '%$data') OR (last_name LIKE '%$data%')";
                              }
                              elseif($selected == 'position'){
                                  $sql = "SELECT * FROM employee_t WHERE (position_code = (SELECT position_code FROM position_t WHERE position LIKE '%$data%')) OR (position_code LIKE '%$data%')";
                              }
                              elseif($selected == 'address'){
                                $sql = "SELECT * FROM employee_t WHERE (address LIKE '%$data%') OR (address LIKE '%$data') OR (address LIKE '%$data%')";
                              }
                          } 
                          else{
                            $selected = 'name';
                            $sql = "SELECT * FROM employee_t WHERE (first_name LIKE '%$data%') OR (last_name LIKE '%$data%')";
                          }
                          
                          $result = mysqli_query($conn, $sql);
                          $count = mysqli_num_rows($result);

                          if(mysqli_num_rows($result) > 0){
                              echo "
                              <table class='table table-striped table-hover'>
                              <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Username</th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Position Code</th>
                                  <th>Sex</th>
                                  <th>Birthdate</th>
                                  <th>Contact No</th>
                                  <th>Address</th>
                              </tr>
                              </thead>
                              <tbody>
                              ";

                              while($row_data = mysqli_fetch_array($result)){

                                  echo '<tr>';

                                  if($count = 1){
                                      $count++;
                                  }

                                  $sql2 = "SELECT username FROM account_t WHERE emp_id = {$row_data['emp_id']}";
                                  $query2 = mysqli_query($conn, $sql2);
                                  $row_data2 = mysqli_fetch_array($query2);

                                  echo "
                                  <td>{$row_data['emp_id']}</td>
                                  <td>{$row_data2[0]}</td>
                                  <td>{$row_data['first_name']}</td>
                                  <td>{$row_data['last_name']}</td>
                                  <td>{$row_data['position_code']}</td>
                                  <td>{$row_data['sex']}</td>
                                  <td>{$row_data['birthdate']}</td>
                                  <td>{$row_data['contact_no']}</td>
                                  <td>{$row_data['address']}</td>
                                  ";
                              }

                              echo '</tbody></table>'; 
                
                          }
                          else{
                              echo '<td colspan=6>No results found.</td>';
                          }
                          
                          echo "
              </div>
            </div>
          </div>";} 
        ?>

        <div class="col">
          <div class="card bg-custom text-white">
            <div class="card-header border-0">
                <h3 class="card-title">Birds</h3>
            </div>
            <div class="card-body">
                    <?php
                        $sql = "SELECT * FROM birds_t WHERE (bird_breed LIKE '%$data%')";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);

                        if(mysqli_num_rows($result) > 0){
                            echo "
                            <table class='table table-striped table-hover'>
                            <thead>
                            <tr>
                                <th>Batch ID</th>
                                <th>Breed</th>
                                <th>Quantity</th>
                                <th>Update Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            ";

                            while($row_data = mysqli_fetch_array($result)){

                                echo "<tr>";

                                if($count = 1){
                                    $count++;
                                }

                                echo "
                                <td>{$row_data['batch_id']}</td>

                                <td>{$row_data['bird_breed']}</td>
                                <td>{$row_data['quantity']}</td>
                                <td>{$row_data['update_date']}</td>
                                ";
                            }

                            echo "</tbody></table>"; 
              
                        }
                        else{
                            echo "<td colspan=6>No results found.</td>";
                        }
                    ?>
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

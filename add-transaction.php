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

    if(isset($_POST["addBtn"])){
      $invNum = validate($_POST["invNum"], $conn);
      $billTo = validate($_POST["billTo"], $conn);
      $address = validate($_POST["address"], $conn);
      $contact = validate($_POST["contact"], $conn);
      
      $pricePerEgg = $_POST["pricePerEgg"];
      $pricePerChicken = $_POST["pricePerChicken"];
      $invDate = $_POST["invDate"];
      $paymentDue = $_POST["paymentDue"];
      $total = $_POST["total2"];

      $_SESSION["billTo"] = $billTo;
      $_SESSION["address"] = $address;
      $_SESSION["contact"] = $contact;
      $_SESSION["invDate"] = $paymentDue;
      $_SESSION["paymentDue"] = $paymentDue;
      $_SESSION["total"] = $total;

      $_SESSION["items"] = "";


      $sql = "SELECT customer_id FROM customer_t WHERE customer_name = '$billTo'";  
      $query = mysqli_query($conn, $sql);

      if(mysqli_num_rows($query) > 0){
        $result = mysqli_fetch_array($query);
        $customer_id = $result[0];
      }
      else{
        $sql = "INSERT INTO customer_t(customer_id, customer_name, contact, address) VALUES (default, '$billTo', '$contact', '$address')";  
        $query = mysqli_query($conn, $sql);

        $sql = "SELECT customer_id FROM customer_t WHERE customer_name = '$billTo'";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        $customer_id = $result[0];
      }



      if(isset($_POST["item1"])){
        $item1 = $_POST["item1"];
        $toGet1 = $_POST["toGet1"];

        $sql = "SELECT quantity, batch_id, price FROM supply_t WHERE supply_id = {$_POST['item1']}";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        
        if($result[0] < $toGet1){
          echo "<div class='alert alert-danger' role='alert'>Item 1 has insufficient quantity.</div>";
        }
        else{
            $remaining = $result[0] - $toGet1;
    
            // subtract the birds in birds_t
            $sql2 = "UPDATE birds_t SET quantity = quantity - {$toGet1} WHERE batch_id = {$result[1]}";  
            $query = mysqli_query($conn, $sql2);
    
            // subtract the birds in supply_t
            $sql = "UPDATE supply_t SET quantity = {$remaining} WHERE supply_id = {$_POST['item1']}";  
            $query = mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO sales_t (invoice_id, invoice_date, customer_id , payment_date, type, item, item_sold, total) VALUES ('$invNum', '$invDate', '$customer_id', '$paymentDue', 'Bird', '$item1', '$toGet1', '$total')";  
            $query = mysqli_query($conn, $sql);
            
            $_SESSION["items"] = $_SESSION["items"] . "<tr><td>$item1</td><td>Bird</td><td>$toGet1</td><td>$pricePerChicken</td></tr>";

    
            // insert activity to activity_t
            $activity = "Add new bird sales values = ({$invNum}, {$invDate}, {$customer_id}, {$paymentDue}, Bird, {$item1}, {$toGet1}, {$total})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            
            echo "<div class='alert alert-success' role='alert'>Item 1 successfully added.</div>";
          }
      }

      if(isset($_POST["item2"])){
        $item2 = $_POST["item2"];
        $toGet2 = $_POST["toGet2"];
        
        $sql = "SELECT quantity, batch_id, price FROM supply_t WHERE supply_id = {$_POST['item2']}";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        
        if($result[0] < $toGet2){
          echo "<div class='alert alert-danger' role='alert'>Item 2 has insufficient quantity.</div>";
        }
        else{
            $remaining = $result[0] - $toGet2;
    
            // subtract the birds in birds_t
            $sql2 = "UPDATE birds_t SET quantity = quantity - {$toGet2} WHERE batch_id = {$result[1]}";  
            $query = mysqli_query($conn, $sql2);
    
            // subtract the birds in supply_t
            $sql = "UPDATE supply_t SET quantity = {$remaining} WHERE supply_id = {$_POST['item2']}";  
            $query = mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO sales_t (invoice_id, invoice_date, customer_id , payment_date, type, item, item_sold, total) VALUES ('$invNum', '$invDate', '$customer_id', '$paymentDue', 'Bird', '$item2', '$toGet2', '$total')";  
            $query = mysqli_query($conn, $sql);
            
            $_SESSION["items"] = $_SESSION["items"] . "<tr><td>$item2</td><td>Bird</td><td>$toGet2</td><td>$pricePerChicken</td></tr>";
    
            // insert activity to activity_t
            $activity = "Add new bird sales values = ({$invNum}, {$invDate}, {$customer_id}, {$paymentDue}, Bird, {$item2}, {$toGet2}, {$total})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            
            echo "<div class='alert alert-success' role='alert'>Item 2 successfully added.</div>";
          }
      }

      if(isset($_POST["item3"])){
        $item3 = $_POST["item3"];
        $toGet3 = $_POST["toGet3"];
        
        $sql = "SELECT quantity, batch_id, price FROM supply_t WHERE supply_id = {$_POST['item3']}";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        
        if($result[0] < $toGet3){
          echo "<div class='alert alert-danger' role='alert'>Item 3 has insufficient quantity.</div>";
        }
        else{

            $remaining = $result[0] - $toGet3;
    
            // subtract the birds in birds_t
            $sql2 = "UPDATE birds_t SET quantity = quantity - {$toGet3} WHERE batch_id = {$result[1]}";  
            $query = mysqli_query($conn, $sql2);
    
            // subtract the birds in supply_t
            $sql = "UPDATE supply_t SET quantity = {$remaining} WHERE supply_id = {$_POST['item3']}";  
            $query = mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO sales_t (invoice_id, invoice_date, customer_id , payment_date, type, item, item_sold, total) VALUES ('$invNum', '$invDate', '$customer_id', '$paymentDue', 'Bird', '$item3', '$toGet3', '$total')";  
            $query = mysqli_query($conn, $sql);
            
            $_SESSION["items"] = $_SESSION["items"] . "<tr><td>$item3</td><td>Bird</td><td>$toGet3</td><td>$pricePerChicken</td></tr>";
    
            // insert activity to activity_t
            $activity = "Add new bird sales values = ({$invNum}, {$invDate}, {$customer_id}, {$paymentDue}, Bird, {$item3}, {$toGet3}, {$total})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            
            echo "<div class='alert alert-success' role='alert'>Item 3 successfully added.</div>";
          }
      }

      if(isset($_POST["item4"])){
        $item4 = $_POST["item4"];
        $toGet4 = $_POST["toGet4"];

        $sql = "SELECT good_condition, total FROM egg_reading_t WHERE reading_id = {$_POST['item4']}";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        
        if($result[0] < $toGet4){
          echo "<div class='alert alert-danger' role='alert'>Item 4 has insufficient quantity.</div>";
        }
        else{
            $remainingGood = $result[0] - $toGet4;
            $remainingTotal = $result[1] - $toGet4;
    
            $sql = "UPDATE egg_reading_t SET good_condition = {$remainingGood}, total = {$remainingTotal} WHERE reading_id = {$_POST['item4']}";  
            $query = mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO sales_t (invoice_id, invoice_date, customer_id , payment_date, type, item, item_sold, total) VALUES ('$invNum', '$invDate', '$customer_id', '$paymentDue', 'Egg', '$item4', '$toGet4', '$total')";  
            $query = mysqli_query($conn, $sql);
            
            $_SESSION["items"] = $_SESSION["items"] . "<tr><td>$item4</td><td>Egg</td><td>$toGet4</td><td>$pricePerEgg</td></tr>";
    
            // insert activity to activity_t
            $activity = "Add new egg sales values = ({$invNum}, {$invDate}, {$customer_id}, {$paymentDue}, Egg, {$item4}, {$toGet4}, {$total})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            
            echo "<div class='alert alert-success' role='alert'>Item 4 successfully added.</div>";
          }
      }

      if(isset($_POST["item5"])){
        $item5 = $_POST["item5"];
        $toGet5 = $_POST["toGet5"];
        
        $sql = "SELECT good_condition, total FROM egg_reading_t WHERE reading_id = {$_POST['item5']}";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        
        if($result[0] < $toGet5){
          echo "<div class='alert alert-danger' role='alert'>Item 5 has insufficient quantity.</div>";
        }
        else{
            $remainingGood = $result[0] - $toGet5;
            $remainingTotal = $result[1] - $toGet5;
    
            $sql = "UPDATE egg_reading_t SET good_condition = {$remainingGood}, total = {$remainingTotal} WHERE reading_id = {$_POST['item5']}";  
            $query = mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO sales_t (invoice_id, invoice_date, customer_id , payment_date, type, item, item_sold, total) VALUES ('$invNum', '$invDate', '$customer_id', '$paymentDue', 'Egg', '$item5', '$toGet5', '$total')";  
            $query = mysqli_query($conn, $sql);
            
            $_SESSION["items"] = $_SESSION["items"] . "<tr><td>$item5</td><td>Egg</td><td>$toGet5</td><td>$pricePerEgg</td></tr>";
    
            // insert activity to activity_t
            $activity = "Add new egg sales values = ({$invNum}, {$invDate}, {$customer_id}, {$paymentDue}, Egg, {$item5}, {$toGet5}, {$total})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            
            echo "<div class='alert alert-success' role='alert'>Item 5 successfully added.</div>";
          }
      }

      if(isset($_POST["item6"])){
        $item6 = $_POST["item6"];
        $toGet6 = $_POST["toGet6"];
        
        $sql = "SELECT good_condition, total FROM egg_reading_t WHERE reading_id = {$_POST['item6']}";  
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        
        if($result[0] < $toGet6){
          echo "<div class='alert alert-danger' role='alert'>Item 6 has insufficient quantity.</div>";
        }
        else{
            $remainingGood = $result[0] - $toGet6;
            $remainingTotal = $result[1] - $toGet6;
    
            $sql = "UPDATE egg_reading_t SET good_condition = {$remainingGood}, total = {$remainingTotal} WHERE reading_id = {$_POST['item6']}";  
            $query = mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO sales_t (invoice_id, invoice_date, customer_id , payment_date, type, item, item_sold, total) VALUES ('$invNum', '$invDate', '$customer_id', '$paymentDue', 'Egg', '$item6', '$toGet6', '$total')";  
            $query = mysqli_query($conn, $sql);
            
            $_SESSION["items"] = $_SESSION["items"] . "<tr><td>$item6</td><td>Egg</td><td>$toGet6</td><td>$pricePerEgg</td></tr>";
    
            // insert activity to activity_t
            $activity = "Add new egg sales values = ({$invNum}, {$invDate}, {$customer_id}, {$paymentDue}, Egg, {$item6}, {$toGet6}, {$total})";
            $id = $_SESSION["id_s"];
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            
            echo "<div class='alert alert-success' role='alert'>Item 6 successfully added.</div>";
          }
          
      }
      
      echo "<script type='text/javascript'>window.open('generate-receipt.php', '_blank');</script>";


    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Transaction</title>

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
        <a class="nav-link font-weight-bold">SALES</a>
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
            <li class='nav-item active-item'>
              <a href='add-transaction.php' class='nav-link active'>
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
              <li class='nav-item active-item'>
                <a href='add-transaction.php' class='nav-link active'>
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
            <h1 class="m-0">Add Transaction</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Transaction</li>
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
              <h3 class="card-title">Add Invoice</h3>
            </div>
            <div class="card-body">
              <form class="row rounded" action="add-transaction.php" method="post">
                  <div class="col-md-6">
                      <input type="hidden" name="id">
                      <div class="mb-3">
                          <label for="invNum" class="form-label">Invoice No.</label>
                          <input type="number" name="invNum" class="form-control">

                      </div>
                      <div class="mb-3">
                          <label for="billTo" class="form-label">Bill To</label>
                          <input type="text" name="billTo" class="form-control">
                      </div>
                      <div class="mb-3">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" name="address" class="form-control">
                      </div>
                      <br>

                      <div class="mb-3">
                          <label for="" class="form-label">Item</label>
                          <br>
                          <select name="item1" class="form-select" style="height: 2.5em; padding: 5px">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php
                                $sql = "SELECT * FROM supply_t";  
                                $query = mysqli_query($conn, $sql);

                                while($result = mysqli_fetch_array($query)){
                                    echo "<option value='{$result['supply_id']}'>ID: {$result['supply_id']} - {$result['quantity']} {$result['bird_breed']} (PhP {$result['price']})</option>";
                                }
                            ?>
                          </select>
                          
                      </div>
                      <br>

                      <div class="mb-3">
                          <select name="item2" class="form-select" style="height: 2.5em; padding: 5px">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php
                                $sql = "SELECT * FROM supply_t";  
                                $query = mysqli_query($conn, $sql);

                                while($result = mysqli_fetch_array($query)){
                                    echo "<option value='{$result['supply_id']}'>ID: {$result['supply_id']} - {$result['quantity']} {$result['bird_breed']} (PhP {$result['price']})</option>";
                                }
                            ?>
                          </select>
                      </div>
                      <br>

                      <div class="mb-3">
                          <select name="item3" class="form-select" style="height: 2.5em; padding: 5px">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php
                                $sql = "SELECT * FROM supply_t";  
                                $query = mysqli_query($conn, $sql);

                                while($result = mysqli_fetch_array($query)){
                                    echo "<option value='{$result['supply_id']}'>ID: {$result['supply_id']} - {$result['quantity']} {$result['bird_breed']} (PhP {$result['price']})</option>";
                                }
                            ?>
                          </select>
                      </div>

                      <br>

                      <div class="mb-3">
                          <label for="pricePerChicken" class="form-label">Price Per Chicken</label>
                          <input type="number" name="pricePerChicken" id="pricePerChicken"  class="form-control" min=1>
                      </div>



                      <div class="mb-3">
                          <label for="" class="form-label">Item</label>
                          <br>
                          <select name="item4" class="form-select" style="height: 2.5em; padding: 5px">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php
                                $sql = "SELECT * FROM egg_reading_t";  
                                $query = mysqli_query($conn, $sql);

                                while($result = mysqli_fetch_array($query)){
                                    $date = substr($result['expiration_date'], 0, 10);
                                    echo "<option value='{$result['reading_id']}'>ID: {$result['reading_id']} -- Exp. Date: {$date} -- Total: {$result['good_condition']}</option>";
                                }
                            ?>
                          </select>
                          
                      </div>
                      <br>

                      <div class="mb-3">
                          <select name="item5" class="form-select" style="height: 2.5em; padding: 5px">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php
                                $sql = "SELECT * FROM egg_reading_t";  
                                $query = mysqli_query($conn, $sql);

                                while($result = mysqli_fetch_array($query)){
                                    $date = substr($result['expiration_date'], 0, 10);
                                    echo "<option value='{$result['reading_id']}'>ID: {$result['reading_id']} -- Exp. Date: {$date} -- Total: {$result['good_condition']}</option>";
                                }
                            ?>
                          </select>
                      </div>
                      <br>

                      <div class="mb-3">
                          <select name="item6" class="form-select" style="height: 2.5em; padding: 5px">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php
                                $sql = "SELECT * FROM egg_reading_t";  
                                $query = mysqli_query($conn, $sql);

                                while($result = mysqli_fetch_array($query)){
                                    $date = substr($result['expiration_date'], 0, 10);
                                    echo "<option value='{$result['reading_id']}'>ID: {$result['reading_id']} -- Exp. Date: {$date} -- Total: {$result['good_condition']}</option>";
                                }
                            ?>
                          </select>
                      </div>

                      <br>

                      <div class="mb-3">
                          <label for="pricePerEgg" class="form-label">Price Per Egg</label>
                          <input type="number" name="pricePerEgg" id="pricePerEgg"  class="form-control" min=1>
                      </div>

                      
                  </div>
                  

                      
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="invDate" class="form-label">Invoice Date</label>
                          <input type="date" name="invDate" class="form-control">
                      </div>
                      <div class="mb-3">
                          <label for="paymentDue" class="form-label">Payment Due</label>
                          <input type="date" name="paymentDue" class="form-control">
                      </div>
                      <div class="mb-3">
                          <label for="contact" class="form-label">Contact</label>
                          <input type="text" name="contact" class="form-control">
                      </div>

                      <br>

                      <div class="mb-3">
                          <label for="toGet1" class="form-label"># of Chicken To Get</label>
                          <input type="number" name="toGet1" id="toGet1" class="form-control" min=1>
                          <small class="text-muted">Quantity must be equal or less than total of items</small>
                      </div>

                       <div class="mb-3">
                          <input type="number" name="toGet2" id="toGet2" class="form-control" min=1>
                          <small class="text-muted">Quantity must be equal or less than total of items</small>
                      </div>

                       <div class="mb-3">
                          <input type="number" name="toGet3" id="toGet3" class="form-control" min=1>
                          <small class="text-muted">Quantity must be equal or less than total of items</small>
                      </div>

                      <br>
                      <br>
                      <br>
                      <br>

                      <div class="mb-3">
                          <label for="toGet1" class="form-label"># of Eggs To Get</label>
                          <input type="number" name="toGet4" id="toGet4" class="form-control" min=1>
                          <small class="text-muted">Quantity must be equal or less than total of items</small>
                      </div>

                       <div class="mb-3">
                          <input type="number" name="toGet5" id="toGet5" class="form-control" min=1>
                          <small class="text-muted">Quantity must be equal or less than total of items</small>
                      </div>

                       <div class="mb-3">
                          <input type="number" name="toGet6" id="toGet6" class="form-control" min=1>
                          <small class="text-muted">Quantity must be equal or less than total of items</small>
                      </div>

                      <br>
                      <br>

                      <div>
                        <h2 class="card-title" id="total"></h2>
                        <input type="number" id="total2" name="total2" hidden>
                    </div>
                      
                      <div class="d-flex justify-content-end">
                          <div class='btn-group' role='group' aria-label='action'>
                                <button type="reset" class='btn btn-light'> Clear </button>
                                <button type='submit' class='btn btn-warning' name='addBtn' onclick='return confirm(`Are you sure you want to add this record?`);'>Add</button>
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

<script> // SCRIPT FOR TOTAL # EGGS
    var pricePerEgg = document.getElementById("pricePerEgg");
    var pricePerChicken = document.getElementById("pricePerChicken");
    var toGet1 = document.getElementById("toGet1");
    var toGet2 = document.getElementById("toGet2");
    var toGet3 = document.getElementById("toGet3");
    var toGet4 = document.getElementById("toGet4");
    var toGet5 = document.getElementById("toGet5");
    var toGet6 = document.getElementById("toGet6");
    var total = document.getElementById("total");
    var total2 = document.getElementById("total2");

    pricePerEgg.addEventListener("input", multiply);
    pricePerChicken.addEventListener("input", multiply);
    toGet1.addEventListener("input", multiply);
    toGet2.addEventListener("input", multiply);
    toGet3.addEventListener("input", multiply);
    toGet4.addEventListener("input", multiply);
    toGet5.addEventListener("input", multiply);
    toGet6.addEventListener("input", multiply);

    function multiply() {
        var pricePerEgg2 = parseFloat(pricePerEgg.value) || 0;
        var pricePerChicken2 = parseFloat(pricePerChicken.value) || 0;
        var toGet11 = parseFloat(toGet1.value) || 0;
        var toGet22 = parseFloat(toGet2.value) || 0;
        var toGet33 = parseFloat(toGet3.value) || 0;
        var toGet44 = parseFloat(toGet4.value) || 0;
        var toGet55 = parseFloat(toGet5.value) || 0;
        var toGet66 = parseFloat(toGet6.value) || 0;

        var totalPrice = (pricePerChicken2 * (toGet11 + toGet22 + toGet33)) + (pricePerEgg2 * (toGet44 + toGet55 + toGet66));

        total.innerHTML = "Total: " + Math.round(totalPrice * 100) / 100 + " PhP";
        total2.value = Math.round(totalPrice * 100) / 100;
    }
</script>

</body>
</html>

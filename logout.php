<?php
    include("connection.php");
    session_start();

    $id = $_SESSION["id_s"];

    // add logout activity to activity table
    date_default_timezone_set("Asia/Manila");
    $datetime = date("Y-m-d H:i:s");
    $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', 'Logout', '$datetime')";  
    $query = mysqli_query($conn, $sql);

    // destroy all session variables
    unset($_SESSION["id_s"]);
    unset($_SESSION["username_s"]);
    unset($_SESSION["fname_s"]);
    unset($_SESSION["lname_s"]);
    unset($_SESSION["type_s"]);
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
?>
<?php
    // connect to database and start session
    include("connection.php");
    session_start();

    // restarts session variables
    unset($_SESSION["username_s"]);
    unset($_SESSION["fname_s"]);
    unset($_SESSION["lname_s"]);

    // validate data and prevent sql injection
    function validate($data, $conn){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = mysqli_real_escape_string($conn, $data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST["username"]) && isset($_POST["password"])){

        if(empty($_POST["username"]) || empty($_POST["password"])){
            echo "<div class='alert alert-danger' role='alert'>Both Username and Password are required.</div>";
        }
        else{
            $username_v = validate($_POST["username"], $conn);
            $password_v = validate($_POST["password"], $conn);

            $sql = "SELECT * FROM account_t WHERE (username = '$username_v') AND (accpass = '$password_v')";  
            $result = mysqli_query($conn, $sql);
            $row_data = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);

            // if input data is found in db
            if($count == 1){

                // sets session variables (from login table)
                $_SESSION["username_s"] = $row_data["username"];
                $_SESSION["id_s"] = $row_data["emp_id"];
                $_SESSION["type_s"] = $row_data["account_type"];

                $id = $row_data["emp_id"];

                $sql = "SELECT * FROM employee_t where emp_id = '$id'";  
                $result = mysqli_query($conn, $sql);
                $row_data = mysqli_fetch_assoc($result);

                // sets session variables (from user table)
                $_SESSION["fname_s"] = $row_data["first_name"];
                $_SESSION["lname_s"] = $row_data["last_name"];

                // add login activity to activity table
                date_default_timezone_set("Asia/Manila");
                $datetime = date("Y-m-d H:i:s");
                $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', 'Login', '$datetime')";  
                $query = mysqli_query($conn, $sql);

                header("Location: home.php"); 
                exit;
            }
            else{
                echo "<div class='alert alert-danger' role='alert'>Login Failed. Account does not exist.</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/style.css">        
        <title>Login</title>
        <style>
            body {
                background-image: url(./dist/img/bg-login.jpg);
                max-width: 100%;
                max-width: 100vw;
                overflow-x: hidden;
            }

            

            .brand-logo {
                font-size: 3rem;
                color: #d4ae01;
            }

            .right-login {
                min-height: 100%;
                min-height: 100vh;

                display: flex;
                align-items: center;
                justify-content: center;

                background-color: #0F242C99;
            }
            .left-login {
                min-height: 100%;
                min-height: 80vh;  /* need mag-equal to 100 to saka yung margin-top */

                padding: 0 5rem;

                display: flex;

                flex-direction: column;
                margin-top: 20vh;
            } 

            .left-login > div {
                margin-left: 2rem;
            }

            #hidden {
                display: none;
            }
            
            footer > div {
                background-color: #2b2b2b !important;
                color: #fff;
            }

            @media only screen and (max-width: 1026px) {
                #hidden {
                    display: block;
                    
                }
                #hidden a {
                    text-decoration: none;
                }

                .left-login {
                    padding: 0 1rem;
                }
            }
        </style>
    </head>
    
    <body>
        <div class="d-md-flex h-md-100">
            <div class="row"  id="login" >
                <div class="col-lg-7 h-md-100 text-light left-login">
                    <div class="brand-logo">
                        <img src="dist/img/logo-xs.svg" width="75" alt="">
                    </div>
                    <div class="mb-4">
                        <h1 style="color: #d4ae01">Welcome!</h1>
                    </div>
                    <div>
                        <p class="lead"><strong  style="color: #d4ae01">Poultry Farm Management System</strong> provides a business goals-oriented solution to automate and digitalize poultry farm activities equipped with report generation, user control, resource management, and sales projection modules.</p>
                    </div>
                    <div id="hidden">
                        <a href="#form" >Login ></a>
                    </div>
                </div>
                <div class="col-lg-5 h-md-100 right-login text-light" id="form">
                    <form class="mx-5 card p-5 rounded bg-custom1" action="login.php" method="post">
                        <div class="mb-4">
                            <h1>Login</h1>
                        </div>
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username here">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="******">
                        </div>
                        <div class="mb-4">
                            Don't have an account? <a href="signup.php" class="link-primary">Click here to sign up.</a>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-link">Clear</button>
                            <button type="submit" class="btn btn-warning">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer p-1 text-center">
                <small>For account concerns, kindly contact your administrator. | Copyright &copy; 2022. All rights reserved.</small>
            </div>
        </footer>
        
        <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
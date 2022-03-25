<?php
    include("connection.php");
    session_start();

    $username = $_SESSION['username_s'];

    $sql = "SELECT otp FROM otp_t WHERE username = '$username'";  
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    if(isset($_POST["digit-1"]) && isset($_POST["digit-2"]) && isset($_POST["digit-3"]) && isset($_POST["digit-4"]) && isset($_POST["digit-5"]) && isset($_POST["digit-6"])){
        $enteredOTP =  $_POST["digit-1"].$_POST["digit-2"].$_POST["digit-3"].$_POST["digit-4"].$_POST["digit-5"].$_POST["digit-6"];

        if($result[0] == $enteredOTP){

            $fname_v = $_SESSION["fname_s"];
            $lname_v = $_SESSION["lname_s"];
            $radioSex_v = $_SESSION["sex_s"];
            $birthdate_v = $_SESSION["birthdate_s"];
            $username_v = $_SESSION["username_s"];
            $password_v = $_SESSION["password_s"];
            $contact_v = $_SESSION["contact_s"];
            $address_v = $_SESSION["address_s"];
            $position_v = $_SESSION["position_s"];

            // insert into employee_t
            $sql = "INSERT INTO employee_t(first_name, last_name, position_code, sex, birthdate, contact_no, address) VALUES('$fname_v', '$lname_v', '$position_v', '$radioSex_v', '$birthdate_v', '$contact_v', '$address_v')";  
            $result = mysqli_query($conn, $sql);

            // insert into account_t
            $sql = "INSERT INTO account_t(username, accpass, account_type) VALUES('$username_v', '$password_v', 'Employee')";  
            $result = mysqli_query($conn, $sql);

            // insert activity to activity_t
            $activity = "Add new user values = ({$fname_v}, {$lname_v}, {$position_v}, {$radioSex_v}, {$birthdate_v}, {$contact_v}, {$address_v}, {$username_v}, {$password_v})";
            $id = 0;  // 0 - added thru signup
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO activity_t(emp_id, activity, act_datetime) VALUES ('$id', '$activity', '$datetime')";  
            $result = mysqli_query($conn, $sql);
            // echo "<div class='alert alert-success' role='alert'>Record successfully added.</div>";

            session_unset();
            session_destroy();

            header("Location: login.php"); 
            exit;
        }
        else {
            echo "<div class='alert alert-danger' role='alert'>Incorrect OTP.</div>";
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
    <title>Verify Account</title>
    <style>
        body {
            background-image: url(./dist/img/bg-login.jpg);
            max-width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }

        input {
            width: 2em;
            height: 2em;
            background-color: lighten($BaseBG, 5%);
            line-height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: 500;
            margin: 0 2px;
        }

        h1, p {
            color: #ddd;
        }

        .card {
            margin-top: 5rem;
        }

        footer {
            position:fixed;
            bottom:0;
            width:100%;

        }

        footer > div {
            background-color: #2b2b2b !important;
            color: #fff;
        }
    
    </style>

</head>
<body>
    <div class="container ">
        <div class="card bg-custom1 py-5">
            <div class="col text-center mb-4">
                <div class="mb-4">
                    <h1  style="color: #d4ae01">Verify Account</h1>
                </div>
                <p>We have sent a one-time password (OTP) to <span style="color: #00A663"><?php echo $_SESSION['email_s'] ?></span>.<br> If you cannot find the email, kindly check your spam folder.</p>
                <br>
                <p>Enter the OTP below to verify your account.</p>
            </div>
            <div class="col text-center">
            
                <form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off" action="verify-account.php">
                    <div class="col mb-4">
                        <input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
                        <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                        <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                        <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                        <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
                        <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" />
                    </div>
                    <div class="col">
                        <a href="email.php" class="btn btn-link">Re-send OTP</a>
                        <button type="submit" class="btn btn-warning">Verify</button>
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
    

    <script src="plugins/jquery/jquery.min.js"></script>
    <script>
        $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());
            
            if(e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));
                
                if(prev.length) {
                    $(prev).select();
                }
            }else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));
                
                if(next.length) {
                    $(next).select();
                }else {
                    if(parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
        });
    </script>

</body>
</html>
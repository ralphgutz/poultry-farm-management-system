<?php
    include("connection.php");
    require("PHPMailer/src/PHPMailer.php");
    require("PHPMailer/src/SMTP.php");
    session_start();

    function validate($data, $conn){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = mysqli_real_escape_string($conn, $data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["radioSex"]) && isset($_POST["birthdate"]) && 
       isset($_POST["username"]) && isset($_POST["password"])){


        if(strcmp($_POST["password"], $_POST["passwordConfirm"]) != 0){
            echo "<div class='alert alert-danger' role='alert'>Passwords do not match.</div>";
        }
        elseif(strlen($_POST["password"]) < 6){
            echo "<div class='alert alert-danger' role='alert'>Password must be 6+ characters long.</div>";
        }
        else{
            $fname_v = validate($_POST["fname"], $conn);
            $lname_v = validate($_POST["lname"], $conn);
            $radioSex_v = validate($_POST["radioSex"], $conn);
            $birthdate_v = validate($_POST["birthdate"], $conn);
            $username_v = validate($_POST["username"], $conn);
            $password_v = validate($_POST["password"], $conn);
            $contact_v = validate($_POST["contact"], $conn);
            $address_v = validate($_POST["address"], $conn);
            $position_v = validate($_POST["position"], $conn);

            $sql = "SELECT username FROM account_t WHERE username = '$username_v'";  
            $result = mysqli_query($conn, $sql);
            
            $sql2 = "SELECT username FROM otp_t WHERE username = '$username_v'";  
            $result2 = mysqli_query($conn, $sql2);

            if(mysqli_num_rows($result) > 0){
                echo "<div class='alert alert-danger' role='alert'>Record failed to add. Username already exists.</div>";
            }
            else{
                if(mysqli_num_rows($result2) > 0){
                    echo "<div class='alert alert-danger' role='alert'>Record failed to add. Username already exists.</div>";
                }
                else{
                    $_SESSION["fname_s"] = $fname_v;
                    $_SESSION["lname_s"] = $lname_v;
                    $_SESSION["username_s"] = $username_v;
                    $_SESSION["password_s"] = $password_v;
                    $_SESSION["sex_s"] = $radioSex_v;
                    $_SESSION["birthdate_s"] = $birthdate_v;
                    $_SESSION["contact_s"] = $contact_v;
                    $_SESSION["address_s"] = $address_v;
                    $_SESSION["position_s"] = $position_v;
                    $_SESSION["email_s"] = $_POST['email'];
                    $mailTo = $_SESSION['email_s'];
    
                    $_SESSION["otp_s"] = rand(100000,999999);
                    $otp = $_SESSION['otp_s'];
    
                    $sql = "INSERT INTO otp_t VALUES('$username_v', '$mailTo', '$otp')";  
                    $query = mysqli_query($conn, $sql);
    
                    header("Location: email.php"); 
                    exit;
    
                    /*
                    // insert into login table
                    $sql = "insert into login(username, password) values('$username_v', '$password_v')";  
                    $result = mysqli_query($conn, $sql);
                    echo "<div class='alert alert-success' role='alert'>Record successfully added to Login table.</div>";
    
                    // insert into user table
                    $sql = "insert into user(fname, lname, sex, birthdate) values('$fname_v', '$lname_v', '$radioSex_v', '$birthdate_v')";  
                    $result = mysqli_query($conn, $sql);
                    echo "<div class='alert alert-success' role='alert'>Record successfully added to User table.</div>";
                    */
                }
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
        <title>Signup</title>
        <style>
            body {
                background-image: url(./dist/img/bg-login.jpg);
                max-width: 100%;
                max-width: 100vw;
                overflow-x: hidden;
            }

            select, input[type=date] {
                padding: 5px 14px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .card {
                margin-top: 3rem;
            }

            label, h1 {
                color: #ddd;
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

            @media only screen and (max-width: 800px) {
                .container {
                    margin-top: 5rem;
                    display: block;
                }
                form {
                    margin: 0 0 3em 0 !important;
                }

            }
        </style>
    </head>
    
    <body>
        <div class="d-md-flex h-md-100">
            <div class="container h-md-100" id="form">
                <form class="card p-5 rounded bg-custom1 text-light" action="signup.php" method="post">
                    <div class="mb-4">
                        <h1 style="color: #d4ae01">Signup</h1>
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" name="fname" class="form-control" placeholder="Ex. Jose" required>
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" name="lname" class="form-control" placeholder="Ex. Dela Cruz" required>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="mb-2">Gender</label><br>
                                <input type="radio" class="form-check-input" name="radioSex" id="male" value="male" required>
                                <label for="male" class="form-check-label me-2">Male</label>
                                <input type="radio" class="form-check-input" name="radioSex" id="female" value="female" required>
                                <label for="female" class="form-check-label">Female</label>
                            </div>
                            <div class="col mb-3">
                                <label for="birthdate" class="mb-2">Birthdate</label><br>
                                <input type="date" name="birthdate" placeholder="Select date" required>
                            </div>
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
                      <div class="mb-3">
                          <label for="contact" class="form-label">Contact Number</label>
                          <input type="number" name="contact" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" name="address" class="form-control" required>
                      </div>

                        </div>
                        <div class="col">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username here" required>
                            <small class="form-text text-muted">NOTE: Username must be unique. This cannot be edited later on.</small>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                            <small class="form-text text-muted">NOTE: Must be 6+ characters long.</small>
                        </div>
                        <div class="mb-3">
                            <label for="passwordConfirm" class="form-label">Confirm Password</label>
                            <input type="password" name="passwordConfirm" class="form-control" placeholder="******" required>
                        </div>
                        <hr>
                        <p>Please enter an active email address to confirm your sign up process.</p>
                        <div class="mb-3">
                            
                            <input type="email" name="email" class="form-control" placeholder="me@email.com" required>
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" class="form-check-input" id="checkTerms" required> 
                            <label for="checkTerms" class="form-check-label">I agree to the <a href="terms-and-conditions.php">terms and conditions</a> and <a href="privacy-policy.php">privacy policy</a>.</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class='btn-group' role='group' aria-label='action'>
                                <button type="reset" class='btn btn-light'> Clear </button>
                                <button type='submit' class='btn btn-warning' onclick='return confirm(`Are you sure you want to add this record?`);'>Add</button>
                        </div>
                        </div>
                        </div>
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

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
</html>
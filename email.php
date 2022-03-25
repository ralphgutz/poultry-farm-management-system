<?php
    include("connection.php");
    require("PHPMailer/src/PHPMailer.php");
    require("PHPMailer/src/SMTP.php");
    session_start();

    $otp = $_SESSION['otp_s'];
    $mailTo = $_SESSION['email_s'];

    $body = "<p>Good day, ".$_SESSION['fname_s'].",<br><br>Your one-time password (OTP) is <strong>".$otp."</strong>. Use this code to verify your account information to complete the sign-up process.<br><br>Thank you for joining Poultry Farm Management.<br><br><strong>IMPORTANT: Do not share your OTP to anyone!</strong><br><br><i>This is an auto-generated email. If you did not sign-up for a PFMS account, or believe that you received this in error, please ignore this email.</i><br><br>Regards,<br>PFMS</p>";
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->SMTPDebug = false;

    $mail->isSMTP();
    $mail->Host = "mail.smtp2go.com";
    $mail->SMTPAuth = true;
    $mail->Username = "poultryfarm";
    $mail->Password = "poultryfarm";
    $mail->SMTPSecure = "tls";
    $mail->Port = "2525";
    $mail->From = "ralphgutz17@gmail.com";
    $mail->FromName = "Red Hen Poultry Farm";

    $mail->addAddress($mailTo, "New User");

    $mail->isHTML(true);
    $mail->Subject = "[OTP] Verify Account - PFMS";
    $mail->Body = $body;

    if(!$mail->send()){
        echo "Mailer Error:" .$mail->ErrorInfo;
    }
    else{
        header("Location: verify-account.php"); 
        exit;
    }


?>
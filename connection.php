<?php
    $server = "localhost";
    $user = "id18514383_root";
    $password = "JItPuFPJlvc9r(=n";
    $db = "id18514383_pfms_db";

    $conn = mysqli_connect($server, $user, $password, $db);
    //$conn = new mysqli($server, $user, $pass, $db);

    if(!$conn){
        die("ERROR: Connection failed. " . mysqli_connect_error());
    }
?>
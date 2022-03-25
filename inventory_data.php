<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: https://redhenpfms.000webhostapp.com');

    
    $mysqli = new mysqli("localhost", "id18514383_root", "JItPuFPJlvc9r(=n", "id18514383_pfms_db");

    $query = sprintf("SELECT collection_date, good_condition, cracked FROM egg_reading_t");

    //execute query
    $result = $mysqli->query($query);

    //loop through the returned data
    $data = array();
    foreach ($result as $row) {
      $data[] = $row;
    }

    //free memory associated with result
    $result->close();

    //close connection
    $mysqli->close();

    //now print the data
    print json_encode($data);

?>
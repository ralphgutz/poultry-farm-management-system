<?php
include("connection.php");

$table = $_GET["generate"];
$title = "";

switch($table){
  case "sales_t":
    $title = "Sales";
    break;
  case "customer_t":
    $title = "Customers";
    break;
  case "employee_t":
    $title = "Employee";
    break;
  case "activity_t":
    $title = "User Activity";
    break;
  case "birds_t":
    $title = "Birds";
    break;
  case "egg_reading_t":
    $title = "Egg Readings";
    break;
  case "supply_t":
    $title = "Supplies (Birds)";
    break;
  case "resources_t":
    $title = "Resources";
    break;
  case "consumption_t":
    $title = "Consumption";
    break;
}

date_default_timezone_set("Asia/Manila");
$datetime = date("Y-m-d H:i:s");


function fetch_data(){  
  include("connection.php");
  $table = $_GET["generate"];
  $output = '';  
  $sql = "SELECT * FROM $table";
  $query = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($query);
  $col_count = count($result)/2;
  $query = mysqli_query($conn, $sql);
  

  while($row = mysqli_fetch_assoc($query)){
      foreach($row as $key => $value){
      if($col_count == 0){
          break;
      }
      $output .= "<th><strong>".$key."</strong></th>";
      $col_count--;
      }
  }
  $output .= "</tr></thead>";

  $query = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($query)){                   
    $output .= "<tr>";
    
    foreach($row as $key => $value){
      $output .= "<td>$value</td>";
    }
    $output .= "</tr>";
  }

  $query = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($query);
  

  return array($output, $num);  
}  


list($output, $num) = fetch_data();
$output = "<table><thead><tr>".$output."</table>";

$filename = "$title Report.xls";

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename = $filename");
echo $output;

?>
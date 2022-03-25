<?php
include("connection.php");
session_start();
require_once('TCPDF/tcpdf.php');
ob_start();

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


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RedHen Poultry Farm Enterprise');
$pdf->SetTitle($title.' Report');
$pdf->SetSubject($title.' report generated on '.$datetime.'.');

// set header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "REDHEN POULTRY FARM ENTERPRISE", "Elliptical Road, Diliman, Quezon City,
Philippines, 1107\nconcerns@redhenent.com");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------
$pdf->setHeaderFont(array('helvetica', '', 11));

// set font
$pdf->SetFont('helvetica', 'B', 14);

// add a page
$pdf->AddPage();
$pdf->Write(0, "\n".strtoupper($title)." REPORT\n\n", '', 0, 'C', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 11);
$pdf->Write(0, "No. of records: $num\n\n", '', 0, 'L', true, 0, false, false, 0);

// -----------------------------------------------------------------------------


$output = "<table><thead><tr>".$output."</table>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->Write(0, "\n\nReport generated on $datetime", '', 0, 'L', true, 0, false, false, 0);

ob_end_clean();

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');
?>
<?php
include("connection.php");
session_start();
require_once('TCPDF/tcpdf.php');
ob_start();


date_default_timezone_set("Asia/Manila");
$datetime = date("Y-m-d H:i:s");


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RedHen Poultry Farm Enterprise');
$pdf->SetTitle('Invoice '.$datetime);
$pdf->SetSubject('Invoice generated on '.$datetime.'.');

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
$pdf->Write(0, "\nINVOICE\n\n", '', 0, 'C', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 11);
//$pdf->Write(0, "No. of items: $num\n\n", '', 0, 'L', true, 0, false, false, 0);

$pdf->Write(0, "Bill to: {$_SESSION['billTo']}\n", '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, "Address: {$_SESSION['address']}\n", '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, "Contact: {$_SESSION['contact']}\n", '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, "Invoice Date: {$_SESSION['invDate']}\n", '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, "Payment Due: {$_SESSION['paymentDue']}\n", '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, "Invoice generated on $datetime\n", '', 0, 'L', true, 0, false, false, 0);

// -----------------------------------------------------------------------------


$pdf->SetFont('helvetica', 'B', 11);
$pdf->writeHTML("<br><br><br><table><tr><th>Item</th><th>Type</th><th>Quantity</th><th>Unit Price</th></tr></table>", true, false, false, false, '');

$pdf->SetFont('helvetica', '', 11);


$output = "<table>".$_SESSION["items"]."</table>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetFont('helvetica', 'B', 11);
$pdf->writeHTML("<br><br>Total: PhP ".$_SESSION["total"], true, false, false, false, '');
$pdf->SetFont('helvetica', '', 11);


ob_end_clean();

//Close and output PDF document
$pdf->Output('Invoice '.$datetime.'.pdf', 'I');
?>
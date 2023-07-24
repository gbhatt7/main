<?php
include('connection.php');
require 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

if ($connection->connect_error) {
    die("Connection failed: " );
}

//read all row from database table
$id = $_GET['id'];
$sql = "SELECT * FROM employee WHERE id=$id";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " );
}
$row = $result->fetch_assoc();

// instantiate and use the dompdf class
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

ob_start();
require('detailsemployee.php');
$html = ob_get_contents();
ob_get_clean();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('printemployee.php', ['Attachment' => false]);

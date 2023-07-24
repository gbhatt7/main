<?php
require('connection.php');
$id = $_GET['id'];
//read all row from database table
$sql = "SELECT e.emid, e.name, e.email, e.cadre, e.post, e.phone, e.gender, e.postin, e.postout, e.address, e.dob
FROM `employee` e
INNER JOIN `employee_event` ee ON e.emid = ee.employee_id
INNER JOIN `event` emp ON ee.event_id = emp.id
WHERE emp.id = $id";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: ");
}

$html = '<table><tr><td>Employee ID</td><td>Name</td><td>Email</td><td>Gender</td><td>Cadre</td><td>Post</td><td>Post in</td><td>Post out</td><td>Date of Birth</td><td>Phone Number</td><td>Address</td></tr>';

// Read data of each row
while ($row = $result->fetch_assoc()) {
    // Create an array to store event names
    
    $html.='<tr>
    <td>'.$row['emid'].'</td>
    <td>'.$row['name'].'</td>
    <td>'.$row['email'].'</td>
    <td>'.$row['gender'].'</td>
    <td>'.$row['cadre'].'</td>
    <td>'.$row['post'].'</td>
    <td>'.$row['postin'].'</td>
    <td>'.$row['postout'].'</td>
    <td>'.$row['dob'].'</td>
    <td>'.$row['phone'].'</td>
    <td>'.$row['address'].'</td>';
}

$html.='</tr></table>';

$filename = "report_" . $id . ".xls";

header('Content-Type:application/xls');
header("Content-Disposition: attachment; filename=" . $filename);

echo $html;
?>
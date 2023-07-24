<?php
require('connection.php');

require("image.php");

//read all row from database table
$sql = "SELECT * FROM `employee`";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: ");
}

$html = '<table><tr><td>ID</td><td>Employee ID</td><td>Name</td><td>Email</td><td>Gender</td><td>Cadre</td><td>Post</td><td>Post in</td><td>Post out</td><td>Date of Birth</td><td>Phone Number</td><td>Address</td><td>Educational Qualifications</td></tr>';

// Read data of each row
while ($row = $result->fetch_assoc()) {
    $html.='<tr>
    <td>'.$row['id'].'</td>
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
    <td>'.$row['address'].'</td>
    <td>'.$row['education'].'</td>';
}

$html.='</tr></table>';

header('Content-Type:application/xls');
header('Content-Disposition:attachment;filename=report.xls');

echo $html;
?>
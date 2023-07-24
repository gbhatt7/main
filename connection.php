<?php

$connection = mysqli_connect("localhost", "root", "", "maindrdo");

if (mysqli_connect_errno()) {
    die("Cannot connect to database" . mysqli_connect_errno());
}

?>

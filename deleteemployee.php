<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    require("connection.php");
    require("image.php");

    $query = "SELECT * FROM `employee` WHERE `id` = '$_GET[id]'";
    $result = mysqli_query($connection, $query);
    $fetch = mysqli_fetch_assoc($result);
    if (!empty($fetch['image'])) {
        image_remove($fetch['image']);
        $sql = "DELETE FROM employee WHERE id=$id";
        $connection->query($sql);
    } else {
        $sql = "DELETE FROM employee WHERE id=$id";
        $connection->query($sql);
    }
};

header("location: /main/employee.php");
exit;

?>
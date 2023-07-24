<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    require("connection.php");
    require("image.php");

    $sql = "SELECT * FROM `employee` WHERE ";

    $query = "SELECT * FROM `event` WHERE `id` = '$_GET[id]'";
    $result = mysqli_query($connection, $query);
    $fetch = mysqli_fetch_assoc($result);
    if (!empty($fetch['image'])) {
        image_remove($fetch['image']);
        $sql = "DELETE FROM `event` WHERE id=$id";
        $connection->query($sql);
    } else {
        $sql = "DELETE FROM `event` WHERE id=$id";
        $connection->query($sql);
    }
};

header("location: /main/event.php");
exit;

?>
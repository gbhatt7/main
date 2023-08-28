<?php
require("connection.php");

require("image.php");

//create variables
$eid = "";
$ename = "";
$edepartment = "";
$estart = "";
$eend = "";
$estatus = "";
$eplace = "";
$eimage = "";

$errorMessage = "";
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eid=$_POST["eid"];
    $ename = $_POST["ename"];
    $edepartment = $_POST["edepartment"];
    $estart = $_POST["estart"];
    $eend = $_POST["eend"];
    $estatus = $_POST["estatus"];
    $eplace = $_POST["eplace"];
    $imgpath = image_upload($_FILES['eimage']);
    

    do {
        if (empty($eid)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED !";
            break;
        }

        //add new client to database
        $sql = "INSERT INTO `event`(`eid`, `ename`, `edepartment`, `eplace`, `estart`, `eend`, `estatus`, `eimage`)" .
            "VALUES ('$eid','$ename','$edepartment', '$eplace','$estart','$eend','$estatus', '$imgpath')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: ";
            break;
        }

        $eid = "";
        $ename = "";
        $edepartment = "";
        $estart = "";
        $eend = "";
        $estatus = "";
        $eplace = "";
        $eimage = "";

        $successMessage = "ADDED SUCCESSFULLY";

        header("location: /main/event.php");
        exit;
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Add Event</title>
    <style>
        label {
            text-transform: uppercase;
        }
    </style>
</head>

<body class="bg-light">

    <?php
    if (!empty($errorMessage)) {
        echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
    }
    ?>
    <div class="container px-5">
        <form method="post" enctype="multipart/form-data">
            <nav class="navbar sticky-top navbar-light bg-light">
                <div class="text-center py-3">
                    <h2>Add Event</h2>
                </div>
                <div class="offset-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="/main/event.php" role="button">Cancel</a>
                </div>
            </nav>
            <div class="mb-3">
                <label for="eid" class="form-label">Event ID</label>
                <input type="text" class="form-control" id="eid" name="eid" placeholder="Event ID" value="<?php echo $eid; ?>">
            </div>
            <div class="mb-3">
                <label for="ename" class="form-label">event Name</label>
                <input type="text" class="form-control text-capitalize" id="ename" name="ename" placeholder="Event Name" value="<?php echo $ename; ?>">
            </div>
            <div class="mb-3">
                <label for="edepartment" class="form-label">Event Department</label>
                <input type="text" class="form-control" id="edepartment" name="edepartment" placeholder="Event Department" value="<?php echo $edepartment; ?>">
            </div>
            <div class="mb-3">
                <label for="eplace" class="form-label">Event Place</label>
                <input type="text" class="form-control" id="eplace" name="eplace" placeholder="Event Place" value="<?php echo $eplace; ?>">
            </div>
            <div class="mb-3">
                <label for="estart" class="form-label">Event Start Date</label>
                <input type="date" class="form-control" id="estart" name="estart" placeholder="Event Start Date" value="<?php echo $estart; ?>">
            </div>
            <div class="mb-3">
                <label for="eend" class="form-label">Event end Date</label>
                <input type="date" class="form-control" id="eend" name="eend" placeholder="Event End Date" value="<?php echo $eend; ?>">
            </div>
            <div class="mb-3">
                <label for="estatus" class="form-label">Event Status</label>
                <select class="form-select" id="estatus" name="estatus">
                    <option value="" selected disabled class="text-muted">Event Status</option>
                    <option value="Completed" <?php if ($estatus === "Completed") echo "selected"; ?>>Completed</option>
                    <option value="Ongoing" <?php if ($estatus === "Ongoing") echo "selected"; ?>>Ongoing</option>
                    <option value="Not Started" <?php if ($estatus === "Not Started") echo "selected"; ?>>Not Started</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="eimage" class="form-label">event image</label>
                <input type="file" class="form-control" name="eimage" accept=".jpg,.png,.jpeg" value="<?php echo $eimage; ?>">
            </div>
            <br>
            <br>
            <br>
        </form>
        <?php
        if (!empty($successMessage)) {
            echo "
                <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-3 d-grid'>
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>
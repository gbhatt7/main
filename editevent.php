<?php
require("connection.php");
require("image.php");

// Check if an event ID is provided in the URL
if (!isset($_GET["id"])) {
    header("location: /main/event.php");
    exit;
}

// Get the event ID from the URL
$event_id = $_GET["id"];

// Create variables to store event data
$eid = "";
$ename = "";
$edepartment = "";
$eplace = "";
$estart = "";
$eend = "";
$estatus = "";
$eimage = "";
$editimage = "";
$myArray = array();

$errorMessage = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ename = $_POST["ename"];
    $edepartment = $_POST["edepartment"];
    $eplace = $_POST["eplace"];
    $estart = $_POST["estart"];
    $eend = $_POST["eend"];
    $estatus = $_POST["estatus"];

    do {
        if (empty($ename) || empty($edepartment)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED!";
            break;
        }
        if (!empty($_FILES['editimage']['name'])) {
            // Handle image upload and get the image path
            $imgpath = image_upload($_FILES['editimage']);
            // Update employee in the database
            $sql = "UPDATE `event` SET `ename`='$ename', `edepartment`='$edepartment', `eplace`='$eplace', `estart`='$estart', `eend`='$eend', `estatus`='$estatus', `eimage`='$imgpath' WHERE `id`='$event_id'";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: ";
                break;
            }
        } else {
            $sql = "UPDATE `event` SET `ename`='$ename', `edepartment`='$edepartment', `eplace`='$eplace', `estart`='$estart', `eend`='$eend', `estatus`='$estatus' WHERE `id`='$event_id'";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: ";
                break;
            }
        }


        //not working
        // if (isset($_POST['colors']) && is_array($_POST['colors'])) {
        //     // Remove previous associations
        //     $sqlDelete = "DELETE FROM `employee_event` WHERE `event_id`='$event_id'";
        //     $deleteResult = $connection->query($sqlDelete);
        //     if (!$deleteResult) {
        //         $errorMessage = "Error updating employee associations: " . $connection->error;
        //         break;
        //     }

        //     // Add new associations
        //     foreach ($_POST['colors'] as $selectedEmployeeId) {
        //         $sqlInsert = "INSERT INTO `employee_event` (`employee_id`, `event_id`) VALUES ('$selectedEmployeeId', '$event_id')";
        //         $insertResult = $connection->query($sqlInsert);
        //         if (!$insertResult) {
        //             $errorMessage = "Error updating employee associations: " . $connection->error;
        //             break 2;
        //         }
        //     }
        // }
        //only the above section

        $successMessage = "UPDATED SUCCESSFULLY";

        header("location: /main/event.php");
        exit;
    } while (false);
} else {
    // Fetch the existing event data from the database
    $sql = "SELECT * FROM `event` WHERE `id`='$event_id'";
    $result = $connection->query($sql);

    // Read all rows from the database table
    $sql1 = "SELECT e.emid, e.name, e.email, e.cadre, e.post, e.phone
    FROM `employee` e
    INNER JOIN `employee_event` ee ON e.emid = ee.employee_id
    INNER JOIN `event` emp ON ee.event_id = emp.id
    WHERE emp.id = '$event_id';            
    ";
    $r = $connection->query($sql1);

    if (!$r) {
        die("Invalid query: ");
    }

    while ($e = $r->fetch_assoc()) {
        array_push($myArray, $e['emid']);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $eid = $row["eid"];
        $ename = $row["ename"];
        $edepartment = $row["edepartment"];
        $eplace = $row["eplace"];
        $estart = $row["estart"];
        $eend = $row["eend"];
        $estatus = $row["estatus"];
        $eimage = $row["eimage"];
    } else {
        // No event found with the provided ID, redirect to the events page
        header("location: /main/event.php");
        exit;
    }
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

    <title>Update Event</title>
    <style>
        label {
            text-transform: uppercase;
        }

        th {
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
                    <h2>Update Event</h2>
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
                <input type="text" class="form-control" id="eid" name="eid" placeholder="Event ID" value="<?php echo $eid; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="ename" class="form-label">Event Name</label>
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
                <label for="eend" class="form-label">Event End Date</label>
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
                <br>
                <img src="<?php echo $fetch_src . $eimage; ?>" width="200px" height="200px">
                <br>
                <br>
                <input type="file" class="form-control" name="editimage" accept=".jpg,.png,.jpeg" value="<?php echo $editimage; ?>">
            </div>
            <div class="mb-3">
                <label for="event" class="form-label text-uppercase">employee</label>
                <div class="">
                    <div class="input-group mt-3 mb-3">
                        <input type="text" id="search" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="search..">
                    </div>
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <!-- <th>Select</th> -->
                                <th>employee id</th>
                                <th>employee name</th>
                                <th>employee email</th>
                                <th>cadre</th>
                                <th>post</th>
                                <th>phone number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require('connection.php');
                            $sql = "SELECT * FROM `employee`";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: ");
                            }
                            while ($row = $result->fetch_assoc()) {
                                $eId = $row['emid'];
                                $eName = $row['name'];
                                // Check if the event is associated with the employee
                                $isChecked = in_array($eId, $myArray) ? 'checked' : '';
                                echo "
                                    <tr>"
                                        /*<td><input type='checkbox' name='colors[]' value='$eId' $isChecked></td>*/;
                                echo "  <td>{$row['emid']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['cadre']}</td>
                                        <td>{$row['post']}</td>
                                        <td>{$row['phone']}</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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
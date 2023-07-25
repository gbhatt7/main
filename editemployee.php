<?php
require("connection.php");
require("image.php");

// Check if an employee ID is provided in the URL
if (!isset($_GET["id"])) {
    header("location: /main/employee.php");
    exit;
}

// Get the employee ID from the URL
$employee_id = $_GET["id"];

$sql = "SELECT `emid` FROM `employee` WHERE `id`='$employee_id'";
$result = $connection->query($sql);
while ($row = $result->fetch_assoc()) {
    $emid = $row['emid'];
}

$name = "";
$email = "";
$gender = "";
$cadre = "";
$post = "";
$postin = "";
$postout = "";
$dob = "";
$phone = "";
$address = "";
$event = "";
$image = "";
$education = "";
$editimage = "";
$myArray = array();

$errorMessage = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $cadre = $_POST["cadre"];
    $post = $_POST["post"];
    $postin = $_POST["postin"];
    $postout = $_POST["postout"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $education = $_POST["education"];

    do {
        if (empty($name) || empty($email) || empty($gender) || empty($cadre) || empty($post) || empty($dob) || empty($phone) || empty($address)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED!";
            break;
        }
        if (!empty($_FILES['editimage']['name'])) {
            // Handle image upload and get the image path
            $imgpath = image_upload($_FILES['editimage']);
            // Update employee in the database
            $sql = "UPDATE `employee` SET `name`='$name', `email`='$email', `gender`='$gender', `cadre`='$cadre', `post`='$post', `postin`='$postin', `postout`='$postout', `dob`='$dob', `phone`='$phone', `address`='$address', `education`='$education', `image`='$imgpath' WHERE `id`='$employee_id'";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
                break;
            }
        } else {
            $sql = "UPDATE `employee` SET `name`='$name', `email`='$email', `gender`='$gender', `cadre`='$cadre', `post`='$post', `postin`='$postin', `postout`='$postout', `dob`='$dob', `phone`='$phone', `address`='$address', `education`='$education' WHERE `id`='$employee_id'";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
                break;
            }
        }

        // Update employee_event table based on selected employees
        if (isset($_POST['colors']) && is_array($_POST['colors'])) {
            // Remove previous associations
            $sqlDelete = "DELETE FROM `employee_event` WHERE `employee_id`='$emid'";
            $deleteResult = $connection->query($sqlDelete);
            if (!$deleteResult) {
                $errorMessage = "Error updating employee associations: " . $connection->error;
                break;
            }

            // Add new associations
            foreach ($_POST['colors'] as $selectedEmployeeId) {
                $sqlInsert = "INSERT INTO `employee_event` (`employee_id`, `event_id`) VALUES ('$emid', '$selectedEmployeeId')";
                $insertResult = $connection->query($sqlInsert);
                if (!$insertResult) {
                    $errorMessage = "Error updating employee associations: " . $connection->error;
                    break 2;
                }
            }
        }

        $successMessage = "UPDATED SUCCESSFULLY";

        header("location: /main/employee.php");
        exit;
    } while (false);
} else {
    // Fetch the existing employee data from the database
    $sql = "SELECT * FROM `employee` WHERE `id`='$employee_id'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $emid = $row["emid"];
        $name = $row["name"];
        $email = $row["email"];
        $gender = $row["gender"];
        $cadre = $row["cadre"];
        $post = $row["post"];
        $postin = $row["postin"];
        $postout = $row["postout"];
        $dob = $row["dob"];
        $phone = $row["phone"];
        $address = $row["address"];
        $education = $row["education"];
        $image = $row["image"];
        $sql1 = "SELECT e.id, e.eid, e.ename, e.edepartment, e.estart, e.eend, e.estatus
        FROM `event` e
        INNER JOIN `employee_event` ee ON e.id = ee.event_id
        INNER JOIN `employee` emp ON ee.employee_id = emp.emid
        WHERE emp.emid = '$emid';        
        ";
        $r = $connection->query($sql1);

        if (!$r) {
            die("Invalid query: ");
        }

        while ($e = $r->fetch_assoc()) {
            array_push($myArray, $e['id']);
        }
    } else {
        // No employee found with the provided ID, redirect to the employees page
        header("location: /main/employee.php");
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

    <title>Update employee</title>
    <style>
        label {
            text-transform: uppercase;
        }

        th {
            text-transform: uppercase;
        }

        td,
        th {
            text-align: center;
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
                    <h2>Add Employee</h2>
                </div>
                <div class="offset-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="/main/employee.php" role="button">Cancel</a>
                </div>
            </nav>
            <div class="mb-3">
                <label for="emid" class="form-label">Employee ID</label>
                <input type="text" class="form-control" id="emid" name="emid" placeholder="Employee ID" value="<?php echo $emid; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control text-capitalize" id="name" name="name" placeholder="Employee Name" value="<?php echo $name; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Email" value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="" selected disabled class="text-muted">Gender</option>
                    <option value="Male" <?php if ($gender === "Male") echo "selected"; ?>>Male</option>
                    <option value="Female" <?php if ($gender === "Female") echo "selected"; ?>>Female</option>
                    <option value="Other" <?php if ($gender === "Other") echo "selected"; ?>>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cadre" class="form-label">Cadre</label>
                <input type="text" class="form-control" id="cadre" name="cadre" placeholder="Cadre" value="<?php echo $cadre; ?>">
            </div>
            <div class="mb-3">
                <label for="post" class="form-label">Post / position</label>
                <input type="text" class="form-control" id="post" name="post" placeholder="Employee Post" value="<?php echo $post; ?>">
            </div>
            <div class="mb-3">
                <label for="postin" class="form-label">Post In</label>
                <input type="date" class="form-control" id="postin" name="postin" placeholder="Post In" value="<?php echo $postin; ?>">
            </div>
            <div class="mb-3">
                <label for="postout" class="form-label">Post Out</label>
                <input type="date" class="form-control" id="postout" name="postout" placeholder="Post Out" value="<?php echo $postout; ?>">
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $phone; ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="4" placeholder="Address"><?php echo $address; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="education" class="form-label">Educational Qualifications</label>
                <textarea class="form-control" id="education" name="education" rows="4" placeholder="Educational Qualifications"><?php echo $education; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="editimage" class="form-label">image</label>
                <br>
                <img src="<?php echo $fetch_src . $image; ?>" width="200px" height="200px">
                <br>
                <br>
                <input type="file" class="form-control" name="editimage" accept=".jpg,.png,.jpeg" value="<?php echo $editimage; ?>">
            </div>
            <br>
            <div class="mb-3">
                <label for="event" class="form-label">event</label>
                <div class="">
                    <div class="input-group mt-3 mb-3">
                        <input type="text" id="search" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="search..">
                    </div>
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>event id</th>
                                <th>event name</th>
                                <th>event department</th>
                                <th>event place</th>
                                <th>start date</th>
                                <th>end date</th>
                                <th>event status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require('connection.php');
                            $sql = "SELECT * FROM `event`";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: ");
                            }
                            while ($row = $result->fetch_assoc()) {
                                $isChecked = in_array($row['id'], $myArray) ? 'checked' : '';
                                echo "
                                    <tr>
                                    <td><input type='checkbox' name='colors[]' value='$row[id]' $isChecked></td>
                                    <td>{$row['eid']}</td>
                                    <td>{$row['ename']}</td>
                                    <td>{$row['edepartment']}</td>
                                    <td>{$row['eplace']}</td>
                                    <td>{$row['estart']}</td>
                                    <td>{$row['eend']}</td>
                                    <td>{$row['estatus']}</td>
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
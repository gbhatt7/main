<?php
require("connection.php");

require("image.php");

//create variables
$emid = "";
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

$errorMessage = "";
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $myArray = array();
    if (isset($_POST["colors"]) && is_array($_POST["colors"])) {
        $selectedColors = $_POST["colors"];
        foreach ($selectedColors as $color) {
            // Add the selected colors to the array
            $myArray[] = $color;
        }
    }
    // Convert the array to a comma-separated string
    $event = implode(", ", $myArray);

    $name = $_POST["name"];
    $emid = $_POST["emid"];
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
    $imgpath = image_upload($_FILES['image']);

    do {
        if (empty($name) || empty($emid)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED !";
            break;
        }

        //add new client to database
        $sql = "INSERT INTO `employee`(`emid`, `name`, `email`, `gender`, `cadre`, `post`, `postin`, `postout`, `dob`, `phone`, `address`, `education`, `image`)" .
        "VALUES ('$emid','$name','$email','$gender','$cadre','$post','$postin','$postout','$dob','$phone','$address', '$education', '$imgpath')";    
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: ";
            break;
        }
        $eventname = explode(',', $event);
        // Insert employee and event IDs into the `employee_event` table
        foreach ($eventname as $cell) {
            $query = "INSERT INTO `employee_event`(`employee_id`, `event_id`) VALUES ('$emid','$cell')";
            $result_employee_event = $connection->query($query);
            if (!$result_employee_event) {
                $errorMessage = "Invalid query: ";
                break;
            }
        }

        $emid = "";
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
        $education = "";
        $event = "";
        $image = "";

        $successMessage = "CLIENT ADDED SUCCESSFULLY";

        header("location: /main/employee.php");
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

    <title>Add Employee</title>
    <style>
        th,label{
            text-transform: uppercase;
        }
        th,td{
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
                <input type="text" class="form-control" id="emid" name="emid" placeholder="Employee ID" value="<?php echo $emid; ?>">
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
                <label for="image" class="form-label">image</label>
                <input type="file" class="form-control" name="image" accept=".jpg,.png,.jpeg" value="<?php echo $image; ?>">
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
                                echo "
                                    <tr>
                                    <td><input type='checkbox' name='colors[]' value='{$row['id']}'></td>
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

<script src="jquery.js"></script>
<script src="index.js"></script>

</html>
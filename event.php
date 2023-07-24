<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Event Table</title>
    <style>
        /* Add custom CSS for the hover effect */
        .nav-link.btn.btn-outline-primary {
            color: #000;
            /* Change this to your desired hover text color (white in this case) */
        }

        .nav-link.btn.btn-outline-primary:hover {
            color: #fff;
            /* Change this to your desired hover text color (white in this case) */
        }
        th{
            text-transform: uppercase;
            text-align: center;
        }
        td{
            text-align: center;
        }
        
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-light bg-light">
        <div class="container d-flex justify-content-center">
            <a class="nav-link btn btn-outline-primary text-uppercase mx-3" href="/main/employee.php" role="button">employee</a>
            <a class="nav-link btn btn-outline-primary text-uppercase mx-3" href="/main/event.php" role="button">event</a>
        </div>
    </nav>
    <div class="container my-2">
        <br>
        <div class="row justify-content-end">
            <div class="sm-2 col-sm-2 d-grid">
                <a class="btn btn-primary" href="/main/createevent.php" role="button">Add Event</a>
            </div>
            <div class="sm-2 col-sm-2 d-grid">
                <a class="btn btn-success" href="/main/exportevent.php" role="button">Export</a>
            </div>
        </div>
        <br>
        <div class="input-group mt-3 mb-2">
            <input type="text" id="search" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="search..">
        </div>
        <table class="table fs-6" id="table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>event ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>event place</th>
                    <th>start date</th>
                    <th>end date</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                require("connection.php");

                require("image.php");

                // Read all rows from the database table
                $sql = "SELECT * FROM `event`";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: ");
                }
                $i = 1;
                // Read data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr class='align-middle'>
                    <td>$i.</td>
                    <td>{$row['eid']}</td>
                    <td>{$row['ename']}</td>
                    <td>{$row['edepartment']}</td>
                    <td>{$row['eplace']}</td>
                    <td>{$row['estart']}</td>
                    <td>{$row['eend']}</td>
                    <td>{$row['estatus']}</td>
                    <td>
                        <a target='_blank' class='special btn btn-warning btn-sm' href='/main/printemployeeevent.php?id=$row[id]'>Employee List</a>
                        <a target='_blank' class='special btn btn-success btn-sm' href='/main/printevent.php?id=$row[id]'>Print</a>
                        <a class='special btn btn-primary btn-sm' href='/main/editevent.php?id={$row['id']}'>Edit</a>
                        <a class='special btn btn-danger btn-sm' href='/main/deleteevent.php?id={$row['id']}'>Delete</a>
                    </td>
                    </tr>";
                $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>
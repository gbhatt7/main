<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Employee Table</title>
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
        /* .container{
            font-size: 14px;
        }
        .special{
            font-size: 14px;
        } */
        
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
                <a class="btn btn-primary" href="/main/createemployee.php" role="button">Add Employee</a>
            </div>
            <div class="sm-2 col-sm-2 d-grid">
                <a class="btn btn-success" href="/main/exportemployee.php" role="button">Export</a>
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
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>gender</th>
                    <th>cadre</th>
                    <th>postin</th>
                    <th>postout</th>
                    <th>dob</th>
                    <th>phone</th>
                    <th>address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                require("connection.php");

                require("image.php");

                // Read all rows from the database table
                $sql = "SELECT * FROM `employee`";
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
                    <td>{$row['emid']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['cadre']}</td>
                    <td>{$row['postin']}</td>
                    <td>{$row['postout']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td>
                        <a target='_blank' class='special btn btn-success btn-sm' href='/main/printemployee.php?id=$row[id]'>Print</a>
                        <a class='special btn btn-primary btn-sm' href='/main/editemployee.php?id={$row['id']}'>Edit</a>
                        <a class='special btn btn-danger btn-sm' href='/main/deleteemployee.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>";
                $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script src="jquery.js"></script>
<script src="index.js"></script>

</html>
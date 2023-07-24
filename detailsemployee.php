<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        td {
            width: 50%;
        }

        tr {
            text-align: center;
        }

        th {
            text-align: center;
            text-transform: capitalize;
        }
    </style>
</head>

<body style="text-align: center;">
    <h1><b>Employee Details</b></h1>
    <table width="100%" border="1">
        <tr>
            <th>Employee ID</th>
            <td><?= $row['emid'] ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?= $row['name'] ?></td>
        </tr>
        <tr>
            <th>email</th>
            <td><?= $row['email'] ?></td>
        </tr>
        <tr>
            <th>gender</th>
            <td><?= $row['gender'] ?></td>
        </tr>
        <tr>
            <th>cadre</th>
            <td><?= $row['cadre'] ?></td>
        </tr>
        <tr>
            <th>post</th>
            <td><?= $row['post'] ?></td>
        </tr>
        <tr>
            <th>post in</th>
            <td><?= $row['postin'] ?></td>
        </tr>
        <tr>
            <th>post out</th>
            <td><?= $row['postout'] ?></td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><?= $row['dob'] ?></td>
        </tr>
        <tr>
            <th>phone number</th>
            <td><?= $row['phone'] ?></td>
        </tr>
        <tr>
            <th>address</th>
            <td><?= $row['address'] ?></td>
        </tr>
        <tr>
            <th>education</th>
            <td><?= $row['education']?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <?php
                require('image.php');
                $fetch_src = FETCH_SRC;
                $imagePath = $fetch_src . $row['image'];
                echo "<img src='$fetch_src$row[image]' width='200px' height='200px'>";
                ?>
                <br>
            </td>
        </tr>
    </table>
    <br>
    <h2>Event Table</h2>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>S.NO.</th>
                <th>event id</th>
                <th>event name</th>
                <th>event department</th>
                <th>start date</th>
                <th>end date</th>
                <th>event status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require("connection.php");

            // Read all rows from the database table
            $sql = "SELECT e.eid, e.ename, e.edepartment, e.estart, e.eend, e.estatus
            FROM `event` e
            INNER JOIN `employee_event` ee ON e.id = ee.event_id
            INNER JOIN `employee` emp ON ee.employee_id = emp.emid
            WHERE emp.emid = '$row[emid]';            
            ";
            $result = $connection->query($sql);

            if (!$result) {
                die("Invalid query: ");
            }

            // Read data of each row
            $i = 1;
            // Read data of each row
            while ($e = $result->fetch_assoc()) {
                echo "
                    <tr>
                    <td>$i</td>
                    <td>{$e['eid']}</td>
                    <td>{$e['ename']}</td>
                    <td>{$e['edepartment']}</td>
                    <td>{$e['estart']}</td>
                    <td>{$e['eend']}</td>
                    <td>{$e['estatus']}</td>
                    </tr>";
                    $i++;
            }
            ?>
        </tbody>
    </table>
    <br>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
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
    <h1><b>Event Details</b></h1>
    <table width="100%" border="1">
        <tr>
            <th>Event ID</th>
            <td><?= $row['eid'] ?></td>
        </tr>
        <tr>
            <th>Event Name</th>
            <td><?= $row['ename'] ?></td>
        </tr>
        <tr>
            <th>Event Department</th>
            <td><?= $row['edepartment'] ?></td>
        </tr>
        <tr>
            <th>Event Place</th>
            <td><?= $row['eplace'] ?></td>
        </tr>
        <tr>
            <th>Event Start Date</th>
            <td><?= $row['estart']?></td>
        </tr>
        <tr>
            <th>Event End Date</th>
            <td><?= $row['eend']?></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <th>Event Image</th>
            <td>
                <?php
                require('image.php');
                $fetch_src = FETCH_SRC;
                $imagePath = $fetch_src . $row['eimage'];
                echo "<img src='$fetch_src$row[eimage]' width='200px' height='200px'>";
                ?>
                <br>
            </td>
        </tr>
    </table>
    <br>
    <h2>Employee Table</h2>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>S.NO.</th>
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
            require("connection.php");

            // Read all rows from the database table
            $sql = "SELECT e.emid, e.name, e.email, e.cadre, e.post, e.phone
            FROM `employee` e
            INNER JOIN `employee_event` ee ON e.emid = ee.employee_id
            INNER JOIN `event` emp ON ee.event_id = emp.id
            WHERE emp.id = '$row[id]';            
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
                    <td>{$e['emid']}</td>
                    <td>{$e['name']}</td>
                    <td>{$e['email']}</td>
                    <td>{$e['cadre']}</td>
                    <td>{$e['post']}</td>
                    <td>{$e['phone']}</td>
                    </tr>";
                    $i++;
            }
            ?>
        </tbody>
    </table>
    <br>
</body>

</html>
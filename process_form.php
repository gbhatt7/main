<!DOCTYPE html>
<html>
<head>
    <title>Processed Data</title>
</head>
<body>
    <h2>Selected Colors:</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if colors were selected
        if (isset($_POST["colors"]) && is_array($_POST["colors"])) {
            $selectedColors = $_POST["colors"];
            foreach ($selectedColors as $color) {
                // Display the selected colors
                echo '<p>' . htmlspecialchars($color) . '</p>';
            }
        } else {
            echo '<p>No colors were selected.</p>';
        }
    } else {
        echo '<p>Invalid request method.</p>';
    }
    ?>
</body>
</html>
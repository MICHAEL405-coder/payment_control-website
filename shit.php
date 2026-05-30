<?php
// Database configuration
$servername = "localhost";
    $username = "deboengineeringc"; // Updated username
    $password = ''; // REPLACED: credentials removed (use env vars / non-public config)
    $dbname = "deboengineeringc_coffee_control"; // Updated database name


// Include the PhpSpreadsheet autoload file
require 'vendor/autoload.php';

// Use PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    // Handle file upload and processing
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
        // Load the uploaded Excel file
        $fileTmpName = $_FILES['excelFile']['tmp_name'];
        $spreadsheet = IOFactory::load($fileTmpName);
        $worksheet = $spreadsheet->getActiveSheet();
        $excelData = $worksheet->toArray(null, true, true, true);

        // Remove header row
        $headers = array_shift($excelData);

        // Display the Excel data in a table for insertion
        echo "<form action='' method='POST'>";
        echo "<table border='1'>";
        echo "<tr>
                <th>" . htmlspecialchars($headers['A']) . "</th>
                <th>" . htmlspecialchars($headers['B']) . "</th>
                <th>" . htmlspecialchars($headers['C']) . "</th>
                <th>" . htmlspecialchars($headers['D']) . "</th>
                <th>" . htmlspecialchars($headers['E']) . "</th>
                <th>" . htmlspecialchars($headers['F']) . "</th>
              </tr>";

        foreach ($excelData as $row) {
            // Skip empty rows
            if (empty(trim($row['A'])) && empty(trim($row['B'])) && empty(trim($row['C'])) && empty(trim($row['D'])) && empty(trim($row['E'])) && empty(trim($row['F']))) {
                continue;
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['A']) . "</td>";
            echo "<td>" . htmlspecialchars($row['B']) . "</td>";
            echo "<td>" . htmlspecialchars($row['C']) . "</td>";
            echo "<td>" . htmlspecialchars($row['D']) . "</td>";
            echo "<td>" . htmlspecialchars($row['E']) . "</td>";
            echo "<td>" . htmlspecialchars($row['F']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<input type='hidden' name='excelData' value='" . htmlspecialchars(json_encode($excelData)) . "'>";
        echo "<button type='submit' formaction='?action=insert'>Insert into Database</button>";
        echo "</form>";
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'insert') {
        if (isset($_POST['excelData'])) {
            $excelData = json_decode($_POST['excelData'], true);

            // Connect to database
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Prepare statement
            $stmt = $conn->prepare("INSERT INTO buyy (sn, commodity_class, symbol, warehouse, lower_limit, upper_limit) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            foreach ($excelData as $row) {
                // Skip empty rows
                if (empty(trim($row['A'])) && empty(trim($row['B'])) && empty(trim($row['C'])) && empty(trim($row['D'])) && empty(trim($row['E'])) && empty(trim($row['F']))) {
                    continue;
                }

                // Sanitize data
                $sn = $row['A'];
                $commodity_class = $row['B'];
                $symbol = $row['C'];
                $warehouse = $row['D'];
                $lower_limit = $row['E'];
                $upper_limit = $row['F'];

                // Bind parameters
                $stmt->bind_param("ssssss", $sn, $commodity_class, $symbol, $warehouse, $lower_limit, $upper_limit);

                // Execute statement
                if (!$stmt->execute()) {
                    echo "Error inserting record (SN: $sn): " . $stmt->error . "<br>";
                }
            }

            echo "All records inserted successfully";

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Process Excel</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="excelFile" required />
        <button type="submit">Upload and Display</button>
    </form>
</body>
</html>

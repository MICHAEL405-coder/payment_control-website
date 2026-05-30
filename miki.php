<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Database configuration
$servername = "localhost";
$username = "deboengineeringc"; // Updated username
$password = "s0QR~a)GVK50"; // Updated password
$dbname = "deboengineeringc_coffee_control"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

    // Load the Excel file
    $spreadsheet = IOFactory::load($file);

    // Get the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();

    // Get the highest row and column numbers referenced in the worksheet
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    // Prepare SQL to create table if not exists
    $createTableSql = "CREATE TABLE IF NOT EXISTS data (";
    for ($col = 1; $col <= $highestColumnIndex; $col++) {
        $header = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
        $createTableSql .= "`$header` VARCHAR(255), ";
    }
    $createTableSql = rtrim($createTableSql, ', ') . ");";

    // Create the table
    if ($conn->query($createTableSql) !== TRUE) {
        die("Error creating table: " . $conn->error);
    }

    // Prepare SQL to insert data
    $insertSql = "INSERT INTO data (";
    for ($col = 1; $col <= $highestColumnIndex; $col++) {
        $header = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
        $insertSql .= "`$header`, ";
    }
    $insertSql = rtrim($insertSql, ', ') . ") VALUES ";

    for ($row = 2; $row <= $highestRow; $row++) {
        $insertSql .= "(";
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
            $insertSql .= "'" . $conn->real_escape_string($value) . "', ";
        }
        $insertSql = rtrim($insertSql, ', ') . "), ";
    }
    $insertSql = rtrim($insertSql, ', ') . ";";

    // Insert the data
    if ($conn->query($insertSql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error inserting data: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No file uploaded or invalid request method";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Excel</title>
</head>
<body>
    <h2>Upload Excel File</h2>
    <form action="upload_excel.php" method="post" enctype="multipart/form-data">
        <label for="excelFile">Choose Excel file:</label>
        <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
        <button type="submit">Upload</button>
    </form>
</body>
</html>

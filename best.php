<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    // Skip the header rows (index 0 and 1)
    for ($i = 2; $i < count($rows); $i++) {
        $row = $rows[$i];
        $sn = trim($row[1]);
        $commodity_class = trim($row[2]);
        $symbol = trim($row[3]);
        $warehouse = trim($row[4]);
        $lower_limit = floatval(str_replace(',', '', trim($row[5])));
        $upper_limit = floatval(str_replace(',', '', trim($row[6])));

        // Uncomment the following lines for debugging if needed
        // echo "Row $i: sn = $sn, commodity_class = $commodity_class, symbol = $symbol, warehouse = $warehouse, lower_limit = $lower_limit, upper_limit = $upper_limit<br>";
        // echo "Skipping row $i due to null or empty values.<br>";

        // Check for null values
        if ($sn === "" || $commodity_class === "" || $symbol === "" || $warehouse === "" || $lower_limit === 0 || $upper_limit === 0) {
            continue;
        }

        // Insert data into the database
        $sql = "INSERT INTO buyy (sn, commodity_class, symbol, warehouse, lower_limit, upper_limit) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssdd", $sn, $commodity_class, $symbol, $warehouse, $lower_limit, $upper_limit);
        $stmt->execute();
    }

    echo "<p class='message'>Data uploaded and inserted successfully!</p>";
}

// Fetch data from the database
$sql = "SELECT * FROM buyy";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Coffee Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .container {
            width: 80%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Coffee Data</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose Excel file:</label>
            <input type="file" name="file" id="file" accept=".xlsx,.xls">
            <button type="submit">Upload</button>
        </form>

        <h2>Data from Database</h2>
        <table>
            <tr>
                <th>S.N</th>
                <th>Commodity Class</th>
                <th>Symbol</th>
                <th>Warehouse</th>
                <th>Lower Limit</th>
                <th>Upper Limit</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['sn']}</td>
                            <td>{$row['commodity_class']}</td>
                            <td>{$row['symbol']}</td>
                            <td>{$row['warehouse']}</td>
                            <td>{$row['lower_limit']}</td>
                            <td>{$row['upper_limit']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>

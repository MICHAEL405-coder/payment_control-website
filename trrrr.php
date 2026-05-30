<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_control";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['file']['tmp_name'];

        // Check if file is actually uploaded
        if (file_exists($file)) {
            try {
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

                header("Location: upload.php");
                exit();
            } catch (Exception $e) {
                echo "<p class='message error'>Error loading file: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p class='message error'>File does not exist.</p>";
        }
    } else if (isset($_POST['delete'])) {
        // Check if delete action is requested
        if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'true') {
            $sql = "DELETE FROM buyy";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='message'>All data deleted successfully!</p>";
            } else {
                echo "<p class='message error'>Error deleting data: " . $conn->error . "</p>";
            }
        }
    } else {
        echo "<p class='message error'>No file uploaded or file upload error.</p>";
    }
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
        /* Your CSS styles here */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .message {
            text-align: center;
            color: green;
        }
        .message.error {
            color: red;
        }
        .delete-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
        .average-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
        }
        .average-button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function confirmDelete(event) {
            if (!confirm("Are you sure you want to delete all data? This action cannot be undone!")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Upload Coffee Data</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose Excel file:</label>
            <input type="file" name="file" id="file" accept=".xlsx,.xls">
            <button type="submit">Upload</button>
            <button type="submit" name="delete" class="delete-button" onclick="confirmDelete(event)">Delete All Data</button>
            <input type="hidden" name="confirm_delete" value="true">
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

        <!-- Add Show Average button -->
        <form action="display_averages.php" method="get">
            <button type="submit" class="average-button">Show Averages</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>

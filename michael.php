<?php
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

// Fetch data from the database
$sql = "SELECT * FROM buyy";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buyy Table Data with Averages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #87CEEB; /* Navbar background color */
            padding: 10px;
            color: white;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
            font-size: 16px;
        }

        .navbar a:hover {
            background-color: #ddd; /* Darker shade on hover */
            border-radius: 3px;
        }

        /* Container Styles */
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: white;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            margin-top: 20px;
        }

        .message.error {
            color: red;
            margin-top: 20px;
        }

        .icon {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="home.php"><i class="fa fa-home icon"></i> Home</a>
    </div>

    <div class="container">
        <h1><i class="fa fa-table icon"></i> Data with Averages</h1>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>S.N</th>
                    <th>Commodity Class</th>
                    <th>Symbol</th>
                    <th>Warehouse</th>
                    <th>Lower Limit</th>
                    <th>Upper Limit</th>
                    <th>Average</th>
                    <th>Ave.price+5%</th>
                </tr>

                <?php
                // Display fetched data
                $result->data_seek(0); // Reset result pointer
                while ($row = $result->fetch_assoc()): 
                    // Calculate average for this row
                    $lowerLimit = is_numeric($row['lower_limit']) ? $row['lower_limit'] : 0;
                    $upperLimit = is_numeric($row['upper_limit']) ? $row['upper_limit'] : 0;
                    $average = ($lowerLimit + $upperLimit) / 2;

                    // Calculate adjusted average with 5% added
                    $adjustedAverage = $average * 0.05 + $average;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['sn']); ?></td>
                        <td><?php echo htmlspecialchars($row['commodity_class']); ?></td>
                        <td><?php echo htmlspecialchars($row['symbol']); ?></td>
                        <td><?php echo htmlspecialchars($row['warehouse']); ?></td>
                        <td><?php echo htmlspecialchars($row['lower_limit']); ?></td>
                        <td><?php echo htmlspecialchars($row['upper_limit']); ?></td>
                        <td><?php echo number_format($average, 2); ?></td>
                        <td><?php echo number_format($adjustedAverage, 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

        <?php else: ?>
            <p class='message error'>No data found</p>
        <?php endif; ?>

        <br>
        <a href="upload.php"><i class="fa fa-arrow-left icon"></i> Back to Upload Page</a>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Records with Calculated Averages</title>
</head>
<body>
    <h2>Inserted Records with Averages</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>S.N</th>
            <th>Commodity Class</th>
            <th>Symbol</th>
            <th>Warehouse</th>
            <th>Lower Limit</th>
            <th>Upper Limit</th>
            <th>Average</th>
            <th>Action</th>
        </tr>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "deboengineeringc"; // Updated username
        $password = ''; // REPLACED: credentials removed (use env vars / non-public config)
        $dbname = "deboengineeringc_coffee_control"; // Updated database name
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch records from the database
        $sql = "SELECT * FROM buy";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = isset($row['id']) ? $row['id'] : 'N/A';
                $sn = isset($row['sn']) ? $row['sn'] : 'N/A';
                $commodityClass = isset($row['commodity_class']) ? $row['commodity_class'] : 'N/A';
                $symbol = isset($row['symbol']) ? $row['symbol'] : 'N/A';
                $warehouse = isset($row['warehouse']) ? $row['warehouse'] : 'N/A';
                $lowerLimit = isset($row['lower_limit']) ? $row['lower_limit'] : 'N/A';
                $upperLimit = isset($row['upper_limit']) ? $row['upper_limit'] : 'N/A';
                
                // Calculate the average
                $average = ($lowerLimit + $upperLimit) / 2;

                echo "<tr>
                        <td>{$id}</td>
                        <td>{$sn}</td>
                        <td>{$commodityClass}</td>
                        <td>{$symbol}</td>
                        <td>{$warehouse}</td>
                        <td>{$lowerLimit}</td>
                        <td>{$upperLimit}</td>
                        <td>{$average}</td>
                        <td>
                            <form action='del.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this record?\");'>
                                <input type='hidden' name='id' value='{$id}'>
                                <button type='submit'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No records found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>

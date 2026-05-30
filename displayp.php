<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Purchases</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions form {
            display: inline;
        }
    </style>
</head>
<body>
    <h2>Purchase Records</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Commodity Class</th>
                <th>Symbol</th>
                <th>Warehouse</th>
                <th>Current Lower Limit</th>
                <th>Upper Limit</th>
                <th>Average</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "deboengineeringc"; // Updated username
            $password = ''; // REPLACED: credentials removed (use env vars / non-public config)
            $dbname = "deboengineeringc_coffee_control"; // Updated database name
        
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT *, (current_lower_limit + upper_limit) / 2 AS average FROM purchase";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row_number = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_number . "</td>";
                    echo "<td>" . $row['commodity_class'] . "</td>";
                    echo "<td>" . $row['symbol'] . "</td>";
                    echo "<td>" . $row['warehouse'] . "</td>";
                    echo "<td>" . $row['current_lower_limit'] . "</td>";
                    echo "<td>" . $row['upper_limit'] . "</td>";
                    echo "<td>" . $row['average'] . "</td>";
                    echo "<td class='actions'>
                            <form action='updatee.php' method='POST'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='submit' value='Update'>
                            </form>
                            <form action='deletee.php' method='POST'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='submit' value='Delete'>
                            </form>
                          </td>";
                    echo "</tr>";
                    $row_number++;
                }
            } else {
                echo "<tr><td colspan='9'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="purchase.php">Insert anew record</a>

</body>
</html>

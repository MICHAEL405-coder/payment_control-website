<?php
$servername = "localhost";
$username = "deboengineeringc";
$password = "s0QR~a)GVK50";
$dbname = "deboengineeringc_coffee_control"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data'])) {
    $data = $_POST['data'];

    foreach ($data as $rowIndex => $rowData) {
        // Explode row data to insert into the database
        $values = explode(",", $rowData);

        // Ensure all columns have values
        if (count($values) < 6) {
            continue; // Skip rows with incomplete data
        }

        // Trim and sanitize values
        $sn = trim($values[0]);
        $commodity_class = trim($values[1]);
        $symbol = trim($values[2]);
        $warehouse = trim($values[3]);
        $lower_limit = trim($values[4]); // Ensure this is correctly handled
        $upper_limit = trim($values[5]);

        // Prepare an SQL statement for execution
        $stmt = $conn->prepare("INSERT INTO record (sn, commodity_class, symbol, warehouse, lower_limit, upper_limit) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("ssssss", $sn, $commodity_class, $symbol, $warehouse, $lower_limit, $upper_limit);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Record inserted successfully<br>";
        } else {
            echo "Error inserting record: " . $stmt->error . "<br>";
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

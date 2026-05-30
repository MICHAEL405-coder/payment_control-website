<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
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

    // SQL to delete all records
    $sql = "DELETE FROM buy";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "All records deleted successfully.";
    } else {
        echo "Error deleting records: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete All Records</title>
</head>
<body>
    <h2>Delete All Records</h2>
    <form action="delete_all.php" method="POST" onsubmit="return confirm('Are you sure you want to delete all records?');">
        <button type="submit">Delete All Records</button>
    </form>
</body>
</html>

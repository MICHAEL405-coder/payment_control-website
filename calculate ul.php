<?php
// Database connection
$servername = "localhost";
$username = "deboengineeringc";
$password = "s0QR~a)GVK50";
$dbname = "deboengineeringc_coffee_control";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the database
$sql = "SELECT id, lower_limit, upper_limit FROM buy";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $lowerLimit = $row['lower_limit'];
        $upperLimit = $row['upper_limit'];
        
        // Calculate the average
        $average = ($lowerLimit + $upperLimit) / 2;

        // Update the average in the database
        $updateSql = "UPDATE buy SET avarage = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("di", $average, $id);
        $stmt->execute();
        $stmt->close();
    }
    echo "Averages calculated and updated successfully.";
} else {
    echo "No records found.";
}

$conn->close();
?>

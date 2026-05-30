<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM buy";

    if ($conn->query($sql) === TRUE) {
        echo "All records deleted successfully<br>";
    } else {
        echo "Error deleting records: " . $conn->error . "<br>";
    }
}

$conn->close();
?>

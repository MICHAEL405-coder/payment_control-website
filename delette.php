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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $values = explode(",", $_POST['delete']);

    $sn = $values[0];

    $sql = "DELETE FROM buy WHERE sn = '$sn'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully<br>";
    } else {
        echo "Error deleting record: " . $conn->error . "<br>";
    }
}

$conn->close();
?>

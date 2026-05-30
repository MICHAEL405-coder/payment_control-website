<?php
$servername = "localhost";
$username = "deboengineeringc"; // Updated username
$password = ''; // REPLACED: credentials removed (use env vars / non-public config)
$dbname = "deboengineeringc_coffee_control"; // Updated database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM purchase WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

header("Location: displayp.php");
exit();
?>

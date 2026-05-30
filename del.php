<?php
$servername = "localhost";
$username = "deboengineeringc"; // Updated username
$password = ''; // REPLACED: credentials removed (use env vars / non-public config)
$dbname = "deboengineeringc_coffee_control"; // Updated database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete all records from the 'buy' table
    $sql = "DELETE FROM buy";
    $conn->exec($sql);
    echo "All records from the 'buy' table deleted successfully.";
} catch (PDOException $e) {
    echo "Error deleting records: " . $e->getMessage();
}

$conn = null;
?>

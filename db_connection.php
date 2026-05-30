
<?php
$servername = "localhost";
$username = "deboengineeringc"; // Updated username
$password = ''; // NOTE: credentials removed; use env vars / non-public config
$dbname = "deboengineeringc_coffee_control"; // Updated database name
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
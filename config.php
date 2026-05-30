<?php
$dsn = 'mysql:host=localhost;dbname=deboengineeringc_coffee_control';
$username = 'deboengineeringc'; // Your MySQL username
$password = 's0QR~a)GVK50'; // Your MySQL password

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
 
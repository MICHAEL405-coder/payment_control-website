<?php
$dsn = 'mysql:host=localhost;dbname=deboengineeringc_coffee_control';
$username = 'deboengineeringc'; // Your MySQL username
$password = ''; // REPLACED: credentials removed (store secrets in environment variables or non-public config)

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
 
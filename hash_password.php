<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'coffee_control';

// Create a new MySQLi instance
$mysqli = new mysqli($host, $user, $pass, $db);

// Check connection
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Define your username and password
$username = 'michael';
$plain_password = '1234miki';

// Hash the password
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// Insert the username and hashed password into the database
$query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ss', $username, $hashed_password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Password hashed and inserted successfully.";
} else {
    echo "Failed to insert password.";
}

$stmt->close();
$mysqli->close();
?>

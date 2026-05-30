<?php
// Define your database connection parameters
$host = 'localhost'; // Your database host
$user = 'root'; // Your database username
$pass = ''; // NOTE: credentials removed; use env vars / non-public config
$db = 'coffee_control'; // Your database name

// Create a new MySQLi instance
$mysqli = new mysqli($host, $user, $pass, $db);

// Check connection
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>

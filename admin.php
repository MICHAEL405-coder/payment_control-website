<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

echo "<h1>Welcome Admin</h1>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="miko.css"> <!-- Your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Admin Panel</h2>
        <p>Welcome to the admin dashboard.</p>
        <p><a href="home.php">Home Page</a> | <a href="change_password.php">Change Password</a> | <a href="logout.php">Logout</a></p>
        <!-- Add admin-specific functionalities here -->
    </div>
</body>
</html>

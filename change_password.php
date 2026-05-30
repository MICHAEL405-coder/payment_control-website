<?php
session_start();
include('connect.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Retrieve the user's hashed password from the database
    $user_id = $_SESSION['user_id'];
    $stmt = $mysqli->prepare('SELECT password FROM users WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($old_password, $user['password'])) {
        // Check if new passwords match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $stmt = $mysqli->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->bind_param('si', $hashed_password, $user_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success = 'Password updated successfully.';
            } else {
                $error = 'Failed to update password.';
            }
        } else {
            $error = 'New passwords do not match.';
        }
    } else {
        $error = 'Old password is incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="change_password.css">
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form method="post">
            <div class="input-group">
                <label for="old_password">Old Password</label>
                <input type="password" id="old_password" name="old_password" placeholder="Old Password" required>
            </div>
            <div class="input-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="New Password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
            </div>
            <input type="submit" value="Change Password">
        </form>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

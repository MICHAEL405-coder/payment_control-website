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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Process the update form
    $id = $_POST['id'];
    $commodity_class = $_POST['commodity_class'];
    $symbol = $_POST['symbol'];
    $warehouse = $_POST['warehouse'];
    $current_lower_limit = $_POST['current_lower_limit'];
    $upper_limit = $_POST['upper_limit'];

    $sql = "UPDATE purchase SET 
            commodity_class='$commodity_class', 
            symbol='$symbol', 
            warehouse='$warehouse', 
            current_lower_limit='$current_lower_limit', 
            upper_limit='$upper_limit' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: displayp.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Display the update form
    $id = $_POST['id'];
    $sql = "SELECT * FROM purchase WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit;
    }
} else {
    echo "Invalid request";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Purchase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Update Purchase</h2>
    <form method="POST" action="updatee.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="commodity_class">Commodity Class</label>
        <input type="text" name="commodity_class" value="<?php echo $row['commodity_class']; ?>" required>

        <label for="symbol">Symbol</label>
        <input type="text" name="symbol" value="<?php echo $row['symbol']; ?>" required>

        <label for="warehouse">Warehouse</label>
        <input type="text" name="warehouse" value="<?php echo $row['warehouse']; ?>" required>

        <label for="current_lower_limit">Current Lower Limit</label>
        <input type="number" step="0.01" name="current_lower_limit" value="<?php echo $row['current_lower_limit']; ?>" required>

        <label for="upper_limit">Upper Limit</label>
        <input type="number" step="0.01" name="upper_limit" value="<?php echo $row['upper_limit']; ?>" required>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

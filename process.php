
<?php
// Establishing the database connection
$conn = new mysqli('localhost', 'root', '', 'coffee_control');

// Check the connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if(isset($_POST['commodity_class'], $_POST['symbol'], $_POST['warehouse'], $_POST['current_lower_limit'], $_POST['upper_limit'])) {
        // Retrieving form data
        $commodity_class = $_POST['commodity_class'];
        $symbol = $_POST['symbol'];
        $warehouse = $_POST['warehouse'];
        $current_lower_limit = $_POST['current_lower_limit'];
        $upper_limit = $_POST['upper_limit'];

        // Insert query using prepared statement
        $sql = $conn->prepare("INSERT INTO purchase (commodity_class, symbol, warehouse, current_lower_limit, upper_limit) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $commodity_class, $symbol, $warehouse, $current_lower_limit, $upper_limit);

        // Execute the query
        if ($sql->execute()) {
           echo "Purchase added successfully";
        } else {
           echo "Error: " . $sql->error;
        }

        $sql->close();
    } else {
        echo "All fields are required";
    }
} else {
    echo "Form not submitted";
}

// Close the database connection
$conn->close();
?>
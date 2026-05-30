<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Insert Data</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .form-body {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Adds space between columns */
        }
        .form-group {
            flex: 1 1 calc(50% - 20px); /* Takes half of the width minus the gap */
            box-sizing: border-box;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"], 
        .form-group input[type="number"], 
        .form-group input[type="date"] {
            max-width: 300px; /* Adjust this value as needed */
            width: 100%;
            padding: 8px 30px 8px 8px; /* Adjust padding to make room for the icon */
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #0074d9;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            background-image: url('bean.jpg'); /* Replace 'bean.jpg' with your image file path */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-attachment: fixed; /* Fixed background image */
            color: #333; /* Text color */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Add a white background with some transparency */
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 20px auto;
        }
        .navbar {
            background-color: #87CEEB; /* Light blue color */
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            flex-wrap: wrap;
        }
        .navbar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            display: flex;
            align-items: center;
        }
        .navbar a i {
            margin-right: 8px;
        }
        .navbar a:hover {
            background-color: #ddd; /* Lighter blue for hover */
            color: #333;
        }
    </style>
</head>
<body>
    <?php
    include("connect.php");
    error_reporting(E_ALL); // Report all errors
    ini_set('display_errors', 1); // Display errors for debugging
    session_start();

    if (isset($_POST['submit'])) {
        // Check if all fields are filled
        if (empty($_POST['supplier_name']) || empty($_POST['coffee_point']) || empty($_POST['coffee_grade']) || empty($_POST['bank_tr_id']) || empty($_POST['payment_date']) || empty($_POST['plate_number']) || empty($_POST['coffee_origin']) || empty($_POST['coffee_weight']) || empty($_POST['exporter_name']) || empty($_POST['amount_paid']) || empty($_POST['date_in_ec']) || empty($_POST['coffee_symbol'])) {
            $error = 'Please fill all fields';
        } else {
            $supplier_name = $_POST['supplier_name'];
            $coffee_point = $_POST['coffee_point'];
            $coffee_grade = $_POST['coffee_grade'];
            $bank_tr_id = $_POST['bank_tr_id'];
            $payment_date = $_POST['payment_date']; // From the input form
            $plate_number = $_POST['plate_number'];
            $coffee_origin = $_POST['coffee_origin'];
            $coffee_weight = $_POST['coffee_weight'];
            $exporter_name = $_POST['exporter_name'];
            $amount_paid = $_POST['amount_paid'];
            $date_in_ec = $_POST['date_in_ec'];
            $coffee_symbol = $_POST['coffee_symbol'];

            // Convert the date to the format 'YYYY.MM.DD'
            $formatted_payment_date = date('Y.m.d', strtotime($payment_date));

            // Prepare SQL statement to prevent SQL injection
            $sql = "INSERT INTO quality (supplier_name, coffee_point, coffee_grade, bank_tr_id, payment_date, plate_number, coffee_origin, coffee_weight, exporter_name, amount_paid, date_in_ec, coffee_symbol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssssssssssss', $supplier_name, $coffee_point, $coffee_grade, $bank_tr_id, $formatted_payment_date, $plate_number, $coffee_origin, $coffee_weight, $exporter_name, $amount_paid, $date_in_ec, $coffee_symbol);

                if (mysqli_stmt_execute($stmt)) {
                    $success = 'Data is inserted';
                } else {
                    $error = 'Error adding record: ' . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error = 'Failed to prepare statement: ' . mysqli_error($db);
            }
        }
    }
    ?>

    <div class="navbar">
        <a href="home.php"><i class="fa fa-home"></i>Home</a>
    </div>

    <div class="container">
        <h1>INSERT DATA</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label">Supplier Name</label>
                    <input type="text" name="supplier_name" placeholder="Enter supplier name" required>
                    <i class="fa fa-user"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Point</label>
                    <input type="text" name="coffee_point" placeholder="Enter coffee point" required>
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Grade</label>
                    <input type="text" name="coffee_grade" placeholder="Enter coffee grade" required>
                    <i class="fa fa-star"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Bank Transaction ID</label>
                    <input type="text" name="bank_tr_id" placeholder="Enter transaction id" required>
                    <i class="fa fa-credit-card"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Payment Date</label>
                    <input type="date" name="payment_date" required>
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Symbol</label>
                    <input type="text" name="coffee_symbol" placeholder="Enter coffee symbol" required>
                    <i class="fa fa-tag"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Plate Number</label>
                    <input type="text" name="plate_number" placeholder="Enter plate number" required>
                    <i class="fa fa-car"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Origin</label>
                    <input type="text" name="coffee_origin" placeholder="Enter coffee origin" required>
                    <i class="fa fa-globe"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Weight</label>
                    <input type="text" name="coffee_weight" placeholder="Enter coffee weight" required>
                    <i class="fa fa-weight"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Exporter Name</label>
                    <input type="text" name="exporter_name" placeholder="Enter exporter name" required>
                    <i class="fa fa-industry"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Amount Paid</label>
                    <input type="number" step="0.01" name="amount_paid" placeholder="Enter amount paid" required>
                    <i class="fa fa-dollar"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Date in EC</label>
                    <input type="date" name="date_in_ec" required>
                    <i class="fa fa-calendar-alt"></i>
                </div>
            </div>
            <input type="submit" name="submit" value="Save">
        </form>

        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
        <?php if (isset($success)) { echo "<div class='success'>$success</div>"; } ?>
        <a href="display.php">Show me data</a>
    </div>
</body>
</html>

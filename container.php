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
    <style>
        .form-body {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-body > div {
            flex: 0 0 48%;
            padding: 10px;
        }
        .control-label {
            display: block;
            margin-bottom: 5px;
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
    </style>
</head>
<body>
    <?php
    include("connect.php");
    error_reporting(0);
    session_start();

    if (isset($_POST['submit'])) {
        if (empty($_POST['supplier_name']) || empty($_POST['coffee_point']) || empty($_POST['coffee_grade']) || empty($_POST['bank_tr_id']) || empty($_POST['payment_date']) || empty($_POST['plate_number']) || empty($_POST['coffee_origin']) || empty($_POST['coffee_weight']) || empty($_POST['exporter_name']) || empty($_POST['amount_paid']) || empty($_POST['date_in_ec']) || empty($_POST['total_cost']) || empty($_POST['coffee_symbol'])) {
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
            $total_cost = $_POST['total_cost'];
            $coffee_symbol = $_POST['coffee_symbol'];

            // Convert the date to the format 'YYYY.MM.DD'
            $formatted_payment_date = date('Y.m.d', strtotime($payment_date));

            // Prepare SQL statement to prevent SQL injection
            $sql = "INSERT INTO quality (supplier_name, coffee_point, coffee_grade, bank_tr_id, payment_date, plate_number, coffee_origin, coffee_weight, exporter_name, amount_paid, date_in_ec, total_cost, coffee_symbol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sssssssssssss', $supplier_name, $coffee_point, $coffee_grade, $bank_tr_id, $formatted_payment_date, $plate_number, $coffee_origin, $coffee_weight, $exporter_name, $amount_paid, $date_in_ec, $total_cost, $coffee_symbol);

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
        <a href="home.php">Home</a>
    </div>

    <div class="container">
        <h1>INSERT DATA</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div>
                    <label class="control-label">Supplier Name</label>
                    <input type="text" name="supplier_name" placeholder="Enter supplier name" required><br>

                    <label class="control-label">Coffee Point</label>
                    <input type="text" name="coffee_point" placeholder="Enter coffee point" required><br>

                    <label class="control-label">Coffee Grade</label>
                    <input type="text" name="coffee_grade" placeholder="Enter coffee grade" required><br>

                    <label class="control-label">Bank Transaction ID</label>
                    <input type="text" name="bank_tr_id" placeholder="Enter transaction id" required><br>

                    <label class="control-label">Payment Date</label>
                    <input type="date" name="payment_date" required><br>

                    <label class="control-label">Coffee Symbol</label>
                    <input type="text" name="coffee_symbol" placeholder="Enter coffee symbol" required><br>
                </div>
                <div>
                    <label class="control-label">Plate Number</label>
                    <input type="text" name="plate_number" placeholder="Enter plate number" required><br>

                    <label class="control-label">Coffee Origin</label>
                    <input type="text" name="coffee_origin" placeholder="Enter coffee origin" required><br>

                    <label class="control-label">Coffee Weight</label>
                    <input type="text" name="coffee_weight" placeholder="Enter coffee weight" required><br>

                    <label class="control-label">Exporter Name</label>
                    <input type="text" name="exporter_name" placeholder="Enter exporter name" required><br>

                    <label class="control-label">Amount Paid</label>
                    <input type="number" step="0.01" name="amount_paid" placeholder="Enter amount paid" required><br>

                    <label class="control-label">Date in EC</label>
                    <input type="date" name="date_in_ec" required><br>
                    
                    <label class="control-label">Total Cost</label>
                    <input type="number" step="0.01" name="total_cost" placeholder="Enter total cost" required><br>
                </div>
                <input type="submit" name="submit" value="Save">
            </div>
        </form>

        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
        <?php if (isset($success)) { echo "<div class='success'>$success</div>"; } ?>
        <a href="display.php">Show me data</a>
    </div>
</body>
</html>

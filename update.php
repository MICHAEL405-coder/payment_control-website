<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Update Data</title>
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
            background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity */
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
    session_start();

    // Initialize variables
    $id = $supplier_name = $coffee_point = $coffee_grade = $bank_tr_id = $payment_date = $plate_number = $coffee_origin = $coffee_weight = $exporter_name = $amount_paid = $date_in_ec = "";
    $error = $success = "";

    // Fetch existing data if 'id' is set
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = mysqli_query($db, "SELECT * FROM quality WHERE id='$id'");

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            // Check if $row is not empty
            if ($row) {
                $supplier_name = $row['supplier_name'];
                $coffee_point = $row['coffee_point'];
                $coffee_grade = $row['coffee_grade'];
                $bank_tr_id = $row['bank_tr_id'];
                $payment_date = date('Y-m-d', strtotime($row['payment_date'])); // Ensure date format is correct
                $plate_number = $row['plate_number'];
                $coffee_origin = $row['coffee_origin'];
                $coffee_weight = $row['coffee_weight'];
                $exporter_name = $row['exporter_name'];
                $amount_paid = $row['amount_paid'];
                $date_in_ec = date('Y-m-d', strtotime($row['date_in_ec']));
            } else {
                $error = "No record found with the given ID.";
            }
        } else {
            $error = "Error fetching record: " . mysqli_error($db);
        }
    }

    // Handle form submission
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $supplier_name = $_POST['supplier_name'];
        $coffee_point = $_POST['coffee_point'];
        $coffee_grade = $_POST['coffee_grade'];
        $bank_tr_id = $_POST['bank_tr_id'];
        $payment_date = $_POST['payment_date'];
        $plate_number = $_POST['plate_number'];
        $coffee_origin = $_POST['coffee_origin'];
        $coffee_weight = $_POST['coffee_weight'];
        $exporter_name = $_POST['exporter_name'];
        $amount_paid = $_POST['amount_paid'];
        $date_in_ec = $_POST['date_in_ec'];

        $sql = "UPDATE quality SET 
                supplier_name='$supplier_name', 
                coffee_point='$coffee_point', 
                coffee_grade='$coffee_grade', 
                bank_tr_id='$bank_tr_id', 
                payment_date='$payment_date', 
                plate_number='$plate_number', 
                coffee_origin='$coffee_origin', 
                coffee_weight='$coffee_weight', 
                exporter_name='$exporter_name', 
                amount_paid='$amount_paid', 
                date_in_ec='$date_in_ec' 
                WHERE id='$id'";

        if (mysqli_query($db, $sql)) {
            $success = 'Data updated successfully';
        } else {
            $error = 'Error updating record: ' . mysqli_error($db);
        }
    }
    ?>

    <div class="navbar">
        <a href="home.php"><i class="fa fa-home"></i>Home</a>
    </div>

    <div class="container">
        <h1>UPDATE DATA</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label">Supplier Name</label>
                    <input type="text" name="supplier_name" value="<?php echo htmlspecialchars($supplier_name); ?>" required>
                    <i class="fa fa-user"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Point</label>
                    <input type="text" name="coffee_point" value="<?php echo htmlspecialchars($coffee_point); ?>" required>
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Grade</label>
                    <input type="text" name="coffee_grade" value="<?php echo htmlspecialchars($coffee_grade); ?>" required>
                    <i class="fa fa-star"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Bank Transaction ID</label>
                    <input type="text" name="bank_tr_id" value="<?php echo htmlspecialchars($bank_tr_id); ?>" required>
                    <i class="fa fa-credit-card"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Payment Date</label>
                    <input type="date" name="payment_date" value="<?php echo htmlspecialchars($payment_date); ?>" required>
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Plate Number</label>
                    <input type="text" name="plate_number" value="<?php echo htmlspecialchars($plate_number); ?>" required>
                    <i class="fa fa-car"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Origin</label>
                    <input type="text" name="coffee_origin" value="<?php echo htmlspecialchars($coffee_origin); ?>" required>
                    <i class="fa fa-globe"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Coffee Weight</label>
                    <input type="text" name="coffee_weight" value="<?php echo htmlspecialchars($coffee_weight); ?>" required>
                    <i class="fa fa-weight"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Exporter Name</label>
                    <input type="text" name="exporter_name" value="<?php echo htmlspecialchars($exporter_name); ?>" required>
                    <i class="fa fa-truck"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Amount Paid</label>
                    <input type="number" step="0.01" name="amount_paid" value="<?php echo htmlspecialchars($amount_paid); ?>" required>
                    <i class="fa fa-dollar"></i>
                </div>
                <div class="form-group">
                    <label class="control-label">Date in EC</label>
                    <input type="date" name="date_in_ec" value="<?php echo htmlspecialchars($date_in_ec); ?>" required>
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="submit" name="update" value="Update">
            </div>
        </form>

        <?php if (isset($error) && $error != "") { echo "<div class='error'>$error</div>"; } ?>
        <?php if (isset($success) && $success != "") { echo "<div class='success'>$success</div>"; } ?>
    </div>
</body>
</html>

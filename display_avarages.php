<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Display Data</title>
    <style>
        /* Basic Reset and Background Image */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('coffee-background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .navbar {
            background-color: #0074d9; /* Updated color */
            overflow: hidden;
            color: white;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #0056a0; /* Darker shade on hover */
            color: white;
        }

        .container {
            padding: 20px;
            position: relative;
            background: rgba(255, 255, 255, 0.2); /* Semi-transparent white background */
            backdrop-filter: blur(15px); /* Apply stronger blur effect */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 1200px;
            margin: 0 auto;
            color: #0074d9; /* Ensure text color contrasts well with the blurred background */
        }

        .content h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .edit-btn {
            background-color: #4CAF50; /* Green */
        }

        .delete-btn {
            background-color: #f44336; /* Red */
        }

        .success, .error {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php
    include("connect.php");
    session_start();

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sql = "DELETE FROM quality WHERE id='$id'";

        if (mysqli_query($db, $sql)) {
            $success = 'Record deleted successfully';
        } else {
            $error = 'Error deleting record: ' . mysqli_error($db);
        }
    }
    ?>

    <div class="navbar">
        <a href="home.php">Home</a>
    </div>

    <div class="container">
        <div class="content">
            <h1>INFORMATION</h1>
            <?php if (isset($success)) { echo "<div class='success'>$success</div>"; } ?>
            <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
            <table>
                <tr>
                    <th>Supplier Name</th>
                    <th>Coffee Point</th>
                    <th>Coffee Grade</th>
                    <th>Bank Transaction ID</th>
                    <th>Payment Date</th>
                    <th>Plate Number</th>
                    <th>Coffee Origin</th>
                    <th>Coffee Weight</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = mysqli_query($db, "SELECT * FROM quality");
                while ($row = mysqli_fetch_assoc($result)) {
                    // Format the date to the desired format before displaying it
                    $formatted_date = date('Y.m.d', strtotime($row['payment_date']));
                    echo "<tr>";
                    echo "<td>".$row['supplier_name']."</td>";
                    echo "<td>".$row['coffee_point']."</td>";
                    echo "<td>".$row['coffee_grade']."</td>";
                    echo "<td>".$row['bank_tr_id']."</td>";
                    echo "<td>".$formatted_date."</td>";
                    echo "<td>".$row['plate_number']."</td>";
                    echo "<td>".$row['coffee_origin']."</td>";
                    echo "<td>".$row['coffee_weight']."</td>";
                    echo "<td>
                            <a class='btn edit-btn' href='update.php?id=".$row['id']."'>Edit</a>
                            <a class='btn delete-btn' href='display.php?delete=".$row['id']."' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

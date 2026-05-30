<?php
include("connect.php");
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM quality WHERE id='$id'";

    if (mysqli_query($db, $sql)) {
        $success = 'Record deleted successfully';
    } else {
        $error = 'Error deleting record: ' . mysqli_error($db);
    }
}

header("Location: display.php");
?>

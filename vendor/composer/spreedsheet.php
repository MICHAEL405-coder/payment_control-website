<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    $spreadsheet = IOFactory::load('path_to_some_test_file.xlsx');
    echo "Loaded spreadsheet successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

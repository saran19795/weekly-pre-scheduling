<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $htmlTable = $_POST['tableContent'];

    // Generate a unique filename based on timestamp
    $filename = 'table_' . date('Ymd_His') . '.txt';

    // Save HTML table to the unique text file
    $file = fopen($filename, 'w');
    fwrite($file, $htmlTable);
    fclose($file);

    echo 'success';
} else {
    echo 'Invalid request.';
}
?>

<?php
session_start();

if (!isset($_SESSION['timetable']) || empty($_SESSION['timetable'])) {
    echo "<script>alert('No timetable found! Please generate a timetable first.'); window.location='index.php';</script>";
    exit();
}

$timetable = $_SESSION['timetable'];

// Set CSV file headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="timetable_report.csv"');

$output = fopen('php://output', 'w');

// Add CSV column headers
fputcsv($output, ['Class', 'Day', 'Period', 'Teacher', 'Subject']);

// Add timetable data to CSV
foreach ($timetable as $row) {
    fputcsv($output, [$row['class'], "Day " . $row['day'], "Period " . $row['period'], $row['teacher'], $row['subject']]);
}

fclose($output);
exit();

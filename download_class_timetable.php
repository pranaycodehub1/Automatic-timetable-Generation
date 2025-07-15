<?php
session_start();

if (!isset($_SESSION['timetable']) || empty($_SESSION['timetable'])) {
    echo "<script>alert('No timetable found! Please generate a timetable first.'); window.location='index.php';</script>";
    exit();
}

$timetable = $_SESSION['timetable'];

// Organize timetable by class
$class_wise_timetable = [];
foreach ($timetable as $entry) {
    $class_wise_timetable[$entry['class']][$entry['day']][$entry['period']] = [
        'teacher' => $entry['teacher'],
        'subject' => $entry['subject']
    ];
}

// Sort classes
ksort($class_wise_timetable);

// Set CSV file headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="class_wise_timetable_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');

// Add file header
fputcsv($output, ['Class-wise Timetable - Generated on ' . date('Y-m-d H:i:s')]);
fputcsv($output, []); // Empty line

foreach ($class_wise_timetable as $class => $days) {
    // Add class header with some styling (will appear as plain text in CSV)
    fputcsv($output, ['==========']);
    fputcsv($output, ["Class: $class"]);
    fputcsv($output, ['==========']);
    
    // Add day headers
    fputcsv($output, ['Period', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
    
    // Add periods
    for ($period = 1; $period <= 6; $period++) {
        $row = ["Period $period"];
        for ($day = 1; $day <= 5; $day++) {
            if (isset($days[$day][$period])) {
                $row[] = $days[$day][$period]['subject'] . ' (' . $days[$day][$period]['teacher'] . ')';
            } else {
                $row[] = '- Free Period -';
            }
        }
        fputcsv($output, $row);
    }
    
    // Add summary row
    fputcsv($output, []); // Empty line
    
    // Add blank lines between classes
    fputcsv($output, []);
    fputcsv($output, []);
}

// Add footer
fputcsv($output, ['=== End of Timetable ===']);

fclose($output);
exit();


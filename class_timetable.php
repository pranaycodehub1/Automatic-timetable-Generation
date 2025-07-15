<?php
session_start();

if (!isset($_SESSION['timetable'])) {
    echo "<script>alert('No timetable generated!'); window.location='index.php';</script>";
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

// Sort by class name
ksort($class_wise_timetable);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Class-wise Timetable</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .timetable-container {
            margin: 20px;
        }
        .class-timetable {
            margin-bottom: 40px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Class-wise Timetable</h1>
    <div class="timetable-container">
        <?php foreach ($class_wise_timetable as $class => $days): ?>
            <div class="class-timetable">
                <h2>Class: <?php echo htmlspecialchars($class); ?></h2>
                <table>
                    <tr>
                        <th>Period ↓ Day →</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                    </tr>
                    <?php for ($period = 1; $period <= 6; $period++): ?>
                        <tr>
                            <th>Period <?php echo $period; ?></th>
                            <?php for ($day = 1; $day <= 5; $day++): ?>
                                <td>
                                    <?php
                                    if (isset($days[$day][$period])) {
                                        echo htmlspecialchars($days[$day][$period]['subject']) . '<br>';
                                        echo '<small>(' . htmlspecialchars($days[$day][$period]['teacher']) . ')</small>';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="actions">
        <form action="download_class_timetable.php" method="post">
            <button type="submit" name="download">Download Class-wise Timetable (CSV)</button>
        </form>
        <br>
        <a href="timetable.php">View Complete Timetable</a> |
        <a href="index.php">Go Back</a>
    </div>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['timetable'])) {
    $_SESSION['error'] = "No timetable generated! Please generate a timetable first.";
    header("Location: dashboard.php");
    exit();
}

$timetable = $_SESSION['timetable'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generated Timetable</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .timetable-container {
            margin: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .download-options {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .download-options button {
            margin: 0 10px;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .download-options button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #f5f5f5;
        }
        .view-options {
            margin-top: 20px;
        }
        .view-options a {
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
        }
        .view-options a:hover {
            text-decoration: underline;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="timetable-container">
        <h1>Generated Timetable</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <table>
            <tr>
                <th>Class</th>
                <th>Day</th>
                <th>Period</th>
                <th>Teacher</th>
                <th>Subject</th>
            </tr>
            <?php foreach ($timetable as $entry): ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['class']); ?></td>
                    <td>Day <?php echo htmlspecialchars($entry['day']); ?></td>
                    <td>Period <?php echo htmlspecialchars($entry['period']); ?></td>
                    <td><?php echo htmlspecialchars($entry['teacher']); ?></td>
                    <td><?php echo htmlspecialchars($entry['subject']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="download-options">
            <h3>Download Options</h3>
            <form action="download_timetable.php" method="post" style="display: inline;">
                <button type="submit" name="download">Download Complete Timetable (CSV)</button>
            </form>
            <form action="download_class_timetable.php" method="post" style="display: inline;">
                <button type="submit" name="download">Download Class-wise Timetable (CSV)</button>
            </form>
        </div>

        <div class="view-options">
            <a href="class_timetable.php">View Class-wise Timetable</a> |
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $teacher_name = trim($_POST['teacher_name']);
    $subject_name = trim($_POST['subject_name']);
    $class_name = trim($_POST['class_name']);

    if ($teacher_name == "" || $subject_name == "" || $class_name == "") {
        $_SESSION['error'] = "All fields are required!";
    } else {
        // Check if teacher exists
        $teacher_query = $conn->prepare("SELECT id FROM teachers WHERE name = ?");
        $teacher_query->bind_param("s", $teacher_name);
        $teacher_query->execute();
        $teacher_query->store_result();
        
        if ($teacher_query->num_rows == 0) {
            $insert_teacher = $conn->prepare("INSERT INTO teachers (name) VALUES (?)");
            $insert_teacher->bind_param("s", $teacher_name);
            $insert_teacher->execute();
            $teacher_id = $insert_teacher->insert_id;
        } else {
            $teacher_query->bind_result($teacher_id);
            $teacher_query->fetch();
        }

        // Check if subject exists
        $subject_query = $conn->prepare("SELECT id FROM subjects WHERE name = ?");
        $subject_query->bind_param("s", $subject_name);
        $subject_query->execute();
        $subject_query->store_result();

        if ($subject_query->num_rows == 0) {
            $insert_subject = $conn->prepare("INSERT INTO subjects (name) VALUES (?)");
            $insert_subject->bind_param("s", $subject_name);
            $insert_subject->execute();
            $subject_id = $insert_subject->insert_id;
        } else {
            $subject_query->bind_result($subject_id);
            $subject_query->fetch();
        }

        // Check if class exists
        $class_query = $conn->prepare("SELECT id FROM classes WHERE name = ?");
        $class_query->bind_param("s", $class_name);
        $class_query->execute();
        $class_query->store_result();

        if ($class_query->num_rows == 0) {
            $insert_class = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
            $insert_class->bind_param("s", $class_name);
            $insert_class->execute();
        }

        // Assign teacher to subject
        $check_assignment = $conn->prepare("SELECT id FROM teacher_subjects WHERE teacher_id = ? AND subject_id = ?");
        $check_assignment->bind_param("ii", $teacher_id, $subject_id);
        $check_assignment->execute();
        $check_assignment->store_result();

        if ($check_assignment->num_rows == 0) {
            $assign_teacher = $conn->prepare("INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (?, ?)");
            $assign_teacher->bind_param("ii", $teacher_id, $subject_id);
            $assign_teacher->execute();
        }

        $_SESSION['success'] = "Data Added Successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Timetable Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: hsl(210, 16.70%, 97.60%);
            text-align: center;
            background-image: url('../timetable/index.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background:green;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Teacher Timetable Generator</h1>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="message error">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="message success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <h2>Add Data</h2>
        <form method="POST">
            <label>Teacher Name:</label>
            <input type="text" name="teacher_name" required><br>

            <label>Subject Name:</label>
            <input type="text" name="subject_name" required><br>

            <label>Class Name:</label>
            <input type="text" name="class_name" required><br>

            <button type="submit" name="submit" class="btn">Add Data</button>
        </form>

        <h2>Generate Timetable</h2>
        <form action="generate_timetable.php" method="POST">
            <button type="submit" name="generate" class="btn">Generate Timetable</button>
        </form>

        <?php if(isset($_SESSION['timetable'])): ?>
            <div class="timetable-section">
                <h2>Current Timetable</h2>
                <a href="timetable.php" class="btn">View Full Timetable</a>
                <a href="class_timetable.php" class="btn">View Class-wise Timetable</a>
                <a href="download_timetable.php" class="btn">Download Timetable</a>
            </div>
        <?php endif; ?>

        <div class="navigation">
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </div>

    <script>
        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function(message) {
                message.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>

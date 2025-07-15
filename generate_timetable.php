<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function generateTimetable($conn) {
    // Fetch classes
    $classes = mysqli_query($conn, "SELECT * FROM classes");
    if (!$classes) {
        return false;
    }

    // Fetch teacher-subject associations
    $teacher_subjects_query = "SELECT t.id AS teacher_id, t.name AS teacher_name, 
                             s.id AS subject_id, s.name AS subject_name 
                             FROM teacher_subjects ts 
                             JOIN teachers t ON ts.teacher_id = t.id 
                             JOIN subjects s ON ts.subject_id = s.id";
    
    $teacher_subjects_result = mysqli_query($conn, $teacher_subjects_query);
    if (!$teacher_subjects_result) {
        return false;
    }

    // Organize subjects per teacher
    $teacher_subjects = [];
    while ($row = mysqli_fetch_assoc($teacher_subjects_result)) {
        $teacher_subjects[$row['teacher_id']]['name'] = $row['teacher_name'];
        $teacher_subjects[$row['teacher_id']]['subjects'][] = [
            'id' => $row['subject_id'],
            'name' => $row['subject_name']
        ];
    }

    // Check if data exists
    if (mysqli_num_rows($classes) == 0 || empty($teacher_subjects)) {
        $_SESSION['error'] = "No teachers, subjects, or classes found! Please add data first.";
        return false;
    }

    $schedule = [];
    $teacher_availability = [];

    // Initialize teacher availability
    foreach ($teacher_subjects as $teacher_id => $teacher) {
        $teacher_availability[$teacher_id] = [
            'total_periods' => 0,
            'daily_periods' => [0, 0, 0, 0, 0] // Monday to Friday
        ];
    }

    // Generate timetable for each class
    while ($class = mysqli_fetch_assoc($classes)) {
        for ($day = 0; $day < 5; $day++) { // Monday to Friday
            for ($period = 0; $period < 6; $period++) { // 6 periods per day
                $available_teachers = [];

                // Find available teachers
                foreach ($teacher_subjects as $teacher_id => $teacher) {
                    if ($teacher_availability[$teacher_id]['daily_periods'][$day] < 4 && 
                        $teacher_availability[$teacher_id]['total_periods'] < 25) {
                        $available_teachers[$teacher_id] = $teacher;
                    }
                }

                if (empty($available_teachers)) continue;
                
                // Select a random teacher
                $selected_teacher_id = array_rand($available_teachers);
                $selected_teacher = $teacher_subjects[$selected_teacher_id];

                // Pick a subject
                $selected_subject = $selected_teacher['subjects'][array_rand($selected_teacher['subjects'])];

                // Add to schedule
                $schedule[] = [
                    'class' => $class['name'],
                    'day' => $day + 1,
                    'period' => $period + 1,
                    'teacher' => $selected_teacher['name'],
                    'subject' => $selected_subject['name']
                ];

                // Update teacher workload
                $teacher_availability[$selected_teacher_id]['daily_periods'][$day]++;
                $teacher_availability[$selected_teacher_id]['total_periods']++;
            }
        }
    }

    return $schedule;
}

// Handle timetable generation
if (isset($_POST['generate'])) {
    $timetable = generateTimetable($conn);
    if ($timetable !== false) {
        $_SESSION['timetable'] = $timetable;
        $_SESSION['success'] = "Timetable generated successfully!";
        header("Location: timetable.php");
        exit();
    } else {
        $_SESSION['error'] = isset($_SESSION['error']) ? $_SESSION['error'] : "Failed to generate timetable!";
        header("Location: dashboard.php");
        exit();
    }
}
?>

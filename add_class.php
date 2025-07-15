<?php
session_start();
include('db.php');
include('session_check.php'); // Ensure only logged-in admins can access

if (isset($_POST['submit'])) {
    $class_name = mysqli_real_escape_string($conn, trim($_POST['class_name']));
    
    // Check if class already exists
    $check_query = "SELECT * FROM classes WHERE name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $class_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Class already exists!</div>";
    } else {
        // Insert new class
        $query = "INSERT INTO classes (name) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $class_name);
        
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Class added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Class</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            background-image: url('../timetable/Background.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Class</h2>
        <?php if (isset($message)) echo $message; ?>
        
        <form method="POST">
            <label>Class Name:</label>
            <input type="text" name="class_name" required>
            <button type="submit" name="submit">Add Class</button>
        </form>
        
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

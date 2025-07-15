<?php
session_start();
include('db.php');
include('session_check.php'); // Ensure only logged-in admins can access

if (isset($_POST['submit'])) {
    $subject_name = mysqli_real_escape_string($conn, trim($_POST['subject_name']));
    
    // Check if subject already exists
    $check_query = "SELECT * FROM subjects WHERE name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $subject_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Subject already exists!</div>";
    } else {
        // Insert new subject
        $query = "INSERT INTO subjects (name) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $subject_name);
        
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Subject added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
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
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-link {
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Subject</h2>
        <?php if (isset($message)) echo $message; ?>
        
        <form method="POST">
            <div>
                <label for="subject_name">Subject Name:</label>
                <input type="text" id="subject_name" name="subject_name" required>
            </div>
            <button type="submit" name="submit">Add Subject</button>
        </form>
        
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>

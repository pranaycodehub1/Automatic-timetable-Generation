<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['role'];
$user_name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Teacher Timetable System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            background: green;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

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

        <div class="card-container">
            <?php if($user_role == 'admin'): ?>
            <div class="card">
                <h3>Manage Teachers</h3>
                <p>Add or modify teacher information</p>
                <a href="add_teacher.php" class="btn">Manage Teachers</a>
            </div>
            <div class="card">
                <h3>Manage Subjects</h3>
                <p>Add or modify subjects</p>
                <a href="add_subject.php" class="btn">Manage Subjects</a>
            </div>
            <div class="card">
                <h3>Manage Classes</h3>
                <p>Add or modify classes</p>
                <a href="add_class.php" class="btn">Manage Classes</a>
            </div>
            <?php endif; ?>
            
            <div class="card">
                <h3>Generate Timetable</h3>
                <p>Create and view timetables</p>
                <a href="index.php" class="btn">Generate New Timetable</a>
                <?php if(isset($_SESSION['timetable'])): ?>
                    <a href="timetable.php" class="btn">View Current Timetable</a>
                <?php endif; ?>
            </div>
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


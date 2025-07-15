<?php
include('db.php');

if (isset($_POST['submit'])) {
    $teacher_name = $_POST['teacher_name'];

    $query = "INSERT INTO teachers (name) VALUES ('$teacher_name')";
    if (mysqli_query($conn, $query)) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
</head>
<body>
    <h2>Add Teacher</h2>
    <form method="POST">
        <label>Teacher Name:</label>
        <input type="text" name="teacher_name" required>
        <button type="submit" name="submit">Add Teacher</button>
    </form>
</body>
</html>

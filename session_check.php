<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// For admin-only pages, add this check:
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}
?>

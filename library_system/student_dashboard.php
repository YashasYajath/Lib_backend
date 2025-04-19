<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome, Student!</h2>
    <ul>
        <li><a href="my_books.php">My Books</a></li>
        <li><a href="my_penalty.php">My Penalty</a></li>
        <li><a href="my_account.php">My Account</a></li>
        <li><a href="return_book.php">Return Book</a></li>
        <li><a href="student_logout.php">Logout</a></li>

    </ul>
</body>
</html>
<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student'];

$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
</head>
<body>
    <h2>My Account</h2>
    <table border="1">
        <tr><th>Name:</th><td><?= $student['name']; ?></td></tr>
        <tr><th>Username:</th><td><?= $student['username']; ?></td></tr>
        <tr><th>Branch:</th><td><?= $student['branch']; ?></td></tr>
    </table>
    <br><a href="student_dashboard.php">Back to Dashboard</a>
</body>
</html>
